<?php

namespace App\Enums;

/**
 * External source the assistant reads from – mail accounts, calendars and work tools all share
 * one abstraction (one Settings section "Konektory"). A provider declares what it can deliver
 * (capabilities) and what the user has to fill in to connect it.
 */
enum ConnectorProvider: string
{
    case Gmail = 'gmail';
    case Microsoft365 = 'microsoft365';
    case Seznam = 'seznam';
    case Imap = 'imap';
    case GoogleCalendar = 'google_calendar';
    case CalDav = 'caldav';
    case Ical = 'ical';
    case Productive = 'productive';
    case Jira = 'jira';
    case DevTool = 'devtool';
    case BankStatements = 'bank_statements';
    case BankNotices = 'bank_notices';

    public function label(): string
    {
        return match ($this) {
            self::Gmail          => 'Gmail',
            self::Microsoft365   => 'Microsoft 365',
            self::Seznam         => 'Seznam.cz',
            self::Imap           => 'Vlastní IMAP',
            self::GoogleCalendar => 'Google Kalendář',
            self::CalDav         => 'CalDAV',
            self::Ical           => 'iCal URL',
            self::Productive     => 'Productive',
            self::Jira           => 'Jira',
            self::DevTool        => 'DevTool',
            self::BankStatements => 'Bankovní výpisy (PDF)',
            self::BankNotices    => 'Avíza o platbách',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::Gmail, self::GoogleCalendar => 'fab fa-google',
            self::Microsoft365                => 'fab fa-microsoft',
            self::Seznam                      => 'fas fa-s',
            self::Imap                        => 'fas fa-server',
            self::CalDav                      => 'fas fa-calendar-days',
            self::Ical                        => 'fas fa-link',
            self::Productive                  => 'fas fa-stopwatch',
            self::Jira                        => 'fab fa-jira',
            self::DevTool                     => 'fas fa-screwdriver-wrench',
            self::BankStatements              => 'fas fa-file-pdf',
            self::BankNotices                 => 'fas fa-building-columns',
        };
    }

    /** Has an implemented client? Unavailable providers are shown but cannot be picked. */
    public function isAvailable(): bool
    {
        return !in_array($this, [self::Microsoft365, self::Seznam]);
    }

    /**
     * What the connector delivers to the assistant.
     *
     * @return list<string> keys of capabilityLabels()
     */
    public function capabilities(): array
    {
        return match ($this) {
            self::Gmail, self::Microsoft365 => ['mail', 'calendar'],
            self::Seznam, self::Imap        => ['mail'],
            self::GoogleCalendar, self::CalDav, self::Ical => ['calendar'],
            self::Productive                => ['worklog'],
            self::Jira, self::DevTool       => ['tasks', 'worklog'],
            self::BankStatements, self::BankNotices => ['bank'],
        };
    }

    /** @return array<string, string> */
    public static function capabilityLabels(): array
    {
        return ['mail' => 'Pošta', 'calendar' => 'Kalendář', 'tasks' => 'Úkoly', 'worklog' => 'Výkazy', 'bank' => 'Banka'];
    }

    /** Signs in via OAuth – no credentials are typed in. */
    public function usesOAuth(): bool
    {
        return in_array($this, [self::Gmail, self::Microsoft365, self::GoogleCalendar]);
    }

    /**
     * Form fields for the connect dialog (wireframe shape, see App\Livewire\Wireframe\Form).
     *
     * @return list<array{label: string, type?: string, options?: array}>
     */
    public function fields(): array
    {
        $name = ['label' => 'Název (např. Práce)'];
        // Bank sources read from an already connected mailbox – statements as PDF attachments, notices as plain e-mails.
        $bankMail = [
            ['label' => 'Banka', 'type' => 'select', 'options' => ['fio' => 'Fio banka', 'csob' => 'ČSOB', 'kb' => 'Komerční banka', 'rb' => 'Raiffeisenbank', 'airbank' => 'Air Bank']],
            ['label' => 'E-mailový účet', 'type' => 'select', 'options' => ['imap:1' => 'Práce', 'google:2' => 'Osobní (Gmail)']],
            ['label' => 'Odesílatel (adresa nebo @doména)'],
            ['label' => 'Maska předmětu (nepovinné, např. Výpis z účtu*)'],
        ];

        return match (true) {
            $this->usesOAuth()     => [$name, ['label' => 'Přihlášení proběhne přes ' . $this->label() . ' – heslo se nezadává.', 'type' => 'note']],
            $this === self::Imap   => [$name, ['label' => 'Server (imap.example.com)'], ['label' => 'Port', 'type' => 'number'], ['label' => 'Uživatel', 'type' => 'email'], ['label' => 'Heslo pro aplikaci', 'type' => 'password'], ['label' => 'Složka']],
            $this === self::CalDav => [$name, ['label' => 'URL serveru', 'type' => 'url'], ['label' => 'Uživatel'], ['label' => 'Heslo', 'type' => 'password']],
            $this === self::Ical   => [$name, ['label' => 'URL kalendáře (.ics)', 'type' => 'url']],
            $this === self::BankStatements => [['label' => 'Název (např. Osobní účet)'], ...$bankMail, ['label' => 'Maska přílohy (výchozí *.pdf)'], ['label' => 'Heslo k PDF výpisu', 'type' => 'password']],
            $this === self::BankNotices    => [['label' => 'Název (např. Osobní účet)'], ...$bankMail],
            $this === self::Jira   => [$name, ['label' => 'URL (https://firma.atlassian.net)', 'type' => 'url'], ['label' => 'E-mail účtu', 'type' => 'email'], ['label' => 'API token', 'type' => 'password']],
            default                => [$name, ['label' => 'URL', 'type' => 'url'], ['label' => 'API token', 'type' => 'password']],
        };
    }

    /** Type tiles for <x-ui.add-button :types>. */
    public static function pickerTypes(): array
    {
        $types = [];
        foreach (self::cases() as $case) {
            $types[$case->value] = [
                'label'       => $case->label(),
                'icon'        => $case->icon(),
                'description' => implode(' · ', array_map(fn ($c) => self::capabilityLabels()[$c], $case->capabilities())),
                'disabled'    => !$case->isAvailable(),
                'fields'      => $case->fields(),
            ];
        }

        return $types;
    }
}

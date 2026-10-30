@php
    // [key, label, icon, configured, model]
    $providers = [
        ['claude', 'Anthropic Claude', 'fas fa-asterisk', true, 'claude-sonnet-5-5'],
        ['openai', 'OpenAI (GPT)', 'fas fa-circle-nodes', false, null],
        ['gemini', 'Google Gemini', 'fab fa-google', false, null],
        ['compatible', 'Ollama (lokálně)', 'fas fa-house-laptop', true, 'qwen3:14b, bge-m3'],
    ];
@endphp
<x-ui.section title="AI modely">
    <p class="small text-body-secondary">Připojení poskytovatelé. Klíč se ukládá šifrovaně a nejde zpětně zobrazit.</p>
    <div class="list-group list-flat">
        @foreach ($providers as [$key, $label, $icon, $configured, $model])
            <x-ui.list-item :title="$label" :subtitle="$configured ? 'Modely: ' . $model : 'Klíč není nastavený'" :icon="$icon" :color="$configured ? 'primary' : 'secondary'">
                <x-slot:trailing>
                    <x-badge :color="$configured ? 'success' : 'secondary'" variant="subtle" size="sm">{{ $configured ? 'Nastaveno' : 'Nenastaveno' }}</x-badge>
                    <x-ui.add-button label="Upravit" :title="$label" icon="fas fa-pen" variant="light" class="btn-sm" :fields="array_values(array_filter([
                        $key === 'compatible' ? ['label' => 'Adresa endpointu – Ollama http://localhost:11434/v1, LM Studio http://localhost:1234/v1 (libovolný OpenAI-kompatibilní server)', 'type' => 'url'] : null,
                        ['label' => $key === 'compatible' ? 'API klíč (volitelné – lokální servery ho obvykle nepotřebují)' : ($configured ? 'API klíč (prázdné pole jej zachová)' : 'API klíč'), 'type' => 'password'],
                        ['label' => 'Uložením se připojení otestuje a načte se seznam modelů. Který model běží na které úloze, se volí v AI jobech.', 'type' => 'note'],
                    ]))" />
                </x-slot:trailing>
            </x-ui.list-item>
        @endforeach
    </div>
</x-ui.section>

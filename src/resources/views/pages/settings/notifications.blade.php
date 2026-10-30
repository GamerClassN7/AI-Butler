@php
    // [event label, push, e-mail]
    $events = [
        ['Výkaz práce – vytvoření', false, false], ['Výkaz práce – úprava', false, false], ['Výkaz práce – smazání', false, false],
        ['Úkol – vytvoření', true, false], ['Úkol – úprava', false, false], ['Úkol – smazání', false, false],
        ['Událost kalendáře – vytvoření', true, false], ['Událost kalendáře – úprava', true, false], ['Událost kalendáře – smazání', true, false],
        ['Finance – měsíční cíl dosažen', true, true], ['Finance – pozadu za plánem', true, true],
    ];
@endphp
<x-ui.section>
    {{-- No in-app notification centre – alerts go out by push or e-mail only. --}}
    <p class="small text-body-secondary">Co ti aplikace posílá a kudy. Push se doručí na zařízení povolená v sekci Aplikace.</p>
    <div class="table-responsive">
        <table class="table align-middle mb-2">
            <thead>
                <tr><th class="fw-medium text-body-secondary">Událost</th><th class="text-center fw-medium text-body-secondary" style="width: 6rem">Push</th><th class="text-center fw-medium text-body-secondary" style="width: 6rem">E-mail</th></tr>
            </thead>
            <tbody>
                @foreach ($events as [$label, $push, $mail])
                    <tr>
                        <td>{{ $label }}</td>
                        <td class="text-center"><input class="form-check-input" type="checkbox" @checked($push) aria-label="{{ $label }} – push"></td>
                        <td class="text-center"><input class="form-check-input" type="checkbox" @checked($mail) aria-label="{{ $label }} – e-mail"></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-end"><button class="btn btn-primary btn-sm">Uložit notifikace</button></div>
</x-ui.section>

<x-ui.section>
    <p class="small text-body-secondary">Kolik se drží a jak podrobně se zapisuje.</p>
    <x-ui.setting-row label="Uchování" help="Chyby se drží rok kvůli dohledávání, ostatní záznamy podle tohoto počtu dní.">
        <div class="input-group" style="max-width: 12rem">
            <input type="number" class="form-control" value="30">
            <span class="input-group-text">dní</span>
        </div>
    </x-ui.setting-row>
    <div class="d-flex justify-content-between align-items-center mt-3">
        <a href="{{ route('system.log.index') }}" class="small text-decoration-none">Otevřít log aplikace →</a>
        <button class="btn btn-primary btn-sm">Uložit</button>
    </div>
</x-ui.section>

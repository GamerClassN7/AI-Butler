<x-ui.section>
    <p class="small text-body-secondary">Přístup agentů a vyhledávání. Model pro embeddingy se volí v AI jobech, endpoint v AI modelech.</p>
    <x-ui.setting-row label="Osobní znalosti pro agenty" help="Smí MCP agenti číst prostor Osobní? Ve výchozím stavu vidí jen Projekty.">
        <div class="form-check form-switch mb-0">
            <input class="form-check-input" type="checkbox" id="kn-personal">
            <label class="form-check-label" for="kn-personal">Povolit agentům přístup k osobním znalostem</label>
        </div>
    </x-ui.setting-row>
    <x-ui.setting-row label="Sémantické vyhledávání" help="Doplní fulltext o vyhledávání podle významu. Používá úlohu Embeddingy z AI jobů.">
        <div class="form-check form-switch mb-0">
            <input class="form-check-input" type="checkbox" id="kn-semantic" checked>
            <label class="form-check-label" for="kn-semantic">Zapnout sémantické vyhledávání</label>
        </div>
    </x-ui.setting-row>
    <x-ui.setting-row label="Minimální podobnost" help="Výsledky s nižší kosinovou podobností se zahodí (0–1). Záleží na modelu, typicky 0,4–0,6.">
        <input type="number" class="form-control" style="max-width: 8rem" step="0.05" min="0" max="1" value="0.5">
    </x-ui.setting-row>
    <div class="d-flex justify-content-end gap-2 mt-3">
        <button class="btn btn-light btn-sm">Přeindexovat</button>
        <button class="btn btn-primary btn-sm">Uložit</button>
    </div>
</x-ui.section>

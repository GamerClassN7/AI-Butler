<x-ui.section title="Znalosti">
    <p class="small text-body-secondary">Přístup agentů a volitelné sémantické vyhledávání přes lokální model.</p>
    <x-ui.setting-row label="Osobní znalosti pro agenty" help="Smí MCP agenti číst prostor Osobní? Ve výchozím stavu vidí jen Projekty.">
        <div class="form-check form-switch mb-0">
            <input class="form-check-input" type="checkbox" id="kn-personal">
            <label class="form-check-label" for="kn-personal">Povolit agentům přístup k osobním znalostem</label>
        </div>
    </x-ui.setting-row>
    <x-ui.setting-row label="Sémantické vyhledávání" help="Doplní fulltext o vyhledávání podle významu. Funguje s libovolným OpenAI-kompatibilním endpointem – doporučeno Ollama + bge-m3 (umí česky).">
        <div class="form-check form-switch mb-0">
            <input class="form-check-input" type="checkbox" id="kn-semantic" checked>
            <label class="form-check-label" for="kn-semantic">Zapnout sémantické vyhledávání</label>
        </div>
    </x-ui.setting-row>
    <x-ui.setting-row label="Adresa endpointu" help="Např. http://localhost:11434/v1 (Ollama) nebo http://localhost:1234/v1 (LM Studio).">
        <input type="url" class="form-control" placeholder="http://localhost:11434/v1">
    </x-ui.setting-row>
    <x-ui.setting-row label="Model" help="Název embedding modelu na endpointu.">
        <input type="text" class="form-control" placeholder="bge-m3">
    </x-ui.setting-row>
    <x-ui.setting-row label="API klíč" help="Volitelné – lokální servery ho obvykle nepotřebují.">
        <input type="password" class="form-control">
    </x-ui.setting-row>
    <x-ui.setting-row label="Prefixy" help="Jen pro modely typu e5 / nomic (např. „query: “ a „passage: “).">
        <div class="d-flex gap-2">
            <input type="text" class="form-control" placeholder="Prefix dotazu">
            <input type="text" class="form-control" placeholder="Prefix dokumentu">
        </div>
    </x-ui.setting-row>
    <x-ui.setting-row label="Minimální podobnost" help="Výsledky s nižší kosinovou podobností se zahodí (0–1). Typicky 0,4–0,6.">
        <input type="number" class="form-control" step="0.05" min="0" max="1" value="0.5">
    </x-ui.setting-row>
    <div class="d-flex justify-content-end gap-2 mt-3">
        <button class="btn btn-light btn-sm">Otestovat</button>
        <button class="btn btn-light btn-sm">Přeindexovat</button>
        <button class="btn btn-primary btn-sm">Uložit</button>
    </div>
</x-ui.section>

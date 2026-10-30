<div>
    @if ($types && !$type)
        {{-- Step 1: pick a type --}}
        <div class="row g-2">
            @foreach ($types as $key => $option)
                <div class="col-6">
                    <button type="button" wire:click="pickType('{{ $key }}')" @disabled(!empty($option['disabled']))
                        class="btn border w-100 h-100 text-start d-flex align-items-start gap-2 p-3">
                        @isset($option['icon'])
                            <x-boilerplate::icon-tile :icon="$option['icon']" size="sm" />
                        @endisset
                        <span class="min-w-0">
                            <span class="d-block fw-semibold">{{ $option['label'] }}</span>
                            @if (!empty($option['disabled']))
                                <span class="d-block small text-body-tertiary">{{ __('Zatím nedostupné') }}</span>
                            @elseif (isset($option['description']))
                                <span class="d-block small text-body-secondary">{{ $option['description'] }}</span>
                            @endif
                        </span>
                    </button>
                </div>
            @endforeach
        </div>
    @else
        {{-- Step 2: details --}}
        @if ($type)
            <div class="d-flex align-items-center gap-2 mb-3">
                <x-boilerplate::icon-tile :icon="$types[$type]['icon'] ?? 'fas fa-circle'" size="sm" />
                <span class="fw-semibold me-auto">{{ $types[$type]['label'] }}</span>
                <button type="button" class="btn btn-sm btn-link" wire:click="resetType">{{ __('Změnit typ') }}</button>
            </div>
        @endif
        <x-form::form wire:submit.prevent="store">
            @foreach ($activeFields as $field)
                @php($fieldType = $field['type'] ?? 'text')
                @if ($fieldType === 'textarea')
                    <x-form::textarea :label="$field['label']" group-class="mb-3" rows="4" />
                @elseif ($fieldType === 'select')
                    <x-form::select :label="$field['label']" :options="$field['options'] ?? []" group-class="mb-3" />
                @elseif ($fieldType === 'checkboxes')
                    <div class="mb-3">
                        <label class="form-label">{{ $field['label'] }}</label>
                        @foreach ($field['options'] ?? [] as $value => $optionLabel)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="cb-{{ $loop->parent->index }}-{{ $loop->index }}">
                                <label class="form-check-label" for="cb-{{ $loop->parent->index }}-{{ $loop->index }}">{{ $optionLabel }}</label>
                            </div>
                        @endforeach
                    </div>
                @elseif ($fieldType === 'note')
                    <p class="small text-body-secondary">{{ $field['label'] }}</p>
                @else
                    <x-form::input :type="$fieldType" :label="$field['label']" group-class="mb-3" />
                @endif
            @endforeach
            <div class="d-flex justify-content-end gap-2">
                <button type="button" class="btn btn-light" wire:click="$dispatch('closeModal')">{{ __('Zrušit') }}</button>
                <x-form::button class="btn-primary" type="submit">{{ __('Uložit') }}</x-form::button>
            </div>
        </x-form::form>
    @endif
</div>

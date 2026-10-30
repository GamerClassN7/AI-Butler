<div>
    <x-form::form wire:submit.prevent="store">
        @foreach ($fields as $field)
            @php($type = $field['type'] ?? 'text')
            @if ($type === 'textarea')
                <x-form::textarea :label="$field['label']" group-class="mb-3" rows="4" />
            @elseif ($type === 'select')
                <x-form::select :label="$field['label']" :options="$field['options'] ?? []" group-class="mb-3" />
            @else
                <x-form::input :type="$type" :label="$field['label']" group-class="mb-3" />
            @endif
        @endforeach
        <div class="d-flex justify-content-end gap-2">
            <button type="button" class="btn btn-light" wire:click="$dispatch('closeModal')">{{ __('Zrušit') }}</button>
            <x-form::button class="btn-primary" type="submit">{{ __('Uložit') }}</x-form::button>
        </div>
    </x-form::form>
</div>

@props([
    'label' => '',
    'name' => '',
    'placeholder' => '',
    'value' => '',
    'prefix' => '62',
    'disabled' => false,
])

<label for="{{ $name }}" class="form-label">{{ $label }}</label>

<div class="input-group" style="padding:0;">

    <div class="input-group-text">
        {{ $prefix }}
    </div>

    <input
        type="text"
        name="{{ $name }}"
        placeholder="{{ $placeholder }}"
        value="{{ old($name, $value) }}"
        class="form-control"
        @if($disabled) disabled @endif
        {{ $attributes }}
    >
</div>

@props([
    'label' => '',
    'name' => '',
    'placeholder' => '',
    'value' => '',
    'prefix' => '62',
    'disabled' => false,
])

<label for="{{ $name }}" class="form-label">
    {{ $label }} <span class="text-danger">*</span>
</label>

<div class="input-group" style="padding:0;">

    <div class="input-group-text">
        {{ $prefix }}
    </div>

    <input
        pattern="[0-9]*"
        inputmode="numeric"
        maxlength="12"
        type="text"
        name="{{ $name }}"
        placeholder="{{ $placeholder }}"
        value="{{ old($name, $value) }}"
        class="form-control"
        @if($disabled) disabled @endif
        {{ $attributes }}
    >
</div>

@props([
    'label' => '',
    'type' => 'text',
    'name' => '',
    'placeholder' => '',
    'value' => '',
    'disabled' => false,
    'id'=> ''
])

<label for="{{ $name }}" class="form-label">{{ $label }}</label>

<input
    type="{{ $type }}"
    name="{{ $name }}"
    placeholder="{{ $placeholder }}"
    value="{{ old($name, $value) }}"
    class="form-control "
    id="{{$id}}"
    @if($disabled) disabled @endif
    {{ $attributes }}
>

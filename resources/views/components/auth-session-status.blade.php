@props(['status'])

@if ($status)
    <div style="color: green" {{ $attributes->merge(['class' => 'font-medium text-sm text-green-600']) }}>
        {{ $status }}
    </div>
@endif

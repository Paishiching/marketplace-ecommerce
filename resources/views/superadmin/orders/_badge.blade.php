@php
    $cfg   = config("order.{$type}.{$value}");
    $color = $cfg['color'] ?? 'secondary';
    $label = $cfg['label'] ?? \Illuminate\Support\Str::headline((string) $value ?: 'N/A');
@endphp
<div class="badge rounded-pill text-{{ $color }} bg-light-{{ $color }} p-2 text-uppercase px-3">
    <i class='bx bxs-circle me-1'></i>{{ $label }}
</div>
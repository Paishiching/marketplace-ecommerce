@php
    $raw = $status;
    if (is_bool($raw) || is_numeric($raw)) {
        $raw = $raw ? 'active' : 'inactive';
    }
    $key = strtolower((string) $raw);
    $color = match (true) {
        in_array($key, ['active', 'approved', 'completed', 'delivered', 'synced', 'success', 'enabled', 'paid']) => 'success',
        in_array($key, ['pending', 'processing', 'syncing', 'queued']) => 'warning',
        in_array($key, ['shipped', 'confirmed']) => 'info',
        default => 'danger',
    };
@endphp
<div class="badge rounded-pill text-{{ $color }} bg-light-{{ $color }} p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>{{ $key ?: 'n/a' }}</div>

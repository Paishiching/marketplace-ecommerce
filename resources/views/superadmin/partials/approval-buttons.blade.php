@php
    $status    = $model->status;
    $canReject = $canReject ?? false; // শুধু vendor-এ true দেবেন
@endphp

<div class="d-flex gap-2 flex-wrap">
    @if ($status !== 'approved')
        <form method="POST" action="{{ route($routePrefix . '.approve', $model) }}">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn btn-success btn-sm">
                {{ $status === 'suspended' ? 'Re-activate' : 'Approve' }}
            </button>
        </form>
    @endif

    @if ($canReject && $status === 'pending')
        <form method="POST" action="{{ route($routePrefix . '.reject', $model) }}"
              onsubmit="return confirm('Reject this application?')">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn btn-danger btn-sm">Reject</button>
        </form>
    @endif

    @if ($status === 'approved')
        <form method="POST" action="{{ route($routePrefix . '.suspend', $model) }}"
              onsubmit="return confirm('Suspend this account?')">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn btn-warning btn-sm">Suspend</button>
        </form>
    @endif
</div>

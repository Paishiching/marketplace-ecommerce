@php
    $skip = ['updated_at', 'deleted_at'];
    $cols = $rows->count()
        ? collect(array_keys($rows->first()->getAttributes()))->reject(fn ($c) => in_array($c, $skip, true))->values()
        : collect();
@endphp

<div class="table-responsive">
    <table class="table table-striped table-bordered align-middle mb-0">
        <thead class="table-light">
        <tr>
            <th>Order#</th>
            @foreach ($cols as $c)
                <th class="text-capitalize">{{ str_replace('_', ' ', $c) }}</th>
            @endforeach
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($rows as $row)
            @php $order = $orders[$row->order_id] ?? null; @endphp
            <tr>
                <td>#{{ $order->order_number ?? $row->order_id }}</td>
                @foreach ($cols as $c)
                    @php
                        $v = $row->{$c};
                        if (is_array($v) || is_object($v)) {
                            $v = $v instanceof \Carbon\Carbon ? $v->format('M d, Y h:i A') : json_encode($v);
                        }
                    @endphp
                    <td>{{ \Illuminate\Support\Str::limit((string) $v, 60) ?: '—' }}</td>
                @endforeach
                <td>
                    <a href="{{ route('vendor.orders.orders.show', $row->order_id) }}" class="btn btn-primary btn-sm radius-30 px-3">Order</a>
                </td>
            </tr>
        @empty
            <tr><td colspan="{{ $cols->count() + 2 }}" class="text-center py-4">{{ $empty ?? 'Kichu nai.' }}</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
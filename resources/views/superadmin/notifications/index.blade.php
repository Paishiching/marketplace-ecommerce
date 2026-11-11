@extends('layouts.superadmin.app')

@section('title', 'Notifications')

@section('content')
    @php
        $typeColor = fn ($t) => match ($t) {
            'success' => 'success',
            'warning' => 'warning',
            'danger'  => 'danger',
            default   => 'primary',
        };
        $typeIcon = fn ($t) => match ($t) {
            'success' => 'bx-check-circle',
            'warning' => 'bx-error',
            'danger'  => 'bx-x-circle',
            default   => 'bx-bell',
        };
    @endphp

    <div class="page-wrapper">
        <div class="page-content">

            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Administration</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboards') }}"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Notifications</li>
                        </ol>
                    </nav>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success border-0 alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center flex-wrap gap-2 mb-3">
                        <div>
                            <h5 class="mb-0">All Notifications</h5>
                            <small class="text-secondary">{{ $unreadCount }} unread</small>
                        </div>

                        <div class="ms-auto d-flex gap-2">
                            <div class="btn-group">
                                <a href="{{ route('superadmin.notifications.index') }}"
                                   class="btn btn-sm {{ request('status') ? 'btn-outline-primary' : 'btn-primary' }}">All</a>
                                <a href="{{ route('superadmin.notifications.index', ['status' => 'unread']) }}"
                                   class="btn btn-sm {{ request('status') === 'unread' ? 'btn-primary' : 'btn-outline-primary' }}">Unread</a>
                                <a href="{{ route('superadmin.notifications.index', ['status' => 'read']) }}"
                                   class="btn btn-sm {{ request('status') === 'read' ? 'btn-primary' : 'btn-outline-primary' }}">Read</a>
                            </div>

                            @if ($unreadCount > 0)
                                <form action="{{ route('superadmin.notifications.read-all') }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-outline-secondary">Mark all as read</button>
                                </form>
                            @endif
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                            <tr>
                                <th style="width:50px"></th>
                                <th>Notification</th>
                                <th>Time</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($notifications as $n)
                                @php $c = $typeColor($n->type); @endphp
                                <tr class="{{ $n->is_read ? '' : 'fw-semibold' }}">
                                    <td>
                                        <div class="notify bg-light-{{ $c }} text-{{ $c }}"><i class="bx {{ $typeIcon($n->type) }}"></i></div>
                                    </td>
                                    <td>
                                        <a href="{{ route('superadmin.notifications.show', $n) }}" class="text-reset">
                                            {{ $n->title }}
                                        </a>
                                        @if ($n->message)
                                            <div class="small text-secondary fw-normal">{{ \Illuminate\Support\Str::limit($n->message, 110) }}</div>
                                        @endif
                                    </td>
                                    <td class="text-nowrap">{{ $n->created_at->diffForHumans() }}</td>
                                    <td>
                                        <span class="badge bg-light-{{ $n->is_read ? 'secondary' : 'primary' }} text-{{ $n->is_read ? 'secondary' : 'primary' }}">
                                            {{ $n->is_read ? 'Read' : 'Unread' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-end gap-2">
                                            @unless ($n->is_read)
                                                <form action="{{ route('superadmin.notifications.update', $n) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-sm btn-outline-success" title="Mark as read"><i class="bx bx-check"></i></button>
                                                </form>
                                            @endunless
                                            <form action="{{ route('superadmin.notifications.destroy', $n) }}" method="POST"
                                                  onsubmit="return confirm('Ei notification ta delete korben?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"><i class="bx bx-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-secondary py-5">
                                        <i class="bx bx-bell-off font-30 d-block mb-1"></i>
                                        No notifications yet.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $notifications->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
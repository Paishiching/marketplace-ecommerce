@extends('layouts.superadmin.app')

@section('title','Customers')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">

            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Customers</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboards') }}"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">All Customers</li>
                        </ol>
                    </nav>
                </div>
            </div>

            @foreach (['success' => 'success', 'error' => 'danger'] as $key => $type)
                @if (session($key))
                    <div class="alert alert-{{ $type }} alert-dismissible fade show" role="alert">
                        {{ session($key) }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            @endforeach

            <div class="card">
                <div class="card-body">

                    <form method="GET" action="{{ route('superadmin.customers.index') }}" class="row g-2 mb-4">
                        <div class="col-lg-5">
                            <input type="text" name="q" value="{{ request('q') }}" class="form-control"
                                   placeholder="Name, email or phone">
                        </div>
                        <div class="col-lg-4 d-flex gap-2">
                            <button type="submit" class="btn btn-primary"><i class="bx bx-search"></i> Search</button>
                            <a href="{{ route('superadmin.customers.index') }}" class="btn btn-outline-secondary">Reset</a>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Customer</th>
                                <th>Phone</th>
                                <th>Gender</th>
                                <th class="text-center">Orders</th>
                                <th class="text-end">Total Spent</th>
                                <th class="text-center">Loyalty Points</th>
                                <th>Joined</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($customers as $customer)
                                <tr>
                                    <td>{{ $customer->id }}</td>
                                    <td>
                                        <h6 class="mb-0 font-14">{{ $customer->user->name ?? 'Deleted user' }}</h6>
                                        <div class="text-muted small">{{ $customer->user->email ?? '—' }}</div>
                                    </td>
                                    <td>{{ $customer->user->phone ?? '—' }}</td>
                                    <td class="text-capitalize">{{ $customer->gender ?? '—' }}</td>
                                    <td class="text-center">{{ $customer->orders_count }}</td>
                                    <td class="text-end">Tk. {{ number_format($customer->total_spent ?? 0, 2) }}</td>
                                    <td class="text-center">{{ $customer->loyalty_points ?? 0 }}</td>
                                    <td>{{ $customer->created_at?->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('superadmin.customers.show', $customer->id) }}"
                                           class="btn btn-primary btn-sm radius-30 px-4">View</a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="9" class="text-center py-4">No customers found.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $customers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@extends('layouts.superadmin.app')
@section('title','Dropshipping Settings')
@section('content')
    <div class="page-wrapper"><div class="page-content">
            @include('superadmin.partials.page-header', ['title' => 'Dropshipping', 'current' => 'Settings'])

            <div class="card"><div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-middle mb-0">
                            <thead class="table-light">
                            <tr><th>Vendor</th><th>Auto Sync</th><th>Markup %</th><th>Action</th></tr>
                            </thead>
                            <tbody>
                            @forelse ($settings as $s)
                                <tr>
                                    <td>{{ $s->vendor?->shop_name ?? $s->vendor?->name ?? 'Vendor #' . $s->vendor_id }}</td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="auto_sync" value="1"
                                                   form="setting-{{ $s->id }}" @checked($s->auto_sync)>
                                        </div>
                                    </td>
                                    <td style="max-width:160px">
                                        <input type="number" step="0.01" min="0" name="markup_percentage" class="form-control form-control-sm"
                                               form="setting-{{ $s->id }}" value="{{ $s->markup_percentage }}">
                                    </td>
                                    <td>
                                        <form id="setting-{{ $s->id }}" action="{{ route('superadmin.dropshipping.settings.update', $s) }}" method="POST" class="m-0">
                                            @csrf @method('PUT')
                                            <button class="btn btn-sm btn-primary">Save</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center py-4">No vendor settings found.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">{{ $settings->links('pagination::bootstrap-5') }}</div>
                </div></div>
        </div></div>
@endsection

@php $selected = old('permissions', $assigned); @endphp

<div class="card">
    <div class="card-body p-4">
        <div class="mb-4" style="max-width:420px;">
            <label for="name" class="form-label">Role Name <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $role->name) }}" placeholder="e.g. manager, support" required>
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="d-flex align-items-center mb-2">
            <h5 class="card-title mb-0">Permissions</h5>
            <div class="ms-auto form-check">
                <input class="form-check-input" type="checkbox" id="checkAll">
                <label class="form-check-label" for="checkAll">Select all</label>
            </div>
        </div>
        <hr/>

        @error('permissions.*') <div class="text-danger mb-2">{{ $message }}</div> @enderror

        <div class="row">
            @forelse ($groups as $group => $permissions)
                <div class="col-md-6 col-xl-4 mb-3">
                    <div class="border rounded p-3 h-100 perm-group">
                        <div class="form-check mb-2 pb-2 border-bottom">
                            <input class="form-check-input group-check" type="checkbox" id="group-{{ $loop->index }}">
                            <label class="form-check-label fw-bold" for="group-{{ $loop->index }}">
                                {{ \Illuminate\Support\Str::headline(str_replace('.', ' ', $group)) }}
                            </label>
                        </div>
                        @foreach ($permissions as $permission)
                            <div class="form-check">
                                <input class="form-check-input perm-check" type="checkbox" name="permissions[]"
                                       value="{{ $permission->name }}" id="perm-{{ $permission->id }}"
                                       @checked(in_array($permission->name, $selected))>
                                <label class="form-check-label" for="perm-{{ $permission->id }}">
                                    {{ $permission->action_label }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="col-12 text-muted">No permissions found. Run <code>php artisan permissions:sync</code>.</div>
            @endforelse
        </div>
    </div>
</div>

<div class="d-flex gap-2 mb-4">
    <a href="{{ route('superadmin.roles.index') }}" class="btn btn-outline-secondary btn-lg">Cancel</a>
    <button type="submit" class="btn btn-primary btn-lg">{{ $submit }}</button>
</div>

@push('scripts')
    <script>
        (function () {
            const all = document.getElementById('checkAll');
            const perms = () => document.querySelectorAll('.perm-check');

            function refresh() {
                document.querySelectorAll('.perm-group').forEach(function (g) {
                    const boxes = g.querySelectorAll('.perm-check');
                    g.querySelector('.group-check').checked = boxes.length && [...boxes].every(b => b.checked);
                });
                all.checked = perms().length && [...perms()].every(b => b.checked);
            }

            all.addEventListener('change', function () {
                perms().forEach(b => b.checked = all.checked);
                refresh();
            });

            document.querySelectorAll('.group-check').forEach(function (gc) {
                gc.addEventListener('change', function () {
                    gc.closest('.perm-group').querySelectorAll('.perm-check').forEach(b => b.checked = gc.checked);
                    refresh();
                });
            });

            perms().forEach(b => b.addEventListener('change', refresh));
            refresh();
        })();
    </script>
@endpush
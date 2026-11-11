@php
    $adminUser = auth()->user();
    $productRoute = $adminUser->can('admin.products.products.index') ? 'admin.products.products.index' : null;
    $categoryRoute = $adminUser->can('admin.products.categories.index') ? 'admin.products.categories.index' : null;
@endphp
<header>
    <div class="topbar d-flex align-items-center">
        <nav class="navbar navbar-expand gap-3">
            <div class="mobile-toggle-menu"><i class='bx bx-menu'></i></div>
            <div class="top-menu-left d-none d-lg-block"><ul class="nav">
                @if ($productRoute)<li class="nav-item"><a class="nav-link" href="{{ route($productRoute) }}" title="Products"><i class='bx bx-cart-alt'></i></a></li>@endif
                @if ($categoryRoute)<li class="nav-item"><a class="nav-link" href="{{ route($categoryRoute) }}" title="Categories"><i class='bx bx-category'></i></a></li>@endif
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboards') }}" title="Dashboard"><i class='bx bx-home'></i></a></li>
            </ul></div>
            <div class="search-bar flex-grow-1"><div class="position-relative search-bar-box">
                @if ($productRoute)<form action="{{ route($productRoute) }}" method="GET"><input type="text" name="search" value="{{ request('search') }}" class="form-control search-control" placeholder="Search products or categories..."><span class="position-absolute top-50 search-show translate-middle-y"><i class='bx bx-search'></i></span><span class="position-absolute top-50 search-close translate-middle-y"><i class='bx bx-x'></i></span></form>@endif
            </div></div>
            <div class="top-menu ms-auto"><ul class="navbar-nav align-items-center gap-1">
                <li class="nav-item mobile-search-icon"><a class="nav-link" href="javascript:;"><i class='bx bx-search'></i></a></li>
                <li class="nav-item dark-mode d-none d-sm-flex"><a class="nav-link dark-mode-icon" href="javascript:;"><i class='bx bx-moon'></i></a></li>
                <li class="nav-item dropdown dropdown-large"><a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown"><i class='bx bx-category'></i></a>
                    <div class="dropdown-menu dropdown-menu-end"><div class="row row-cols-2 g-3 p-3">
                        @if ($productRoute)<div class="col text-center"><a href="{{ route($productRoute) }}" class="text-reset text-decoration-none"><div class="app-box mx-auto bg-gradient-cosmic"><i class='bx bx-cart-alt'></i></div><div class="app-title">Products</div></a></div>@endif
                        @if ($categoryRoute)<div class="col text-center"><a href="{{ route($categoryRoute) }}" class="text-reset text-decoration-none"><div class="app-box mx-auto bg-gradient-burning"><i class='bx bx-category'></i></div><div class="app-title">Categories</div></a></div>@endif
                    </div></div>
                </li>
            </ul></div>
            <div class="user-box dropdown px-3"><a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown">
                @if ($adminUser->avatar)<img src="{{ asset('storage/' . $adminUser->avatar) }}" class="user-img" alt="user avatar">@else<img src="{{ asset('superadmin/assets/images/avatars/avatar-2.png') }}" class="user-img" alt="user avatar">@endif
                <div class="user-info ps-3"><p class="user-name mb-0">{{ $adminUser->name }}</p><p class="designattion mb-0">Admin</p></div>
            </a><ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="{{ route('admin.dashboards') }}"><i class='bx bx-home-circle'></i><span>Dashboard</span></a></li>
                <li><a class="dropdown-item" href="{{ route('homes') }}" target="_blank"><i class='bx bx-link-external'></i><span>Visit Website</span></a></li>
                <li><div class="dropdown-divider mb-0"></div></li>
                <li><a class="dropdown-item" href="javascript:;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class='bx bx-log-out-circle'></i><span>Logout</span></a><form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form></li>
            </ul></div>
        </nav>
    </div>
</header>

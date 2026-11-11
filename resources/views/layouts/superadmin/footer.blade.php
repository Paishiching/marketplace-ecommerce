@php $siteSettings = \App\Models\WebsiteSetting::current(); @endphp
<footer class="page-footer">
    <p class="mb-0">Copyright © {{ date('Y') }} {{ $siteSettings->site_name ?? config('app.name') }}. All rights reserved.</p>
</footer>
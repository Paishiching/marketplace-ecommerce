<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href=" {{asset('/')}}superadmin/assets/images/favicon-32x32.png" type="image/png" />
    <!--plugins-->
    <link href=" {{asset('/')}}superadmin/assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <link href=" {{asset('/')}}superadmin/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
    <link href=" {{asset('/')}}superadmin/assets/plugins/highcharts/css/highcharts.css" rel="stylesheet" />
    <link href=" {{asset('/')}}superadmin/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
    <link href=" {{asset('/')}}superadmin/assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
    <!-- loader-->
    <link href=" {{asset('/')}}superadmin/assets/css/pace.min.css" rel="stylesheet" />
    <script src=" {{asset('/')}}superadmin/assets/js/pace.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href=" {{asset('/')}}superadmin/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href=" {{asset('/')}}superadmin/assets/css/bootstrap-extended.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
    <link href=" {{asset('/')}}superadmin/assets/css/app.css" rel="stylesheet">
    <link href=" {{asset('/')}}superadmin/assets/css/icons.css" rel="stylesheet">
    <!-- Theme Style CSS -->
    <link rel="stylesheet" href=" {{asset('/')}}superadmin/assets/css/dark-theme.css" />
    <link rel="stylesheet" href=" {{asset('/')}}superadmin/assets/css/semi-dark.css" />
    <link rel="stylesheet" href=" {{asset('/')}}superadmin/assets/css/header-colors.css" />
    <link rel="stylesheet" href="{{ asset('css/responsive-overrides.css') }}?v=1" />

    <!--database search-->
    <link href=" {{asset('/')}}superadmin/assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />


    <link href=" {{asset('/')}}superadmin/assets/plugins/Drag-And-Drop/dist/imageuploadify.min.css" rel="stylesheet" />
    <title>MarketPlace–@yield('title')</title>



    @php $settings = \App\Models\WebsiteSetting::current(); @endphp

    <link rel="icon" href="{{ $settings->favicon ? asset('storage/'.$settings->favicon) : asset('favicon.ico') }}">
    <title>{{ $settings->meta_title ?? $settings->site_name }}</title>
    <meta name="description" content="{{ $settings->meta_description }}">

    @if ($settings->google_tag_manager_id)
    <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','{{ $settings->google_tag_manager_id }}');</script>
        <!-- End Google Tag Manager -->
    @endif

    @if ($settings->google_analytics_id)
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $settings->google_analytics_id }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $settings->google_analytics_id }}');
        </script>
    @endif

    @stack('styles')
</head>

<body>

@if ($settings->google_tag_manager_id)
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $settings->google_tag_manager_id }}"
                      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
@endif


<!--wrapper-->
<div class="wrapper">
    <!--sidebar wrapper -->
@hasSection('sidebar')
    @yield('sidebar')
@else
    @include('layouts.superadmin.sidebar')
@endif
<!--end sidebar wrapper -->

    <!--start header -->
@hasSection('header')
    @yield('header')
@else
    @include('layouts.superadmin.header')
@endif
<!--end header -->

    <!--start page wrapper -->
@yield('content')
<!--end page wrapper -->


    <!--start overlay-->
    <div class="overlay toggle-icon"></div>
    <!--end overlay-->
    <!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
    <!--End Back To Top Button-->
    @include('layouts.superadmin.footer')
</div>
<!--end wrapper-->
<!--start switcher-->
<div class="switcher-wrapper">
    <div class="switcher-btn"> <i class='bx bx-cog bx-spin'></i>
    </div>
    <div class="switcher-body">
        <div class="d-flex align-items-center">
            <h5 class="mb-0 text-uppercase">Theme Customizer</h5>
            <button type="button" class="btn-close ms-auto close-switcher" aria-label="Close"></button>
        </div>
        <hr/>
        <h6 class="mb-0">Theme Styles</h6>
        <hr/>
        <div class="d-flex align-items-center justify-content-between">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="lightmode" checked>
                <label class="form-check-label" for="lightmode">Light</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="darkmode">
                <label class="form-check-label" for="darkmode">Dark</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="semidark">
                <label class="form-check-label" for="semidark">Semi Dark</label>
            </div>
        </div>
        <hr/>
        <div class="form-check">
            <input class="form-check-input" type="radio" id="minimaltheme" name="flexRadioDefault">
            <label class="form-check-label" for="minimaltheme">Minimal Theme</label>
        </div>
        <hr/>
        <h6 class="mb-0">Header Colors</h6>
        <hr/>
        <div class="header-colors-indigators">
            <div class="row row-cols-auto g-3">
                <div class="col"><div class="indigator headercolor1" id="headercolor1"></div></div>
                <div class="col"><div class="indigator headercolor2" id="headercolor2"></div></div>
                <div class="col"><div class="indigator headercolor3" id="headercolor3"></div></div>
                <div class="col"><div class="indigator headercolor4" id="headercolor4"></div></div>
                <div class="col"><div class="indigator headercolor5" id="headercolor5"></div></div>
                <div class="col"><div class="indigator headercolor6" id="headercolor6"></div></div>
                <div class="col"><div class="indigator headercolor7" id="headercolor7"></div></div>
                <div class="col"><div class="indigator headercolor8" id="headercolor8"></div></div>
            </div>
        </div>
        <hr/>
        <h6 class="mb-0">Sidebar Backgrounds</h6>
        <hr/>
        <div class="header-colors-indigators">
            <div class="row row-cols-auto g-3">
                <div class="col"><div class="indigator sidebarcolor1" id="sidebarcolor1"></div></div>
                <div class="col"><div class="indigator sidebarcolor2" id="sidebarcolor2"></div></div>
                <div class="col"><div class="indigator sidebarcolor3" id="sidebarcolor3"></div></div>
                <div class="col"><div class="indigator sidebarcolor4" id="sidebarcolor4"></div></div>
                <div class="col"><div class="indigator sidebarcolor5" id="sidebarcolor5"></div></div>
                <div class="col"><div class="indigator sidebarcolor6" id="sidebarcolor6"></div></div>
                <div class="col"><div class="indigator sidebarcolor7" id="sidebarcolor7"></div></div>
                <div class="col"><div class="indigator sidebarcolor8" id="sidebarcolor8"></div></div>
            </div>
        </div>
    </div>
</div>

<!--end switcher-->
<!-- Bootstrap JS -->
<script src=" {{asset('/')}}superadmin/assets/js/bootstrap.bundle.min.js"></script>
<!--plugins-->
<script src=" {{asset('/')}}superadmin/assets/js/jquery.min.js"></script>
<script src=" {{asset('/')}}superadmin/assets/plugins/simplebar/js/simplebar.min.js"></script>
<script src=" {{asset('/')}}superadmin/assets/plugins/metismenu/js/metisMenu.min.js"></script>
<script src=" {{asset('/')}}superadmin/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
<script src=" {{asset('/')}}superadmin/assets/plugins/highcharts/js/highcharts.js"></script>
<script src=" {{asset('/')}}superadmin/assets/plugins/highcharts/js/exporting.js"></script>
<script src=" {{asset('/')}}superadmin/assets/plugins/highcharts/js/variable-pie.js"></script>
<script src=" {{asset('/')}}superadmin/assets/plugins/highcharts/js/export-data.js"></script>
<script src=" {{asset('/')}}superadmin/assets/plugins/highcharts/js/accessibility.js"></script>
<script src=" {{asset('/')}}superadmin/assets/plugins/apexcharts-bundle/js/apexcharts.min.js"></script>

<!--app JS-->
<script src=" {{asset('/')}}superadmin/assets/js/app.js"></script>
<script>
    ['.customers-list', '.store-metrics', '.product-list'].forEach(function (s) {
        var el = document.querySelector(s);
        if (el) { new PerfectScrollbar(el); }
    });
</script>

<script src="{{asset('/')}}superadmin/assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
<script src="{{asset('/')}}superadmin/assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function () {
        if ($('#example').length) {
            $('#example').DataTable();
        }

        if ($('#example2').length) {
            var table = $('#example2').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf', 'print']
            });

            if (typeof table.buttons === 'function') {
                table.buttons().container()
                    .appendTo('#example2_wrapper .col-md-6:eq(0)');
            }
        }
    });
</script>

<!--plugins-->
<script src="{{asset('/')}}superadmin/assets/plugins/Drag-And-Drop/dist/imageuploadify.min.js"></script>
<script>
    $(document).ready(function () {
        if ($('#image-uploadify').length) {
            $('#image-uploadify').imageuploadify();
        }
    });
</script>

@stack('scripts')

</body>
</html>

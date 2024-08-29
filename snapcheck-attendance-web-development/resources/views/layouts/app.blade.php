<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<head><base href="../../../"/>
    <title>SnapCheck</title>
    <meta charset="utf-8" />
    <meta name="description" content="The most advanced Bootstrap 5 Admin Theme with 40 unique prebuilt layouts on Themeforest trusted by 100,000 beginners and professionals. Multi-demo, Dark Mode, RTL support and complete React, Angular, Vue, Asp.Net Core, Rails, Spring, Blazor, Django, Express.js, Node.js, Flask, Symfony & Laravel versions. Grab your copy now and get life-time updates for free." />
    <meta name="keywords" content="metronic, bootstrap, bootstrap 5, angular, VueJs, React, Asp.Net Core, Rails, Spring, Blazor, Django, Express.js, Node.js, Flask, Symfony & Laravel starter kits, admin themes, web design, figma, web development, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button, bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="Metronic - Bootstrap Admin Template, HTML, VueJS, React, Angular. Laravel, Asp.Net Core, Ruby on Rails, Spring Boot, Blazor, Django, Express.js, Node.js, Flask Admin Dashboard Theme & Template" />
    <meta property="og:url" content="https://keenthemes.com/metronic" />
    <meta property="og:site_name" content="Keenthemes | Metronic" />
    <link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{secure_asset('metronic/demo6/dist/assets/media/logos/favicon.ico')}}" />
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Vendor Stylesheets(used for this page only)-->
    <link href="{{asset('metronic/demo6/dist/assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
    <!--end::Vendor Stylesheets-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{asset('metronic/demo6/dist/assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('metronic/demo6/dist/assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('metronic/demo6/dist/assets/css/custom.css')}}" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
    <script>// Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }</script>
    <script src="{{ asset('metronic/demo6/dist/assets/js/jquery.js') }}"></script>
    <script src="{{asset('metronic/demo6/dist/assets/plugins/global/plugins.bundle.js')}}"></script>
    <script src="{{asset('metronic/demo6/dist/assets/js/scripts.bundle.js')}}"></script>
</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed">
<!--begin::Theme mode setup on page load-->
<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
<!--end::Theme mode setup on page load-->
<!--begin::Main-->
<!--begin::Root-->
<div class="d-flex flex-column flex-root">
    <!--begin::Page-->
    <div class="page d-flex flex-row flex-column-fluid">
        <!--begin::Aside-->
        @include('layouts.aside')
        <!--end::Aside-->
        <!--begin::Wrapper-->
        <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
            <!--begin::Header-->
            <div id="kt_header" style="" class="header align-items-stretch d-md-none">
                <!--begin::Container-->
                <div class="container-fluid d-flex align-items-stretch justify-content-between">
                    <!--begin::Aside mobile toggle-->
                    <div class="d-flex align-items-center d-lg-none ms-n1 me-2" title="Show aside menu">
                        <div class="btn btn-icon btn-active-color-primary w-30px h-30px w-md-40px h-md-40px" id="kt_aside_mobile_toggle">
                            <i class="ki-outline ki-abstract-14 fs-1"></i>
                        </div>
                    </div>
                    <!--end::Aside mobile toggle-->
                    <!--begin::Mobile logo-->
                    <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
                        <a href="../../demo6/dist/index.html" class="d-lg-none">
                            <img alt="Logo" src="{{asset('metronic/demo6/dist/assets/media/logos/demo6.svg')}}" class="h-25px" />
                        </a>
                    </div>
                    <!--end::Mobile logo-->
                    <!--begin::Wrapper-->
                    <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
                        <!--begin::Navbar-->
                        <div class="d-flex align-items-stretch" id="kt_header_nav">
                            <!--begin::Menu wrapper-->
                            <div class="header-menu align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_header_menu_mobile_toggle" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header_nav'}">
                                <!--begin::Menu-->
                                <div class="menu menu-rounded menu-column menu-lg-row menu-active-bg menu-state-primary menu-title-gray-700 menu-arrow-gray-400 fw-semibold my-5 my-lg-0 px-2 px-lg-0 align-items-stretch" id="#kt_header_menu" data-kt-menu="true">

                                </div>
                                <!--end::Menu-->
                            </div>
                            <!--end::Menu wrapper-->
                        </div>
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Container-->
            </div>
            <!--end::Header-->
            <!--begin::Toolbar-->
            @yield('content')
            <!--end::Content-->
            <!--begin::Footer-->
            <div class="footer py-4 d-flex flex-lg-column" id="kt_footer">
                <!--begin::Container-->
                <div class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
                    <!--begin::Copyright-->
                    <div class="text-dark order-2 order-md-1">
                        <span class="text-muted fw-semibold me-1">2024&copy;</span>
                        <a href="https://keenthemes.com" target="_blank" class="text-gray-800 text-hover-primary">SnapCheck</a>
                    </div>
                    <!--end::Copyright-->
                    <!--begin::Menu-->
                    <ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1">
                        <li class="menu-item">
                            <a href="https://keenthemes.com" target="_blank" class="menu-link px-2"></a>
                        </li>
                        <li class="menu-item">
                            <a href="https://devs.keenthemes.com" target="_blank" class="menu-link px-2"></a>
                        </li>
                        <li class="menu-item">
                            <a href="https://1.envato.market/EA4JP" target="_blank" class="menu-link px-2"></a>
                        </li>
                    </ul>
                    <!--end::Menu-->
                </div>
                <!--end::Container-->
            </div>
            <!--end::Footer-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Page-->
</div>

<!--begin::Scrolltop-->
<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
    <i class="ki-outline ki-arrow-up"></i>
</div>
<!--end::Modal - Create Campaign-->
<!--begin::Modal - Users Search-->

<!--end::Modal - Invite Friend-->
<!--end::Modals-->
<!--begin::Javascript-->
<script>var hostUrl = "assets/";</script>
<!--begin::Global Javascript Bundle(mandatory for all pages)-->

<!--end::Global Javascript Bundle-->
<!--begin::Vendors Javascript(used for this page only)-->
{{--<script src="{{asset('metronic/demo6/dist/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>--}}
<!--end::Vendors Javascript-->
<!--begin::Custom Javascript(used for this page only)-->
{{--<script src="{{asset('metronic/demo6/dist/assets/js/custom/apps/user-management/users/list/table.js')}}"></script>--}}
{{--<script src="{{asset('metronic/demo6/dist/assets/js/custom/apps/user-management/users/list/export-users.js')}}"></script>--}}
{{--<script src="{{asset('metronic/demo6/dist/assets/js/custom/apps/user-management/users/list/add.js')}}"></script>--}}
{{--<script src="{{asset('metronic/demo6/dist/assets/js/widgets.bundle.js')}}"></script>--}}
{{--<script src="{{asset('metronic/demo6/dist/assets/js/custom/widgets.js')}}"></script>--}}
{{--<script src="{{asset('metronic/demo6/dist/assets/js/custom/apps/chat/chat.js')}}"></script>--}}
{{--<script src="{{asset('metronic/demo6/dist/assets/js/custom/utilities/modals/upgrade-plan.js')}}"></script>--}}
{{--<script src="{{asset('metronic/demo6/dist/assets/js/custom/utilities/modals/create-campaign.js')}}"></script>--}}
{{--<script src="{{asset('metronic/demo6/dist/assets/js/custom/utilities/modals/users-search.js')}}"></script>--}}
<!--end::Custom Javascript-->
<!--end::Javascript-->
</body>
<!--end::Body-->
</html>

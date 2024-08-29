
<div id="kt_toolbar_container" class="container-fluid d-flex align-items-center">
    <!--begin::Page title-->
    <div class="flex-grow-1 flex-shrink-0 me-5">
        <!--begin::Page title-->
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <!--begin::Title-->
            <h1 class="d-flex align-items-center text-dark fw-bold my-1 fs-3">{{ $pageName }}</h1>
            <!--end::Title-->
            <!--begin::Separator-->
            <span class="h-20px border-gray-200 border-start mx-3"></span>
            <!--end::Separator-->
            <!--begin::Breadcrumb-->
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-1">
                <!--begin::Item-->

                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted">{{ $bigSection }}</li>
                <!--end::Item-->
                <!--begin::Item-->
                @if(isset($feature))
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-200 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">{{ $feature }}</li>
                @endif

                <!--end::Item-->
                <!--begin::Item-->
                @if(isset($pageName))
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-200 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-dark">{{ $pageName }}</li>
                @endif

                <!--end::Item-->
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
    </div>
    <!--end::Page title-->
    <!--begin::Action group-->
    <div class="d-flex align-items-center flex-wrap">
        <!--begin::Wrapper-->

        <!--end::Wrapper-->
    </div>
    <!--end::Action group-->
</div>

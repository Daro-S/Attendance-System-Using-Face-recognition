<!--begin::Alert-->
@if($message = Session::get('success'))
    {{--Alert sucess--}}
    <div class="alert alert-dismissible bg-light-success border border-success d-flex flex-column flex-sm-row p-5 mb-10">
        <!--begin::Icon-->
        <i class="ki-duotone ki-check-circle fs-2hx text-success me-4 mb-5 mb-sm-0"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
        <!--end::Icon-->

        <!--begin::Wrapper-->
        <div class="d-flex flex-column pe-0 pe-sm-10">
            <!--begin::Title-->
            <h5 class="mt-3"> {{ $message }}</h5>
            <!--end::Title-->

            <!--begin::Content-->
{{--            <span>{{ $message }}</span>--}}
            <!--end::Content-->
        </div>
        <!--end::Wrapper-->

        <!--begin::Close-->
        <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
            <i class="ki-duotone ki-cross fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
        </button>
        <!--end::Close-->
    </div>
@endif
{{--Alert failed--}}
@if($message = Session::get('error'))
    <div class="alert alert-dismissible bg-light-danger border border-danger d-flex flex-column flex-sm-row p-5 mb-10">
        <!--begin::Icon-->
        <i class="bi bi-exclamation-circle-fill fs-2hx text-danger me-4 mb-5 mb-sm-0"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
        <!--end::Icon-->

        <!--begin::Wrapper-->
        <div class="d-flex flex-column pe-0 pe-sm-10">
            <!--begin::Title-->
            <h5 class="mt-3"> {{ $message }}</h5>
            <!--end::Title-->

            <!--begin::Content-->
{{--            <span>{{ $message }}</span>--}}
            <!--end::Content-->
        </div>
        <!--end::Wrapper-->

        <!--begin::Close-->
        <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
            <i class="ki-duotone ki-cross fs-1 text-danger"><span class="path1"></span><span class="path2"></span></i>
        </button>
        <!--end::Close-->
    </div>
@endif
<!--end::Alert-->
@if($message = Session::get('logout-required'))
    {{--Alert sucess--}}
    <form id="logout" method="get" action="{{ route('logout') }}">
        @csrf
    </form>
    <script>
        let $logoutForm = document.getElementById('logout');
        Swal.fire({
            text: "{{ $message }}",
            icon: "success",
            buttonsStyling: false,
            confirmButtonText: "Sign out",
            customClass: {
                confirmButton: "btn btn-primary"
            },
            allowOutsideClick: false
        }).then((result) => {
            if (result.isConfirmed) {
                $logoutForm.submit();
            }
        });
    </script>
@endif

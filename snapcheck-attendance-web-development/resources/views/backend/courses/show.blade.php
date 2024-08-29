@php
    /**
     * @var App\Models\Course $course
     */
@endphp
@extends('layouts.app')
@section('content')
    {{--Top bar --}}
    <div class="toolbar py-2" id="kt_toolbar">
        <!--begin::Container-->
        @include('layouts.topbar',['bigSection'=>'Courses management','feature' => 'Courses','pageName' => 'Course details'])
        <!--end::Container-->
    </div>
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Card-->
            <div class="card">

                <div class="card-body pt-9 pb-0">
                    <!--begin::Details-->
                    <div class="d-flex flex-wrap flex-sm-nowrap d-none">
                        <!--begin: Pic-->
                        <div class="me-7 mb-4">
                            <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">


                                    <img src="metronic/demo6/dist/assets/media/svg/brand-logos/plurk.svg" alt="Emma Smith" class="w-100" />

                                <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success bg-success rounded-circle border border-4 border-body h-20px w-20px"></div>
                            </div>
                        </div>
                        <!--end::Pic-->
                        <!--begin::Info-->
                        <div class="flex-grow-1" >
                            <!--begin::Title-->
                            <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                                <!--begin::User-->
                                <div class="d-flex flex-column">
                                    <!--begin::Name-->
                                    <div class="d-flex align-items-center mb-2">
                                        <span href="#" class="text-gray-900 fs-2 fw-bold me-1">{{ $course->name }}</span>
                                        <span href="#">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                                    </div>
                                    <!--end::Name-->
                                    <!--begin::Info-->
                                    <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2 row">
                                <span class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">

                                        <span class="  fs-7 me-1">{{$course->course_description}}</span>
{{--                                    @empty--}}
                                    {{--                                    @endforelse--}}
                                </span>
                                        <span class="d-flex align-items-center text-gray-400 text-hover-primary mb-2"></span>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="py-3">
                    <div class="card mb-5 mb-xl-10 fs-4" id="kt_profile_details_view" >
                        <!--begin::Card header-->
                        <div class="card-header cursor-pointer">
                            <!--begin::Card title-->
                            <div class="card-title m-0">
                                <h3 class="fw-bold m-0">Course Detail</h3>
                            </div>


                                <form class="form_delete" method="POST" action="{{ route('course.destroy', $course) }}">
                                    @csrf
                                    @method('DELETE')
                                    <span>
                                        <a href="{{ route('course.edit',$course) }}" class="btn btn-primary ">Edit</a>

                                        <button data-name="{{ $course->name }}" type="submit" class="btn btn-danger delete_element">Delete</button>
                                    </span>
                                </form>




                            <!--end::Action-->
                        </div>
                        <!--begin::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body p-9">


                            <div class="row mb-7">
                                <!--begin::Label-->
                                <label class="col-lg-4 fw-semibold text-muted">Course Name</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <span class=" text-gray-800 fw-bold">{{ $course->name }}</span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <div class="row mb-7">
                                <!--begin::Label-->
                                <label class="col-lg-4 fw-semibold text-muted">Course Description</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <span class="fw-semibold text-gray-800 fw-bold">{{ $course->description }}</span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <div class="row mb-7">
                                <!--begin::Label-->
                                <label class="col-lg-4 fw-semibold text-muted">Course Color</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <span class="fw-semibold text-gray-800 fw-bold "  style="color:{{$course->color}};" > {{ $course->color }}</span>
                                </div>
                                <!--end::Col-->
                            </div>


                            <div class="row mb-7">
                                <!--begin::Label-->
                                <label class="col-lg-4 fw-semibold text-muted">Created at</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                            <span class="fw-semibold text-gray-800">
                                {{ $course->created_at->format('d M Y, h:i a') }}
                            </span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <div class="row mb-7">
                                <!--begin::Label-->
                                <label class="col-lg-4 fw-semibold text-muted">Updated at</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                            <span class="fw-semibold text-gray-800">
                                {{ $course->updated_at->format('d M Y, h:i a') }}
                            </span>
                                </div>
                                <!--end::Col-->
                            </div>
                        </div>
                        <!--end::Card body-->
                    </div>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--begin::Group actions-->
    <div class="d-flex justify-content-end align-items-center d-none" data-kt-user-table-toolbar="selected">
        <div class="fw-bold me-5">
            <span class="me-2" data-kt-user-table-select="selected_count"></span>Selected</div>
        <button type="button" class="btn btn-danger" data-kt-user-table-select="delete_selected">Delete Selected</button>
    </div>
    <script>

        $(document).ready(function(){

            $('.delete_element').on('click', function (e) {
                e.preventDefault();
                let $thisForm = $(this).closest('.form_delete');
                let name = $(this).data('name');
                Swal.fire({
                    title: 'Are you sure you want to delete <span class="text-danger">' + name + '</span> ?',
                    icon: 'warning',
                    iconColor: '#d33',
                    showCancelButton: true,
                    confirmButtonColor: '#F94144',
                    cancelButtonColor: '#70757E',
                    cancelButtonText: 'No, Cancel',
                    confirmButtonText: 'Yes, delete!',
                    customClass: {
                        title: 'fw-bold fs-2',
                    },
                    reverseButtons: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $thisForm.submit();
                    }
                })
            })
        })
    </script>
@endsection

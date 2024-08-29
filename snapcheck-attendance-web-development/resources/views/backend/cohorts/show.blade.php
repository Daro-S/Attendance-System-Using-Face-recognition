@php
    /**
     * @var App\Models\Cohort $cohort
     */
@endphp
@extends('layouts.app')
@section('content')
    {{--Top bar --}}
    <div class="toolbar py-2" id="kt_toolbar">
        <!--begin::Container-->
        @include('layouts.topbar',['bigSection'=>'Cohorts management','feature' => 'Cohort','pageName' => 'Cohort details'])
        <!--end::Container-->
    </div>
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Card-->
            <div class="card">


                <div class="card-body pt-9 pb-0">
                    <!--begin::Details-->
                    <div class="d-flex flex-wrap flex-sm-nowrap">
                        <!--begin: Pic-->
                        <div class="me-7 mb-4">
                            <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">


                                <img src="{{asset($cohort->profile_path)}}" alt="Emma Smith" class="w-100" />

                                <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success bg-success rounded-circle border border-4 border-body h-20px w-20px"></div>
                            </div>
                        </div>
                        <!--end::Pic-->
                        <!--begin::Info-->
                        <div class="flex-grow-1">
                            <!--begin::Title-->
                            <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                                <!--begin::User-->
                                <div class="d-flex flex-column">
                                    <!--begin::Name-->
                                    <div class="d-flex align-items-center mb-2">
                                        <span href="#" class="text-gray-900 fs-2 fw-bold me-1">{{ $cohort->name }}</span>
                                        <span href="#">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                </span>
                                    </div>
                                    <!--end::Name-->
                                    <!--begin::Info-->
                                    <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2 row">

                                        <span class="d-flex align-items-center text-gray-400 text-hover-primary mb-2"></span>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="py-3">
                    <div class="card mb-5 mb-xl-10 fs-4" id="kt_profile_details_view">
                        <!--begin::Card header-->
                        <div class="card-header cursor-pointer">
                            <!--begin::Card title-->
                            <div class="card-title m-0">
                                <h3 class="fw-bold m-0">Cohort Detail</h3>
                            </div>


                            <form class="form_delete" method="POST" action="{{ route('cohort.destroy', $cohort) }}">
                                @csrf
                                @method('DELETE')
                                <span>
                                        <a href="{{ route('cohort.edit',$cohort) }}" class="btn btn-primary ">Edit</a>

                                        <button data-name="{{ $cohort->name }}" type="submit" class="btn btn-danger delete_element">Delete</button>
                                    </span>
                            </form>




                            <!--end::Action-->
                        </div>
                        <!--begin::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body p-9">


                            <div class="row mb-7">
                                <!--begin::Label-->
                                <label class="col-lg-4 fw-semibold text-muted">Cohort Name</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <span class=" text-gray-800 fw-bold">{{ $cohort->name }}</span>
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
                                {{ $cohort->created_at->format('d M Y, h:i a') }}
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
                                {{ $cohort->updated_at->format('d M Y, h:i a') }}
                            </span>
                                </div>
                                <!--end::Col-->
                            </div>
                        </div>
                        <!--end::Card body-->
                    </div>
                    <div class="card-body p-9 pt-0 ">
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-11 fv-row pb-3">
                                <div class="card-title m-0">
                                    <h3 class="fw-bold m-0">Cohort Students</h3>
                                </div>
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_students">
                                    <thead>
                                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">

                                        <th class="min-w-125px">Student</th>
                                        <th class="min-w-125px">Gender</th>
                                        <th class="min-w-125px">Registered Date</th>
                                        <th class="text-end min-w-100px">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody class="text-gray-600 fw-semibold">
                                    @foreach($cohort->students as $student)
                                        <tr>
                                            <td class="d-flex align-items-center">
                                                <!--begin:: Avatar -->
                                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                                    <a href="{{ route('student.show', $student) }}">
                                                        <div class="symbol-label">
                                                            @if(is_null($student->profile_path))
                                                                <img src="{{asset('metronic/demo6/dist/assets/media/svg/files/blank-image.svg')}}" alt="Emma Smith" class="w-100" />
                                                            @else
                                                                <img src="{{asset($student->profile_path)}}" alt="Emma Smith" class="w-100" />
                                                            @endif
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <a href="{{ route('student.show', $student) }}" class="text-gray-800 text-hover-primary mb-1">{{ $student->name }}</a>
                                                </div>
                                                <!--begin::User details-->
                                            </td>
                                            <td>
                                                @if($student->gender == \App\Enum\GenderEnum::MALE)
                                                    <span class="badge badge-light-primary text-primary">Male</span>
                                                @else
                                                    <span class="badge badge-light-danger text-danger">Female</span>

                                                @endif
                                            </td>
                                            <td>{{ $student->created_at->format('d M Y, h:i a') }}</td>
                                            <td class="text-end">
                                                <form class="form_delete" method="post" action="{{ route('student.destroy',$student) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                                        <i class="ki-outline ki-down fs-5 ms-1"></i></a>
                                                    <!--begin::Menu-->
                                                    <div class=" p-3 menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                                        <a href="{{ route('student.edit',$student) }}" class="btn btn-primary mb-2">Edit</a>
                                                        <button data-name="{{$student->name}}" type="submit" class="btn btn-danger delete_element" data-kt-users-table-filter="delete_row">Delete</button>
                                                        <!--end::Menu item-->
                                                    </div>
                                                </form>
                                                <!--end::Menu-->
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!--end::Col-->
                        </div>
                    </div>


                    </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>

        <!--end::Container-->
    </div>
    <!--begin::Group actions-->
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

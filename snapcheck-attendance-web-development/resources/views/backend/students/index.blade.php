@php
    /**
     * @var App\Models\Student $student
     */
@endphp
@extends('layouts.app')

@section('content')
    @include('backend.components.flash_message_sweet_alert')

    {{--Top bar --}}
    <div class="toolbar py-2" id="kt_toolbar">
        <!--begin::Container-->
        @include('layouts.topbar',['bigSection'=>'Students management','feature' => 'Students','pageName' => 'Students List'])
        <!--end::Container-->
    </div>
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Card-->
            <div class="card">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <!--begin::Search-->
                        <div class="d-flex align-items-center position-relative my-1">
                            <i class="ki-outline ki-magnifier fs-3 position-absolute ms-5"></i>
                            <input type="text" data-kt-student-table-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="Search student" />
                        </div>
                        <!--end::Search-->
                    </div>
                    {{--Filter--}}
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-student-table-toolbar="base">
                            <!--begin::Filter--><!--begin::Add student-->
                            <a href="{{ route('student.create') }}" type="button" class="btn btn-primary">
                                <i class="ki-outline ki-plus fs-2"></i>Add student</a>
                            <!--end::Add student-->
                        </div>

                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body py-4">
                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_students">
                        <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">

                            <th class="min-w-125px">student</th>
                            <th class="min-w-125px">Gender</th>
                            <th class="min-w-125px">Cohort</th>
                            <th class="min-w-125px">Registered Date</th>
                            <th class="text-end min-w-100px">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="text-gray-600 fw-semibold">
                        @foreach($students as $student)
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
                                <td>{{ $student->cohort ? $student->cohort->name:'' }}</td>
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
                    {{ $students->links('vendor.pagination.custom') }}
                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <script>
        $(document).ready(function(){
            $('.delete_element').on('click', function (e) {
                e.preventDefault();
                let $thisForm = $(this).closest('.form_delete');
                let name = $(this).data('name');
                Swal.fire({
                    title: 'Are you sure you want to delete student <span class="text-danger">' + name + '</span> ?',
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

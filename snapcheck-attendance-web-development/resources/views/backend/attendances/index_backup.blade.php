@php
    /**
     * @var App\Models\Cohort $cohort
     * @var App\Models\Course $course
     */
@endphp
@extends('layouts.app')

@section('content')
    @include('backend.components.flash_message_sweet_alert')

    {{--Top bar --}}
    <div class="toolbar py-2" id="kt_toolbar">
        <!--begin::Container-->
        @include('layouts.topbar',['bigSection'=>'Attendance management','pageName' => 'Activate Attendance'])
        <!--end::Container-->
    </div>
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Card-->
            <div class="card">
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body py-4">
                    <!--begin::Table-->
                    <div class="">
                        <div class="row mb-4">
                            <form method="get" action="{{ route('attendance.index') }}">
                                <div class="fv-row col-4">
                                    <!--begin::Label-->
                                    <label for="cohort_id" class="fw-semibold fs-6 mb-2">Cohort</label>
                                    <select id="cohort_id" data-control="select2" class="form-select form-select-solid"
                                            aria-label="Select example" name="cohort_id">
                                        <option value="">Choose one</option>
                                        @foreach($cohorts as $cohort)
                                            <option value="{{ $cohort->id }}">{{ $cohort->name }}</option>
                                        @endforeach
                                    </select>
                                    <!--end::Input-->
                                </div>
                            </form>
                        </div>
                        <div class="separator bg-secondary border-2"></div>
                        {{--Filter type of view list or calendar--}}
                        <div class="card-header px-0 border-bottom-dashed border-2">
                            <form method="get" id="attendance_view" action="{{ route('attendance.index') }}">
                                <div class="btn-group w-100px mt-4 card-title" data-kt-buttons="true"
                                     data-kt-buttons-target="[data-kt-button]">

                                    <label
                                        class="btn btn-sm bg-active-secondary bg-hover-secondary text-hover-primary text-active-primary bg-gray-200 {{ $viewType == 'list' ? 'active':'' }}"
                                        data-kt-button="true">
                                        <!--begin::Input-->
                                        <input class="btn-check" type="radio" name="view" value="list"/>
                                        <!--end::Input-->
                                        List
                                    </label>

                                    <!--begin::Radio-->
                                    <label
                                        class="btn btn-sm bg-active-secondary bg-hover-secondary text-hover-primary text-active-primary bg-gray-200 {{ $viewType == 'calendar' ? 'active':'' }}"
                                        data-kt-button="true">
                                        <!--begin::Input-->
                                        <input class="btn-check" type="radio" name="view" value="calendar"/>
                                        <!--end::Input-->
                                        Calendar
                                    </label>
                                    <!--end::Radio-->
                                </div>
                            </form>
                            <div class="d-flex justify-content-end card-toolbar" data-kt-student-table-toolbar="base">
                                <!--begin::Filter--><!--begin::Add student-->
                                <a href="{{ route('student.create') }}" type="button" class="btn btn-primary">
                                    <i class="ki-outline ki-plus fs-2"></i>New Attendance Schedule</a>
                                <!--end::Add student-->
                            </div>
                        </div>
                        @if($viewType == 'list')
                            <div class="row mt-4">
                                @include('backend.attendances.view_types.list_view')
                            </div>
                        @else
                            <div class="row mt-4">
                                @include('backend.attendances.view_types.calendar_view')
                            </div>
                        @endif

                    </div>
                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <script>
        $(document).ready(function () {
            // console.log('hi')
            $('input[name="view"]').on('change', function () {
                let $form = $('#attendance_view');
                $form.submit();
            })
        })
    </script>

@endsection

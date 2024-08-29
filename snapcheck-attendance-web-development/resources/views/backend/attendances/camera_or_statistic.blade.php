@php
    /**
     * @var App\Models\Student $student
     */
@endphp
@extends('layouts.app')

@section('content')
    @include('backend.components.flash_message_sweet_alert')

    {{--Top bar --}}
    <input type="hidden" id="value_of_active_selected_date" name="value_of_active_selected_date" value="{{ request()->target_date }}">
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
                <form id="redirectForm" action="{{ getenv('RECOGNITION_BASE_URL') }}" method="post" target="_blank">
                    @csrf
                    {{--Token for the form request--}}
                    <input type="hidden" name="personal_access_token" value="{{request()->session()->get('auth_session')}}">
                    <input type="hidden" name="time_start" value="" id="time_start">
                    <input type="hidden" name="time_end" value="" id="time_end">
                    <input type="hidden" name="date" value="" id="date">


                    <div class="card-body py-4 row" style="height: 80vh">
                        <!--begin::Table-->
                        <div class="col col-9 p-8 border-2 border-end">
                            <div class="row mb-5">
                                {{-- Course id --}}
                                <div class="fv-row mb-7  w-100 w-md-50 col">
                                    <!--begin::Label-->
                                    <label for="course_id" class="fw-semibold fs-6 mb-2">Course</label>
                                    <select id="course_id" data-control="select2" class="form-select form-select-solid"
                                            aria-label="Select example" name="course_id">
                                        <option value="">Choose one</option>
                                        @foreach($attendances as $attendance)
                                            <option value="{{ $attendance->course->id }}">{{ $attendance->course->name }}</option>
{{--                                            <option value="{{ $course->id }}">{{ $course->name }}</option>--}}
                                        @endforeach
                                    </select>
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div>{{ $errors->first('course_id') }}</div>
                                    </div>
                                    <!--end::Input-->
                                </div>
                                <div class="fv-row mb-7  w-100 w-md-50 col">
                                    <!--begin::Label-->
                                    <label for="attendance_id" class="fw-semibold fs-6 mb-2">Session</label>
                                    <select id="attendance_id" data-control="select2" class="form-select form-select-solid"
                                            aria-label="Select example" name="attendance_id">
                                        <option value="">Choose one</option>

                                    </select>
                                    <!--end::Input-->
                                </div>
                            </div>
                            <div class="mb-7 d-none" id="target_cohorts">
                                <label class="fw-semibold fs-6 mb-2">Target Cohort</label>
                                <div class="mt-2 mb-5 " id="target_cohorts_list">
                                    <span class="py-3 px-8 border rounded">CS-G7-GroupB</span>
                                    <span class="py-3 px-8 border rounded">CS-G7-GroupB</span>
                                    <span class="py-3 px-8 border rounded">CS-G7-GroupB</span>
                                    <span class="py-3 px-8 border rounded">CS-G7-GroupB</span>
                                </div>
                                <div><span id="none_cohort" class="badge-light-danger "></span></div>
                            </div>
                            <div class="d-flex align-items-center mt-10">
                                <div class="mt-5">
                                    <label for="attendance_id" class="fw-semibold fs-6 mb-2">Start the Camera</label>
                                    <div class="camera menu-item border rounded border-dashed border-2 border-hover-primary bg-hover-light-primary border-secondary">
                                        <a id="open_camera_button"  class="menu-link menu-center h-200px w-200px">
                                            <span class="menu-icon me-0 pulse pulse-primary">
                                                <i class="ki-duotone ki-faceid icon_camera" style="font-size: 150px">
                                                     <span class="path1"></span>
                                                     <span class="path2"></span>
                                                     <span class="path3"></span>
                                                     <span class="path4"></span>
                                                     <span class="path5"></span>
                                                     <span class="path6"></span>
                                                </i>
                                                <span class="pulse-ring border-5"></span>
                                            </span>

                                        </a>
                                    </div>
                                </div>
                                <div class="mt-5 ms-5">
                                    <label for="attendance_id" class="fw-semibold fs-6 mb-2">View Statistic</label>
                                    <div class="statistic menu-item border rounded border-dashed border-2 border-hover-success bg-hover-light-success border-secondary">
                                        <a class="menu-link menu-center h-200px w-200px" id="report_course_session">
                                            <span class="menu-icon me-0" >
                                                <i class="ki-duotone ki-chart-simple icon_statistic" style="font-size: 150px">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                                <span class="path4"></span>
                                                </i>
                                            </span>

                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col col3">
                            <div class="custom_inline_calendar d-flex justify-content-center">
    {{--                            <div id="date_filter"></div>--}}
                                <div class="input-group" id="date_filter" data-td-target-input="nearest" data-td-target-toggle="nearest">
                                    <label for="selected_date" class="d-none"></label><input id="selected_date" name="selected_date" type="text" class="form-control" data-td-target="#kt_td_picker_time_only"/>
                                    <span class="input-group-text" data-td-target="#kt_td_picker_time_only" data-td-toggle="datetimepicker">
                                    <i class="ki-duotone ki-calendar fs-2"><span class="path1"></span><span class="path2"></span></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!--end::Table-->
                    </div>
                </form>
                <form id="self" action="{{ route('attendance.attendanceCameraOrStatistic') }}" method="get">
                    <input type="hidden" id="target_date" name="target_date" value="">
                </form>
                <form id="statistic" action="{{ route('attendance.attendanceReportSpecificCourseSession') }}" method="get" target="_blank">
{{--                    @csrf--}}
                    <input type="hidden"  name="attendance_id" value="">
                    <input type="hidden"  name="course_id" value="">
                </form>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--begin::Toast-->
    <div class="position-fixed bottom-25 end-0 p-3" style="z-index: 100">
        <div id="kt_docs_toast_toggle" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
{{--                <i class="ki-duotone ki-abstract-19 fs-2 text-danger me-3"><span class="path1"></span><span class="path2"></span></i>--}}
                <i class="ki-duotone ki-information-5 text-danger me-3 fs-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                </i>
                <strong class="me-auto">No Attendance Schedule</strong>
{{--                <small>11 mins ago</small>--}}
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                <a href="{{ route('attendance.create') }}" class="btn btn-primary">Create Attendance Schedule</a>
            </div>
        </div>
    </div>
    <!--end::Toast-->

    <script>
        $(document).ready(function () {
            const toastElement = $('#kt_docs_toast_toggle');
            const toast = bootstrap.Toast.getOrCreateInstance(toastElement);
                // Toggle toast to show --- more info: https://getbootstrap.com/docs/5.1/components/toasts/#show
            @if($attendances->count() == 0)
                toast.show();
            @endif
            console.log('hi')
            const picker = new tempusDominus.TempusDominus(document.getElementById("date_filter"), {
                display: {
                    inline: true,
                    components: {
                        decades: true,
                        year: true,
                        month: true,
                        date: true,
                        hours: false,
                        minutes: false,
                        seconds: false
                    },
                },
                localization: {
                    // locale: "de",
                    // startOfTheWeek: 1,
                    format: "dd/MM/yyyy"
                }
            });
            let DateTimeVal = moment('02/02/2024 00:00', 'MM/DD/YYYY HH:mm').toDate();

            //picker.dates.setValue(tempusDominus.DateTime.convert(DateTimeVal));
            const form = document.getElementById('redirectForm');
            let validator = FormValidation.formValidation(
                form,
                {
                    fields: {
                        'course_id': {
                            validators: {
                                notEmpty: {
                                    message: 'Course input is required!!'
                                }
                            }
                        },
                        'attendance_id': {
                            validators: {
                                notEmpty: {
                                    message: 'Course Session input is required!!'
                                }
                            }
                        },
                    },

                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: '.fv-row',
                            eleInvalidClass: '',
                            eleValidClass: ''
                        })
                    }
                }
            );
            updateDateFormCamera();
            updateActiveOnSelectedDate()

            $(form.querySelector('[name="course_id"]')).on('change', function () {
                // Revalidate the field when an option is chosen
                validator.revalidateField('course_id');
            });
            $(form.querySelector('[name="attendance_id"]')).on('change', function () {
                // Revalidate the field when an option is chosen
                validator.revalidateField('attendance_id');
            });

            $('#open_camera_button').on('click', function (e) {
                e.preventDefault()
                if(validator){
                    validator.validate().then(function(status){
                        if(status === 'Valid'){
                            $('#redirectForm').submit()
                        }
                    })
                }
                //$('#redirectForm').submit()
            })
            $('#report_course_session').on('click', function (e){
                e.preventDefault()
                if(validator){
                    validator.validate().then(function(status){
                        if(status === 'Valid'){
                            let attendanceId = $('#attendance_id').val()
                            let courseId = $('#course_id').val()
                            let form = $('#statistic')
                            form.find('input[name="attendance_id"]').val(attendanceId)
                            form.find('input[name="course_id"]').val(courseId)
                            form.submit()
                            {{--window.open('{{route('attendance.attendanceReportSpecificCourseSession').'?_token='. csrf_token().'&'.'attendance_id='}}'+attendanceId, '_blank');--}}
                        }
                    })
                }
            })

            $('#course_id').on('change', function () {
                $('#target_cohorts').addClass('d-none')
                let courseId = $(this).val()
                let $attendanceIdEle = $('#attendance_id')
                let date = $('#selected_date').val()
                setSessions(courseId, $attendanceIdEle,date)
                // set the time start and time end

            })

            $('#attendance_id').on('change', function (){
                let attendanceId = $(this).val()
                setCohorts(attendanceId, $('#target_cohorts_list'))

                setTimeIntervalAttendanceById(attendanceId)

                console.log("set time done")

            })

            $('#selected_date').on('change',function (){
                // change this value of #date as well
                updateDateFormCamera()
                updateSelfTargetDate()

                //submit self form
                $('#self').submit()
            })
            function updateDateFormCamera(){
                let selectedValue = $('#selected_date').val()
                let $dateElement = $('#date');
                $dateElement.val(convertDateFormat(selectedValue))

                // convert date format "15/02/2024" to "2024-02-15"
                // selectedValue = convertDateFormat(selectedValue)
                //
                //
            }
            function updateActiveOnSelectedDate(){
                let activeDate = $('#value_of_active_selected_date').val()
                // set the date to the picker
                if(activeDate !== ''){
                    let DateTimeVal = moment(activeDate+' 00:00', 'YYYY-MM-DD HH:mm').toDate();
                    picker.dates.setValue(tempusDominus.DateTime.convert(DateTimeVal));
                }
            }
            function updateSelfTargetDate(){
                let selectedValue = $('#selected_date').val()
                $('#target_date').val(convertDateFormat(selectedValue))
            }
            function convertDateFormat(inputDate) {
                // Split the input date based on the '/' delimiter
                let parts = inputDate.split('/');

                // Rearrange the parts to form the desired date format
                return parts[2] + '-' + parts[1] + '-' + parts[0];
            }


            function setTimeIntervalAttendanceById(attendanceId){
                let xhr = $.ajax({
                    url: '/api/attendance/getAttendanceById',
                    type: 'GET',
                    data: {
                        attendance_id: attendanceId,
                    }
                })
                xhr.done(function (response) {
                    console.log(response)
                    $('#time_start').val(response.attendance.time_start)
                    $('#time_end').val(response.attendance.time_end)
                })
                //return null
            }

            function setCohorts(attendanceId, $element){
                $('#target_cohorts').addClass('d-none')
                let xhr = $.ajax({
                    {{--url: '{{ route('attendance.getCohortsByAttendanceId').'?_token='.csrf_token() }}',--}}
                    url: '/api/attendance/getCohortsByAttendanceId',
                    type: 'GET',
                    data: {
                        attendance_id: attendanceId,
                    }
                })
                xhr.done(function (response) {
                    $element.empty()
                    let options = ''
                    response.cohorts.forEach(function (cohort) {
                        options += '<span class="py-3 px-8 border rounded me-2">'+cohort.name+'</span>'
                    })
                    $element.html(options)
                    $('#target_cohorts').removeClass('d-none')
                })
            }
            //console.log($('#selected_date').val())
            function setSessions(courseId, $element, date) {
{{--                {{ route('attendance.getAttendanceIdByCourseId').'?_token='.csrf_token() }}--}}
                let xhr = $.ajax({
                    url: '/api/attendance/getAttendanceIdByCourseId',
                    type: 'GET',
                    data: {
                        course_id: courseId,
                        date: date
                    }
                })
                xhr.done(function (response) {
                    $element.empty()
                    let options = '<option value="" data-time-start="" data-time-end="">Choose one</option>'
                    response.attendances.forEach(function (attendance) {
                        options += '<option data-time-start="" data-time-end="" value="' + attendance.id + '">' + attendance.time_start +' - '+attendance.time_end+ '</option>'
                    })
                    $element.html(options)
                })
            }
        })
    </script>

@endsection

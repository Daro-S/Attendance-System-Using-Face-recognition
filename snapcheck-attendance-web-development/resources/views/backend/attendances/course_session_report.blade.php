@php
    /**
     * @var App\Models\Student $student
     */
    $status = [
        'on_time'=>'On Time',
         'late'=>'Late',
         'absent'=>'Absent'
     ];
@endphp
@extends('layouts.app')

@section('content')
    @include('backend.components.flash_message_sweet_alert')

    {{--Top bar --}}
    <input type="hidden" id="value_of_active_selected_date" name="value_of_active_selected_date" value="{{ $attendance? $attendance->date : request()->target_date }}">
    <input type="hidden" id="attendance_id_for_pusher" name="attendance_id_for_pusher" value="{{ !empty(request()->attendance_id) ? $attendance->id : 0 }}">
    <div class="toolbar py-2" id="kt_toolbar">
        <!--begin::Container-->
        @include('layouts.topbar',['bigSection'=>'Attendance management','feature'=>'Course session report','pageName' => 'Student List'])
        <!--end::Container-->
    </div>
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Card-->
            <div class="card">
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body py-4 row" style="min-height: 80vh">

                    <!--begin::Table-->
                    <div class="col-8 col-md-9 p-2 border-2 border-end">

                        <div class="row">
                            <form id="self" class="row col-9">
                                <input type="hidden" id="target_date" name="target_date" value="{{ request()->target_date ? request()->target_date: $date }}">
{{--                            @foreach(request()->all() as $key => $value)--}}
{{--                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}" />--}}
{{--                                @endforeach--}}
                                <div class="fv-row  w-100 w-md-50 col">
                                    <!--begin::Label-->
                                    <label for="course_id" class="fw-semibold fs-6 mb-2">Course</label>
                                    <select id="course_id" data-control="select2" class="form-select form-select-solid"
                                            aria-label="Select example" name="course_id">
                                        <option value="">Choose one</option>
                                        @foreach($attendanceCourses as $attendanceCourse)
                                            <option
                                                @if(isset(request()->course_id) && request()->course_id  == $attendanceCourse->course->id)
                                                    selected
                                                @endif
                                                value="{{ $attendanceCourse->course->id }}">{{ $attendanceCourse->course->name }}</option>
                                        @endforeach
                                    </select>
                                    <!--end::Input-->
                                </div>
                                <div class="fv-row  w-100 w-md-50 col">
                                    <!--begin::Label-->
                                    <label for="attendance_id" class="fw-semibold fs-6 mb-2">Session</label>
                                    <select id="attendance_id" data-control="select2"
                                            class="form-select form-select-solid"
                                            aria-label="Select example" name="attendance_id">
                                        <option value="">Choose one</option>
                                    </select>
                                    <!--end::Input-->
                                </div>
                                </form>

                            <div class="col-3">
                                <div class="">
                                    <div class="d-flex justify-content-end mb-2">

                                        <a href="#" data-bs-toggle="tooltip" data-bs-placement="top"
                                           title="Unknown Person Report"
                                           class="d-none badge badge-light-danger px-5 py-2 rounded-5"> <i
                                                class="fa-solid fa-person-circle-exclamation fs-2 me-1 text-danger"></i><span
                                                class="text-danger">Unknown</span>
                                        </a>
                                    </div>
                                    <div class="d-flex justify-content-end d-none">
                                        <button type="button" class="btn btn-light-primary" data-kt-menu-trigger="click"
                                                data-kt-menu-placement="bottom-end">
                                            <i class="ki-duotone ki-exit-down fs-2"><span class="path1"></span><span
                                                    class="path2"></span></i>
                                            Export Report
                                        </button>
                                        <!--begin::Menu-->
                                        <div id="kt_datatable_example_export_menu"
                                             class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4"
                                             data-kt-menu="true">

                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3" data-kt-export="excel">
                                                    Export as Excel
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-10">
                            <!--begin::Menu-->
                            @if($attendance)
                            @foreach($attendance->cohorts as $cohort)
                                <div id="student_cohort_id_{{$cohort->id}}"
                                     class="menu menu-rounded menu-column menu-title-gray-700 menu-icon-gray-500 menu-arrow-gray-500 menu-bullet-gray-500 menu-arrow-gray-500 menu-state-bg fw-semibold w-100"
                                     data-kt-menu="true">
                                    <!--begin::Menu item-->
                                    <div class="menu-item menu-sub-indention menu-accordion show"
                                         data-kt-menu-trigger="click">
                                        <!--begin::Menu link-->
                                        <a href="#"
                                           class="menu-link py-3 border border-bottom-1 border-dark border-end-0 border-top-0 border-start-0 rounded-0">
                                            <span class="menu-title fs-2">{{ $cohort->name }}</span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <!--end::Menu link-->

                                        <!--begin::Menu sub-->
                                        <div class="menu-sub menu-sub-accordion">
                                            <!--begin::Menu item-->
                                            <div class="row gap-2 mt-4 ms-4 student_list">
                                                {{--Student List here --}}
                                                @foreach ($cohort->students as $student)
                                                    @if(!empty($student->student))
                                                        @if($student->status == 'on_time')
                                                            <div
                                                                class="border border-success rounded py-2 col-md-2 border-2">
                                                                <div
                                                                    class="image-input image-input-outline d-flex justify-content-center">
                                                                    <div class="image-input-wrapper w-100px h-100px"
                                                                         style="background-image: url({{asset($student->student->profile_path)}})"></div>
                                                                </div>
                                                                <div class="text-center fs-4">{{ $student->student->name }}</div>
                                                                <div
                                                                    class="{{$student->student->gender == 'male' ? 'text-primary': 'text-danger'}} text-center">{{ ucfirst($student->student->gender) }}
                                                                    <span class="text-muted">| {{ date('h:i A',strtotime($student->capture_at))  }}</span></div>
                                                                <div class="text-center"><span
                                                                        class="px-3 badge badge-light-success fw-bold">{{ $status[$student->status] }}</span>
                                                                </div>
                                                            </div>
                                                        @elseif($student->status == 'late')
                                                            <div
                                                                class="border border-warning rounded py-2 col-md-2 border-2">
                                                                <div
                                                                    class="image-input image-input-outline d-flex justify-content-center">
                                                                    <div class="image-input-wrapper w-100px h-100px"
                                                                         style="background-image: url({{asset($student->student->profile_path)}})"></div>
                                                                </div>
                                                                <div class="text-center fs-4">{{ $student->student->name }}</div>
                                                                <div
                                                                    class="{{$student->student->gender == 'male' ? 'text-primary': 'text-danger'}} text-center">{{ ucfirst($student->student->gender) }}
                                                                    <span class="text-muted">| {{ date('h:i A',strtotime($student->capture_at))  }}</span></div>
                                                                <div class="text-center"><span
                                                                        class="px-3 badge badge-light-warning fw-bold">{{ $status[$student->status] }}</span>
                                                                </div>
                                                            </div>
                                                        @elseif($student->status == 'absent')
                                                            <div
                                                                class="border border-danger rounded py-2 col-3 col-md-2 col-sm-4 border-2">
                                                                <div
                                                                    class="image-input image-input-outline d-flex justify-content-center">
                                                                    <div class="image-input-wrapper w-100px h-100px"
                                                                         style="background-image: url({{asset($student->student->profile_path)}})"></div>
                                                                </div>
                                                                <div class="text-center fs-4">{{ $student->student->name }}</div>
                                                                <div
                                                                    class="{{$student->student->gender == 'male' ? 'text-primary': 'text-danger'}} text-center">{{ ucfirst($student->student->gender) }}
                                                                </div>
                                                                <div class="text-center"><span
                                                                        class="px-3 badge badge-light-danger fw-bold">{{ $status[$student->status] }}</span>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endif

                                                @endforeach

                                            </div>
                                            <!--end::Menu item-->
                                        </div>
                                        <!--end::Menu sub-->
                                    </div>
                                    <!--end::Menu item-->
                                </div>
                            @endforeach
                            @endif

                            <!--end::Menu-->
                        </div>
                    </div>
                    <div class="col-4 col-md-3">
                        <div class="custom_inline_calendar d-flex justify-content-center align-items-center">
                            {{--                            <div id="date_filter"></div>--}}
                            <div class="input-group" id="date_filter" data-td-target-input="nearest"
                                 data-td-target-toggle="nearest">
                                <input id="selected_date" type="hidden" class="form-control"
                                       data-td-target="#kt_td_picker_time_only"/>
                                <span class="input-group-text d-none" data-td-target="#kt_td_picker_time_only"
                                      data-td-toggle="datetimepicker">
                                <i class="ki-duotone ki-calendar fs-2 d-none"><span class="path1"></span><span
                                        class="path2"></span></i>
                                </span>
                            </div>
                        </div>
                        @if($attendance)
                        @foreach($attendance->cohorts as $cohort)
                            <div
                                id="report_cohort_id_{{$cohort->id}}" class="ps-5 py-3 mt-8 w-100 mx-3 border border-start border-8 border-primary border-top-0 border-start-8 border-bottom-0 border-right-0 bg-gray-100 rounded">
                                <div class="fs-2 text-gray-700">{{ $cohort->name }}</div>
                                <div class="mt-2 d-flex align-items-center">
                                    <span class="d-block w-25px h-25px rounded-1 bg-success me-1"></span>
                                    <span class="fs-4 me-2 text-gray-700">Present: <span
                                            class="text-success fw-bold num_present">{{ ($cohort->reports)['present'] }}</span></span>
                                    <span class="me-2 d-block w-20px h-20px rounded-circle bg-success text-center text-white num_on_time">{{($cohort->reports)['on_time']}}</span>
                                    <span class="me-2 d-block w-20px h-20px rounded-circle bg-warning text-center text-white num_late">{{($cohort->reports)['late']}}</span>
                                    @if($attendance->isExpired)
                                    <span class="d-block w-20px h-20px rounded-circle bg-danger text-center text-white">{{($cohort->reports)['absent']}}</span>
                                    @endif
                                </div>
                                <div class="d-flex align-items-center mt-2">
                                    <span class="italic fs-4 text-gray-700 me-4">Total Student: <span
                                            class="fw-bold">{{($cohort->reports)['total_students']}}</span></span>
                                    <span class="me-4"><i class="fa-solid fa-venus text-danger me-1"></i>{{($cohort->reports)['num_female']}}</span>
                                    <span><i class="fa-solid fa-mars text-primary me-1"></i>{{($cohort->reports)['num_male']}}</span>
                                </div>
                            </div>
                        @endforeach
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
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        $(document).ready(function () {
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
            updateActiveOnSelectedDate()
            // updateSelfTargetDate
            // picker.dates.setValue(tempusDominus.DateTime.convert(DateTimeVal));



            //Pusher Update In realtime
            // Pusher.logToConsole = true;

            let pusher = new Pusher('58600a31cf7f7fe2b26e', {
                cluster: 'ap1'
            });

            let channel = pusher.subscribe('mark_student_attendance');
            channel.bind('update_attendance', function (data) {
                console.log(JSON.stringify(data));
                // check if data.attendance.attendance_schedule_id is equal to the attendance_id
                if(data.attendance.attendance_schedule_id != $('#attendance_id_for_pusher').val()){
                    return
                }

                let $parent = $('#student_cohort_id_' + data.cohort_id);
                let $child = $parent.find('.student_list');

                let studentComponentHTML = studentItem(data.student.name, data.student.gender, data.attendance.captured_time, data.student.profile_path, data.attendance.status);

                $child.append(studentComponentHTML);
                // update report
                updateReport(data.cohort_id, data.reports)
            });
            // if isset course_id then set the session
            let courseId = $('#course_id').val()
            let $attendanceIdEle = $('#attendance_id')
            let date = $('#selected_date').val()
            if(courseId !== ''){
                setSessions(courseId, $attendanceIdEle,date)
                let attendanceId = '{{ request()->attendance_id }}'
                // set selected option to attendanceElement to which the option value is equal to the attendance_id
                if(attendanceId !== ''){
                    $attendanceIdEle.val(attendanceId)
                }
            }

            $('#selected_date').on('change',function (){
                // change this value of #date as well
                updateSelfTargetDate()
                //set course_id and attendance_id to null
                $('#course_id').val('')
                $('#attendance_id').val('')
                //submit self form
                $('#self').submit()
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
                //submit self form
                $('#self').submit()
            })
            function updateReport(cohort_id, reports){
                let $parent = $('#report_cohort_id_' + cohort_id);
                //console.log('present: '+reports.present)
                //console.log('on_time: '+reports.on_time)


                $parent.find('.num_present').text(reports.present)
                $parent.find('.num_on_time').text(reports.on_time)
                $parent.find('.num_late').text(reports.late)
                //$parent.find('.num_absent').text(reports.absent)
                //console.log('update report')
            }

            //function to capitalize first letter
            function capitalizeFirstLetter(str) {
                return str.charAt(0).toUpperCase() + str.slice(1);
            }

            function getAvatarUrl(profile_path) {
                // Logic to generate avatar URL based on the provided name
                // Replace this logic with your actual implementation
                return '{{url('/') . '/'}}' + profile_path;
            }


            function studentItem(name, gender, time, profile_path, status = 'On Time') {

                // console.log(status)
                // gender color variable = 'text-danger' if gender is female else 'text-primary'
                let genderColor = (gender === 'male') ? 'text-primary' : 'text-danger';
                let statusColorBadge = (status === 'on_time') ? 'badge-light-success' : (status === 'late') ? 'badge-light-warning' : 'badge-light-danger';
                let statusText = (status === 'on_time') ? 'On Time' : (status === 'late') ? 'Late' : 'Absent';
                let statusBorder = (status === 'on_time') ? 'border-success' : (status === 'late') ? 'border-warning' : 'border-danger';

                return `
                            <div class="fade-in-right border ${statusBorder} rounded col-3 py-2 col-md-2 border-2">
                                <div class="image-input image-input-outline d-flex justify-content-center">
                                    <div class="image-input-wrapper w-100px h-100px" style="background-image: url(${getAvatarUrl(profile_path)})"></div>
                                </div>
                                <div class="text-center fs-4">${name}</div>
                                <div class="${genderColor} text-center">${capitalizeFirstLetter(gender)} <span class="text-muted">| ${time}</span></div>
                                <div class="text-center"><span class="px-3 badge ${statusColorBadge} fw-bold">${statusText}</span></div>
                            </div>
                        `;
            }
            function updateActiveOnSelectedDate(){
                let activeDate = $('#value_of_active_selected_date').val()
                console.log(activeDate)
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
            function setSessions(courseId, $element, date) {

                let attendanceId = '{{ request()->attendance_id }}'
                // set selected option to attendanceElement to which the option value is equal to the attendance_id
                //$attendanceIdEle.val(attendanceId)

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
                        // console.log(attendance.id == attendanceId)
                        if(attendance.id == attendanceId){
                            options += '<option data-time-start="" data-time-end="" value="' + attendance.id + '" selected>' + attendance.time_start +' - '+attendance.time_end+ '</option>'
                        }else{

                            options += '<option data-time-start="" data-time-end="" value="' + attendance.id + '">' + attendance.time_start +' - '+attendance.time_end+ '</option>'
                        }
                    })
                    $element.html(options)
                })
            }
        })
    </script>

@endsection

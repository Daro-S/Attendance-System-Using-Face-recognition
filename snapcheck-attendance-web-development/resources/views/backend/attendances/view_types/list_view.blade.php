<div class="col col-9 border-end border-2">
    @foreach($cohortWithItsCourses as $cohort)
        <div
            class=" mt-4 menu menu-rounded menu-column menu-title-gray-700 menu-icon-gray-500 menu-arrow-gray-500 menu-bullet-gray-500 menu-arrow-gray-500 menu-state-bg fw-semibold w-100"
            data-kt-menu="true">
            <!--begin::Menu item-->
            <div class="menu-item menu-sub-indention menu-accordion show"
                 data-kt-menu-trigger="click">
                <!--begin::Menu link-->
                <a href="#"
                   class="menu-link py-3 border border-bottom-1 border-dark border-end-0 border-top-0 border-start-0 rounded-0">
                    <span class="menu-title fs-2">{{ $cohort['cohort']->name }}</span>
                    <span class="menu-arrow"></span>
                </a>
                <!--end::Menu link-->

                <!--begin::Menu sub-->
                <div class="menu-sub menu-sub-accordion pt-3">
                    <!--begin::Menu item-->
                    <div class="ms-4">
                        @foreach($cohort['courses'] as $course)
                            @php
                                $hex = $course['course']->color;
                                list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");
                                $rgb = "rgb($r, $g, $b)";
                                $rgba = "rgba($r, $g, $b, 0.05)";
                            @endphp
                            <div
                                style="border-color: {{$rgb}}!important; background-color: {{ $rgba }}!important;"
                                class="row py-3 mt-3 w-500px mx-3 border border-start border-8  border-top-0 border-start-8 border-bottom-0 border-right-0 rounded">
                                {{--Schedule time and day--}}
                                <div
                                    class="col col-3 fs-2 text-gray-700 border-end-dashed border-2 border-dark d-flex align-items-center justify-content-end">
                                    <div>
                                        <div class="fs-3 fw-bold text-end text-dark fw-bold">
                                            {{ $course['time_start'] }}
                                        </div>
                                        <div class="fs-4 text-end text-dark">{{ ucfirst($course['day']) }}</div>
                                    </div>
                                </div>
                                {{--Course Name--}}
                                <div class="col col-7 d-flex align-items-center"><span
                                        class="fs-4">{{ $course['course']->name }}</span></div>
                                {{--Action--}}
                                <div class="col col-2">
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route('attendance.edit', ['attendance' => $course['attendance_id']]) }}" type="button"
                                           class="btn btn-sm btn-icon btn-active-secondary">
                                            <i class="ki-duotone ki-pencil fs-5 text-primary">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </a>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <form class="delete" method="post" action="{{ route('attendanceCohort.destroy') }}">
                                            @csrf
                                            @method('DELETE')
                                            <input class="attendance_cohort_id" type="hidden" name="attendance_cohort_id" value="{{ $course['attendance_cohort_id'] }}">
                                            <input class="course_name" type="hidden" name="course_name" value="{{ $course['course']->name }}">
                                            <input class="cohort_name" type="hidden" name="cohort_name" value="{{ $cohort['cohort']->name }}">
                                            <input class="day" type="hidden" name="day" value="{{ ucfirst($course['day']) }}">
                                            <a type="button"
                                               class="btn btn-sm btn-icon btn-active-secondary btn-delete">
                                                <i class="ki-duotone ki-trash fs-5 text-danger">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                    <span class="path4"></span>
                                                    <span class="path5"></span>
                                                </i>
                                            </a>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!--end::Menu item-->
                </div>
                <!--end::Menu sub-->
            </div>
            <!--end::Menu item-->
        </div>
    @endforeach
    {{--One Cohort Course--}}

</div>
<div class="col col-3">
    <div class="custom_inline_calendar d-flex justify-content-center">
        {{--                            <div id="date_filter"></div>--}}
        <div class="input-group" id="date_filter" data-td-target-input="nearest"
             data-td-target-toggle="nearest">
            <input id="selected_date" type="text" class="form-control"
                   data-td-target="#kt_td_picker_time_only"/>
            <span class="input-group-text" data-td-target="#kt_td_picker_time_only"
                  data-td-toggle="datetimepicker">
                            <i class="ki-duotone ki-calendar fs-2"><span class="path1"></span><span
                                    class="path2"></span></i>
                            </span>
        </div>
    </div>
</div>

<input type="hidden" id="value_of_active_selected_date" name="value_of_active_selected_date" value="{{ request()->target_date }}">
<form id="self" action="{{ route('attendance.index') }}" method="get">
    <input type="hidden" id="target_date" name="target_date" value="">
    <input type="hidden" name="date" value="" id="date">
</form>

<script>
    $(document).ready(function (){
        // updateDateFormCamera();

        $('.btn-delete').on('click', function (){
            let $form = $(this).closest('form');
            let attendance_cohort_id = $form.find('.attendance_cohort_id').val();
            let course_name = $form.find('.course_name').val();
            let cohort_name = $form.find('.cohort_name').val();
            let day = $form.find('.day').val();
            Swal.fire({
                title: 'Are you sure you want to delete <span class="text-danger">' + course_name + '</span> from <span class="text-danger">' + cohort_name + '</span> on <span class="text-danger">' + day + '</span>?',
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
                    $form.submit();
                }
            })

        })


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
        // picker.dates.setValue(tempusDominus.DateTime.convert(DateTimeVal));
        $('#selected_date').on('change',function (){
            // change this value of #date as well
            //updateDateFormCamera()
            updateSelfTargetDate()

            //submit self form
            $('#self').submit()
        })
        function updateSelfTargetDate(){
            let selectedValue = $('#selected_date').val()
            $('#target_date').val(convertDateFormat(selectedValue))
        }
        function updateActiveOnSelectedDate(){
            let activeDate = $('#value_of_active_selected_date').val()
            // set the date to the picker
            if(activeDate !== ''){
                let DateTimeVal = moment(activeDate+' 00:00', 'YYYY-MM-DD HH:mm').toDate();
                picker.dates.setValue(tempusDominus.DateTime.convert(DateTimeVal));
            }
        }
        function updateDateFormCamera(){
            let selectedValue = $('#selected_date').val()
            let $dateElement = $('#date');
            $dateElement.val(convertDateFormat(selectedValue))

            // convert date format "15/02/2024" to "2024-02-15"
            // selectedValue = convertDateFormat(selectedValue)
            //
            //
        }
        function convertDateFormat(inputDate) {
            // Split the input date based on the '/' delimiter
            let parts = inputDate.split('/');

            // Rearrange the parts to form the desired date format
            return parts[2] + '-' + parts[1] + '-' + parts[0];
        }

    })
</script>

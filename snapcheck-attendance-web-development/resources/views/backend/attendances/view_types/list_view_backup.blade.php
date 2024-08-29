<div class="col col-9 border-end border-2">
    <div class="row mb-4">
        <form method="get" action="{{ route('attendance.index') }}">
            <div class="fv-row col-8">

                <label for="cohort_filter" class="fw-semibold fs-6 mb-2">Cohort</label>
                <select id="cohort_filter" data-control="select2" class="form-select form-select-solid"
                        aria-label="Select example" name="cohort_filter">
                    <option value="">Choose one</option>
                    @foreach($cohorts as $cohort)
                        <option value="{{$cohort->id }}">{{ $cohort->name }}</option>
                    @endforeach
                </select>


                <!--begin::Label-->

                <!--end::Input-->
            </div>
        </form>
    </div>
    <div class="separator bg-secondary border-2"></div>
    <div class="menu-data"></div>


</div>
<div class="col col3">
    <div class="custom_inline_calendar d-flex justify-content-center">
        <div class="input-group" id="date_filter" data-td-target-input="nearest" data-td-target-toggle="nearest">
            <label for="selected_date" class="d-none"></label>
            <input id="selected_date" name="selected_date" type="text"
                   class="form-control"
                   data-td-target="#kt_td_picker_time_only"/>
            <span class="input-group-text" data-td-target="#kt_td_picker_time_only" data-td-toggle="datetimepicker">
                                    <i class="ki-duotone ki-calendar fs-2"><span class="path1"></span><span
                                            class="path2"></span></i>
                                    </span>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>


    $(document).ready(function () {
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

                format: "dd/MM/yyyy"
            }
        });
        let DateTimeVal = moment().toDate();
        picker.dates.setValue(tempusDominus.DateTime.convert(DateTimeVal));

        $('#selected_date, #cohort_filter').on('change', function () {
            let selectedDate = $('#selected_date').val();
            let cohortId = $('#cohort_filter').val();

            getAttendance(cohortId, selectedDate)

            console.log(cohortId, selectedDate);
        });

        function getAttendance(cohort_id, selectedDate) {
            let xhr = $.ajax({
                url: '/api/attendance_cohort_and_date',
                type: 'GET',
                data: {
                    date: selectedDate,
                    cohort_id: cohort_id
                },

            })
            xhr.done(function (response) {

                let attendance = response.data;

                console.log(attendance);

                let menuContainer = $('<div/>', {
                    class: 'mt-4 menu menu-rounded menu-column menu-title-gray-700 menu-icon-gray-500 menu-arrow-gray-500 menu-bullet-gray-500 menu-arrow-gray-500 menu-state-bg fw-semibold w-100',
                    'data-kt-menu': 'true'
                });

                $.each(attendance, function (index, data) {
                    let menuItem = $('<div/>', {
                        class: 'menu-item menu-sub-indention menu-accordion show',
                        'data-kt-menu-trigger': 'click'
                    }).appendTo(menuContainer);

                    let menuLink = $('<a/>', {
                        // href: '#',
                        class: 'menu-link py-3 border border-bottom-1 border-dark border-end-0 border-top-0 border-start-0 rounded-0'
                    }).appendTo(menuItem);


                    if (data.name) {
                        $('<span/>', {
                            class: 'menu-title fs-2',
                            text: data.name
                        }).appendTo(menuLink);

                    }
                    let arrowIcon = $('<span/>', {
                        class: 'menu-arrow'
                    }).appendTo(menuLink);


                    if (data.attendance_cohorts) {
                        let menuSub = $('<div/>', {
                            class: 'menu-sub menu-sub-accordion pt-3'
                        }).appendTo(menuItem);

                        let menuSubItem = $('<div/>', {
                            class: 'ms-4'
                        }).appendTo(menuSub);

                        $.each(data.attendance_cohorts, function (index, attendance) {
                            var originalDate = '2024-03-03';
                            if (attendance && attendance.attendance && attendance.attendance.date) {
                                var originalDate = attendance.attendance.date;
                            }
                            var parts = originalDate.split('-');
                            const formattedDate = new Date(parts[0], parts[1] - 1, parts[2]).toLocaleDateString('en-GB');

                            if (formattedDate === selectedDate) {
                                let row = $('<div/>', {
                                    class: 'row py-3 mt-3 w-500px mx-3 border border-start border-8 border-primary border-top-0 border-start-8 border-bottom-0 border-right-0 bg-light-primary rounded'
                                }).appendTo(menuSubItem);

                                // var lightenedColor = tinycolor(attendance.attendance.course.color).lighten(20).toString();
                                // row.css('background-color', lightenedColor);
                                //
                                // row.removeClass('border-primary').addClass('border-' +attendance.attendance.course.color);

                                var startTime = moment(attendance.attendance.time_start, "HH:mm").format("h:mm a").toUpperCase();
                                var endTime = moment(attendance.attendance.time_end, "HH:mm").format("h:mm a").toUpperCase();


                                let timeColumn = $('<div/>', {
                                    class: 'col col-3 fs-2 text-gray-700 border-end-dashed border-2 border-dark d-flex align-items-center justify-content-end'
                                }).appendTo(row);

                                let timeDiv = $('<div/>').appendTo(timeColumn);

                                $('<div/>', {
                                    class: 'fs-3 fw-bold text-start text-dark fw-bold',
                                    text: startTime
                                }).appendTo(timeDiv);

                                $('<div/>', {
                                    class: 'fs-3 fw-bold text-start text-dark fw-bold',
                                    text: endTime
                                }).appendTo(timeDiv);

                                $('<div/>', {
                                    class: 'col col-7 d-flex align-items-center fw-bold',
                                    html: '<span class="fs-4">' + attendance.attendance.course.name + '</span>'
                                }).appendTo(row);

                                let actionsColumn = $('<div/>', {
                                    class: 'col col-2'
                                }).appendTo(row);

                                let editButton = $('<a/>', {
                                    href: '/admin/attendance/edit/' + attendance.attendance.id,
                                    type: 'button',
                                    class: 'btn btn-sm btn-icon btn-active-secondary'
                                }).appendTo(actionsColumn);

                                $('<i/>', {
                                    class: 'ki-duotone ki-pencil fs-5 text-primary',
                                    html: '<span class="path1"></span><span class="path2"></span>'
                                }).appendTo(editButton);

                                // let deleteButton = $('<a/>', {
                                //     href: '/admin/attendance/destroy/'+attendance.attendance.id,
                                //     type: 'button',
                                //     class: 'btn btn-sm btn-icon btn-active-secondary'
                                // }).appendTo(actionsColumn);
                                var deleteButton = $('<button/>', {
                                    type: 'button',
                                    class: 'btn btn-sm btn-icon btn-active-secondary'
                                }).appendTo(actionsColumn);
                                deleteButton.on('click', function (e) {
                                    console.log('Delete button clicked'); // Add this line to check if the event is triggered

                                    e.preventDefault();
                                    let $thisButton = $(this);
                                    Swal.fire({
                                        title: 'Are you sure you want to delete this attendance schedule?',
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
                                            console.log('Yass button clicked'); // Add this line to check if the event is triggered

                                            $.ajax({
                                                url: 'api/attendance/destroy/' + attendance.attendance.id,
                                                type: 'DELETE',
                                                data: {
                                                    _token: '{{ csrf_token() }}'
                                                },
                                                success: function (response) {
                                                    // Handle the success response
                                                    console.log('Attendance deleted successfully!');
                                                    window.location.reload();
                                                },
                                                error: function (xhr, status, error) {
                                                    // Handle the error response
                                                    console.error('Error deleting attendance:', error);
                                                }
                                            });
                                        }
                                    });
                                });


                                $('<i/>', {
                                    class: 'ki-duotone ki-trash fs-5 text-danger',
                                    html: '<span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span>'
                                }).appendTo(deleteButton);


                            }
                        });
                    }
                });

                $('.menu-data').html(menuContainer);
                $('[data-kt-menu]').each(function () {
                    new KTMenu(this);
                });
                if (response.data.length < 1) {
                    console.log("The response is empty");
                    let noResponse = $('<div/>', {
                        class: 'pt-5 h2 fw-bold text-center text-danger fw-bold align-center ',
                        text: "No scheduled attendance"
                    })
                    $('.menu-data').html(noResponse);

                }

                // let html = '';

                // $.each(attendance, function (index, data) {
                //
                //     html += '<div>';
                //     if (data.name) {
                //         html += '<h2>Cohort: ' + data.name + '</h2>';
                //     }
                //     html += '<h3>Attendance:</h3>';
                //
                //     if (data.attendance_cohorts) {
                //         $.each(data.attendance_cohorts, function (index, attendance) {
                //             const originalDate = attendance.attendance.date; // Assuming attendance.attendance.date is in 'Y-m-d' format
                //             const parts = originalDate.split('-');
                //             const formattedDate = new Date(parts[0], parts[1] - 1, parts[2]).toLocaleDateString('en-GB');
                //
                //             console.log(formattedDate); // Output: dd/mm/yyyy
                //             if(   formattedDate == selectedDate){
                //
                //                 html += '<div>';
                //
                //                 if (attendance.attendance && attendance.attendance.course && attendance.attendance.course.name) {
                //                     html += '<p>Course: ' + attendance.attendance.course.name + '</p>';
                //                 }
                //                 if (attendance.attendance && attendance.attendance.date) {
                //                     html += '<p>Date: ' + formattedDate + '</p>';
                //                 }
                //                 if (attendance.attendance && attendance.attendance.time_start && attendance.attendance.time_end) {
                //                     html += '<p>Time: ' + attendance.attendance.time_start + ' - ' + attendance.attendance.time_end + '</p>';
                //                 }
                //                 html += '</div>';
                //             }
                //             else{
                //                 return true;
                //             }
                //         });
                //     }
                //
                //     html += '</div>';
                // });

                // $('.menu-data').html(html);

            })
        }

    })
</script>

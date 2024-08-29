

<div class="card-body p-9 pt-0 ">
    <div class="row mb-7">
        <!--begin::Label-->
        <!--end::Label-->
        <!--begin::Col-->
        <div class="col-lg-11 fv-row pb-3">
            <div class="card-title m-0 d-flex justify-content-between">
                <h3 class="fw-bold m-0">Attendance</h3>
                <form class="w-25 d-none">
                    <div class="input-group form-control-solid w-100" id="kt_td_picker_custom_icons" data-td-target-input="nearest"
                         data-td-target-toggle="nearest">
                        <input name="date" id="kt_td_picker_custom_icons_input" type="text" class="form-control"
                               data-td-target="#kt_td_picker_custom_icons"/>
                        <span class="input-group-text" data-td-target="#kt_td_picker_custom_icons"
                              data-td-toggle="datetimepicker">
                        <i class="ki-duotone ki-calendar fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </span>
                    </div>
                </form>
            </div>

            <div class="content d-flex flex-column flex-column-fluid d-none" id="kt_content">
                <!--begin::Container-->
                <div id="kt_content_container" class="container-xxl">
                    <!--begin::Card-->
                    <div class="card">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <h2 class="card-title fw-bold">Calendarr</h2>
                            <div class="card-toolbar">
                                <button class="btn btn-flex btn-primary" data-kt-calendar="add">
                                    <i class="ki-outline ki-plus fs-2"></i>Add Eventt</button>
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body">
                            <!--begin::Calendar-->
                            <div id="kt_calendar_app"></div>
                            <!--end::Calendar-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                    <!--begin::Modals-->
                    <!--begin::Modal - New Product-->
                    <div class="modal fade" id="kt_modal_add_event" tabindex-="1" aria-hidden="true" data-bs-focus="false">
                        <!--begin::Modal dialog-->
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                            <!--begin::Modal content-->
                            <div class="modal-content">
                                <!--begin::Form-->
                                <form class="form" action="#" id="kt_modal_add_event_form">
                                    <!--begin::Modal header-->
                                    <div class="modal-header">
                                        <!--begin::Modal title-->
                                        <h2 class="fw-bold" data-kt-calendar="title">Add Event</h2>
                                        <!--end::Modal title-->
                                        <!--begin::Close-->
                                        <div class="btn btn-icon btn-sm btn-active-icon-primary" id="kt_modal_add_event_close">
                                            <i class="ki-outline ki-cross fs-1"></i>
                                        </div>
                                        <!--end::Close-->
                                    </div>
                                    <!--end::Modal header-->
                                    <!--begin::Modal body-->
                                    <div class="modal-body py-10 px-lg-17">
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-9">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold required mb-2">Event Name</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" class="form-control form-control-solid" placeholder="" name="calendar_event_name" />
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-9">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold mb-2">Event Description</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" class="form-control form-control-solid" placeholder="" name="calendar_event_description" />
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-9">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold mb-2">Event Location</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" class="form-control form-control-solid" placeholder="" name="calendar_event_location" />
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-9">
                                            <!--begin::Checkbox-->
                                            <label class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" value="" id="kt_calendar_datepicker_allday" />
                                                <span class="form-check-label fw-semibold" for="kt_calendar_datepicker_allday">All Day</span>
                                            </label>
                                            <!--end::Checkbox-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="row row-cols-lg-2 g-10">
                                            <div class="col">
                                                <div class="fv-row mb-9">
                                                    <!--begin::Label-->
                                                    <label class="fs-6 fw-semibold mb-2 required">Event Start Date</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input class="form-control form-control-solid" name="calendar_event_start_date" placeholder="Pick a start date" id="kt_calendar_datepicker_start_date" />
                                                    <!--end::Input-->
                                                </div>
                                            </div>
                                            <div class="col" data-kt-calendar="datepicker">
                                                <div class="fv-row mb-9">
                                                    <!--begin::Label-->
                                                    <label class="fs-6 fw-semibold mb-2">Event Start Time</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input class="form-control form-control-solid" name="calendar_event_start_time" placeholder="Pick a start time" id="kt_calendar_datepicker_start_time" />
                                                    <!--end::Input-->
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="row row-cols-lg-2 g-10">
                                            <div class="col">
                                                <div class="fv-row mb-9">
                                                    <!--begin::Label-->
                                                    <label class="fs-6 fw-semibold mb-2 required">Event End Date</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input class="form-control form-control-solid" name="calendar_event_end_date" placeholder="Pick a end date" id="kt_calendar_datepicker_end_date" />
                                                    <!--end::Input-->
                                                </div>
                                            </div>
                                            <div class="col" data-kt-calendar="datepicker">
                                                <div class="fv-row mb-9">
                                                    <!--begin::Label-->
                                                    <label class="fs-6 fw-semibold mb-2">Event End Time</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input class="form-control form-control-solid" name="calendar_event_end_time" placeholder="Pick a end time" id="kt_calendar_datepicker_end_time" />
                                                    <!--end::Input-->
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Input group-->
                                    </div>
                                    <!--end::Modal body-->
                                    <!--begin::Modal footer-->
                                    <div class="modal-footer flex-center">
                                        <!--begin::Button-->
                                        <button type="reset" id="kt_modal_add_event_cancel" class="btn btn-light me-3">Cancel</button>
                                        <!--end::Button-->
                                        <!--begin::Button-->
                                        <button type="button" id="kt_modal_add_event_submit" class="btn btn-primary">
                                            <span class="indicator-label">Submit</span>
                                            <span class="indicator-progress">Please wait...
													<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                        </button>
                                        <!--end::Button-->
                                    </div>
                                    <!--end::Modal footer-->
                                </form>
                                <!--end::Form-->
                            </div>
                        </div>
                    </div>
                    <!--end::Modal - New Product-->
                    <!--begin::Modal - New Product-->
                    <div class="modal fade" id="kt_modal_view_event" tabindex="-1" data-bs-focus="false" aria-hidden="true">
                        <!--begin::Modal dialog-->
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                            <!--begin::Modal content-->
                            <div class="modal-content">
                                <!--begin::Modal header-->
                                <div class="modal-header border-0 justify-content-end">
                                    <!--begin::Edit-->
                                    <div class="btn btn-icon btn-sm btn-color-gray-400 btn-active-icon-primary me-2" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Edit Event" id="kt_modal_view_event_edit">
                                        <i class="ki-outline ki-pencil fs-2"></i>
                                    </div>
                                    <!--end::Edit-->
                                    <!--begin::Edit-->
                                    <div class="btn btn-icon btn-sm btn-color-gray-400 btn-active-icon-danger me-2" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Delete Event" id="kt_modal_view_event_delete">
                                        <i class="ki-outline ki-trash fs-2"></i>
                                    </div>
                                    <!--end::Edit-->
                                    <!--begin::Close-->
                                    <div class="btn btn-icon btn-sm btn-color-gray-500 btn-active-icon-primary" data-bs-toggle="tooltip" title="Hide Event" data-bs-dismiss="modal">
                                        <i class="ki-outline ki-cross fs-2x"></i>
                                    </div>
                                    <!--end::Close-->
                                </div>
                                <!--end::Modal header-->
                                <!--begin::Modal body-->
                                <div class="modal-body pt-0 pb-20 px-lg-17">
                                    <!--begin::Row-->
                                    <div class="d-flex">
                                        <!--begin::Icon-->
                                        <i class="ki-outline ki-calendar-8 fs-1 text-muted me-5"></i>
                                        <!--end::Icon-->
                                        <div class="mb-9">
                                            <!--begin::Event name-->
                                            <div class="d-flex align-items-center mb-2">
                                                <span class="fs-3 fw-bold me-3" data-kt-calendar="event_name"></span>
                                                <span class="badge badge-light-success" data-kt-calendar="all_day"></span>
                                            </div>
                                            <!--end::Event name-->
                                            <!--begin::Event description-->
                                            <div class="fs-6" data-kt-calendar="event_description"></div>
                                            <!--end::Event description-->
                                        </div>
                                    </div>
                                    <!--end::Row-->
                                    <!--begin::Row-->
                                    <div class="d-flex align-items-center mb-2">
                                        <!--begin::Bullet-->
                                        <span class="bullet bullet-dot h-10px w-10px bg-success ms-2 me-7"></span>
                                        <!--end::Bullet-->
                                        <!--begin::Event start date/time-->
                                        <div class="fs-6">
                                            <span class="fw-bold">Starts</span>
                                            <span data-kt-calendar="event_start_date"></span>
                                        </div>
                                        <!--end::Event start date/time-->
                                    </div>
                                    <!--end::Row-->
                                    <!--begin::Row-->
                                    <div class="d-flex align-items-center mb-9">
                                        <!--begin::Bullet-->
                                        <span class="bullet bullet-dot h-10px w-10px bg-danger ms-2 me-7"></span>
                                        <!--end::Bullet-->
                                        <!--begin::Event end date/time-->
                                        <div class="fs-6">
                                            <span class="fw-bold">Ends</span>
                                            <span data-kt-calendar="event_end_date"></span>
                                        </div>
                                        <!--end::Event end date/time-->
                                    </div>
                                    <!--end::Row-->
                                    <!--begin::Row-->
                                    <div class="d-flex align-items-center">
                                        <!--begin::Icon-->
                                        <i class="ki-outline ki-geolocation fs-1 text-muted me-5"></i>
                                        <!--end::Icon-->
                                        <!--begin::Event location-->
                                        <div class="fs-6" data-kt-calendar="event_location"></div>
                                        <!--end::Event location-->
                                    </div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Modal body-->
                            </div>
                        </div>
                    </div>
                    <!--end::Modal - New Product-->
                    <!--end::Modals-->
                </div>
                <!--end::Container-->
            </div>
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_students">
                <thead class="text-black">
                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0 text-black">

                    <th class="min-w-125px bold">Course</th>
                    <th class="min-w-125px bold">Cohort</th>
                    <th class="min-w-125px bold" >Start Time</th>
                    <th class="min-w-125px bold">End Time</th>
                    <th class="min-w-125px bold">Date</th>
                    <th class="min-w-125px bold">Action</th>


                </tr>
                </thead>
                <tbody class="text-gray-600 fw-semibold">
                @foreach($attendances as $attendance)
                    <tr>
                        <td>{{ $attendance->course->name }}</td>
                        <td>
                            @foreach ($attendance->cohortattendances as $cohortattendance)
                                {{ $cohortattendance->cohort->name }}&nbsp;&nbsp;&nbsp;&nbsp;
                            @endforeach
                        </td>                        <td style="color: limegreen">{{ $attendance->time_start }}</td>
                        <td style="color: red">{{ $attendance->time_end }}</td>
                        <td>{{date_format(date_create($attendance->date),"d-m-Y")}}</td>
                        <td >
                            <form class="form_delete" method="post" action="{{ route('attendance.destroy',$attendance) }}">
                                @csrf
                                @method('DELETE')
                                <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                    <i class="ki-outline ki-down fs-5 ms-1"></i></a>
                                <!--begin::Menu-->
                                <div class=" p-3 menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                    <a href="{{ route('attendance.edit',$attendance) }}" class="btn btn-primary mb-2">Edit</a>
                                    <button data-name="{{$attendance->course->name}}" type="submit" class="btn btn-danger delete_element" data-kt-users-table-filter="delete_row">Delete</button>
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
<script>

    $(document).ready(function(){
        new tempusDominus.TempusDominus(document.getElementById("kt_td_picker_custom_icons"), {
            display: {
                icons: {
                    time: "ki-outline ki-time fs-1",
                    date: "ki-outline ki-calendar fs-1",
                    up: "ki-outline ki-up fs-1",
                    down: "ki-outline ki-down fs-1",
                    previous: "ki-outline ki-left fs-1",
                    next: "ki-outline ki-right fs-1",
                    today: "ki-outline ki-check fs-1",
                    clear: "ki-outline ki-trash fs-1",
                    close: "ki-outline ki-cross fs-1",
                },
                buttons: {
                    today: true,
                    clear: true,
                    close: true,
                },
            },
            restrictions: {
                minDate: new Date(), // Disable past dates
            },
            localization: {
                format: "dd/MM/yyyy"
            }
        });
        $('.delete_element').on('click', function (e) {
            e.preventDefault();
            let $thisForm = $(this).closest('.form_delete');
            let name = $(this).data('name');
            Swal.fire({
                title: 'Are you sure you want to delete <span class="text-danger">this attendance schedule </span> ?',
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


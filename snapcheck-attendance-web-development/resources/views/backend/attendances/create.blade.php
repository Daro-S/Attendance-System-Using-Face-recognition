@php
    /**
     * @var App\Models\Course $courses
     * @var App\Models\Cohort $cohort
 */
@endphp
@extends('layouts.app')

@section('content')
    @include('backend.components.flash_message_sweet_alert')

    {{--Top bar --}}
    <div class="toolbar py-2" id="kt_toolbar">
        <!--begin::Container-->
        @include('layouts.topbar',['bigSection'=>'Attendance management','feature' => 'Attendances','pageName' => 'Add New Attendance Schedule'])
        <!--end::Container-->
    </div>
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Card-->
            <div class="card">
                <!--begin::Card header-->
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body py-4">
                    <form method="POST" id="form" class="form" action="{{ route('attendance.store') }}"
                          enctype="multipart/form-data">
                        @csrf
                        <!--begin::Scroll-->
                        <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_user_scroll"
                             data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header"
                             data-kt-scroll-wrappers="#kt_modal_add_user_scroll">
                            <div class="fv-row mb-7 w-50">
                                <!--begin::Label-->
                                <label for="course_id" class="fw-semibold fs-6 mb-2">Course</label>
                                <select id="course_id" data-control="select2" class="form-select form-select-solid"
                                        aria-label="Select example" name="course_id">
                                    <option value="">Choose one</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                                    @endforeach
                                </select>
                                <!--end::Input-->
                            </div>

                            <div class="fv-row mb-7 w-50">
                                <!--begin::Label-->
                                <label for="cohort_id" class="fw-semibold fs-6 mb-2">Cohort</label>
                                <select id="cohort_id" data-control="select2" class="form-select form-select-solid"
                                        aria-label="Select example" name="cohort_id[]" multiple>
                                    <option value="">Choose one or more</option>
                                    @foreach($cohorts as $cohort)
                                        <option value="{{ $cohort->id }}">{{ $cohort->name }}</option>
                                    @endforeach
                                </select><!--end::Input-->
                            </div>
                            <div class="input-custom pb-5 col-md-4 w-50">
                                <label class="form-label fs-5">Date</label>
                                <div class="input-group form-control-solid" id="kt_td_picker_custom_icons" data-td-target-input="nearest"
                                     data-td-target-toggle="nearest">
                                    <input name="date" id="kt_td_picker_custom_icons_input" type="text" class="form-control"
                                           data-td-target="#kt_td_picker_custom_icons" />
                                    <span class="input-group-text" data-td-target="#kt_td_picker_custom_icons"
                                          data-td-toggle="datetimepicker">
                                        <i class="ki-duotone ki-calendar fs-2"><span class="path1"></span><span
                                                class="path2"></span></i>
                                        </span>
                                </div>
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div>{{ $errors->first('date') }}</div>
                                </div>
                            </div>
                            <div class="fv-row mb-7 w-50 row">
                                <div class="fv-row w-50">
                                    <label for="time_start" class="required fw-semibold fs-6">Start Time</label>
                                    <input id="time_start" type="time" class="form-control form-control-solid"
                                           name="time_start"/>
                                </div>
                                <div class="fv-row w-50">
                                    <label for="time_end" class="required fw-semibold fs-6">End Time</label>
                                    <input id="time_end" type="time" class="form-control form-control-solid"
                                           name="time_end"/>
                                </div>
                            </div>

                            <div class="fv-row mb-7 w-50">
                                <label for="repeat">Choose repeat weeks (between 1 and 15)</label>
                                <input type="number" class="form-control form-control-solid" id="repeat" name="repeat"
                                       min="1" max="15">
                            </div>


                        </div>


                        <!--end::Scroll-->
                        <!--begin::Actions-->
                        <div class="text-center pt-15">
                            <a href="{{ route('attendance.index') }}" class="btn btn-light me-3">Discard</a>
                            <button id="submit_button" type="submit" class="btn btn-primary"
                                    data-kt-users-modal-action="submit">
                                <span class="indicator-label">Submit</span>
                                <span class="indicator-progress">Please wait...
																	<span
                                                                        class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                        <!--end::Actions-->
                    </form>

                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <script>
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
        const form = document.getElementById('form');
        let validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    'cohort_id': {
                        validators: {
                            notEmpty: {
                                message: 'Cohort is required'
                            }
                        }
                    },
                    'course_id': {
                        validators: {
                            notEmpty: {
                                message: 'Course is required'
                            }
                        }
                    },
                    'date': {
                        validators: {
                            notEmpty: {
                                message: 'Date is required'
                            }
                        }
                    },
                    'time_start': {
                        validators: {
                            notEmpty: {
                                message: 'Start time is required'
                            }
                        }
                    },
                    'time_end': {
                        validators: {
                            notEmpty: {
                                message: 'End time is required'
                            }
                        }
                    },
                    'repeat': {
                        validators: {
                            notEmpty: {
                                message: 'Repeat is required'
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

        // Submit button handler
        const submitButton = document.getElementById('submit_button');
        submitButton.addEventListener('click', function (e) {
            // Prevent default button action
            e.preventDefault();

            // Validate form before submit
            if (validator) {
                validator.validate().then(function (status) {
                    console.log('validated!');

                    if (status === 'Valid') {
                        // Show loading indication
                        submitButton.setAttribute('data-kt-indicator', 'on');

                        // Disable button to avoid multiple click
                        submitButton.disabled = true;

                        // Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                        setTimeout(function () {
                            // Remove loading indication
                            submitButton.removeAttribute('data-kt-indicator');

                            // Enable button
                            submitButton.disabled = false;


                            form.submit(); // Submit form
                        }, 1000);
                    }
                });
            }
        });
    </script>

    <script src="{{ asset('metronic/demo6/dist/assets/js/custom/multiple_image.js') }}"></script>
@endsection

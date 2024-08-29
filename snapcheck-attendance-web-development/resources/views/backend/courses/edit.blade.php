
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
        @include('layouts.topbar',['bigSection'=>'Courses management','feature' => 'Courses','pageName' => 'Edit Courses'])
        <!--end::Container-->
    </div>
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Card-->
            <div class="card">

                <div class="card-body py-4">
                    <!--begin::Table-->
                    <form method="POST" id="form" class="form" action="{{ route('course.update', $course) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <!--begin::Scroll-->
                        <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7 d-none">
                                <!--begin::Label-->
                                <label class="d-block fw-semibold fs-6 mb-5">Course Profile</label>
                                <!--end::Label-->
                                <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">


                                    <img src="metronic/demo6/dist/assets/media/svg/brand-logos/plurk.svg" alt="Emma Smith" class="w-100" />

                                    <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success bg-success rounded-circle border border-4 border-body h-20px w-20px"></div>
                                </div>

                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label for="name" class="required fw-semibold fs-6 mb-2">Course Name</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input id="name" type="text" name="name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="{{$course->name}}" value="{{$course->name}}" />
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div>{{ $errors->first('name') }}</div>
                                </div>
                                <!--end::Input-->
                            </div>
                            <div class="fv-row  mt-7">
                                <label for="color" class="required fw-semibold fs-6 mb-2">Course Color</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input id="color" type="color" name="color" class="w-50px h-50px form-control form-control-solid mb-5 mt-5 mb-lg-0" placeholder="Course Color" />
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div>{{ $errors->first('color') }}</div>
                                </div>
                            </div>
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label for="description" class=" fw-semibold fs-6 mb-2">Course Description</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <textarea id="description" type="text" name="description" class="form-control form-control-solid " rows="3" ></textarea>
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div>{{ $errors->first('description') }}</div>
                                </div>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            <!--end::Input group-->
                        </div>
                        <!--end::Scroll-->
                        <!--begin::Actions-->
{{--                        <div class="text-center pt-15">--}}
{{--                            <a href="{{ route('course.index') }}" class="btn btn-light me-3" data-kt-users-modal-action="cancel">Discard</a>--}}
{{--                            <button id="submit_button" type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">--}}
{{--                                <span class="indicator-label">Submit</span>--}}
{{--                                <span class="indicator-progress">Please wait...--}}
{{--																	<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>--}}
{{--                            </button>--}}
{{--                        </div>--}}
                        <div class="text-center">
                            <a href="{{ route('course.index') }}"  class="btn btn-light me-3" data-kt-users-modal-action="cancel">Discard</a>
                            <button type="submit"  id="submit_button" class="btn btn-primary" data-kt-users-modal-action="submit">
                                <span class="indicator-label">Submit</span>
                                <span class="indicator-progress">Please wait...
																	<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <script>
        const form = document.getElementById('form');
        let validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    fields: {
                        'name': {
                            validators: {
                                notEmpty: {
                                    message: 'Course name is required'
                                }
                            }
                        },
                        'description': {
                            validators: {
                                notEmpty: {
                                    message: 'Course description is required'
                                }
                            }
                        }
                },

                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: '',
                        eleValidClass: ''
                    })
                }
            },
        );
        const modal = new bootstrap.Modal(element);
        // Cancel button handler
        const cancelButton = element.querySelector('[data-kt-users-modal-action="cancel"]');
        cancelButton.addEventListener('click', e => {
            e.preventDefault();

            Swal.fire({
                text: "Are you sure you would like to cancel?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Yes, cancel it!",
                cancelButtonText: "No, return",
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-active-light"
                }
            }).then(function (result) {
                if (result.value) {
                    form.reset(); // Reset form
                    modal.hide();
                } else if (result.dismiss === 'cancel') {
                    Swal.fire({
                        text: "Your form has not been cancelled!.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary",
                        }
                    });
                }
            });
        });
        const modal = new bootstrap.Modal(element);
        // Cancel button handler
        const cancelButton = element.querySelector('[data-kt-users-modal-action="cancel"]');
        cancelButton.addEventListener('click', e => {
            e.preventDefault();

            Swal.fire({
                text: "Are you sure you would like to cancel?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Yes, cancel it!",
                cancelButtonText: "No, return",
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-active-light"
                }
            }).then(function (result) {
                if (result.value) {
                    form.reset(); // Reset form
                    modal.hide();
                } else if (result.dismiss === 'cancel') {
                    Swal.fire({
                        text: "Your form has not been cancelled!.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary",
                        }
                    });
                }
            });
        });



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
@endsection

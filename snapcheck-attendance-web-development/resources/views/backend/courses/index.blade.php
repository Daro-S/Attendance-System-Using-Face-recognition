@php
    /**
     * @var App\Models\Course $course
     */
@endphp
@extends('layouts.app')
@section('content')
    @include('backend.components.flash_message_sweet_alert')
    <style>
        .card-body p {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .card-body h5 {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
    {{--Top bar --}}
    <div class="toolbar py-2" id="kt_toolbar">
        <!--begin::Container-->
        @include('layouts.topbar',['bigSection'=>'Course Management','feature' => 'Courses','pageName' => 'Courses List'])
        <!--end::Container-->
    </div>
    <!--end::Toolbar-->
    <!--begin::Content-->
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
                            <input type="text" data-kt-user-table-filter="search"
                                   class="form-control form-control-solid w-250px ps-13" placeholder="Search course"/>
                        </div>
                        <!--end::Search-->
                    </div>
                    {{--Filter--}}
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                            <!--begin::Filter-->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_add_course">
                                <i class="ki-outline ki-plus fs-2"></i>Add New Course
                            </button>
                            <!--end::Add course-->

                        </div>

                    </div>
                    <!--end::Card toolbar-->
                </div>

                <!--end::Card-->

                <div class="mt-0 mb-10"></div>
                <!--end::Container-->
                <div class="card-body row g-6 g-xl-9 " >
                    <!--begin::Col-->
                    @foreach($courses as $course)
                        <div class="col-md-6 col-xl-3 mb-5 " >
                            <!--begin::Card-->
                            <a href="{{ route('course.show',$course) }}"
                               class="card border m-3 border-2 shadow-sm border-hover-primary">
                                <!--end:: Card body-->
                                <div class="card " style="  border: 4px solid {{$course->color}};">
                                    <img class="d-none card-img-top  h-70px pt-3"
                                         src="metronic/demo6/dist/assets/media/svg/brand-logos/plurk.svg"
                                         alt="Card image cap">


                                    <div class="card-body" >
                                        <h5  class="fs-3 fw-bold text-dark ">{{$course->name}}</h5>
                                        <p class="text-gray-400 fw-semibold fs-5 ">{{$course->description}}</p>

                                    </div>
                                </div>
                            </a>

                            <!--end::Card-->
                        </div>
                    @endforeach
                    <!--end::Col-->
                    <!--begin::Col-->


                </div>
            </div>
            <div class="modal fade" id="kt_modal_add_course" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered mw-650px">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header" id="kt_modal_add_user_header">
                            <!--begin::Modal title-->
                            <h2 class="fw-bold">Add New Course</h2>
                            <!--end::Modal title-->
                            <!--begin::Close-->
                            <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
                                <i class="ki-outline ki-cross fs-1"></i>
                            </div>
                            <!--end::Close-->
                        </div>
                        <!--end::Modal header-->
                        <!--begin::Modal body-->
                        <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                            <!--begin::Form-->
                            <form method="POST" id="kt_modal_add_course_form" class="form"
                                  action="{{ route('course.store') }}" enctype="multipart/form-data">
                                @csrf
                                <!--begin::Scroll-->
                                <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_user_scroll"
                                     data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                                     data-kt-scroll-max-height="auto"
                                     data-kt-scroll-dependencies="#kt_modal_add_user_header"
                                     data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label for="name" class="required fw-semibold fs-6 mb-2">Course Name</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input id="name" type="text" name="name"
                                               class="form-control form-control-solid mb-3 mb-lg-0"
                                               placeholder="Course Name"/>
                                        <div class="fv-plugins-message-container invalid-feedback">
                                            <div>{{ $errors->first('name') }}</div>
                                        </div>
                                        <!--end::Input-->
                                        <div class="fv-row mb-7 mt-7">
                                            <label for="color" class="required fw-semibold fs-6 mb-2">Course Color</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input id="color" type="color" name="color" class="w-50px h-50px form-control form-control-solid mb-5 mt-5 mb-lg-0" />
                                            <div class="fv-plugins-message-container invalid-feedback">
                                                <div>{{ $errors->first('color') }}</div>
                                            </div>
                                        </div>

                                        <div class="fv-row mb-7">
                                            <!--begin::Label-->
                                            <label for="description" class="required fw-semibold fs-6 mb-2">Course
                                                Description </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <textarea id="description" name="description" type="text"
                                                      class="form-control form-control-solid" rows="3"
                                                      placeholder="Course Description"></textarea>
                                            <div class="fv-plugins-message-container invalid-feedback">
                                                <div>{{ $errors->first('description') }}</div>
                                            </div>
                                            <!--end::Input-->
                                        </div>
                                    </div>

                                    <!--end::Input-->
                                    <!--end::Input group-->

                                    <!--end::Scroll-->
                                    <!--begin::Actions-->
                                    <div class="text-center pt-15">
                                        <button type="reset" class="btn btn-light me-3"
                                                data-kt-users-modal-action="cancel">Discard
                                        </button>
                                        <button id="submit_add_user_button" type="submit" class="btn btn-primary"
                                                data-kt-users-modal-action="submit">
                                            <span class="indicator-label">Submit</span>
                                            <span class="indicator-progress">Please wait...
																	<span
                                                                        class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                        </button>
                                    </div>
                                    <!--end::Actions-->
                                </div>
                            </form>
                            <!--end::Form-->
                        </div>
                        <!--end::Modal body-->
                    </div>
                    <!--end::Modal content-->
                </div>
                <!--end::Modal dialog-->
            </div>

            <!--end::Col-->
            <!--begin::Col-->

            <!--end::Col-->
        </div>
        </div>
            <script>
                const element = document.getElementById('kt_modal_add_course');
                const form = element.querySelector('#kt_modal_add_course_form');
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

                // Close button handler
                const closeButton = element.querySelector('[data-kt-users-modal-action="close"]');
                closeButton.addEventListener('click', e => {
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

                // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
                let validator = FormValidation.formValidation(
                    form,
                    {
                        fields: {
                            'name': {
                                validators: {
                                    notEmpty: {
                                        message: 'Course name is required'
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
                // const submitButton = document.getElementById('submit_add_course_button');
                // submitButton.addEventListener('click', function (e) {
                //     // Prevent default button action
                //     e.preventDefault();
                //
                //     // Validate form before submit
                //     if (validator) {
                //         validator.validate().then(function (status) {
                //             console.log('validated!');
                //
                //             if (status === 'Valid') {
                //                 // Show loading indication
                //                 submitButton.setAttribute('data-kt-indicator', 'on');
                //
                //                 // Disable button to avoid multiple click
                //                 submitButton.disabled = true;
                //
                //                 // Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                //                 setTimeout(function () {
                //                     // Remove loading indication
                //                     submitButton.removeAttribute('data-kt-indicator');
                //
                //                     // Enable button
                //                     submitButton.disabled = false;
                //
                //                     // Show popup confirmation
                //                     /*Swal.fire({
                //                         text: "Form has been successfully submitted!",
                //                         icon: "success",
                //                         buttonsStyling: false,
                //                         confirmButtonText: "Ok, got it!",
                //                         customClass: {
                //                             confirmButton: "btn btn-primary"
                //                         }
                //                     });*/
                //
                //                     form.submit(); // Submit form
                //                 }, 1000);
                //             }
                //         });
                //     }
                // });

                $(document).ready(function () {
                    @if ($errors->any())
                    console.log('There is the error')
                    $('#kt_modal_add_course').modal('show')
                    @endif

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

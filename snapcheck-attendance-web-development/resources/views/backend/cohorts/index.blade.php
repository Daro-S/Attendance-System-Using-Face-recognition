@php
    /**
     * @var App\Models\Cohort $cohort
     */
@endphp
@extends('layouts.app')
@section('content')
    @include('backend.components.flash_message_sweet_alert')
    {{--Top bar --}}
    <div class="toolbar py-2" id="kt_toolbar">
        <!--begin::Container-->
        @include('layouts.topbar',['bigSection'=>'Cohort Management','feature' => 'Cohorts','pageName' => 'Cohort List'])
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
                            <input type="text" data-kt-user-table-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="Search cohort" />
                        </div>
                        <!--end::Search-->
                    </div>
                    {{--Filter--}}
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                            <!--begin::Filter-->
                            <!--begin::Menu 1-->
                            <!--begin::Add Cohort-->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_cohort">
                                <i class="ki-outline ki-plus fs-2"></i>Add New Cohort</button>
                            <!--end::Add Cohort-->
                        </div>
                        <!--end::Toolbar-->
                        <!--begin::Group actions-->
                        <div class="d-flex justify-content-end align-items-center d-none" data-kt-user-table-toolbar="selected">
                            <div class="fw-bold me-5">
                                <span class="me-2" data-kt-user-table-select="selected_count"></span>Selected</div>
                            <button type="button" class="btn btn-danger" data-kt-user-table-select="delete_selected">Delete Selected</button>
                        </div>
                        <!--end::Group actions-->
                        <!--begin::Modal - Adjust Balance-->
                        <div class="modal fade" id="kt_modal_export_users" tabindex="-1" aria-hidden="true">
                            <!--begin::Modal dialog-->
                            <div class="modal-dialog modal-dialog-centered mw-650px">
                                <!--begin::Modal content-->
                                <div class="modal-content">
                                    <!--begin::Modal header-->
                                    <div class="modal-header">
                                        <!--begin::Modal title-->
                                        <h2 class="fw-bold">Export Users</h2>
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
                                        <form id="kt_modal_export_users_form" class="form" action="#">
                                            <!--begin::Input group-->
                                            <div class="fv-row mb-10">
                                                <!--begin::Label-->
                                                <label class="fs-6 fw-semibold form-label mb-2">Select Roles:</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <select name="role" data-control="select2" data-placeholder="Select a role" data-hide-search="true" class="form-select form-select-solid fw-bold">
                                                    <option></option>
                                                    <option value="Administrator">Administrator</option>
                                                    <option value="Analyst">Analyst</option>
                                                    <option value="Developer">Developer</option>
                                                    <option value="Support">Support</option>
                                                    <option value="Trial">Trial</option>
                                                </select>
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="fv-row mb-10">
                                                <!--begin::Label-->
                                                <label class="required fs-6 fw-semibold form-label mb-2">Select Export Format:</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <select name="format" data-control="select2" data-placeholder="Select a format" data-hide-search="true" class="form-select form-select-solid fw-bold">
                                                    <option></option>
                                                    <option value="excel">Excel</option>
                                                    <option value="pdf">PDF</option>
                                                    <option value="cvs">CVS</option>
                                                    <option value="zip">ZIP</option>
                                                </select>
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Actions-->
                                            <div class="text-center">
                                                <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">Discard</button>
                                                <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                                                    <span class="indicator-label">Submit</span>
                                                    <span class="indicator-progress">Please wait...
																	<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                </button>
                                            </div>
                                            <!--end::Actions-->
                                        </form>
                                        <!--end::Form-->
                                    </div>
                                    <!--end::Modal body-->
                                </div>
                                <!--end::Modal content-->
                            </div>
                            <!--end::Modal dialog-->
                        </div>
                        <!--end::Modal - New Card-->
                        <!--begin::Modal - Add New Cohort-->
                        <div class="modal fade" id="kt_modal_add_cohort" tabindex="-1" aria-hidden="true">
                            <!--begin::Modal dialog-->
                            <div class="modal-dialog modal-dialog-centered mw-650px">
                                <!--begin::Modal content-->
                                <div class="modal-content">
                                    <!--begin::Modal header-->
                                    <div class="modal-header" id="kt_modal_add_user_header">
                                        <!--begin::Modal title-->
                                        <h2 class="fw-bold">Add New Cohort</h2>
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
                                        <form method="POST" id="kt_modal_add_cohort_form" class="form" action="{{ route('cohort.store') }}" enctype="multipart/form-data">
                                            @csrf
                                            <!--begin::Scroll-->
                                            <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
                                                <!--begin::Input group-->
                                                <div class="fv-row mb-7">
                                                    <!--begin::Label-->
                                                    <label for="name" class="required fw-semibold fs-6 mb-2">Cohort Name</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input id="name" type="text" name="name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Cohort Name" />
                                                    <div class="fv-plugins-message-container invalid-feedback">
                                                        <div>{{ $errors->first('name') }}</div>
                                                    </div>
                                                    <!--end::Input-->

                                                    <div class="fv-row mb-7">
                                                        <!--begin::Label-->
                                                        <label class="d-block fw-semibold fs-6 mb-5">Cohort Image</label>
                                                        <!--end::Label-->
                                                        <!--begin::Image placeholder-->
                                                        <style>.image-input-placeholder { background-image: url({{asset('metronic/demo6/dist/assets/media/svg/files/blank-image.svg')}}); } [data-bs-theme="dark"] .image-input-placeholder { background-image: url('assets/media/svg/files/blank-image-dark.svg'); }</style>
                                                        <!--end::Image placeholder-->
                                                        <!--begin::Image input-->
                                                        <div class="image-input image-input-empty image-input-outline image-input-placeholder" data-kt-image-input="true">
                                                            <!--begin::Preview existing avatar-->
                                                            <div class="image-input-wrapper w-125px h-125px"></div>
                                                            <!--end::Preview existing avatar-->
                                                            <!--begin::Label-->
                                                            <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change image">
                                                                <i class="ki-outline ki-pencil fs-7"></i>
                                                                <!--begin::Inputs-->
                                                                <input type="file" name="profile_image" accept=".png, .jpg, .jpeg" />
                                                                <input type="hidden" name="avatar_remove" />
                                                                <!--end::Inputs-->
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Cancel-->
                                                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel image">
																			<i class="ki-outline ki-cross fs-2"></i>
																		</span>
                                                            <!--end::Cancel-->
                                                            <!--begin::Remove-->
                                                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
																			<i class="ki-outline ki-cross fs-2"></i>
																		</span>
                                                            <!--end::Remove-->
                                                        </div>
                                                        <!--end::Image input-->
                                                        <!--begin::Hint-->
                                                        <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                                                        <div class="fv-plugins-message-container invalid-feedback">
                                                            <div>{{ $errors->first('profile_image') }}</div>
                                                        </div>
                                                        <!--end::Hint-->
                                                    </div>
                                                </div>

                                                <!--end::Input-->
                                                <!--end::Input group-->

                                                <!--end::Scroll-->
                                                <!--begin::Actions-->
                                                <div class="text-center pt-15">
                                                    <button  type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">Discard</button>
                                                    <button id="submit_add_user_button" type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                                                        <span class="indicator-label">Submit</span>
                                                        <span class="indicator-progress">Please wait...
																	<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
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
                        <!--end::Modal - Add task-->
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <div class="card-body py-4">
                    <div class="row g-6 g-xl-9 ">
                        <!--begin::Col-->
                        @foreach($cohorts as $cohort)
                            <div class="col-md-6 col-xl-3 mb-5">
                                <!--begin::Card-->
                                <a href="{{ route('cohort.show',$cohort) }}" class="card border-hover-primary">
                                    <div class="card-body text-center p-5 shadow">
                                        <!--begin::Name-->
                                        <div class="symbol symbol-100px w-100px bg-light shadow-sm">
                                            <img src="{{asset($cohort->profile_path)}}" alt="Emma Smith"  />
                                        </div>
                                        <div class="fs-3 fw-bold text-dark pt-5  ">{{$cohort->name}}</div>

                                    </div>
                                    <!--end:: Card body-->
                                </a>
                                <!--end::Card-->
                            </div>

                        @endforeach
                        <!--end::Col-->
                        <!--begin::Col-->


                    </div>
                </div>
                <!--end::Card-->
            </div>
            <div class="mt-10 mb-10"></div>
            <!--end::Container-->

            <!--end::Col-->
            <!--begin::Col-->

            <!--end::Col-->

        </div>
    </div>
            <script>
                const element = document.getElementById('kt_modal_add_cohort');
                const form = element.querySelector('#kt_modal_add_cohort_form');
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
                                        message: 'Cohort name is required'
                                    }
                                }
                            },
                            'description': {
                                validators: {
                                    notEmpty: {
                                        message: 'Course description is required'
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
                const submitButton = document.getElementById('submit_add_cohort_button');
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

                                    // Show popup confirmation
                                    /*Swal.fire({
                                        text: "Form has been successfully submitted!",
                                        icon: "success",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: {
                                            confirmButton: "btn btn-primary"
                                        }
                                    });*/

                                    form.submit(); // Submit form
                                }, 1000);
                            }
                        });
                    }
                });

                $(document).ready(function(){
                    @if ($errors->any())
                    console.log('There is the error')
                    $('#kt_modal_add_cohort').modal('show')
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

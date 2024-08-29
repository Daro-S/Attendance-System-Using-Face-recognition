@php
    /**
     * @var App\Models\Student $student
     */
@endphp
@extends('layouts.app')

@section('content')
    @include('backend.components.flash_message_sweet_alert')

    {{--Top bar --}}
    <div class="toolbar py-2" id="kt_toolbar">
        <!--begin::Container-->
        @include('layouts.topbar',['bigSection'=>'Students management','feature' => 'Students','pageName' => 'Add New Student'])
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
                    <form method="POST" id="form" class="form" action="{{ route('student.store') }}" enctype="multipart/form-data">
                        @csrf
                        <!--begin::Scroll-->
                        <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_user_scroll" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="d-block fw-semibold fs-6 mb-5">Student Profile</label>
                                <!--end::Label-->
                                <!--begin::Image placeholder-->

                                <style>.image-input-placeholder { background-image: url({{asset('metronic/demo6/dist/assets/media/svg/files/blank-image.svg')}}); } [data-bs-theme="dark"] .image-input-placeholder { background-image: url({{asset('metronic/demo6/dist/assets/media/svg/files/blank-image-dark.svg')}}); }</style>

                                <!--end::Image placeholder-->
                                <!--begin::Image input-->
                                <div class="image-input image-input-empty image-input-outline image-input-placeholder" data-kt-image-input="true">
                                    <!--begin::Preview existing avatar-->
                                    <div class="image-input-wrapper w-125px h-125px"></div>
                                    <!--end::Preview existing avatar-->
                                    <!--begin::Label-->
                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                                        <i class="ki-outline ki-pencil fs-7"></i>
                                        <!--begin::Inputs-->
                                        <input type="file" name="profile_image" accept=".png, .jpg, .jpeg" />
                                        <input type="hidden" name="avatar_remove" />
                                        <!--end::Inputs-->
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Cancel-->
                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
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
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label for="student_name" class="required fw-semibold fs-6 mb-2">Student's name</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input id="student_name" type="text" name="name" class="form-control form-control-solid mb-3 mb-lg-0 w-100 w-md-25" placeholder="SnapCheck" value="{{ old('name') }}" />
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div>{{ $errors->first('name') }}</div>
                                </div>
                                <!--end::Input-->
                            </div>
                            <!--begin::Row-->
                            <div class="fv-row mb-7">
                            <label for="gender" class="required fw-semibold fs-6 mb-2">Student's Sex</label>

                            <div class="row mw-500px mb-5" data-kt-buttons="true" data-kt-buttons-target=".form-check-image, .form-check-input">>
                                <!--begin::Col-->
                                <div class="col-4">
                                    <label class="form-check-image active">
                                        <div class="form-check-wrapper w-100px border border-2">
                                            <img src="{{asset('metronic/demo6/dist/assets/media/svg/avatars/001-boy.svg')}}"/>
                                        </div>

                                        <div class="form-check form-check-custom form-check-solid me-10">
                                            <input checked class="form-check-input" type="radio" value="{{ \App\Enum\GenderEnum::MALE }}" name="gender" id="text_wow"/>
                                            <div class="form-check-label">
                                                Male
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                <!--end::Col-->

                                <!--begin::Col-->
                                <div class="col-4">
                                    <label class="form-check-image">
                                        <div class="form-check-wrapper w-100px border border-2">
                                            <img src="{{ asset('metronic/demo6/dist/assets/media/svg/avatars/003-girl-1.svg') }}"/>
                                        </div>

                                        <div class="form-check form-check-custom form-check-solid me-10">
                                            <input class="form-check-input" type="radio" value="{{ \App\Enum\GenderEnum::FEMALE }}" name="gender"/>
                                            <div class="form-check-label">
                                                Female
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                <!--end::Col-->
                            </div>
                            </div>

                            <div class="fv-row mb-7  w-100 w-md-25">
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
                            <div class="fv-row mb-7">
                            <label for="student" class="required fw-semibold fs-6 mb-2">Student Facial Images</label>
                                <div class="upload__box p-3">
                                    <div class="upload__btn-box">
                                        <label class="btn btn-primary">

                                            Upload images
                                            <input id="student_images_input" name="student_faces[]" type="file" multiple="multiple" data-max_length="500" class="upload__inputfile">
                                        </label>
                                    </div>
                                    <div class="upload__img-wrap dropzone align-items-center justify-content-center" >
                                        <div class="dz-message needsclick" id="drop_zone_text">
                                            <i class="ki-duotone ki-file-up fs-3x text-primary"><span class="path1"></span><span class="path2"></span></i>

                                            <!--begin::Info-->
                                            <div class="ms-4">
                                                <h3 class="fs-5 fw-bold text-gray-900 mb-1">Drop files here or click to upload.</h3>
                                                <span class="fs-7 fw-semibold text-gray-500">Upload up to 500 files</span>
                                            </div>
                                            <!--end::Info-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Scroll-->
                        <!--begin::Actions-->
                        <div class="text-center pt-15">
                            <a href="{{ route('student.index') }}" class="btn btn-light me-3">Discard</a>
                            <button id="submit_button" type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                                <span class="indicator-label">Submit</span>
                                <span class="indicator-progress">Please wait...
																	<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
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
        const form = document.getElementById('form');
        let validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    'username': {
                        validators: {
                            notEmpty: {
                                message: 'Username is required'
                            }
                        }
                    },
                    'email': {
                        validators: {
                            notEmpty: {
                                message: 'Email is required'
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
    </script>

    <script src="{{ asset('metronic/demo6/dist/assets/js/custom/multiple_image.js') }}"></script>
@endsection

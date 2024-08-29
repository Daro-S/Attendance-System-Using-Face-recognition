
@php
    /**
     * @var App\Models\User $user
     */
@endphp
@extends('layouts.app')

@section('content')
    {{--Top bar --}}
    <div class="toolbar py-2" id="kt_toolbar">
        <!--begin::Container-->
        @include('layouts.topbar',['bigSection'=>'Users management','feature' => 'Users','pageName' => 'Edit User'])
        <!--end::Container-->
    </div>
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Card-->
            <div class="card">

                <div class="card-body py-4">
                    <!--begin::Table-->
                    <form method="POST" id="form" class="form" action="{{ route('user.update', $user) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <!--begin::Scroll-->
                        <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="d-block fw-semibold fs-6 mb-5">User Profile</label>
                                <!--end::Label-->
                                <!--begin::Image placeholder-->
                                @if(!is_null($user->profile_path))
                                <style>.image-input-placeholder { background-image: url({{asset($user->profile_path)}}); } [data-bs-theme="dark"] .image-input-placeholder { background-image: url({{asset('metronic/demo6/dist/assets/media/svg/files/blank-image-dark.svg')}}); }</style>
                                @else
                                <style>.image-input-placeholder { background-image: url({{asset('metronic/demo6/dist/assets/media/svg/files/blank-image.svg')}}); } [data-bs-theme="dark"] .image-input-placeholder { background-image: url({{asset('metronic/demo6/dist/assets/media/svg/files/blank-image-dark.svg')}}); }</style>
                                @endif
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
                                <label for="username" class="required fw-semibold fs-6 mb-2">Username</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input id="username" type="text" name="username" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="SnapCheck" value="{{ $user->username }}" />
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div>{{ $errors->first('username') }}</div>
                                </div>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label for="email" class="required fw-semibold fs-6 mb-2">Email</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input id="email" type="email" name="email" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="example@domain.com" value="{{ $user->email }}" />
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div>{{ $errors->first('email') }}</div>
                                </div>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--end::Input group-->
                        </div>
                        <!--end::Scroll-->
                        <!--begin::Actions-->
                        <div class="text-center pt-15">
                            <a href="{{ route('user.index') }}" class="btn btn-light me-3">Discard</a>
                            <button id="submit_button" type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
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
@endsection

@php
    /**
     * @var App\Models\Student $student
     */
@endphp
@extends('layouts.app')

@section('content')
    {{--Top bar --}}
    <div class="toolbar py-2" id="kt_toolbar">
        <!--begin::Container-->
        @include('layouts.topbar',['bigSection'=>'Users management','feature' => 'Users','pageName' => 'User details'])
        <!--end::Container-->
    </div>
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Card-->
            <div class="card">

                <div class="card-body pt-9 pb-0">
                    <!--begin::Details-->
                    <div class="d-flex flex-wrap flex-sm-nowrap">
                        <!--begin: Pic-->
                        <div class="me-7 mb-4">
                            <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">

                                @if(!is_null($student->profile_path))
                                    <img src="{{ asset($student->profile_path) }}" alt="image">
                                @else
                                    <img src="{{asset('metronic/demo6/dist/assets/media/svg/files/blank-image.svg')}}"
                                         alt="Emma Smith" class="w-100"/>
                                @endif
                                <div
                                    class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success bg-success rounded-circle border border-4 border-body h-20px w-20px"></div>
                            </div>
                        </div>
                        <!--end::Pic-->
                        <!--begin::Info-->
                        <div class="flex-grow-1">
                            <!--begin::Title-->
                            <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                                <!--begin::User-->
                                <div class="d-flex flex-column">
                                    <!--begin::Name-->
                                    <div class="d-flex align-items-center mb-2">
                                        <span href="#"
                                              class="text-gray-900 fs-2 fw-bold me-1">{{ $student->name }}</span>
                                        <span href="#">
                                    <i class="ki-duotone ki-verify fs-1 text-primary">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                                    </div>
                                    <!--end::Name-->
                                    <!--begin::Info-->
                                    <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2 row">
                                <span class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                    <i class="ki-duotone ki-profile-circle fs-4 me-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
{{--                                    @forelse ($student->getRoleNames() as $role)--}}
                                    @if($student->gender == \App\Enum\GenderEnum::MALE)
                                        <span class="badge bg-light-primary text-primary fs-7 me-1">Male</span>
                                    @else
                                        <span class="badge bg-light-danger text-danger fs-7 me-1">Female</span>
                                    @endif
                                    {{--                                    @empty--}}
                                    {{--                                    @endforelse--}}
                                </span>
                                        <span class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">
                                    <i class="ki-duotone ki-briefcase fs-4 me-1">
                                         <span class="path1"></span>
                                         <span class="path2"></span>
                                        </i>
                                        @if($student->cohort)
                                            <span class="badge badge-light-primary text-primary">{{ $student->cohort->name }}</span>
                                        @else
                                            <span class="badge badge-light-danger text-danger" style="font-style: italic !important;">Not yet assigned</span>
                                        @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="py-3">
                    <div class="card mb-5 mb-xl-10 fs-4" id="kt_profile_details_view">
                        <!--begin::Card header-->
                        <div class="card-header cursor-pointer">
                            <!--begin::Card title-->
                            <div class="card-title m-0">
                                <h3 class="fw-bold m-0">Student Detail</h3>
                            </div>
                            <!--end::Card title-->
                            <!--begin::Action-->
                            <div class="align-self-center">
                                {{--                                @if((Auth::user()->hasRole('Super Admin') && Auth::user()->id == $student->id) || Auth::user()->id == $student->id)--}}
                                <a href="{{ route('student.edit', $student) }}" class="btn btn-sm btn-primary">Edit</a>
                                {{--                                @endif--}}

                                {{--                                @if(Auth::user()->hasRole('Super Admin'))--}}
                                {{--                                    <a class="btn btn-warning btn-sm" href="{{ route('user.changePassword',$student) }}">{{ __('ប្តូរពាក្យសម្ងាត់') }}</a>--}}

                                {{--                                @elseif(Auth::user()->id == $student->id)--}}
                                {{--                                    <a class="btn btn-warning btn-sm" href="{{ route('user.changePasswordByKnowingOldPassword',$student) }}">{{ __('ប្តូរពាក្យសម្ងាត់') }}</a>--}}
                                {{--                                @endif--}}
                            </div>

                            <!--end::Action-->
                        </div>
                        <!--begin::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body p-9">

                            {{--                            <div class="row mb-7">--}}
                            {{--                                <!--begin::Label-->--}}
                            {{--                                <label class="col-lg-4 fw-semibold text-muted">{{ __('តួនាទី') }}</label>--}}
                            {{--                                <!--end::Label-->--}}
                            {{--                                <!--begin::Col-->--}}
                            {{--                                <div class="col-lg-8 d-flex align-items-center">--}}
                            {{--                                    @forelse ($student->getRoleNames() as $role)--}}
                            {{--                                        <span class="badge bg-light-primary text-primary fs-5">{{ $role }}</span>--}}
                            {{--                                    @empty--}}
                            {{--                                    @endforelse--}}
                            {{--                                </div>--}}
                            {{--                                <!--end::Col-->--}}
                            {{--                            </div>--}}

                            <div class="row mb-7">
                                <!--begin::Label-->
                                <label for="student" class="text-muted fw-semibold fs-6 mb-2 col-lg-4">Student Facial Images</label>
                                <div class="upload__box p-3">
                                    <div class="upload__img-wrap dropzone align-items-center justify-content-center" >
                                        <div class="dz-message needsclick row" id="drop_zone_text">
                                            @foreach($student->studentDetails as $detail)
                                                <div class="upload__img-box mx-2">
                                                    <img class="mw-150px" src="{{ asset($detail->image_path) }}" alt="Student Face"></img>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <!--end::Col-->
                            </div>



                            <div class="row mb-7">
                                <!--begin::Label-->
                                <label class="col-lg-4 fw-semibold text-muted">Registered at</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                            <span class="fw-semibold text-gray-800">
                                {{ $student->created_at->format('d M Y, h:i a') }}
                            </span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <div class="row mb-7">
                                <!--begin::Label-->
                                <label class="col-lg-4 fw-semibold text-muted">Updated at</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                            <span class="fw-semibold text-gray-800">
                                {{ $student->updated_at->format('d M Y, h:i a') }}
                            </span>
                                </div>
                                <!--end::Col-->
                            </div>
                        </div>
                        <!--end::Card body-->
                    </div>
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

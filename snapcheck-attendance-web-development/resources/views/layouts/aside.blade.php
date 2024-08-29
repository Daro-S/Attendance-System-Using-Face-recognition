@php
    use Illuminate\Support\Facades\Auth;

@endphp
<div id="kt_aside" class="aside overflow-visible pb-5 pt-5 pt-lg-0 shadow-sm" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'80px', '300px': '100px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_mobile_toggle">
    <!--begin::Brand-->
    <div class="aside-logo py-8" id="kt_aside_logo">
        <!--begin::Logo-->
        <a href="../../demo6/dist/index.html" class="d-flex align-items-center">
            <img alt="Logo" src="{{asset('metronic/demo6/dist/assets/media/logos/demo6.svg')}}" class="h-45px logo" />
        </a>
        <!--end::Logo-->
    </div>
    <!--end::Brand-->
    <!--begin::Aside menu-->
    <div class="aside-menu flex-column-fluid" id="kt_aside_menu">
        <!--begin::Aside Menu-->
        <div class="my-2 my-lg-5 scroll" id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside, #kt_aside_menu" data-kt-scroll-offset="5px">
            <!--begin::Menu-->
            <div class="menu menu-column menu-title-gray-700 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fw-semibold" id="#kt_aside_menu" data-kt-menu="true">
                <!--begin:Menu item-->
                <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item py-2">
                    <!--begin:Menu link-->
                    <span class="menu-link menu-center d-none">
                        <span class="menu-icon me-0">
                                <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M13.0021 10.9128V3.01281C13.0021 2.41281 13.5021 1.91281 14.1021 2.01281C16.1021 2.21281 17.9021 3.11284 19.3021 4.61284C20.7021 6.01284 21.6021 7.91285 21.9021 9.81285C22.0021 10.4129 21.5021 10.9128 20.9021 10.9128H13.0021Z" fill="currentColor"/>
                                <path opacity="0.3" d="M11.0021 13.7128V4.91283C11.0021 4.31283 10.5021 3.81283 9.90208 3.91283C5.40208 4.51283 1.90209 8.41284 2.00209 13.1128C2.10209 18.0128 6.40208 22.0128 11.3021 21.9128C13.1021 21.8128 14.7021 21.3128 16.0021 20.4128C16.5021 20.1128 16.6021 19.3128 16.1021 18.9128L11.0021 13.7128Z" fill="currentColor"/>
                                <path opacity="0.3" d="M21.9021 14.0128C21.7021 15.6128 21.1021 17.1128 20.1021 18.4128C19.7021 18.9128 19.0021 18.9128 18.6021 18.5128L13.0021 12.9128H20.9021C21.5021 12.9128 22.0021 13.4128 21.9021 14.0128Z" fill="currentColor"/>
                                </svg>
                                </span>
                            </span>
                            <span class="menu-title">Dashboard</span>
                        </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-dropdown px-2 py-4 w-250px mh-75 overflow-auto d-none">
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu content-->
                            <div class="menu-content">
                                <span class="menu-section fs-5 fw-bolder ps-1 py-1">Dashboard</span>
                            </div>
                            <!--end:Menu content-->
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link" href="../../demo6/dist/index.html">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
                                <span class="menu-title">Default</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                        <div class="menu-inner flex-column collapse" id="kt_app_sidebar_menu_dashboards_collapse">
                            <!--begin:Menu item-->
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link" href="../../demo6/dist/dashboards/bidding.html">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
                                    <span class="menu-title">Bidding</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                            <!--end:Menu item-->
                            <!--begin:Menu item-->
                            <!--end:Menu item-->
                        </div>
                        <div class="menu-item">
                            <div class="menu-content">
                                <a class="btn btn-flex btn-color-primary d-flex flex-stack fs-base p-0 ms-2 mb-2 toggle collapsible collapsed" data-bs-toggle="collapse" href="#kt_app_sidebar_menu_dashboards_collapse" data-kt-toggle-text="Show Less">
                                    <span data-kt-toggle-text-target="true">Show 12 More</span>
                                    <i class="ki-outline ki-minus-square toggle-on fs-2 me-0"></i>
                                    <i class="ki-outline ki-plus-square toggle-off fs-2 me-0"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!--end:Menu sub-->
                </div>
                {{--Attendances--}}
                <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item py-2 {{Route::is('attendance.*') ? 'here show':''}}">
                    <!--begin:Menu link-->
                    <span class="menu-link menu-center">
                        <span class="menu-icon me-0 fs">
                                <span class="svg-icon svg-icon-muted svg-icon-3x"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.3" d="M3 6C2.4 6 2 5.6 2 5V3C2 2.4 2.4 2 3 2H5C5.6 2 6 2.4 6 3C6 3.6 5.6 4 5 4H4V5C4 5.6 3.6 6 3 6ZM22 5V3C22 2.4 21.6 2 21 2H19C18.4 2 18 2.4 18 3C18 3.6 18.4 4 19 4H20V5C20 5.6 20.4 6 21 6C21.6 6 22 5.6 22 5ZM6 21C6 20.4 5.6 20 5 20H4V19C4 18.4 3.6 18 3 18C2.4 18 2 18.4 2 19V21C2 21.6 2.4 22 3 22H5C5.6 22 6 21.6 6 21ZM22 21V19C22 18.4 21.6 18 21 18C20.4 18 20 18.4 20 19V20H19C18.4 20 18 20.4 18 21C18 21.6 18.4 22 19 22H21C21.6 22 22 21.6 22 21ZM16 11V9C16 6.8 14.2 5 12 5C9.8 5 8 6.8 8 9V11C7.2 11 6.5 11.7 6.5 12.5C6.5 13.3 7.2 14 8 14V15C8 17.2 9.8 19 12 19C14.2 19 16 17.2 16 15V14C16.8 14 17.5 13.3 17.5 12.5C17.5 11.7 16.8 11 16 11ZM13.4 15C13.7 15 14 15.3 13.9 15.6C13.6 16.4 12.9 17 12 17C11.1 17 10.4 16.5 10.1 15.7C10 15.4 10.2 15 10.6 15H13.4Z" fill="currentColor"/>
                                <path d="M9.2 12.9C9.1 12.8 9.10001 12.7 9.10001 12.6C9.00001 12.2 9.3 11.7 9.7 11.6C10.1 11.5 10.6 11.8 10.7 12.2C10.7 12.3 10.7 12.4 10.7 12.5L9.2 12.9ZM14.8 12.9C14.9 12.8 14.9 12.7 14.9 12.6C15 12.2 14.7 11.7 14.3 11.6C13.9 11.5 13.4 11.8 13.3 12.2C13.3 12.3 13.3 12.4 13.3 12.5L14.8 12.9ZM16 7.29998C16.3 6.99998 16.5 6.69998 16.7 6.29998C16.3 6.29998 15.8 6.30001 15.4 6.20001C15 6.10001 14.7 5.90001 14.4 5.70001C13.8 5.20001 13 5.00002 12.2 4.90002C9.9 4.80002 8.10001 6.79997 8.10001 9.09997V11.4C8.90001 10.7 9.40001 9.8 9.60001 9C11 9.1 13.4 8.69998 14.5 8.29998C14.7 9.39998 15.3 10.5 16.1 11.4V9C16.1 8.5 16 8 15.8 7.5C15.8 7.5 15.9 7.39998 16 7.29998Z" fill="currentColor"/>
                                </svg>
                                </span>
                            </span>
                            <span class="menu-title fs-8">Attendances</span>
                        </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-dropdown px-2 py-4 w-250px mh-75 overflow-auto">
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu content-->
                            <div class="menu-content">
                                <span class="menu-section fs-5 fw-bolder ps-1 py-1">Attendances</span>
                            </div>
                            <!--end:Menu content-->
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link" href="{{ route('attendance.attendanceCameraOrStatistic') }}">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
                                <span class="menu-title {{Route::is('attendance.attendanceCameraOrStatistic') ? 'text-primary':''}}">Activate Attendance</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link" href="{{ route('attendance.attendanceReportSpecificCourseSession') }}">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
                                <span class="menu-title {{Route::is('attendance.attendanceReportSpecificCourseSession') ? 'text-primary':''}}">Course session report</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link" href="{{ route('attendance.index') }}">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
                                <span class="menu-title {{Route::is('attendance.index') ? 'text-primary':''}}">Attendance list</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                    </div>
                    <!--end:Menu sub-->
                </div>
                {{--Students--}}
                <div class="menu-item py-2 {{ Route::is('student.*') ? 'here show': '' }}">
                    <!--begin:Menu link-->
                    <a href="{{ route('student.index') }}" class="menu-link menu-center ">
                        <span class="menu-icon me-0">
                            <i class="fa-solid fa-graduation-cap"></i>
                        </span>
                        <span class="menu-title">Students</span>
                    </a>
                </div>

                <div class="menu-item py-2 {{ Route::is('course.*') ? 'here show': '' }}">
                    <!--begin:Menu link-->
                    <a href="{{ route('course.index') }}" class="menu-link menu-center ">
                        <span class="menu-icon me-0">
                            <i class="ki-duotone ki-book-open">
                             <span class="path1"></span>
                             <span class="path2"></span>
                             <span class="path3"></span>
                             <span class="path4"></span>
                            </i>
                        </span>
                        <span class="menu-title">Course</span>
                    </a>
                </div>

                <div class="menu-item py-2 {{ Route::is('cohort.*') ? 'here show': '' }}">
                    <!--begin:Menu link-->
                    <a href="{{ route('cohort.index') }}" class="menu-link menu-center ">
                        <span class="menu-icon me-0">
                            <i class="fa-solid fa-school"></i>
                        </span>
                        <span class="menu-title">Cohort</span>
                    </a>
                </div>
                <!--end:Menu item-->
                <!--begin:Menu item-->
                <!--end:Menu item-->
                <!--begin:Menu item-->

                {{--Settings--}}
                <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item {{Route::is('admin') || Route::is('user.*') ? 'here show':''}} py-2">
                    <!--begin:Menu link-->
                    <span class="menu-link menu-center">
										<span class="menu-icon me-0">
                                        <i class="ki-duotone ki-setting-3 fs-1">
                                         <span class="path1"></span>
                                         <span class="path2"></span>
                                         <span class="path3"></span>
                                         <span class="path4"></span>
                                         <span class="path5"></span>
                                        </i>
										</span>
										<span class="menu-title">Settings</span>
									</span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-dropdown menu-sub-indention px-2 py-4 w-250px mh-75 overflow-auto">
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu content-->
                            <div class="menu-content">
                                <span class="menu-section fs-5 fw-bolder ps-1 py-1">Settings</span>
                            </div>
                            <!--end:Menu content-->
                        </div>
                        <!--end:Menu item-->
                        <div data-kt-menu-trigger="click" class="menu-item {{Route::is('admin') || Route::is('user.*') ? 'here show':''}} menu-accordion">
                            <!--begin:Menu link-->
                            <span class="menu-link">
												<span class="menu-icon">
													<i class="ki-outline ki-shield-tick fs-2"></i>
												</span>
												<span class="menu-title">User Management</span>
												<span class="menu-arrow"></span>
											</span>
                            <!--end:Menu link-->
                            <!--begin:Menu sub-->
                            <div class="menu-sub menu-sub-accordion">
                                <!--begin:Menu item-->
                                <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion mb-1">

                                    <div class="menu-item">
                                        <a class="menu-link" href="{{ route('user.index') }}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title {{Route::is('admin') || Route::is('user.*') ? 'text-primary':''}}">Users</span>
                                        </a>
                                    </div>

                                </div>
                                <!--end:Menu item-->
                                <!--begin:Menu item-->
                                <!--end:Menu item-->
                            </div>
                            <!--end:Menu sub-->
                        </div>

                        <!--end:Menu item-->
                    </div>
                    <!--end:Menu sub-->
                </div>
                <!--end:Menu item-->
            </div>
            <!--end::Menu-->
        </div>
        <!--end::Aside Menu-->
    </div>
    <!--end::Aside menu-->
    <!--begin::Footer-->
    <div class="aside-footer flex-column-auto" id="kt_aside_footer">
        <!--begin::Menu-->
        <div class="d-flex justify-content-center">
            <div class="d-flex align-items-center ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
                <!--begin::Menu wrapper-->
                <div class="cursor-pointer symbol symbol-30px symbol-md-40px" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="top-start">
                    @if(!empty(Auth::user()->profile_path))
                        <img src="{{ asset(Auth::user()->profile_path) }}" alt="image">
                    @else
                        <img src="{{asset('metronic/demo6/dist/assets/media/svg/files/blank-image.svg')}}" alt="Emma Smith" class="w-100" />
                    @endif
                </div>
                <!--begin::User account menu-->
                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <div class="menu-content d-flex align-items-center px-3">
                            <!--begin::Avatar-->
                            <div class="symbol symbol-50px me-5">
                                @if(!empty(Auth::user()->profile_path))
                                    <img src="{{ asset(Auth::user()->profile_path) }}" alt="image">
                                @else
                                    <img src="{{asset('metronic/demo6/dist/assets/media/svg/files/blank-image.svg')}}" alt="Emma Smith" class="w-100" />
                                @endif
                            </div>
                            <!--end::Avatar-->
                            <!--begin::Username-->
                            <div class="d-flex flex-column">
                                <div class="fw-bold d-flex align-items-center fs-5">{{ Auth::user()->username }}
                                    <span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">Admin</span></div>
                                <a href="#" class="fw-semibold text-muted text-hover-primary fs-7">{{ Auth::user()->email }}</a>
                            </div>
                            <!--end::Username-->
                        </div>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu separator-->
                    <div class="separator my-2"></div>
                    <!--end::Menu separator-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-5">
                        <a href="{{ route('user.show',Auth::user()->id) }}" class="menu-link px-5">My Profile</a>
                    </div>

                    <!--begin::Menu item-->
                    <div class="menu-item px-5">
                        <a href="{{ route('logout') }}" class="menu-link px-5">Sign Out</a>
                    </div>
                    <div class="separator separator-dashed"></div>
                    <div class="menu-item px-5">
                        <div class="d-flex align-items-center ms-1 ms-lg-3">
                            <!--begin::Menu toggle-->
                            <a href="#" class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px" data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                                <i class="ki-outline ki-night-day theme-light-show fs-1"></i>
                                <i class="ki-outline ki-moon theme-dark-show fs-1"></i>
                            </a>
                            <!--begin::Menu toggle-->
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px" data-kt-menu="true" data-kt-element="theme-mode-menu">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3 my-0">
                                    <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
													<span class="menu-icon" data-kt-element="icon">
														<i class="ki-outline ki-night-day fs-2"></i>
													</span>
                                        <span class="menu-title">Light</span>
                                    </a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3 my-0">
                                    <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
													<span class="menu-icon" data-kt-element="icon">
														<i class="ki-outline ki-moon fs-2"></i>
													</span>
                                        <span class="menu-title">Dark</span>
                                    </a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3 my-0">
                                    <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="system">
													<span class="menu-icon" data-kt-element="icon">
														<i class="ki-outline ki-screen fs-2"></i>
													</span>
                                        <span class="menu-title">System</span>
                                    </a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </div>
                    </div>
                    <!--end::Menu item-->
                </div>
                <!--end::User account menu-->
                <!--end::Menu wrapper-->
            </div><!--end::Menu 2-->
        </div>
        <!--end::Menu-->
    </div>
    <!--end::Footer-->
</div>

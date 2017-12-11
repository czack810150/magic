<div id="m_aside_left" class="m-grid__item  m-aside-left  m-aside-left--skin-dark ">
    <!-- BEGIN: Left Aside -->
        <button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn">
          <i class="la la-close"></i>
        </button>
<!-- BEGIN: Aside Menu -->
	<div 
		id="m_ver_menu" 
		class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " 
		data-menu-vertical="true"
		 data-menu-scrollable="false" data-menu-dropdown-timeout="500"  
		>
						<ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
							<li class="m-menu__item  m-menu__item--active" aria-haspopup="true" >
								<a  href="{{ route('home') }}" class="m-menu__link ">
									<i class="m-menu__link-icon flaticon-line-graph"></i>
									<span class="m-menu__link-title">
										<span class="m-menu__link-wrap">
											<span class="m-menu__link-text">
												Dashboard
											</span>
											<span class="m-menu__link-badge">
												<span class="m-badge m-badge--danger">
													2
												</span>
											</span>
										</span>
									</span>
								</a>
							</li>
							<li class="m-menu__section">
								<h4 class="m-menu__section-text">
									Features
								</h4>
								<i class="m-menu__section-icon flaticon-more-v3"></i>
							</li>

							<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true"  data-menu-submenu-toggle="hover">
								<a  href="#" class="m-menu__link m-menu__toggle">
									<i class="m-menu__link-icon flaticon-users"></i>
									<span class="m-menu__link-text">
										People
									</span>
									<i class="m-menu__ver-arrow la la-angle-right"></i>
								</a>
								<div class="m-menu__submenu">
									<span class="m-menu__arrow"></span>
									<ul class="m-menu__subnav">
										@if(Auth::user()->authorization->level >=30 )
										<li class="m-menu__item " aria-haspopup="true" >
											<a  href="/employee" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													Staff Directory
												</span>
											</a>
										</li>
										@endif
										@can('score-employee')
										<li class="m-menu__item " aria-haspopup="true" >
										<a  href="/employee/performance" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													Evaluate
												</span>
											</a>
										</li>
										@endcan
										<li class="m-menu__item " aria-haspopup="true" >
										<a  href="/timeclock/inshift" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													Who's In
												</span>
											</a>
										</li>
									</ul>
								</div>
							</li>
							@if(Auth::user()->authorization->level >= 40)
							<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true"  data-menu-submenu-toggle="hover">
								<a  href="#" class="m-menu__link m-menu__toggle">
									<i class="m-menu__link-icon flaticon-coins"></i>
									<span class="m-menu__link-text">
										Money
									</span>
									<i class="m-menu__ver-arrow la la-angle-right"></i>
								</a>
								<div class="m-menu__submenu">
									<span class="m-menu__arrow"></span>
									<ul class="m-menu__subnav">
										
										<li class="m-menu__item " aria-haspopup="true" >
											<a  href="/tips" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													Tips
												</span>
											</a>
										</li>
										<li class="m-menu__item " aria-haspopup="true" >
											<a  href="/payroll/basic" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													Magic Noodle Pay
												</span>
											</a>
										</li>
										<li class="m-menu__item " aria-haspopup="true" >
											<a  href="/payroll/paystubs" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													Paystubs
												</span>
											</a>
										</li>
										@can('calculate-payroll')
										<li class="m-menu__item " aria-haspopup="true" >
											<a  href="/payroll/compute" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													Compute
												</span>
											</a>
										</li>
										@endcan
										<li class="m-menu__item " aria-haspopup="true" >
											<a  href="/payroll/employee" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													Employee Year Summary
												</span>
											</a>
										</li>
									</ul>
								</div>
							</li>
							@endif
							<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true"  data-menu-submenu-toggle="hover">
								<a  href="#" class="m-menu__link m-menu__toggle">
									<i class="m-menu__link-icon flaticon-time-1"></i>
									<span class="m-menu__link-text">
										Hours
									</span>
									<i class="m-menu__ver-arrow la la-angle-right"></i>
								</a>
								<div class="m-menu__submenu">
									<span class="m-menu__arrow"></span>
									<ul class="m-menu__subnav">
										<li class="m-menu__item " aria-haspopup="true" >
											<a  href="/hours" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													View Hours
												</span>
											</a>
										</li>
										<li class="m-menu__item " aria-haspopup="true" >
											<a  href="/clocks" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													Clocks
												</span>
											</a>
										</li>
										@can('calculate-hours')
										<li class="m-menu__item " aria-haspopup="true" >
											<a  href="/hours/compute" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													Compute
												</span>
											</a>
										</li>
										@endcan
										@can('manage-managers')
										<li class="m-menu__item " aria-haspopup="true" >
											<a  href="/manager/attendance" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													店长考勤
												</span>
											</a>
										</li>
										@endcan
									</ul>
								</div>
							</li>
							
							<li class="m-menu__item m-menu__item--submenu" aria-haspopup="true" data-menu-submenu-toggle="hover">
								<a href="#" class="m-menu__link m-menu__toggle">
									<i class="m-menu__link-icon flaticon-clipboard"></i>
									<span class="m-menu__link-text">Training</span>
									<i class="m-menu__ver-arrow la la-angle-right"></i>
								</a>
									<div class="m-menu__submenu">
									<span class="m-menu__arrow"></span>
									<ul class="m-menu__subnav">
										@if(Auth::user()->authorization->level >= 3)
										<li class="m-menu__item " aria-haspopup="true" >
											<a  href="/my_exam" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													Pending Exam
												</span>
											</a>
										</li>

										@endif
										@if(Auth::user()->authorization->level >= 30)
										<li class="m-menu__item " aria-haspopup="true" >
											<a  href="/exam" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													Exam
												</span>
											</a>
										</li>
										<li class="m-menu__item " aria-haspopup="true" >
											<a  href="/question" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													Question
												</span>
											</a>
										</li>
										@endif
								
									</ul>
								</div>
							</li>
							
							@if(Auth::user()->authorization->level >= 30)
							<li class="m-menu__item m-menu__item--submenu" aria-haspopup="true" data-menu-submenu-toggle="hover">
								<a href="#" class="m-menu__link m-menu__toggle">
									<i class="m-menu__link-icon flaticon-list-2"></i>
									<span class="m-menu__link-text">Score Settings</span>
									<i class="m-menu__ver-arrow la la-angle-right"></i>
								</a>
									<div class="m-menu__submenu">
									<span class="m-menu__arrow"></span>
									<ul class="m-menu__subnav">
										<li class="m-menu__item " aria-haspopup="true" >
											<a  href="/score/category" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													Category
												</span>
											</a>
										</li>
										<li class="m-menu__item " aria-haspopup="true" >
											<a  href="/score/item" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													Items
												</span>
											</a>
										</li>
								
									</ul>
								</div>
							</li>
							@endif
							@if(Auth::user()->authorization->level >= 50)
							<li class="m-menu__item m-menu__item--submenu" aria-haspopup="true" data-menu-submenu-toggle="hover">
								<a href="#" class="m-menu__link m-menu__toggle">
									<i class="m-menu__link-icon flaticon-suitcase"></i>
									<span class="m-menu__link-text">Jobs</span>
									<i class="m-menu__ver-arrow la la-angle-right"></i>
								</a>
									<div class="m-menu__submenu">
									<span class="m-menu__arrow"></span>
									<ul class="m-menu__subnav">
										<li class="m-menu__item " aria-haspopup="true" >
											<a  href="/jobs" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													Positions
												</span>
											</a>
										</li>
										
								
									</ul>
								</div>
							</li>
							@endif
							<!-- MY VOICE -->
							<li class="m-menu__item m-menu__item--submenu" aria-haspopup="true" data-menu-submenu-toggle="hover">
								<a href="#" class="m-menu__link m-menu__toggle">
									<i class="m-menu__link-icon flaticon-paper-plane"></i>
									<span class="m-menu__link-text">My Voice</span>

									@if(Auth::user()->authorization->employee->message->where('read',false)->count())
									<span class="m-menu__link-badge">
												<span class="m-badge m-badge--danger">
													{{ Auth::user()->authorization->employee->message->where('read',false)->count() }}
												</span>
											</span>

									<i class="m-menu__ver-arrow la la-angle-right"></i>
									@else
									<i class="m-menu__ver-arrow la la-angle-right"></i>
									@endif
								</a>
									<div class="m-menu__submenu">
									<span class="m-menu__arrow"></span>
									<ul class="m-menu__subnav">
										<li class="m-menu__item " aria-haspopup="true" >
											<a  href="/message/management" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													Message to Management
												</span>
											</a>
										</li>
										<li class="m-menu__item " aria-haspopup="true" >
											<a  href="/message/management/inbox" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													Inbox
												</span>

											</a>
										</li>
										
								
									</ul>
								</div>
							</li>
						
							
							@if( Auth::user()->authorization->type == 'admin' )
							<li class="m-menu__section">
								<h4 class="m-menu__section-text">
									Admin
								</h4>
								<i class="m-menu__section-icon flaticon-more-v3"></i>
							</li>
							<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true"  data-menu-submenu-toggle="hover">
								<a  href="#" class="m-menu__link m-menu__toggle">
									<i class="m-menu__link-icon flaticon-users"></i>
									<span class="m-menu__link-text">
										Users
									</span>
									<i class="m-menu__ver-arrow la la-angle-right"></i>
								</a>
								<div class="m-menu__submenu">
									<span class="m-menu__arrow"></span>
									<ul class="m-menu__subnav">
										<li class="m-menu__item " aria-haspopup="true" >
											<a  href="/users" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													Current Users
												</span>
											</a>
										</li>
										<li class="m-menu__item " aria-haspopup="true" >
											<a  href="/users/new" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													New User
												</span>
											</a>
										</li>
								
									</ul>
								</div>
							</li>
							<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true"  data-menu-submenu-toggle="hover">
								<a  href="#" class="m-menu__link m-menu__toggle">
									<i class="m-menu__link-icon flaticon-interface-8"></i>
									<span class="m-menu__link-text">
										Scripts
									</span>
									<i class="m-menu__ver-arrow la la-angle-right"></i>
								</a>
								<div class="m-menu__submenu">
									<span class="m-menu__arrow"></span>
									<ul class="m-menu__subnav">
										<li class="m-menu__item " aria-haspopup="true" >
											<a  href="/api/fixShared" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													Fix Shared Employees' Shifts
												</span>
											</a>
										</li>
										
								
									</ul>
								</div>
							</li>
							@endif
							
						</ul>
					</div>
					<!-- END: Aside Menu -->
					 </div>
        <!-- END: Left Aside -->
			
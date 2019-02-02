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
											<!-- <span class="m-menu__link-badge">
												<span class="m-badge m-badge--danger">
													2
												</span>
											</span> -->
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
							@can('view-sales')
							<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true"  data-menu-submenu-toggle="hover">
								<a  href="{{ url('/sales_dashboard') }}" class="m-menu__link ">
									<i class="m-menu__link-icon flaticon-graph"></i>
									<span class="m-menu__link-title">
										<span class="m-menu__link-wrap">
											<span class="m-menu__link-text">
												Sales
											</span>
											
										</span>
									</span>
								</a>
							</li>
							@endcan
							
							@can('use-scheduler')
							<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true"  data-menu-submenu-toggle="hover">
								<a  href="{{ url('/scheduler') }}" class="m-menu__link ">
									<i class="m-menu__link-icon flaticon-squares-1"></i>
									<span class="m-menu__link-title">
										<span class="m-menu__link-wrap">
											<span class="m-menu__link-text">
												MagicShift
											</span>
											
										</span>
									</span>
								</a>
							</li>
							@endcan
							@can('view-hr')
							<li class="m-menu__item m-menu__item--submenu " aria-haspopup="true"  data-menu-submenu-toggle="hover">
								<a  href="#" class="m-menu__link m-menu__toggle">
									<i class="m-menu__link-icon flaticon-puzzle"></i>
									<span class="m-menu__link-text">
										Teams
									</span>
									<i class="m-menu__ver-arrow la la-angle-right"></i>
								</a>
								<div class="m-menu__submenu">
									<span class="m-menu__arrow"></span>
									<ul class="m-menu__subnav">
										
										<li class="m-menu__item " aria-haspopup="true" >
											<a  href="{{ url('team/location') }}" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													门店团队
												</span>
											</a>
										</li>
										<li class="m-menu__item " aria-haspopup="true" >
											<a  href="{{ url('team/taskforce') }}" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													项目团队
												</span>
											</a>
										</li>
									
								</div>
							</li>
							@endcan
							
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
										@can('view-hr')
										<li class="m-menu__item " aria-haspopup="true" >
											<a  href="/hr" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													HR Overview
												</span>
											</a>
										</li>
										@endcan
										<li class="m-menu__item " aria-haspopup="true" >
											<a  href="/applicant" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													Job Applicants
												</span>
											</a>
										</li>

										@if(Auth::user()->authorization->level >= 20 )
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
										@can('promote-employee')
										<li class="m-menu__item " aria-haspopup="true" >
										<a  href="/employeeReview" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													员工考核
												</span>
											</a>
										</li>
										@endcan
										@can('assign-skill')
										<li class="m-menu__item " aria-haspopup="true" >
										<a  href="/employee_availability" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													Availability
												</span>
											</a>
										</li>
										@endcan

									</ul>
								</div>
							</li>
							@if(Auth::user()->authorization->level >= 30)
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
										@can('workon-tips')
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
										@endcan
										<li class="m-menu__item " aria-haspopup="true" >
											<a  href="{{ route('payroll.basic') }}" class="m-menu__link ">
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
										@can('is-office')
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
										<li class="m-menu__item " aria-haspopup="true" >
											<a  href="{{ route('payroll.location') }}" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													Location Year Summary
												</span>
											</a>
										</li>
										@endcan
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
										@can('view-hr')
										<li class="m-menu__item " aria-haspopup="true" >
											<a  href="{{ route('hours.store') }}" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													Store Hours
												</span>
											</a>
										</li>
										@endcan
										<li class="m-menu__item" aria-haspopup="true" >
											<a  href="/hours" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													Employee Hours
												</span>
											</a>
										</li>
										<li class="m-menu__item " aria-haspopup="true" >
											<a  href="/clocks/view" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													View Clocks
												</span>
											</a>
										</li>
										<li class="m-menu__item " aria-haspopup="true" >
											<a  href="/clocks" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													Edit Clocks
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
										@if(Auth::user()->authorization->level >= 20)
										<li class="m-menu__item " aria-haspopup="true" >
											<a  href="/exam/learn" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													知识强化训练
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
											<a  href="/exam_templates" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													Exam Templates
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
							@can('assign-skill')
							<li class="m-menu__item m-menu__item--submenu" aria-haspopup="true" data-menu-submenu-toggle="hover">
								<a href="#" class="m-menu__link m-menu__toggle">
									<i class="m-menu__link-icon flaticon-list-3"></i>
									<span class="m-menu__link-text">Skills</span>
									<i class="m-menu__ver-arrow la la-angle-right"></i>
								</a>
									<div class="m-menu__submenu">
									<span class="m-menu__arrow"></span>
									<ul class="m-menu__subnav">
										<li class="m-menu__item " aria-haspopup="true" >
											<a  href="/employee_skill" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													Employee Skills
												</span>
											</a>
										</li>
										
								
									</ul>
								</div>
							</li>
							@endcan
							
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
							<!-- Request Leave -->
							<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true"  data-menu-submenu-toggle="hover">
								<a  href="{{ url('leave') }}" class="m-menu__link ">
									<i class="m-menu__link-icon flaticon-paper-plane"></i>
									<span class="m-menu__link-title">
										<span class="m-menu__link-wrap">
											<span class="m-menu__link-text">
												Time off
											</span>
											
										</span>
									</span>
								</a>
							</li>
							
							@can('is-admin')
							<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true"  data-menu-submenu-toggle="hover">
								<a  href="{{ route('products') }}" class="m-menu__link ">
									<i class="m-menu__link-icon flaticon-up-arrow"></i>
									<span class="m-menu__link-title">
										<span class="m-menu__link-wrap">
											<span class="m-menu__link-text">
												Products
											</span>
											
										</span>
									</span>
								</a>
							</li>
							@endcan


							<!-- MY VOICE -->
							<li class="m-menu__item m-menu__item--submenu" aria-haspopup="true" data-menu-submenu-toggle="hover">
								<a href="#" class="m-menu__link m-menu__toggle">
									<i class="m-menu__link-icon flaticon-speech-bubble"></i>
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
							@can('configure-app')
							<li class="m-menu__section">
								<h4 class="m-menu__section-text">
									Admin
								</h4>
								<i class="m-menu__section-icon flaticon-more-v3"></i>
							</li>

							<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true"  data-menu-submenu-toggle="hover">
								<a  href="#" class="m-menu__link m-menu__toggle">
									<i class="m-menu__link-icon flaticon-puzzle"></i>
									<span class="m-menu__link-text">
										Configure
									</span>
									<i class="m-menu__ver-arrow la la-angle-right"></i>
								</a>
								<div class="m-menu__submenu">
									<span class="m-menu__arrow"></span>
									<ul class="m-menu__subnav">
										<li class="m-menu__item " aria-haspopup="true" >
											<a  href="/skills" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													Skills
												</span>
											</a>
										</li>

							<li class="m-menu__item m-menu__item--submenu" aria-haspopup="true" data-menu-submenu-toggle="hover">
								<a href="#" class="m-menu__link m-menu__toggle">
									<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
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
							
									
								
									</ul>
								</div>

							</li>

							@endcan
							@can('is-admin')
							
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
								
									</ul>
								</div>
							</li>
							@endcan
							
						</ul>
					</div>
					<!-- END: Aside Menu -->
					 </div>
        <!-- END: Left Aside -->
			
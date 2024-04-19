<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library position -->
{{--        @if(auth()->user()->role =='admin' or auth()->user()->role =='superAdmin')--}}
        @can('main menu show')
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link {{(request()->is('main*')? 'active' : "")}}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        الهيكل
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @can('branch show')
                        <li class="nav-item">
                            <a href="{{route('branches')}}" wire:navigatee
                               class="nav-link {{(request()->is('main/branches')? 'active' : "")}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>الفروع</p>
                            </a>
                        </li>
                    @endcan
                    @can('job show')
                        <li class="nav-item">
                            <a href="{{route('jobs')}}" wire:navigatee
                               class="nav-link {{(request()->is('main/jobs')? 'active' : "")}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>الأنشطة</p>
                            </a>
                        </li>
                    @endcan
                    @can('team show')
                        <li class="nav-item">
                            <a href="{{route('teams')}}" wire:navigatee
                               class="nav-link {{(request()->is('main/teams')? 'active' : "")}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>اللجان</p>
                            </a>
                        </li>
                    @endcan
                    @can('position show')
                        <li class="nav-item">
                            <a href="{{route('positions')}}" wire:navigatee
                               class="nav-link {{(request()->is('main/positions')? 'active' : "")}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>الصفات</p>
                            </a>
                        </li>
                    @endcan
                    @can('event show')
                        <li class="nav-item">
                            <a href="{{route('events')}}" wire:navigatee
                               class="nav-link {{(request()->is('main/events')? 'active' : "")}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>الاحداث</p>
                            </a>
                        </li>
                    @endcan
                    @can('link show')
                        <li class="nav-item">
                            <a href="{{route('links')}}" wire:navigatee
                               class="nav-link {{(request()->is('main/links')? 'active' : "")}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>الروابط</p>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('user menu show')
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link {{(request()->is('user/*')? 'active' : "")}}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        المتطوعين
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @can('degree show')
                        <li class="nav-item">
                            <a href="{{route('degrees')}}" wire:navigatee
                               class="nav-link {{(request()->is('user/degrees')? 'active' : "")}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>درجات التطوع</p>
                            </a>
                        </li>
                    @endcan
                    @can('status show')
                        <li class="nav-item">
                            <a href="{{route('statuses')}}" wire:navigatee
                               class="nav-link {{(request()->is('user/statuses')? 'active' : "")}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>حالات التطوع</p>
                            </a>
                        </li>
                    @endcan
                    @can('maritalStatus show')
                        <li class="nav-item">
                            <a href="{{route('maritalStatuses')}}" wire:navigatee
                               class="nav-link {{(request()->is('user/maritalStatuses')? 'active' : "")}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>الحالة الاجماعية </p>
                            </a>
                        </li>
                    @endcan
                    @can('nationality show')
                        <li class="nav-item">
                            <a href="{{route('nationalities')}}" wire:navigatee
                               class="nav-link {{(request()->is('user/nationalities')? 'active' : "")}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>الجنسيات </p>
                            </a>
                        </li>
                    @endcan
                    @can('qualification show')
                        <li class="nav-item">
                            <a href="{{route('qualifications')}}" wire:navigatee
                               class="nav-link {{(request()->is('user/qualifications')? 'active' : "")}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>الشهادات العلمية </p>
                            </a>
                        </li>
                    @endcan
                    @can('category show')
                        <li class="nav-item">
                            <a href="{{route('categories')}}" wire:navigatee
                               class="nav-link {{(request()->is('user/categories')? 'active' : "")}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>التصنيفات</p>
                            </a>
                        </li>
                    @endcan
                    {{--                    <li class="nav-item">--}}
                    {{--                        <a href="{{route('checkTypes')}}" wire:navigatee--}}
                    {{--                           class="nav-link {{(request()->is('user/check-types')? 'active' : "")}}">--}}
                    {{--                            <i class="far fa-circle nav-icon"></i>--}}
                    {{--                            <p>انواع الاختبارات</p>--}}
                    {{--                        </a>--}}
                    {{--                    </li>--}}
                    @can('user show')
                        <li class="nav-item">
                            <a href="{{route('users')}}" wire:navigatee
                               class="nav-link {{(request()->is('user/users')? 'active' : "")}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>المتطوعين</p>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
            @can('role menu show')
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link {{(request()->is('roles*')? 'active' : "")}}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            الصلاحيات
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{route('roles')}}" wire:navigatee
                               class="nav-link {{(request()->is('roles/roles')? 'active' : "")}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>انواع المستخدمين</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('roles.users')}}" wire:navigatee
                               class="nav-link {{(request()->is('roles/users')? 'active' : "")}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>المستخدمين</p>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
{{--        @endif--}}
        <li class="nav-item">
            <a href="{{route('user.home')}}" class="nav-link {{(request()->is('home')? 'active' : "")}}">
                <i class="nav-icon fas fa-th"></i>
                <p>
                    المشاركات
                    {{--                    <span class="right badge badge-danger">New</span>--}}
                </p>
            </a>
        </li>
        {{--        <li class="nav-item">--}}
        {{--            <a href="pages/gallery.html" class="nav-link">--}}
        {{--                <i class="nav-icon far fa-image"></i>--}}
        {{--                <p>--}}
        {{--                    Gallery--}}
        {{--                </p>--}}
        {{--            </a>--}}
        {{--        </li>--}}
        <li class="nav-header">MISCELLANEOUS</li>
    </ul>
</nav>
<!-- /.sidebar-menu -->

<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library position -->
        @if(auth()->user()->role =='admin')
            <li class="nav-item has-treeview">
            <a href="#" class="nav-link {{(request()->is('admin*')? 'active' : "")}}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    الهيكل
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('branches')}}" wire:navigatee class="nav-link {{(request()->is('admin/branches')? 'active' : "")}}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>الفروع</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('jobs')}}" wire:navigatee class="nav-link {{(request()->is('admin/jobs')? 'active' : "")}}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>الأنشطة</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('teams')}}" wire:navigatee class="nav-link {{(request()->is('admin/teams')? 'active' : "")}}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>اللجان</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('positions')}}" wire:navigatee class="nav-link {{(request()->is('admin/positions')? 'active' : "")}}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>الصفات</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('events')}}" wire:navigatee class="nav-link {{(request()->is('admin/events')? 'active' : "")}}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>الاحداث</p>
                    </a>
                </li>
            </ul>
        </li>
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link {{(request()->is('admin*')? 'active' : "")}}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        المتطوعين
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{route('degrees')}}" wire:navigatee class="nav-link {{(request()->is('admin/degrees')? 'active' : "")}}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>درجات التطوع</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('statuses')}}" wire:navigatee class="nav-link {{(request()->is('admin/statuses')? 'active' : "")}}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>حالات التطوع</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('maritalStatuses')}}" wire:navigatee class="nav-link {{(request()->is('admin/maritalStatuses')? 'active' : "")}}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>الحالة الاجماعية </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('nationalities')}}" wire:navigatee class="nav-link {{(request()->is('admin/nationalities')? 'active' : "")}}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>الجنسيات </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('qualifications')}}" wire:navigatee class="nav-link {{(request()->is('admin/qualifications')? 'active' : "")}}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>الشهادات العلمية </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('categories')}}" wire:navigatee class="nav-link {{(request()->is('admin/categories')? 'active' : "")}}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>التصنيفات</p>
                        </a>
                    </li>
                        <a href="{{route('checkTypes')}}" wire:navigatee class="nav-link {{(request()->is('admin/check-types')? 'active' : "")}}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>انواع الاختبارات</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('users')}}" wire:navigatee class="nav-link {{(request()->is('admin/users')? 'active' : "")}}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>المتطوعين</p>
                        </a>
                    </li>
                </ul>
            </li>
        @endif
        <li class="nav-item">
            <a href="{{route('user.home')}}" class="nav-link {{(request()->is('user/home')? 'active' : "")}}">
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

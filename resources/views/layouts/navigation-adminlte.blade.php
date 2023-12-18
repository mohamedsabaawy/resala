<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item has-treeview">
            <a href="#" class="nav-link {{(request()->is('admin*')? 'active' : "")}}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    لوحة التحكم
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('branches')}}" wire:navigate class="nav-link {{(request()->is('admin/branches')? 'active' : "")}}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>الفروع</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('teams')}}" wire:navigate class="nav-link {{(request()->is('admin/teams')? 'active' : "")}}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>الفرق</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('positions')}}" wire:navigate class="nav-link {{(request()->is('admin/positions')? 'active' : "")}}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>المستويات</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('events')}}" wire:navigate class="nav-link {{(request()->is('admin/events')? 'active' : "")}}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>الاحداث</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('checkTypes')}}" wire:navigate class="nav-link {{(request()->is('admin/check-types')? 'active' : "")}}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>انواع الاختبارات</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('users')}}" wire:navigate class="nav-link {{(request()->is('admin/users')? 'active' : "")}}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>المتطوعين</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="pages/widgets.html" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                    Widgets
                    <span class="right badge badge-danger">New</span>
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="pages/gallery.html" class="nav-link">
                <i class="nav-icon far fa-image"></i>
                <p>
                    Gallery
                </p>
            </a>
        </li>
        <li class="nav-header">MISCELLANEOUS</li>
    </ul>
</nav>
<!-- /.sidebar-menu -->

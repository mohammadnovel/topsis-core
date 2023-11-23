<div class="app-sidebar colored">
    <div class="sidebar-header">
        <a class="header-brand" href="{{route('dashboard')}}">
            <div class="logo-img">
               <img height="30" src="{{ asset('img/logo_white.png')}}" class="header-brand-img" title="RADMIN"> 
            </div>
        </a>
        <div class="sidebar-action"><i class="ik ik-arrow-left-circle"></i></div>
        <button id="sidebarClose" class="nav-close"><i class="ik ik-x"></i></button>
    </div>

    @php
        $segment1 = request()->segment(1);
        $segment2 = request()->segment(2);
    @endphp
    
    <div class="sidebar-content">
        <div class="nav-container">
            <nav id="main-menu-navigation" class="navigation-main">
                <div class="nav-item {{ ($segment1 == 'dashboard') ? 'active' : '' }}">
                    <a href="{{route('dashboard')}}"><i class="ik ik-bar-chart-2"></i><span>{{ __('Dashboard')}}</span></a>
                </div>
                <div class="nav-item {{ ($segment1 == 'users' || $segment1 == 'roles'||$segment1 == 'permission' ||$segment1 == 'user') ? 'active open' : '' }} has-sub">
                    <a href="#"><i class="ik ik-user"></i><span>{{ __('Adminstrator')}}</span></a>
                    <div class="submenu-content">
                        <!-- only those have manage_user permission will get access -->
                        @can('manage_user')
                        <a href="{{url('users')}}" class="menu-item {{ ($segment1 == 'users') ? 'active' : '' }}">{{ __('Users')}}</a>
                        <a href="{{url('user/create')}}" class="menu-item {{ ($segment1 == 'user' && $segment2 == 'create') ? 'active' : '' }}">{{ __('Add User')}}</a>
                         @endcan
                         <!-- only those have manage_role permission will get access -->
                        @can('manage_roles')
                        <a href="{{url('roles')}}" class="menu-item {{ ($segment1 == 'roles') ? 'active' : '' }}">{{ __('Roles')}}</a>
                        @endcan
                        <!-- only those have manage_permission permission will get access -->
                        @can('manage_permission')
                        <a href="{{url('permission')}}" class="menu-item {{ ($segment1 == 'permission') ? 'active' : '' }}">{{ __('Permission')}}</a>
                        @endcan
                    </div>
                </div>
                
                <div class="nav-item {{ ($segment1 == 'profile' || $segment1 == 'invoice'||$segment1 == 'session-timeout') ? 'active open' : '' }} has-sub">
                    <a href="#"><i class="ik ik-file-text"></i><span>{{ __('Data Master')}}</span></a>
                    <div class="submenu-content">
                        <a href="{{url('profile')}}" class="menu-item {{ ($segment1 == 'profile') ? 'active' : '' }}">Alternative</a>
                        <a href="{{url('invoice')}}" class="menu-item {{ ($segment1 == 'invoice') ? 'active' : '' }}">Criteria</a>
                    </div>
                </div>
                <div class="nav-item {{ ($segment1 == 'layouts') ? 'active' : '' }}">
                    <a href="{{url('layouts')}}"><i class="ik ik-layout"></i><span>{{ __('Layouts')}}</span></a>
                </div>
                <div class="nav-item {{ ($segment1 == 'icons') ? 'active' : '' }}">
                    <a href="{{url('icons')}}"><i class="ik ik-command"></i><span>{{ __('Icons')}}</span></a>
                </div>
                <div class="nav-item {{ ($segment1 == 'calculate') ? 'active' : '' }}">
                    <a href="{{url('calculate')}}"><i class="ik ik-sliders"></i><span>{{ __('Calculate Topsis')}}</span></a>
                </div>
                <div class="nav-item {{ ($segment1 == 'pricing') ? 'active' : '' }}">
                    <a href="{{url('pricing')}}"><i class="ik ik-dollar-sign"></i><span>{{ __('Pricing')}}</span><span class=" badge badge-success badge-right">{{ __('New')}}</span></a>
                </div>
                <div class="nav-item has-sub">
                    <a href="javascript:void(0)"><i class="ik ik-list"></i><span>{{ __('Menu Levels')}}</span></a>
                    <div class="submenu-content">
                        <a href="javascript:void(0)" class="menu-item">{{ __('Menu Level 2.1')}}</a>
                        <div class="nav-item {{ ($segment1 == '') ? 'active' : '' }} has-sub">
                            <a href="javascript:void(0)" class="menu-item">{{ __('Menu Level 2.2')}}</a>
                            <div class="submenu-content">
                                <a href="javascript:void(0)" class="menu-item">{{ __('Menu Level 3.1')}}</a>
                            </div>
                        </div>
                        <a href="javascript:void(0)" class="menu-item">{{ __('Menu Level 2.3')}}</a>
                    </div>
                </div>
                <div class="nav-item">
                    <a href="javascript:void(0)" class="disabled"><i class="ik ik-slash"></i><span>{{ __('Disabled Menu')}}</span></a>
                </div>
                
        </div>
    </div>
</div>
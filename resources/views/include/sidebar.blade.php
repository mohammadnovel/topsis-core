<div class="app-sidebar colored">
    <div class="sidebar-header">
        <a class="header-brand" href="{{route('dashboard')}}">
            <div class="logo-img">
               <p>
                SAW
               </p>
            </div>
        </a>
        
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
                
                <div class="nav-item {{ ($segment1 == 'criterias' || $segment1 == 'alternatives' || $segment1 == 'transactions') ? 'active open' : '' }} has-sub">
                    <a href="#"><i class="ik ik-file-text"></i><span>{{ __('Data Master')}}</span></a>
                    <div class="submenu-content">
                        <a href="{{route('alternative.index')}}" class="menu-item {{ ($segment1 == 'alternatives') ? 'active' : '' }}">Alternatif</a>
                        <a href="{{route('criteria.index')}}" class="menu-item {{ ($segment1 == 'criterias') ? 'active' : '' }}">Kriteria</a>
                        <a href="{{route('transaction.index')}}" class="menu-item {{ ($segment1 == 'transactions') ? 'active' : '' }}">Data Perhitungan</a>
                    </div>
                </div>
                {{-- <div class="nav-item {{ ($segment1 == 'icons') ? 'active' : '' }}">
                    <a href="{{url('icons')}}"><i class="ik ik-command"></i><span>{{ __('Icons')}}</span></a>
                </div> --}}
                <div class="nav-item {{ ($segment1 == 'calculate-saw') ? 'active' : '' }}">
                    <a href="{{route('calculate-saw')}}"><i class="ik ik-layers"></i><span>{{ __('Kalkulasi SAW')}}</span></a>
                </div>
                
                
        </div>
    </div>
</div>
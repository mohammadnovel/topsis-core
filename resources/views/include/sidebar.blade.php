<div class="app-sidebar colored" >
    <div class="sidebar-header">
        <a class="header-brand" href="{{route('dashboard')}}">
            <div class="logo-img">
               <p>
                SAW - Maman
               </p>
            </div>
        </a>
        <div class="sidebar-action"><i class="ik ik-arrow-left-circle"></i></div>
        <button id="sidebarClose" class="nav-close"><i class="ik ik-x"></i></button>
    </div>

    @php
        $segment1 = request()->segment(1);
        $segment2 = request()->segment(2);
    @endphp
    
    <div class="sidebar-content" style="background-color: rgb(0, 14, 71)">
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
                        <a href="{{route('transaction.index')}}" class="menu-item {{ ($segment1 == 'transactions') ? 'active' : '' }}">Transaksi</a>
                    </div>
                </div>
                {{-- <div class="nav-item {{ ($segment1 == 'icons') ? 'active' : '' }}">
                    <a href="{{url('icons')}}"><i class="ik ik-command"></i><span>{{ __('Icons')}}</span></a>
                </div> --}}
                <div class="nav-item {{ ($segment1 == 'calculate-saw') ? 'active' : '' }}">
                    <a href="{{route('calculate-saw')}}"><i class="ik ik-sliders"></i><span>{{ __('Perhitungan Metode SAW')}}</span></a>
                </div>
                
                
        </div>
    </div>
</div>
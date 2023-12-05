@extends('layouts.main') 
@section('title', 'Calculate Saw Step By Step')
@section('content')
    <!-- push external head elements to head -->
    @push('head')

        <link rel="stylesheet" href="{{ asset('plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    @endpush

    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-credit-card bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Calculate SAW Step By Step')}}</h5>
                            <span>{{ __('SPK SAW')}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('dashboard')}}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('Perhitungan')}}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Saw step by step')}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-block">
                        <h3>{{ __('Matrix')}}</h3>
                        <span>Tahap  <code>Pertama</code> Matriks Awal</span>
                    </div>
                    <div class="card-body p-0 table-border-style">
                        <div class="table-responsive p-4">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('First Name')}}</th>
                                        @foreach ($criterias as $criteria)
                                        <th>{{ 'C'.$loop->index + 1 }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($matrix as $data)
                                    <tr>
                                        <th scope="row">{{ $loop->index + 1 }}</th>
                                        <td> {{ $data['name'] }} </td>
                                        @foreach ($data['values'] as $data)
                                          <td>{{$data['value']}}</td>
                                        @endforeach
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- normalized Matrix --}}
                <div class="card">
                    <div class="card-header d-block">
                        <h3>{{ __('Nomalisasi Matrix')}}</h3>
                        <span>Tahap  <code>Kedua</code> Normalisasi Matrix</span>
                    </div>
                    <div class="card-body p-0 table-border-style">
                        <div class="table-responsive p-4">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('First Name')}}</th>
                                        @foreach ($criterias as $criteria)
                                        <th>{{ 'C'.$loop->index + 1 }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($normalizedMatrix as $matrixNormalized)
                                    <tr>
                                        <th scope="row">{{ $loop->index + 1 }}</th>
                                        <td> {{ $matrixNormalized['name'] }} </td>
                                        @foreach ($matrixNormalized['values'] as $data)
                                            <td>{{$data['value']}}</td>
                                        @endforeach
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Weighted Matrix --}}
                <div class="card">
                    <div class="card-header d-block">
                        <h3>{{ __('Weight Matrix')}}</h3>
                        <span>Tahap  <code>Ke tiga</code> Pembobotan Matrix</span>

                    </div>
                    <div class="card-body p-0 table-border-style">
                        <div class="table-responsive p-4">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Name')}}</th>
                                        @foreach ($criterias as $criteria)
                                            <th scope="col">
                                            {{ 'C'.$loop->index + 1 }}
                                            <br/>
                                            ( {{ round($criteria['weight'], 2) }} )
                                            </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($weightedNormalized as $wighted)
                                    <tr>
                                        <th scope="row">{{ $loop->index + 1 }}</th>
                                        <td> {{ $wighted['name'] }} </td>
                                        @foreach ($wighted['values'] as $data)
                                            <td>{{$data['value']}}</td>
                                        @endforeach
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- reference --}}
                <div class="card">
                    <div class="card-header d-block">
                        <h3>{{ __('Result Pereference')}}</h3>
                        <span>Tahap <code>Ke Empat</code> Mencari Hasil Reference</span>
                    </div>
                    <div class="card-body p-0 table-border-style">
                        <div class="table-responsive p-4">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Name')}}</th>
                                        @foreach ($criterias as $criteria)
                                            <th scope="col">
                                            {{ 'C'.$loop->index + 1 }}
                                            <br/>
                                            ( {{ round($criteria['weight'], 2) }} )
                                            </th>
                                        @endforeach
                                        <th>Result</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reference as $result)
                                    <tr>
                                        <th scope="row">{{ $loop->index + 1 }}</th>
                                        <td> {{ $result['name'] }} </td>
                                        @foreach ($wighted['values'] as $data)
                                            <td>{{$data['value']}}</td>
                                        @endforeach
                                        <td> {{ $result['result'] }} </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Rank --}}
                <div class="card">
                    <div class="card-header d-block">
                        <h3>{{ __('Rank Result')}}</h3>
                        <span>Tahap <code>Ke Lima</code> Perankingan</span>

                    </div>
                    <div class="card-body p-0 table-border-style">
                        <div class="table-responsive p-4">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Rank</th>
                                        <th>{{ __('Name')}}</th>
                                        @foreach ($criterias as $criteria)
                                            <th scope="col">
                                            {{ 'C'.$loop->index + 1 }}
                                            <br/>
                                            ( {{ round($criteria['weight'], 2) }} )
                                            </th>
                                        @endforeach
                                        <th>Result</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rankedReference as $result)
                                    <tr>
                                        <th scope="row">{{ $result['rank'] }}</th>
                                        <td> {{ $result['name'] }} </td>
                                        @foreach ($wighted['values'] as $data)
                                            <td>{{$data['value']}}</td>
                                        @endforeach
                                        <td> {{ $result['result'] }} </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
      
    
    <!-- push external js -->
    @push('script')  

        <script src="{{ asset('plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

        <script src="{{ asset('js/tables.js') }}"></script>
    @endpush
@endsection
   
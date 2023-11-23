@extends('layouts.main') 
@section('title', 'Table Bootstrap')
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
                            <h5>{{ __('Bootstrap Tables')}}</h5>
                            <span>{{ __('lorem ipsum dolor sit amet, consectetur adipisicing elit')}}</span>
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
                                <a href="#">{{ __('Tables')}}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Bootstrap Tables')}}</li>
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
                        <span>use class <code>table</code> inside table element</span>
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
                                          <td>{{$data}}</td>
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
                        <span>use class <code>table</code> inside table element</span>
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
                                            <td>{{$data}}</td>
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
                        <span>use class <code>table</code> inside table element</span>
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
                                            ( {{ $criteria['weight'] }} )
                                            </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($weightedMatrix as $wighted)
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

                {{-- Ideal Positive --}}
                <div class="card">
                    <div class="card-header d-block">
                        <h3>Matrix Solusi Ideal Positive</h3>
                    </div>
                    <div class="card-body p-0 table-border-style">
                        <div class="table-responsive p-4">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Name')}}</th>
                                        @foreach ($criterias as $criteria)
                                        <th scope="col" class="text-center">
                                            {{ 'C'.$loop->index + 1 }}
                                            <br/>
                                            ( {{ $criteria['type'] }} )
                                        </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($idealSolution['MatrixIdealSolutions'] as $dataIdealSolution)
                                    <tr>
                                        <th scope="row">{{ $loop->index + 1 }}</th>
                                        <td> {{ $dataIdealSolution['name'] }} </td>
                                        @foreach ($dataIdealSolution['values'] as $data)
                                            <td class="text-center">{{$data['value']}}</td>
                                        @endforeach
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Distance --}}
                <div class="card">
                    <div class="card-header d-block">
                        <h3>{{ __('Distances Matrix')}}</h3>
                        <span>Solusi Ideal<code> Positive</code> </span>
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
                                            </th>
                                        @endforeach
                                        <th scope="col"> D+ </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($distances['DistancePositive'] as $distancePositive)
                                    <tr>
                                        <th scope="row">{{ $loop->index + 1 }}</th>
                                        <td> {{ $distancePositive['name'] }} </td>
                                        @foreach ($distancePositive['dataMatrix'] as $data)
                                            <td>{{$data['value']}}</td>
                                        @endforeach
                                        <td>{{ $distancePositive['dPositive'] }}</td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header d-block">
                        <h3>{{ __('Distances Matrix')}}</h3>
                        <span>Solusi Ideal<code>Negative</code> </span>
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
                                            </th>
                                        @endforeach
                                        <th scope="col"> D- </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($distances['DistanceNegative'] as $dNegative)
                                    <tr>
                                        <th scope="row">{{ $loop->index + 1 }}</th>
                                        <td> {{ $dNegative['name'] }} </td>
                                        @foreach ($dNegative['dataMatrix'] as $data)
                                            <td>{{$data['value']}}</td>
                                        @endforeach
                                        <td>{{ $dNegative['dNegative'] }}</td>
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
                        <span>use class <code>table</code> inside table element</span>
                    </div>
                    <div class="card-body p-0 table-border-style">
                        <div class="table-responsive p-4">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Name')}}</th>
                                        <th scope="col">D+</th>
                                        <th scope="col">D-</th>
                                        <th scope="col">V</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($resultPreference as $result)
                                    <tr>
                                        <th scope="row">{{ $loop->index + 1 }}</th>
                                        <td> {{ $result['name'] }} </td>
                                        <td> {{ $result['DPositive_value'] }} </td>
                                        <td> {{ $result['DNegative_value'] }} </td>
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
                        {{-- <span>use class <code>table</code> inside table element</span> --}}
                    </div>
                    <div class="card-body p-0 table-border-style">
                        <div class="table-responsive p-4">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Name')}}</th>
                                        <th>{{ __('D+')}}</th>
                                        <th>{{ __('D-')}}</th>
                                        <th>{{ __('V')}}</th>
                                        <th>{{ __('Rank')}}</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rankedAlternatives as $result)
                                    <tr>
                                        <th scope="row">{{ $loop->index + 1 }}</th>
                                        <td> {{ $result['name'] }} </td>
                                        <td> {{ $result['DPositive_value'] }} </td>
                                        <td> {{ $result['DNegative_value'] }} </td>
                                        <td> {{ $result['result'] }} </td>
                                        <td> {{ $result['rank'] }} </td>
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
   
@extends('layouts.main') 
@section('title', 'Calculate Topsis Step By Step')
@section('content')
    <!-- push external head elements to head -->
    @push('head')
    <link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">

    {{-- <link rel="stylesheet" href="{{ asset('plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}"> --}}
    @endpush
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-credit-card bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Calculate Topsis Step By Step')}}</h5>
                            <span>{{ __('SPK TOPSIS')}}</span>
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

        {{-- <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-block">
                        <h3>{{ __('Scroll - Vertical')}}</h3>
                    </div>
                    <div class="card-body">
                        <div class="dt-responsive p-4">
                            <table id="scr-vrt-dt"
                                   class="table table-striped table-bordered nowrap">
                                <thead>
                                <tr>
                                    <th>{{ __('Name')}}</th>
                                    <th>{{ __('Position')}}</th>
                                    <th>{{ __('Office')}}</th>
                                    <th>{{ __('Age')}}</th>
                                    <th>{{ __('Start date')}}</th>
                                    <th>{{ __('Salary')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{ __('Tiger Nixon')}}</td>
                                    <td>{{ __('System Architect')}}</td>
                                    <td>{{ __('Edinburgh')}}</td>
                                    <td>{{ __('61')}}</td>
                                    <td>{{ __('2011/04/25')}}</td>
                                    <td>{{ __('$320,800')}}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('Garrett Winters')}}</td>
                                    <td>{{ __('Accountant')}}</td>
                                    <td>{{ __('Tokyo')}}</td>
                                    <td>{{ __('63')}}</td>
                                    <td>{{ __('2011/07/25')}}</td>
                                    <td>{{ __('$170,750')}}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('Ashton Cox')}}</td>
                                    <td>{{ __('Junior Technical Author')}}</td>
                                    <td>{{ __('San Francisco')}}</td>
                                    <td>{{ __('66')}}</td>
                                    <td>{{ __('2009/01/12')}}</td>
                                    <td>{{ __('$86,000')}}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('Cedric Kelly')}}</td>
                                    <td>{{ __('Senior Javascript Developer')}}</td>
                                    <td>{{ __('Edinburgh')}}</td>
                                    <td>{{ __('22')}}</td>
                                    <td>{{ __('2012/03/29')}}</td>
                                    <td>{{ __('$433,060')}}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('Airi Satou')}}</td>
                                    <td>{{ __('Accountant')}}</td>
                                    <td>{{ __('Tokyo')}}</td>
                                    <td>{{ __('33')}}</td>
                                    <td>{{ __('2008/11/28')}}</td>
                                    <td>{{ __('$162,700')}}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('Brielle Williamson')}}</td>
                                    <td>{{ __('Integration Specialist')}}</td>
                                    <td>{{ __('New York')}}</td>
                                    <td>{{ __('61')}}</td>
                                    <td>{{ __('2012/12/02')}}</td>
                                    <td>{{ __('$372,000')}}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('Herrod Chandler')}}</td>
                                    <td>{{ __('Sales Assistant')}}</td>
                                    <td>{{ __('San Francisco')}}</td>
                                    <td>{{ __('59')}}</td>
                                    <td>{{ __('2012/08/06')}}</td>
                                    <td>{{ __('$137,500')}}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('Rhona Davidson')}}</td>
                                    <td>{{ __('Integration Specialist')}}</td>
                                    <td>{{ __('Tokyo')}}</td>
                                    <td>{{ __('55')}}</td>
                                    <td>{{ __('2010/10/14')}}</td>
                                    <td>{{ __('$327,900')}}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('Colleen Hurst')}}</td>
                                    <td>{{ __('Javascript Developer')}}</td>
                                    <td>{{ __('San Francisco')}}</td>
                                    <td>{{ __('39')}}</td>
                                    <td>{{ __('2009/09/15')}}</td>
                                    <td>{{ __('$205,500')}}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('Sonya Frost')}}</td>
                                    <td>{{ __('Software Engineer')}}</td>
                                    <td>{{ __('Edinburgh')}}</td>
                                    <td>{{ __('23')}}</td>
                                    <td>{{ __('2008/12/13')}}</td>
                                    <td>{{ __('$103,600')}}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('Jena Gaines')}}</td>
                                    <td>{{ __('Office Manager')}}</td>
                                    <td>{{ __('London')}}</td>
                                    <td>{{ __('30')}}</td>
                                    <td>{{ __('2008/12/19')}}</td>
                                    <td>{{ __('$90,560')}}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('Quinn Flynn')}}</td>
                                    <td>{{ __('Support Lead')}}</td>
                                    <td>{{ __('Edinburgh')}}</td>
                                    <td>{{ __('22')}}</td>
                                    <td>{{ __('2013/03/03')}}</td>
                                    <td>{{ __('$342,000')}}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('Charde Marshall')}}</td>
                                    <td>{{ __('Regional Director')}}</td>
                                    <td>{{ __('San Francisco')}}</td>
                                    <td>{{ __('36')}}</td>
                                    <td>{{ __('2008/10/16')}}</td>
                                    <td>{{ __('$470,600')}}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('Haley Kennedy')}}</td>
                                    <td>{{ __('Senior Marketing Designer')}}</td>
                                    <td>{{ __('London')}}</td>
                                    <td>{{ __('43')}}</td>
                                    <td>{{ __('2012/12/18')}}</td>
                                    <td>{{ __('$313,500')}}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('Tatyana Fitzpatrick')}}</td>
                                    <td>{{ __('Regional Director')}}</td>
                                    <td>{{ __('London')}}</td>
                                    <td>{{ __('19')}}</td>
                                    <td>{{ __('2010/03/17')}}</td>
                                    <td>{{ __('$385,750')}}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('Michael Silva')}}</td>
                                    <td>{{ __('Marketing Designer')}}</td>
                                    <td>{{ __('London')}}</td>
                                    <td>{{ __('66')}}</td>
                                    <td>{{ __('2012/11/27')}}</td>
                                    <td>{{ __('$198,500')}}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('Paul Byrd')}}</td>
                                    <td>{{ __('Chief Financial Officer (CFO)')}}</td>
                                    <td>{{ __('New York')}}</td>
                                    <td>{{ __('64')}}</td>
                                    <td>{{ __('2010/06/09')}}</td>
                                    <td>{{ __('$725,000')}}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('Gloria Little')}}</td>
                                    <td>{{ __('Systems Administrator')}}</td>
                                    <td>{{ __('New York')}}</td>
                                    <td>{{ __('59')}}</td>
                                    <td>{{ __('2009/04/10')}}</td>
                                    <td>{{ __('$237,500')}}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('Bradley Greer')}}</td>
                                    <td>{{ __('Software Engineer')}}</td>
                                    <td>{{ __('London')}}</td>
                                    <td>{{ __('41')}}</td>
                                    <td>{{ __('2012/10/13')}}</td>
                                    <td>{{ __('$132,000')}}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('Dai Rios')}}</td>
                                    <td>{{ __('Personnel Lead')}}</td>
                                    <td>{{ __('Edinburgh')}}</td>
                                    <td>{{ __('35')}}</td>
                                    <td>{{ __('2012/09/26')}}</td>
                                    <td>{{ __('$217,500')}}</td>
                                </tr>
                            </tbody>
                                <tfoot>
                                <tr>
                                    <th>{{ __('Name')}}</th>
                                    <th>{{ __('Position')}}</th>
                                    <th>{{ __('Office')}}</th>
                                    <th>{{ __('Age')}}</th>
                                    <th>{{ __('Start date')}}</th>
                                    <th>{{ __('Salary')}}</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        {{-- data awal --}}
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-block">
                        <h3>{{ __('Matrix')}}</h3>
                        <span>Tahap  <code>Pertama</code> Matriks Awal</span>
                    </div>
                    <div class="card-body p-0 table-border-style">
                        <div class="dt-responsive p-4">
                            <table id="scr-vrt-dt"
                                   class="table table-striped table-bordered nowrap">
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
                        <span>Tahap  <code>Kedua</code> Normalisasi Matrix</span>
                    </div>
                    <div class="card-body p-0 table-border-style">
                        <div class="dt-responsive p-4">
                            <table id="scr-vrt-dt-2"
                                   class="table table-striped table-bordered nowrap">
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
                        <span>Tahap  <code>Ke tiga</code> Pembobotan Matrix</span>

                    </div>
                    <div class="card-body p-0 table-border-style">
                       <div class="dt-responsive p-4">
                            <table id="scr-vrt-dt-3"
                                   class="table table-striped table-bordered nowrap">
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
                        <h3>Matrix Solusi Ideal </h3>
                        <span>Tahap  <code>Keempat</code>  Matrix Solusi Ideal</span>

                    </div>
                    <div class="card-body p-0 table-border-style">
                       <div class="dt-responsive p-4">
                            <table id="scr-vrt-dt-4"
                                   class="table table-striped table-bordered nowrap">
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
                            {{-- <div class="dt-responsive"> --}}
                                <table 
                                       class="table table-striped table-bordered nowrap">
                                <tr class="">
                                    <th scope="row" colspan="2" class="text-center">MAX</th>
                                    @foreach ($idealSolution['MAX'] as $item)
                                      <td class="text-center">{{$item}}</td>
                                    @endforeach
                                  </tr>
                  
                                <tr class="">
                                <th scope="row" colspan="2" class="text-center">MIN</th>
                                @foreach ($idealSolution['MIN'] as $item)
                                    <td class="text-center">{{$item}}</td>
                                @endforeach
                                </tr>
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
                       <div class="dt-responsive p-4">
                            <table id="scr-vrt-dt-5"
                                   class="table table-striped table-bordered nowrap">
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
                       <div class="dt-responsive p-4">
                            <table id="scr-vrt-dt-6"
                                   class="table table-striped table-bordered nowrap">
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
                        <span>Tahap <code>Keenam</code> Mencari Hasil Reference</span>
                    </div>
                    <div class="card-body p-0 table-border-style">
                       <div class="dt-responsive p-4">
                            <table id="scr-vrt-dt-7"
                                   class="table table-striped table-bordered nowrap">
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
                        <span>Tahap <code>Ke 7</code> Perankingan</span>

                    </div>
                    <div class="card-body p-0 table-border-style">
                        <div class="row p-4">
                            <div class="col-sm-6">
                                <div class="input-group input-group-button">
                                    <input type="number" id="limitVal" min="1" class="form-control" placeholder="Jumlah Filter">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button" id="filterLimit">{{ __('Filter')}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                       <div class="dt-responsive p-4">
                            <table id="DTResult"
                                   class="table table-striped table-bordered nowrap">
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
                                {{-- <tbody>
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
                                </tbody> --}}
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
      
    
    <!-- push external js -->
    @push('script')  

    <script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/datatables.js') }}"></script>
    <script>
        $(document).ready(function () {
            $("#limitVal").on('input', function () {
                var inputValue = $(this).val();
                if (inputValue === '0' || inputValue.startsWith('0')) {
                    $(this).val('');
                }
            });
        });
         // Datatable Start
        let Datatable = (function () {
            let init = function () {
                let table = $("#DTResult").DataTable({
                    language: {
                        processing: '<i class="ace-icon fa fa-spinner fa-spin orange bigger-500" style="font-size:60px;margin-top:50px;"></i>'
                    },
                    dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>>tipr",
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('transaction.rank-serverside') }}",
                        type: "POST",
                        data: function (d) {
                            d._token = "{{ csrf_token() }}";
                            d.filterLimit = $("#limitVal").val();
                        }
                    },
                    columns: [
                        { 
                            data: 'id', 
                            render: function (data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        { data: 'name', name: 'name' },
                        { data: 'DPositive_value', name: 'DPositive_value' },
                        { data: 'DNegative_value', name: 'DNegative_value' },
                        { data: 'result', name: 'result' },
                        { data: 'rank', name: 'rank' },
                    ],
                    order: [[5, 'asc']],
                    columnDefs: [
                        {
                            "targets": 0,
                            "className": "text-center",
                            "width": "7%",
                        },
                    ],
                    buttons: [
                        {
                            extend: 'copy',
                            className: 'btn-sm btn-info',
                            title: 'Data Narapidana',
                            header: false,
                            footer: true,
                            exportOptions: {
                                // columns: ':visible'
                            }
                        },
                        {
                            extend: 'csv',
                            className: 'btn-sm btn-success',
                            title: 'Data Narapidana',
                            header: false,
                            footer: true,
                            exportOptions: {
                                // columns: ':visible'
                            }
                        },
                        {
                            extend: 'excel',
                            className: 'btn-sm btn-warning',
                            title: 'Data Narapidana',
                            header: false,
                            footer: true,
                            exportOptions: {
                                // columns: ':visible',
                            }
                        },
                        {
                            extend: 'pdf',
                            className: 'btn-sm btn-primary',
                            title: 'Data Narapidana',
                            pageSize: 'A4',
                            header: false,
                            footer: true,
                            exportOptions: {
                                // columns: ':visible'
                            }
                        },
                        {
                            extend: 'print',
                            className: 'btn-sm btn-default',
                            title: 'Data Narapidana',
                            // orientation:'landscape',
                            pageSize: 'A4',
                            header: true,
                            footer: false,
                            orientation: 'landscape',
                            exportOptions: {
                                orthogonal: 'export',
                                stripHtml: false
                            }
                        }
                    ],
                    initComplete: function () {
                        var api =  this.api();
                        // api.columns(searchable).every(function () {
                        //     var column = this;
                        //     var input = document.createElement("input");
                        //     input.setAttribute('placeholder', $(column.header()).text());
                        //     input.setAttribute('style', 'width: 140px; height:25px; border:1px solid whitesmoke;');

                        //     $(input).appendTo($(column.header()).empty())
                        //     .on('keyup', function () {
                        //         column.search($(this).val(), false, false, true).draw();
                        //     });

                        //     $('input', this.column(column).header()).on('click', function(e) {
                        //         e.stopPropagation();
                        //     });
                        // });

                        // api.columns(selectable).every( function (i, x) {
                        //     var column = this;

                        //     var select = $('<select style="width: 140px; height:25px; border:1px solid whitesmoke; font-size: 12px; font-weight:bold;"><option value="">'+$(column.header()).text()+'</option></select>')
                        //         .appendTo($(column.header()).empty())
                        //         .on('change', function(e){
                        //             var val = $.fn.dataTable.util.escapeRegex(
                        //                 $(this).val()
                        //             );
                        //             column.search(val ? '^'+val+'$' : '', true, false ).draw();
                        //             e.stopPropagation();
                        //         });

                        //     $.each(dropdownList[i], function(j, v) {
                        //         select.append('<option value="'+v+'">'+v+'</option>')
                        //     });
                        // });
                    }
                });
            };

            return {
                init: function () {
                    init();
                },
            };
        })();
      // Datatable End

      // Filtering start
      $('#filterLimit').on('click', function() {
        $('#DTResult').DataTable().ajax.reload();

      });
      // Filtering End

      jQuery(document).ready(function() {
        Datatable.init();
      });
    </script>
    @endpush
@endsection
   
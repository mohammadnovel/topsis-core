@extends('layouts.main') 
@section('title', 'Criteria')
@section('content')
    <!-- push external head elements to head -->
    @push('head')
        <link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
    @endpush

    
    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-users bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Kriteria')}}</h5>
                            <span>{{ __('List of Kriteria')}}</span>
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
                                <a href="#">{{ __('Kriterua')}}</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row clearfix">
	        <!-- start message area-->
            {{-- @include('include.message') --}}
            <!-- end message area-->
            <!-- only those have manage_role permission will get access -->
            
			<div class="col-md-12">
	            <div class="card">
	                <div class="card-header"><h3>{{ __('Add Criteria')}}</h3></div>
	                <div class="card-body">
	                    <form class="forms-sample" method="POST" action="{{url('criteria/create')}}">
	                    	@csrf
	                        <div class="row">
	                            <div class="col-sm-12">
	                                <div class="form-group">
	                                    <label for="name">{{ __('Name Criteria')}}<span class="text-red">*</span></label>
	                                    <input type="text" class="form-control " id="name" name="name" placeholder=" Name" required>
	                                </div>
	                            </div>
                                <div class="col-sm-12">
	                                <div class="form-group">
	                                    <label for="type">{{ __('Type')}}<span class="text-red">*</span></label>
	                                    <input type="text" class="form-control " id="type" name="type" placeholder="Tipe" required>
	                                </div>
	                            </div>
                                <div class="col-sm-12">
	                                <div class="form-group">
	                                    <label for="Weight">{{ __('Bobot')}}<span class="text-red">*</span></label>
	                                    <input type="text" class="form-control " id="Weight" name="weight" placeholder="Weight " required>
	                                </div>
	                            </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-rounded">{{ __('Save')}}</button>
                                    </div>
                                </div>
	                        </div>
	                    </form>
	                </div>
	            </div>
	        </div>
		</div>
        <div class="row">
            <!-- start message area-->
            @include('include.message')
            <!-- end message area-->
            <div class="col-md-12">
                <div class="card p-3">
                    <div class="card-header"><h3>{{ __('Kriteria')}}</h3></div>
                    <div class="card-body">
                        <table id="criteria_table" class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('Name')}}</th>
                                    <th>{{ __('Type')}}</th>
                                    <th>{{ __('Weight')}}</th>
                                    <th>{{ __('Action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- push external js -->
    @push('script')
    <script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
    <!--server side users table script-->
    <script src="{{ asset('js/custom.js') }}"></script>
    @endpush
@endsection

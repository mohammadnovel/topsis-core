@extends('layouts.main') 
@section('title', 'Criteria Detail')
@section('content')
    @push('head')
        <link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.min.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    @endpush

    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-users bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Criteria Detail')}}</h5>
                            <span>{{ __('Detail of selected criteria')}}</span>
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
                                <a href="{{route('criteria.index')}}">{{ __('Criteria')}}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('criteria-detail.index', ['criteriaId' => $criterias->id]) }}">{{ $criterias->name }}</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <!-- Form Add Detail -->
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h3>{{ __('Add Detail')}}</h3></div>
                    <div class="card-body">
                        <form id="addDetailForm">
                            @csrf
                            <div class="form-group">
                                <label for="criteria_id">{{ __('Kriteria Anda ')}} <span class="text-red">*</span></label>
                                <input type="hidden" name="criteria_id" value="{{$criterias->id}}" id="value" class="form-control" required>

                                <p>{{$criterias->name}}</p>
                                {{-- <select name="criteria_id" id="criteria_id" class="form-control select2" required>
                                    <option value="">{{ __('Select Criteria')}}</option>
                                    @foreach($criterias as $criteria)
                                        <option value="{{ $criteria->id }}">{{ $criteria->name }}</option>
                                    @endforeach
                                </select> --}}
                            </div>
                            <div class="form-group">
                                <label for="value">{{ __('Value')}} <span class="text-red">*</span></label>
                                <input type="text" name="value" id="value" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="description">{{ __('Description')}} <span class="text-red">*</span></label>
                                <textarea name="description" id="description" class="form-control" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">{{ __('Save')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Details -->
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h3>{{ __('Criteria Details')}}</h3></div>
                    <div class="card-body">
                        <table id="criteria_detail_table" class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('Criteria')}}</th>
                                    <th>{{ __('Value')}}</th>
                                    <th>{{ __('Description')}}</th>
                                    <th>{{ __('Action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- DataTables content will load here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('script')
    <script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.select2').select2();

            // Initialize DataTable
            const table = $('#criteria_detail_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("criteria-detail.list", $criteriaId) }}',
                columns: [
                    { data: 'criteria_name', name: 'criteria_name' },
                    { data: 'value', name: 'value' },
                    { data: 'description', name: 'description' },
                    { 
                        data: 'action', 
                        name: 'action', 
                        orderable: false, 
                        searchable: false 
                    }
                ]
            });

            // Add Detail Form Submission
            $('#addDetailForm').on('submit', function (e) {
                e.preventDefault();
                const formData = $(this).serialize();

                $.ajax({
                    url: '{{ route("criteria-detail.store", $criteriaId) }}',
                    method: 'POST',
                    data: formData,
                    success: function (response) {
                        toastr.success('Detail added successfully!');
                        table.ajax.reload();
                        $('#addDetailForm')[0].reset();
                        $('.select2').val(null).trigger('change');
                    },
                    error: function (xhr) {
                        toastr.error('Failed to add detail. Please try again.');
                    }
                });
            });

            // Inline Edit
            $(document).on('click', '.edit-btn', function () {
                const id = $(this).data('id');
                const row = $(this).closest('tr');
                const valueCell = row.find('td:eq(1)');
                const descriptionCell = row.find('td:eq(2)');

                const currentValue = valueCell.text();
                const currentDescription = descriptionCell.text();

                valueCell.html(`<input type="text" class="form-control edit-value" value="${currentValue}">`);
                descriptionCell.html(`<input type="text" class="form-control edit-description" value="${currentDescription}">`);

                $(this).hide();
                row.find('.save-btn').show();
            });

            // Save Edit
            $(document).on('click', '.save-btn', function () {
                const id = $(this).data('id');
                const row = $(this).closest('tr');
                const value = row.find('.edit-value').val();
                const description = row.find('.edit-description').val();

                $.ajax({
                    url: `/criteria-detail/update/${id}`,
                    method: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}',
                        value: value,
                        description: description
                    },
                    success: function () {
                        toastr.success('Detail updated successfully!');
                        table.ajax.reload();
                    },
                    error: function () {
                        toastr.error('Failed to update detail. Please try again.');
                    }
                });
            });

            // Delete Confirmation
            $(document).on('click', '.delete-btn', function () {
                const id = $(this).data('id');

                if (confirm('Are you sure you want to delete this detail?')) {
                    $.ajax({
                        url: `/criteria-detail/delete/${id}`,
                        method: 'DELETE',
                        data: { _token: '{{ csrf_token() }}' },
                        success: function () {
                            toastr.success('Detail deleted successfully!');
                            table.ajax.reload();
                        },
                        error: function () {
                            toastr.error('Failed to delete detail. Please try again.');
                        }
                    });
                }
            });
        });
    </script>
    @endpush
@endsection

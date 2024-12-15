@extends('layouts.main')
@section('title', 'Edit Criteria Detail')
@section('content')
    @push('head')
        <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.min.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    @endpush

    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-edit bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Edit Criteria Detail') }}</h5>
                            <span>{{ __('Update detail information for the selected criteria') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-right">
                    <!-- Tombol Back -->
                    <a href="{{ route('criteria-detail.index', $detail->criteria_id) }}" class="btn btn-light">
                        <i class="ik ik-arrow-left"></i> {{ __('Back') }}
                    </a>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h3>{{ __('Edit Detail') }}</h3></div>
                    <div class="card-body">
                        <form id="editDetailForm" method="POST" action="{{ route('criteria-detail.update', $detail->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <input type="hidden" name="criteria_id" value="{{ $detail->criteria_id }}">
                            </div>
                            <div class="form-group">
                                <label for="value">{{ __('Value') }} <span class="text-red">*</span></label>
                                <input type="text" name="value" id="value" class="form-control" value="{{ $detail->value }}" required>
                            </div>
                            <div class="form-group">
                                <label for="description">{{ __('Description') }} <span class="text-red">*</span></label>
                                <textarea name="description" id="description" class="form-control" rows="3" required>{{ $detail->description }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                            <a href="{{ route('criteria-detail.index', $detail->criteria_id) }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('script')
        <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script>
            $(document).ready(function () {
                $('.select2').select2();

                @if(session('success'))
                    toastr.success('{{ session('success') }}');
                @endif

                @if(session('error'))
                    toastr.error('{{ session('error') }}');
                @endif
            });
        </script>
    @endpush
@endsection

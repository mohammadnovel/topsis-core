@extends('layouts.main') 
@section('title', 'Transactions')
@section('content')
    <!-- push external head elements to head -->
    @push('head')
        <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/toastr/build/toastr.min.css') }}">

    @endpush

    
    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-users bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Transactions')}}</h5>
                            <span>{{ __('List of Transactions')}}</span>
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
                                <a href="#">{{ __('Transaction')}}</a>
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
            
			{{-- <div class="col-md-12">
	            <div class="card">
	                <div class="card-header"><h3>{{ __('Add Transaction')}}</h3></div>
	                <div class="card-body">
	                    <form class="forms-sample" method="POST" action="{{url('transaction/create')}}">
	                    	@csrf
	                        <div class="row">
	                            <div class="col-sm-12">
	                                <div class="form-group">
	                                    <label for="name">{{ __('Name Transaction')}}<span class="text-red">*</span></label>
	                                    <input type="text" class="form-control " id="name" name="name" placeholder=" Name" required>
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
	        </div> --}}
		</div>
        <div class="row">
            <!-- start message area-->
            {{-- @include('include.message') --}}
            <!-- end message area-->
            <div class="col-md-12">
                
                <div class="card p-3">
                    <div class="card-header"><h3>{{ __('Transaction')}}</h3></div>
                    <div class="card-body template-demo">
                        <div class="flex ">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#demoModal">{{ __('Upload Data Excel')}}</button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">{{ __('Tambah Data')}}</button>

                        </div>
                    </div>
                    <div class="card-body">
                        <table id="transaction_table" class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('Nama')}}</th>
                                    <th>{{ __('Inisial')}}</th>
                                    <th>{{ __('Criteria')}}</th>
                                    <th>{{ __('Nilai')}}</th>
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
        <div class="modal fade" id="demoModal" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('upload-transaction') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="demoModalLabel">{{ __('Upload Transaction')}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>{{ __('File upload')}}</label>
                                <input type="file" name="file" class="file-upload-default">
                                <div class="input-group col-xs-12">
                                    <input type="text" class="form-control file-upload-info" disabled placeholder="Upload File">
                                    <span class="input-group-append">
                                    <button class="file-upload-browse btn btn-primary" type="button">{{ __('Browse')}}</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close')}}</button>
                            <button type="submit" class="btn btn-primary">{{ __('Save changes')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="addModal"  role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <!--begin::Modal content-->
                <div class="rounded modal-content">
                  <!--begin::Modal header-->
                  <div class="pb-0 border-0 modal-header justify-content-end">
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                      <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                  </div>
                  <!--begin::Modal header-->
                  <!--begin::Modal body-->
                  <div class="px-10 pt-0 modal-body scroll-y px-lg-15 pb-15">
                    <!--begin:Form-->
                    <form id="addModal_form" action="{{ route('store-transaction') }}" method="POST" enctype="multipart/form-data"
                      class="form">
                      @csrf
                      <!--begin::Heading-->
                      <div class="mb-8">
                        <!--begin::Title-->
                        <h1 class="mb-3">Tambah Transaksi </h1>
                        <!--end::Title-->
                      </div>
                      <!--end::Heading-->
                      <!--begin::Input group-->
                      <div class="mb-8 d-flex flex-column fv-row">
                        <!--begin::Label-->
                        <label class="mb-2 d-flex align-items-center fs-6 fw-semibold">
                          <span class="required">Alternative</span>
                          <span class="ms-1" data-bs-toggle="tooltip" title="Write Transaction Name">
                            <i class="text-gray-500 ki-outline ki-information-5 fs-6"></i>
                          </span>
                        </label>
                        <select class="form-control select2" name="alternative_id">
                            <option selected disabled>Pilih Alternative</option>
                            @foreach ($alternatives as $alt)
                              <option value="{{ $alt->id }}">{{ $alt->name }}</option>
                            @endforeach
                        </select>
                        <!--end::Label-->
                      </div>
                      <!--end::Input group-->
                      <!--begin::Input group-->
                      <div class="mb-8 d-flex flex-column fv-row">
                        <div class="row g-9">
                          @foreach ($criterias as $crt)
                            <div class="col-12 pt-2">
                              <!--begin::Label-->
                              <label class="mb-2 d-flex align-items-center fs-6 fw-semibold">
                                <span class="required">{{ $crt->name }} <span class="text-red">*</span></span>
                                <span class="ms-1" data-bs-toggle="tooltip" title="Criteria Name">
                                  <i class="text-gray-500 ki-outline ki-information-5 fs-6"></i>
                                </span>
                              </label>
                              <!--end::Label-->
                              <input type="hidden" value="{{ $crt->id }}" name="criteria_id[]">
                              <input type="number" class="form-control form-control-solid" min="1" 
                                placeholder="Masukan Nilai {{ $crt->name }} Value" name="weight[]" required />
                            </div>
                          @endforeach
                        </div>
                      </div>
                      <!--end::Input group-->
                      <!--begin::Actions-->
                      <div class="pt-4">
                        <button type="submit" id="addModal_submit" class="btn btn-primary">
                          <span class="indicator-label">Simpan</span>
                          
                        </button>
                        <button type="reset" id="addModal_cancel" class="btn btn-light me-3">
                          Batal
                        </button>
                      </div>
                      <!--end::Actions-->
                    </form>
                    <!--end:Form-->
                  </div>
                  <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
              </div>
        </div>

        {{-- edit Modal --}}
        <div class="modal fade" id="editModal"  role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <!--begin::Modal content-->
                <div class="rounded modal-content">
                  <!--begin::Modal header-->
                  <div class="pb-0 border-0 modal-header justify-content-end">
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                      <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                  </div>
                  <!--begin::Modal header-->
                  <!--begin::Modal body-->
                  <div class="px-10 pt-0 modal-body scroll-y px-lg-15 pb-15">
                    <!--begin:Form-->
                    <form action="PUT" id="formUpdate" method="" enctype="multipart/form-data">
                      @csrf
                        <input type="hidden" name="id" id="id">

                      <!--begin::Heading-->
                      <div class="mb-8">
                        <!--begin::Title-->
                        <h1 class="mb-3">Edit Transaction</h1>
                        <!--end::Title-->
                      </div>
                      <!--end::Heading-->
                      <!--begin::Input group-->
                      <div class="mb-8 d-flex flex-column fv-row">
                        <!--begin::Label-->
                        <label class="mb-2 d-flex align-items-center fs-6 fw-semibold">
                            <span class="required">Alternative</span>
                            <span class="ms-1" data-bs-toggle="tooltip" title="Write Transaction Name">
                              <i class="text-gray-500 ki-outline ki-information-5 fs-6"></i>
                            </span>
                        </label>
                        <input type="text" id="altEdit" class="form-control form-control-solid"
                        placeholder="Enter Alternative Name" name="alternative" required readonly />
                        <!--end::Label-->
                      </div>
                      <!--end::Input group-->
                      <!--begin::Input group-->
                      <div class="mb-8 d-flex flex-column fv-row" id="">
                        <div class="row g-9" id="criteriaContainer">
                          {{-- HTML Edit --}}
                        </div>
                      </div>
                      <!--end::Input group-->
                      <!--begin::Actions-->
                      <div class="pt-4">
                        <button type="submit" id="addModal_submit" class="btn btn-primary">
                          <span class="indicator-label">Simpan</span>
                          
                        </button>
                        <button type="reset" id="addModal_cancel" class="btn btn-light me-3">
                          Batal
                        </button>
                      </div>
                      <!--end::Actions-->
                    </form>
                    <!--end:Form-->
                  </div>
                  <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
              </div>
        </div>
    </div>
    <!-- push external js -->
    @push('script')
    <script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
    <!--server side users table script-->
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('js/form-components.js') }}"></script>
    <script src="{{ asset('plugins/toastr/build/toastr.min.js')}} "></script>
    <script>

    @if (session('success'))
        toastr.success('{{ session('success') }}', 'Success', {
          closeButton: true,
          progressBar: true,
          timeOut: 4000,
          positionClass: 'toastr-top-right'
        });
      @elseif (session('warning'))
        toastr.warning('{{ session('warning') }}', 'Warning', {
          closeButton: true,
          progressBar: true,
          timeOut: 4000,
          positionClass: 'toastr-top-right'
        });
      @elseif (session('error'))
        toastr.error('{{ session('error') }}', 'Failed', {
          closeButton: true,
          progressBar: true,
          timeOut: 4000,
          positionClass: 'toastr-top-right'
        });
    @endif
        // start edit html
      function addCriteriaInput(trans) {
        var html = `<div class="col-12 pt-2">
      <label class="mb-2 d-flex align-items-center fs-6 fw-semibold">
        <span class="required">${trans.criterias.name}</span>
        <span class="ms-1" data-bs-toggle="tooltip" title="Criteria Name">
          <i class="text-gray-500 ki-outline ki-information-5 fs-6"></i>
        </span>
      </label>
      <input type="hidden" id="" value="${trans.criterias.id}" name="criteria_id[]">
      <input type="number" id="weightEdit" value="${trans.value}" class="form-control form-control-solid" min="1"
        placeholder="Masukan Nilai " name="weightEdit[]" required />
    </div>`;

        $('#criteriaContainer').append(html);
      }

      // end edit html


      // Add Records Start
      $(document).ready(function() {
        // KTDatatablesServerSide.init();
        $("#addModal_form").submit(function(e) {
          //   e.preventDefault();
          $.ajax({
            type: "POST",
            url: $(this).attr("action"),
            data: $(this).serialize(),
            dataType: "json",
            success: function(response) {
              toastr.success(response.message, 'Success', {
                closeButton: true,
                progressBar: true,
                timeOut: 3000,
                positionClass: 'toastr-top-right'
              });
              $("#addModal").modal("hide");
              $("#addModal_form")[0].reset();
              $("#transaction_table").DataTable().ajax.reload();
            },
            error: function(xhr, ajaxOptions, thrownError) {
              toastr.error('Terjadi kesalahan: ' + xhr.status + ' - ' + thrownError,
                'Error', {
                  closeButton: true,
                  progressBar: true,
                  timeOut: 4000,
                  positionClass: 'toastr-top-right'
                });
            },
          });
          return false;
        });
      });

      function ShowModalEdit(id) {
        $.ajax({
          url: "/transaction/" + id,
          type: 'GET',
          success: function(data) {
            // console.log(data);

            $('#id').val(data.id);
            $('#altEdit').val(data.name);
            $('#criteriaContainer').empty();

            data.transactions.forEach(function(transaction) {
              addCriteriaInput(transaction);
            });

            $('#editModal').modal('show');
          },
          error: function(error) {
            toastr.error('Terjadi kesalahan: ' + xhr.status + ' - ' + thrownError, 'Error', {
              closeButton: true,
              progressBar: true,
              timeOut: 4000,
              positionClass: 'toastr-bottom-right'
            });
          }
        });
      }
      // Modal Edit Ends


      // start update function
      function Update(e) {
        e.preventDefault();

        var id = $('#id').val();
        // var weight = $('#weightEdit').val();
        var weights = $('input[name^="weightEdit["]').map(function() {
          return $(this).val();
        }).get();

        $.ajax({
          url: "/transaction/update/" + id,
          type: 'PUT',
          data: {
            "_token": "{{ csrf_token() }}",
            id: id,
            weights: weights,
          },
          success: function(response) {
            // console.log(data);
            toastr.success(response.message, 'Success', {
              closeButton: true,
              progressBar: true,
              timeOut: 3000,
              positionClass: 'toastr-top-right'
            });

            $('#transaction_table').DataTable().ajax.reload();
            $("#editModal").modal('hide');
          },
          error: function(xhr, status, thrownError) {
            // console.log(data);
            toastr.error('Terjadi kesalahan: ' + xhr.status + ' - ' + thrownError, 'Error', {
              closeButton: true,
              progressBar: true,
              timeOut: 4000,
              positionClass: 'toastr-top-right'
            });
            $('#transaction_table').DataTable().ajax.reload();
          }
        });
      }
      $("#formUpdate").on("submit", Update);
    </script>
    @endpush
@endsection

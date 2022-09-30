@extends('layouts.main')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">

        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10 d-flex flex-row justify-content-between">
                                <div>
                                    <i class="feather icon-file mr-1"></i>
                                    File Manager
                                </div>
                            </h5>
                        </div>
                        <p class="mb-0">Provides an interface for working with file systems. This software is very useful for speeding up interaction with files.</p>
                    </div>
                </div>
            </div>
        </div>


        {{-- <div class="row row-sm">
            <div class="col-lg-12 col-xl-12">
                <form method="get" action="{{ route('fileManagerSearch') }}" class="mb-3">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control py-4" placeholder="Search file here..." name="keywords" value="{{ old('keywords') }}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">
                                <i class="feather icon-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
                <div class="row row-sm">
                    @if(count($files) == 0)    
                    <div class="col-12 text-center">
                        <div class="card py-4">
                            <b class="text-secondary">There is no file in here.</b>
                        </div>
                    </div>
                    @endif

                    @foreach($files as $key => $file)
                    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4">
                        <div class="card overflow-hidden mb-3">
                            <div class="d-flex flex-row px-3 py-2">
                                <div>
                                    <i class="fa fa-file text-primary" style="font-size: 45px;"></i>
                                </div>
                                <div class="ml-3">
                                    <a href="{{ asset('assets/files/'.$file->link) }}" target="_blank" class="text-dark">
                                        <small><b>{{ $file->link }}</b></small>
                                    </a>
                                    <small class="d-block mt-1">
                                        <span><i class="feather icon-user mr-1"></i>{{ getName($file->sender_id) }}</span>
                                    </small>
                                    <small class="d-block mt-1">
                                        <span><i class="feather icon-calendar mr-1"></i>{{ indonesianDate($file->created_at) }}</span>
                                    </small>
                                    <!-- <small class="d-block mt-1">
                                        <i><i class="feather icon-alert-circle mr-1"></i>{{ $file->description }}</i>
                                    </small> -->
                                </div>
                            </div>
                            <!-- <a href="filemanager-details.html" class="mx-auto my-3">
                                <i class="fa fa-file text-secondary" style="font-size: 65px;"></i>
                            </a> -->
                            <!-- <div class="card-footer">
                                <div class="d-flex flex-row justify-content-between">
                                    <div class="">
                                        <small class="mb-0 fw-semibold">{{ $file->link }}</small>
                                    </div>
                                    <div class="ms-auto my-auto"> <small class="text-muted mb-0">{{ getSize($file->size) }}</small> </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                    @endforeach
                </div>
            </div> <!-- End Row -->
        </div> --}}

        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4>List Data File</h4>
                            </div>
                            {{-- {{ dd(Auth::user()->level) }} --}}
                            @if (Auth::user()->level == 'admin')
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                <i class="feather icon-plus"></i>
                                Add File
                            </button>
                            @endif
                            {{-- <a href="" class="btn btn-primary btn-sm">
                            </a> --}}
                        </div>
                    </div>
                    {{-- {{ dd($files) }} --}}
                    <div class="card-body">
                        <div class="table table-responsive">
                            <table class="table table-bordered " id="datatable">
                                <thead class="text-center">
                                    <tr>
                                        <th>No</th>
                                        <th width="20%">File Name</th>
                                        <th width="50%">Description</th>
                                        <th>File</th>
                                        @if (Auth::user()->level == 'admin')
                                        <th>Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @foreach ($files as $item=>$key)
                                    <tr>
                                        <td>1</td>
                                        <td>{{ $key->file_name }}</td>
                                        <td>{{ $key->description }}</td>
                                        <td>
                                            <a href="{{ url('uploads/files/'.$key->file_path) }}" target="_blank">
                                                <div class="badge badge-info"> download</div>
                                            </a>
                                        </td>
                                        @if (Auth::user()->level == 'admin')
                                        <td>
                                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit{{ $key->id }}">
                                                <i class="feather icon-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapus{{ $key->id }}">
                                                <i class="feather icon-trash"></i>
                                            </button>
                                        </td>
                                            
                                        @endif
                                    </tr>
                                    @if (Auth::user()->level == 'admin')
                                    <div class="modal fade" id="edit{{ $key->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Edit File</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ url("filesupport/update") }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="filesupport_id" value="{{ $key->id }}">
                                                    <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="" class="control-label">File Name</label>
                                                                <input type="text" class="form-control" name="filename" value="{{ $key->file_name }}" placeholder="Form Izin Surat CUTI .. ">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="" class="control-label">Description File Name</label>
                                                                <textarea name="description" class="form-control" cols="10" rows="5">{{ $key->description }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="" class="control-label">File</label>
                                                                <input type="file" class="form-control" name="file">
                                                                <small class="text-danger">keep clearly, if document not change</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="hapus{{ $key->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Edit File</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ url("filesupport/delete") }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="filesupport_id" value="{{ $key->id }}">
                                                    <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <p>Apakah anda yakin ingin menghapus dokumen "{{ $key->file_name }}" ? </p>
                                                        </div>
                                                    </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                        
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add File</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="{{ url("filesupport") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
              <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="" class="control-label">File Name</label>
                        <input type="text" class="form-control" name="filename" placeholder="Form Izin Surat CUTI .. ">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="" class="control-label">Description File Name</label>
                        <textarea name="description" class="form-control" cols="10" rows="5"></textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="" class="control-label">File</label>
                        <input type="file" class="form-control" name="file">
                    </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
    </div>
  </div>
</div>
@endsection

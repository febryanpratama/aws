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
                                    Mail Form
                                </div>
                            </h5>
                        </div>
                        <p class="mb-0">Provides an interface for working with file systems. This software is very useful for speeding up interaction with files.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4>List Data Mail Form</h4>
                            </div>
                            {{-- {{ dd(Auth::user()->level) }} --}}
                            {{-- @if (Auth::user()->level == 'admin') --}}
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                <i class="feather icon-plus"></i>
                                Add Mail
                            </button>
                            {{-- @endif --}}
                            {{-- <a href="" class="btn btn-primary btn-sm">
                            </a> --}}

                        </div>
                    </div>
                    {{-- {{ dd($files) }} --}}
                    <div class="card-body">
                        <div class="table table-responsive">
                            <table class="table table-bordered" id="datatable">
                                <thead class="text-center">
                                    <tr class="text-center">
                                        <th class="text-center">No</th>
                                        <th class="text-center" width="20%">Name</th>
                                        <th class="text-center" width="20%">Category</th>
                                        <th class="text-center">Reason</th>
                                        <th class="text-center">File</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @foreach ($data as $item=>$val)
                                        <tr>
                                            <td>{{ $item+1 }}</td>
                                            <td>{{ $val->user->name }}</td>
                                            <td>{{ $val->category }}</td>
                                            <td>{{ $val->reason }}</td>
                                            <td>
                                                <a href="{{ url("uploads/izin/".$val->path_file) }}" target="_blank" class="badge badge-info">
                                                    document
                                                </a>
                                            </td>
                                            <td>
                                                @switch($val->status)
                                                    @case("pending")
                                                        <div class="badge badge-warning"> {{ $val->status }} </div>
                                                        @break
                                                    @case("approved")
                                                        <div class="badge badge-success"> {{ $val->status }} </div>
                                                        @break
                                                        @case("rejected")
                                                        <div class="badge badge-danger"> {{ $val->status }} </div>

                                                    @break
                                                    @default
                                                        
                                                @endswitch
                                            </td>
                                            <td>
                                                @if (auth()->user()->level == 'admin' || auth()->user()->level == 'manager')
                                                    <a href="{{ url("mail/".$val->id."/approved") }}" class="btn btn-success btn-sm" title="Approved">
                                                        <i class="feather icon-check"></i>
                                                    </a>
                                                    <a href="{{ url("mail/".$val->id."/rejected") }}" class="btn btn-danger btn-sm" title="Rejected">
                                                        <i class="feather icon-x"></i>
                                                    </a>
                                                @endif
                                                <a href="" class="btn btn-warning btn-sm">
                                                    <i class="feather icon-edit"></i>
                                                </a>
                                                {{-- <a href="" class="btn btn-danger btn-sm">
                                                    <i class="feather icon-trash"></i>
                                                </a> --}}
                                            </td>
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
        <form action="{{ url("mail") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
              <div class="row">
                
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="" class="control-label">Category Mail</label>
                        <select name="category" id="" class="form-control">
                            <option value="" selected disabled> == Pilih == </option>
                            <option value="Sakit">Sakit</option>
                            <option value="Cuti Khusus">Cuti Khusus</option>
                            <option value="Keluar Kantor">Keluar Kantor</option>
                        </select>
                        {{-- <input type="text" class="form-control" name="filename" placeholder="Form Izin Surat CUTI .. "> --}}
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="" class="control-label">Reason Mail</label>
                        <textarea name="reason" class="form-control" cols="10" rows="5"></textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="" class="control-label">Start Date</label>
                        <input type="date" class="form-control" name="start_date" placeholder="Form Izin Surat CUTI .. ">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="" class="control-label">End Date</label>
                        <input type="date" class="form-control" name="end_date" placeholder="Form Izin Surat CUTI .. ">
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

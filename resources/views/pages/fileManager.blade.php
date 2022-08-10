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


        <div class="row row-sm">
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
        </div>
    </div>
</div>
@endsection
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
                                    Settings
                                </div>
                            </h5>
                        </div>
                        <p class="mb-0">Manage your account information at here.</p>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-xl-5 col-sm-12">
                <div class="card">
                    <div class="card-header border-bottom py-3">
                        <h5>Form Settings</h5>
                    </div>
                    <form action="{{ route('settingsPost') }}" method="post" enctype="multipart/form-data" class="card-body mt-3">
                        @csrf
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" class="form-control" placeholder="Full Name" value="{{ Auth::user()->name }}" name="name" required="">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" placeholder="Email Address" value="{{ Auth::user()->email }}" name="email" required="">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" placeholder="(leave it blank if nothing change)" name="password">
                        </div>
                        <div class="form-group">
                            <label for="avatar">Avatar</label>
                            <div class="input-group mb-3">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="inputGroupFile01" name="file" accept="image/*">
                                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="job_title">Job Title</label>
                            <input type="text" class="form-control" placeholder="Job Title" value="{{ Auth::user()->job_title }}" name="job_title" required="">
                        </div>
                        <div class="form-group">
                            <label for="bio">Bio</label>
                            <textarea name="bio" id="bio" rows="4" class="form-control">{{ Auth::user()->bio }}</textarea>
                        </div>
                        <div class="form-group float-right mt-2">
                            <button type="submit" name="submit" class="btn btn-primary">
                                <i class="feather icon-check mr-1"></i>
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="col-xl-7 col-sm-12">
                <div class="card">
                    <div class="card-header border-bottom py-3">
                        <h5>E-Sign</h5>
                    </div>
                    <form action="{{ route('esignPost') }}" method="post" enctype="multipart/form-data" class="card-body mt-3">
                        @csrf
                        <div class="form-group">
                            <label for="name">Current E-Sign</label>
                            @if(Auth::user()->esign <> NULL)
                            <img src="{{ asset('assets/images/user/'.Auth::user()->esign) }}" alt="E-Sign" class="d-block border" style="border-radius: 15px; width: 130px;">
                            @else
                            <div class="p-2 pl-3 border text-danger">
                                There is no esign. Please update your esign..
                            </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="name">Upload Image</label>
                            <input type="file" class="form-control" name="esign" required="" accept="image/*">
                        </div>
                        <div class="form-group float-right mt-2">
                            <button type="submit" name="submit" class="btn btn-primary">
                                <i class="feather icon-check mr-1"></i>
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
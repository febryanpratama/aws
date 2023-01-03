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
                                    <i class="feather icon-user mr-1"></i>
                                    {{ $title }}
                                </div>
                            </h5>
                        </div>
                        {{-- <p class="mb-0">GPS-based Website attendance application. Stop leaning on to fingerprint machine and you can track or document it in a simpler, faster way.</p> --}}
                    </div>
                </div>
            </div>
        </div>


        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-content collapse show">
                        <div class="card-body">
        
                            {{-- <div class="card-text">
                                <p>You can always change the border color of the form controls using
                                    <code>border-*</code> class.</p>
                            </div> --}}
        
                            @if (@$data->id)
                            <form class="form" action="{{ url('user/'. @$data->id.'/update') }}" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="user_id" value="{{ @$data->id }}">
                            @else
                            <form class="form" method="POST" action="{{ url('user/store') }}" enctype="multipart/form-data">
                            @endif
                                @csrf
                                <div class="form-body">
        
                                    <h4 class="form-section">
                                    <i class="ft-briefcase"></i>{{ $title }} Forms</h4>
                                    {{-- <div class="form-group">
                                        <label for="contactinput5">NISN</label>
                                        <input type="number" class="form-control @error('nisn') is-invalid @enderror" required name="nisn" placeholder="Masukkan No NISN" />
                                    </div> --}}
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label for="" class="control-label">Name</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="name" value="{{ @$data->name }}" placeholder="Febryan Caesar Pratama" required>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-2">
                                            <label for="" class="label-control">Email</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="email" class="form-control" name="email" value="{{ @$data->email }}" placeholder="mail@mail.com" required>
                                        </div>
                                    </div>
        
                                    <div class="row mt-2">
                                        <div class="col-md-2">
                                            <label for="" class="label-control">Password</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="password" class="form-control" name="password" placeholder="Input Your Password Here !!">
                                        </div>
                                    </div>
                                    @if (@$data->id)
                                    <small class="text-danger">leave it blank if nothing change</small>
                                    @endif
                                    <div class="row mt-2">
                                        <div class="col-md-2">
                                            <label for="" class="label-control">Re-Password</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="password" class="form-control" name="re-password" placeholder="Input Your Password Here !!">
                                        </div>
                                    </div>
                                    @if (@$data->id)
                                    <small class="text-danger">leave it blank if nothing change</small>
                                    @endif

                                    <div class="row mt-2">
                                        <div class="col-md-2">
                                            <label for="" class="control-label">Level</label>
                                        </div>
                                        <div class="col-md-8">
                                            <select name="level" class="form-control" required>
                                                <option value="" selected disabled> == PILIH == </option>
                                                <option value="manager" {{ @$data->level == 'manager' ? 'selected' : '' }}>Manager</option>
                                                <option value="admin" {{ @$data->level == 'admin' ? 'selected' : '' }}>Admin</option>
                                                <option value="user" {{ @$data->level == 'user' ? 'selected' : '' }}>User</option>
                                            </select>
                                        </div>
                                    </div>
        
                                </div>
        
                                <div class="form-actions float-right m-2">
                                    <button type="button" class="btn btn-danger mr-1">
                                        <i class="ft-x"></i> Cancel
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="la la-check-square-o"></i> Save
                                    </button>
                                </div>
                            </form>
        
                        </div>
                    </div>

                </div>

            </div>



        </div>

    </div>
</div>
@endsection
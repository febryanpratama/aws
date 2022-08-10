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
                                    <i class="feather icon-mail mr-1"></i>
                                    My Permission
                                </div>
                                @if(Auth::user()->level == "user")
                                <div>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLive">
                                        <i class="feather icon-plus mr-1"></i>
                                        Add New
                                    </button>
                                </div>
                                @endif
                            </h5>
                        </div>
                        <p class="mb-0">It's a feature of users permission.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($permissions as $key => $permission)
            <div class="col-lg-12 col-xl-4">
                <div class="card">
                    <div class="card-header border d-flex flex-row justify-content-between">
                        <div>
                            <h6>{{ $permission->title }}</h6>
                            <small>{{ indonesianDate($permission->date_permission) }} - <b class="text-danger" style="text-transform: uppercase">{{ $permission->status }}</b></small>
                            @if(Auth::user()->level == "admin")
                            <small class="d-block">by <b>{{ getName($permission->user_id) }}</b></small>
                            @endif
                        </div>
                        <div class="align-self-center">
                            @if($permission->status !== "accepted" && Auth::user()->level == "user")
                            <a href="{{ route('permission.destroy', $permission->id) }}">
                                <i class="feather icon-trash text-dark"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                    <div class="card-body pt-3">
                        <p>{{ $permission->description }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<!-- Modal -->
<div id="exampleModalLive" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="modal-content" method="post" action="{{ route('permission.store') }}">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLiveLabel">Add New Permission</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="title">Date</label>
                    <input type="date" name="date_permission" placeholder="Date of your permission" class="form-control">
                </div>
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" placeholder="Title of your permission" class="form-control">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" rows="5" placeholder="Description of your permission" class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn  btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn  btn-primary">Save changes</button>
            </div>
        </form>
    </div>
</div>
@endsection
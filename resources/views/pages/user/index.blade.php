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

            <div class="col-xl-12 col-md-12">
                <div class="card table-card">
                    <form class="card-header" method="get" action="#">
                        <h5 class="border-bottom pb-3">List</h5>
                    
                        
                        <div class="card-header-right">
                            <a href="{{ url('user/create') }}" class="btn btn-outline-primary mr-3">
                                Add User
                                {{-- <button type="button" class="btn btn-outline-primary mr-3">Add User</button> --}}

                            </a>
                            {{-- <div class="btn-group card-option">
                                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="feather icon-more-horizontal"></i>
                                </button>
                                <ul class="list-unstyled card-option dropdown-menu dropdown-menu-right">
                                    <li class="dropdown-item full-card"><a href="#!"><span><i class="feather icon-maximize"></i> maximize</span><span style="display:none"><i class="feather icon-minimize"></i> Restore</span></a></li>
                                    <li class="dropdown-item minimize-card"><a href="#!"><span><i class="feather icon-minus"></i> collapse</span><span style="display:none"><i class="feather icon-plus"></i> expand</span></a></li>
                                    <li class="dropdown-item close-card"><a href="#!"><i class="feather icon-trash"></i> remove</a></li>
                                    <li class="dropdown-item"><a id="btn-print"><i class="feather icon-printer"></i> print</a></li>
                                </ul>
                            </div> --}}
                        </div>
                    </form>
                    <div class="card-body p-0">
                        <div class="table-responsive custom-scroll" style="max-height: 500px;">
                            <table class="table table-hover m-b-0" id="printTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>User</th>
                                        <th>Email</th>
                                        <th>Join At</th>
                                        <th>Level</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $key => $item)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>
                                            @switch($item->level)
                                                @case('admin')
                                                    <span class="badge badge-success">Admin</span>
                                                    @break
                                                    @case('user')
                                                    <span class="badge badge-info">User</span>
                                                    
                                                    @break
                                                @default
                                                    
                                            @endswitch
                                        </td>
                                        <td>
                                            <a href="{{ url('user/'.$item->id.'/edit') }}" class="btn btn-sm btn-info">
                                                <svg xmlns="http://www.w3.org/2000/svg" style="width: 20px;height: 20px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            {{-- <a href="#" class="btn btn-sm btn-danger" onclick="delete($item->id)"> --}}
                                                <button type="button" class="btn btn-sm btn-danger delete" data-id="{{ $item->id }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" style="width: 20px;height: 20px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            {{-- </a> --}}
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
@endsection

@section('custom-script')

<script>
    $(document).ready(function(){
        $('.delete').on('click', function(){
            swal.fire("Danger", "Are you sure?", "warning");
        })
    })
</script>

@endsection
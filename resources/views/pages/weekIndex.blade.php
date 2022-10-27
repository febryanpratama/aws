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
                                    <i class="feather icon-activity mr-1"></i>
                                    Weekly Working Plan
                                    <p class="mt-3 mb-0" style="font-weight: 300">It's a feature of weekly working plan.</p>
                                </div>
                                <div>
                                    @if(Auth::user()->level == "user")
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLive">
                                        <i class="feather icon-plus mr-1"></i>
                                        Add New
                                    </button>
                                    @endif
                                    
                                    @if(count($weeks) >= 2)
                                    <a href="{{ route('weeks.timesheetexcel', [$month, $year]) }}">
                                        <button type="button" class="btn btn-danger" >
                                            <i class="feather icon-printer mr-1"></i>
                                            Create Timesheet
                                        </button>
                                    </a>
                                    @endif
                                </div>
                            </h5>
                        </div>
                        <div class="d-flex flex-row justify-content-between">
                            <form method="get" action="" class="d-flex flex-row">
                                @if(Auth::user()->level == "admin")
                                <div class="form-group mr-3">
                                    <label for="user_id">User:</label>
                                    <select name="user_id" id="user_id" class="form-control">
                                        <option value="all">Select User</option>
                                        @foreach($users as $key => $user)
                                        <option value="{{ $user->id }}" {{ (old('user_id') == $user->id) ? 'selected=""' : '' }}>{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                <div class="form-group mr-3">
                                    <label for="date_start">Year:</label>
                                    <select name="year" id="year" class="form-control">
                                        @for($i = date('Y'); $i > (date('Y') - 5); $i--)
                                        @if(old('year') <> '')
                                            <option value="{{ $i }}" {{ (old('year') == $i) ? 'selected=""' : '' }}>{{ $i }}</option>
                                            @else
                                            <option value="{{ $i }}" {{ (date('Y') == $i) ? 'selected=""' : '' }}>{{ $i }}</option>
                                            @endif
                                            @endfor
                                    </select>
                                </div>
                                <div class="form-group mr-3">
                                    <label for="date_start">Month:</label>
                                    <select name="month" id="month" class="form-control">
                                        @for($i = 1; $i <= 12; $i++) @if(old('month') <> '')
                                            <option value="{{ $i }}" {{ (old('month') == $i) ? 'selected=""' : '' }}>{{ getMonthCode($i) }}</option>
                                            @else
                                            <option value="{{ $i }}" {{ (date('n') == $i) ? 'selected=""' : '' }}>{{ getMonthCode($i) }}</option>
                                            @endif
                                            @endfor
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="d-block">&nbsp;</label>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="feather icon-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($weeks as $key => $week)
            <div class="col-lg-12 col-xl-3">
                <div class="card pr-1" style="border-radius: 45px;">
                    <div class="card-header text-center">
                        <a href="{{ route('weeks_activity.index', $week->id) }}">
                            <h4 class="text-primary">{{ $week->title }}</h4>
                        </a>
                        <small class="d-block"><i class="feather icon-calendar mr-1"></i> from <b class="text-danger">{{ $week->date_start }}</b></small>
                        <small class="d-block mb-4"><i class="feather icon-check-circle mr-1"></i> to <b class="text-danger">{{ $week->date_end }}</b></small>
                        <!-- <a href="{{ route('weeks.edit', $week->id) }}">
                            <small><b class="mr-3 text-muted"><i class="feather icon-settings mr-1"></i> Edit</b></small>
                        </a> -->
                        @if(Auth::user()->level == "user")
                        <a href="{{ route('weeks.delete', $week->id) }}">
                            <small><b class="text-muted"><i class="feather icon-trash mr-1"></i> Delete</b></small>
                        </a>
                        @endif
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
        <form class="modal-content" method="post" action="{{ route('weeks.store') }}">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLiveLabel">Add New Weekly Working Plan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-6">
                        <label for="date_start">Date Start</label>
                        <input type="date" name="date_start" placeholder="Date start of your weekly working plan" class="form-control">
                    </div>
                    <div class="form-group col-6">
                        <label for="date_end">Date End</label>
                        <input type="date" name="date_end" placeholder="Date end of your weekly working plan" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-6">
                        <label for="date_start">Year:</label>
                        <select name="year" id="year" class="form-control">
                            @for($i = date('Y'); $i > (date('Y') - 5); $i--)
                            <option value="{{ $i }}" {{ (date('Y') == $i) ? 'selected=""' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group col-6">
                        <label for="date_start">Month:</label>
                        <select name="month" id="month" class="form-control">
                            @for($i = 1; $i <= 12; $i++) <option value="{{ $i }}" {{ (date('n') == $i) ? 'selected=""' : '' }}>{{ getMonthCode($i) }}</option>
                                @endfor
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" placeholder="Title of your permission" class="form-control">
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
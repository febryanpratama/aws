<!DOCTYPE html>
<html lang="en">

<head>
    <title>Alatan's Working Support</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <meta name="keywords" content="">
    <meta name="author" content="Codedthemes" />
    @include('includes.assets')
    <style>
        td, th{
            font-size: 12px !important;
        }
        th{
            padding: 10px 0 !important;
        }
        input[type="date"]::-webkit-inner-spin-button,
        input[type="date"]::-webkit-calendar-picker-indicator {
            margin-left: -10px;
        }

        .input {
            width: 100%;
            border: 1px solid rgba(0,0,0,.05);
            padding: 5px;
            border-radius: 10px;
        }

        .textarea {
            width: 100%;
            border: none;
            padding: 10px;
        }

        .textarea {
            scrollbar-width: auto;
            scrollbar-color: #c7c7c7 #ffffff;
        }
        
        .textarea::-webkit-scrollbar {
            width: 16px;
        }

        .textarea::-webkit-scrollbar-track {
            background: #ffffff;
        }

        .textarea::-webkit-scrollbar-thumb {
            background-color: #c7c7c7;
            border-radius: 10px;
            border: 5px solid #ffffff;
        }
    </style>
</head>

<body class="">
    @if(!Auth::guest())
    @include('includes.loader')
    @include('includes.header')
    @endif

    <div class="pcoded-main-container" style="margin-left: 0;">
        <div class="pcoded-content">

            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">

                                <h5 class="m-b-10 d-flex flex-row justify-content-between">
                                    <div>
                                        <i class="feather icon-activity mr-1"></i>
                                        {{ $wp->title }}
                                        <p class="mt-3 mb-0" style="font-weight: 300">from <b>{{ $wp->date_start }}</b> to <b>{{ $wp->date_end }}</b></p>
                                    </div>
                                    <a href="{{ route('weeks.index') }}">
                                        <button type="button" class="btn btn-warning text-dark">
                                            <i class="feather icon-chevron-left mr-1"></i>
                                            Back
                                        </button>
                                    </a>
                                </h5>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="save-all" class="btn btn-primary badge-pill px-4">
                        <i class="feather icon-check mr-2"></i>
                        Save All Changes
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <form method="post" action="{{ route('weeks_activity.update', $id) }}" class="card" id="form">
                        @csrf
                        <table class="table table-bordered mb-0">
                            <thead class="text-center">
                                <tr>
                                    <th style="width: 0">Date</th>
                                    <th style="width: 70px">Days</th>
                                    <th style="width: 80px">Place</th>
                                    <th>Plan Activities</th>
                                    <th style="width: 0">Start</th>
                                    <th>Realization Activities</th>
                                    <th style="width: 0">End</th>
                                    <th style="width: 145px">Status</th>
                                    <th style="width: 150px">Evidance Link</th>
                                    <!-- <th style="width: 0;">Action</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($weeks_activity as $key => $wa)
                                
                                {{-- <tr class="text-center" >
                                    <div>
                                        <td>
                                            <input type="date" class="form-control">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" value="{{ $wa->days }}">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" value="{{ $wa->place }}">
                                        </td>
                                        <td>
                                            <textarea class="form-control textarea" rows="2">{{ $wa->plan_activities }}</textarea>
                                        </td>
                                        <td>
                                            <input type="time" class="form-control" value="{{ $wa->start }}">
                                        </td>
                                        <td>
                                            <textarea class="form-control textarea" rows="2">{{ $wa->realization_activities }}</textarea>
                                        </td>
                                        <td>
                                            <input type="time" class="form-control" value="{{ $wa->end }}">
                                        </td>
                                        <td>
                                            <select name="status" class="form-control" id="">
                                                <option value="" selected disabled>== PILIH ==</option>
                                                <option value="In Progress"> In Progress </option>
                                                <option value="Done"> Done </option>
                                                <option value="Canceled"> Canceled </option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" value="{{ $wa->evidance_link }}">
                                            <button type="button" class="mt-2 btn btn-sm btn-danger" onclick="addRow({{ $wa->id }})">Add</button>
                                        </td>

                                    </div>
                                </tr> --}}
                                <tr>
                                    <td>
                                        <input type="date" value="{{ $wa->date_activities }}" class="input" name="date_activities[{{ $wa->id }}]">
                                    </td>
                                    <td class="text-center">
                                        <input type="number" value="{{ $wa->days_worked }}" class="input" name="days_worked[{{ $wa->id }}]">
                                    </td>
                                    <td>
                                        <input type="text" value="{{ ($wa->place <> null) ? $wa->place : 'Office' }}" class="input" name="place[{{ $wa->id }}]">
                                    </td>
                                    <td class="p-0">
                                        <textarea name="plan_activities[{{ $wa->id }}]" rows="15" class="textarea">{{ $wa->plan_activities }}</textarea>
                                    </td>
                                    <td>
                                        <input type="time" value="{{ $wa->time_start }}" class="input" name="time_start[{{ $wa->id }}]">
                                    </td>
                                    <td class="p-0">
                                        <textarea name="realization_activities[{{ $wa->id }}]" rows="15" class="textarea">{{ $wa->realization_activities }}</textarea>
                                    </td>
                                    <td>
                                        <input type="time" value="{{ $wa->time_end }}" class="input" name="time_end[{{ $wa->id }}]">
                                    </td>
                                    <td>
                                        <select name="status[{{ $wa->id }}]" id="status" class="bg-outline-secondary form-control badge-pill" style="border: 1px solid rgba(0,0,0,.05)">
                                            <option value="in_progres" {{ ($wa->status == 'in_progres') ? 'selected=""' : '' }}>In Progres</option>
                                            <option value="done" {{ ($wa->status == 'done') ? 'selected=""' : '' }}>Done</option>
                                            <option value="canceled" {{ ($wa->status == 'canceled') ? 'selected=""' : '' }}>Canceled</option>
                                        </select>
                                    </td>
                                    <td>
                                        <textarea name="evidance_link[{{ $wa->id }}]" rows="10" class="textarea border">{{ $wa->evidance_link }}</textarea>
                                        <a href="#" target="_blank">
                                            <button type="button" class="btn btn-primary d-block w-100">
                                                <i class="feather icon-link mr-1"></i> Open
                                            </button>
                                        </a>
                                    </td>
                                    <!-- <td class="text-center">
                                        <a href="#">
                                            <button type="button" class="btn btn-danger badge-pill" style="background: #f44336;">
                                                <i class="feather icon-trash"></i>
                                            </button>
                                        </a>
                                    </td> -->
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
@include('includes.scripts')
<script>
    $('#save-all').click(() => {
        $('#form').submit();
    });

    // add row

    function addRow(id){
        $('#newRow'+id).append(`
        <tr class="text-center" id="newRow`+id+`">
            <td>
                <input type="date" class="form-control">
            </td>
            <td>
                <input type="number" class="form-control" value="{{ $wa->days }}">
            </td>
            <td>
                <input type="text" class="form-control" value="{{ $wa->place }}">
            </td>
            <td>
                <textarea class="form-control textarea" rows="2">{{ $wa->plan_activities }}</textarea>
            </td>
            <td>
                <input type="time" class="form-control" value="{{ $wa->start }}">
            </td>
            <td>
                <textarea class="form-control textarea" rows="2">{{ $wa->realization_activities }}</textarea>
            </td>
            <td>
                <input type="time" class="form-control" value="{{ $wa->end }}">
            </td>
            <td>
                <select name="status" class="form-control" id="">
                    <option value="" selected disabled>== PILIH ==</option>
                    <option value="In Progress"> In Progress </option>
                    <option value="Done"> Done </option>
                    <option value="Canceled"> Canceled </option>
                </select>
            </td>
            <td>
                <input type="text" class="form-control" value="{{ $wa->evidance_link }}">
                {{-- <button id="addRow" type="button" class="btn btn-info">Add Row</button> --}}
                <button type="button" class="mt-2 btn btn-sm btn-danger addRow">Add</button>
            </td>
        </tr>
        `);
    }

    $("#addRow").click(function () {
        var html = '';
        html += '<div id="inputFormRow">';
        html += '<div class="input-group mb-3">';
        html += '<input type="text" name="title[]" class="form-control m-input" placeholder="Enter title" autocomplete="off">';
        html += '<div class="input-group-append">';
        html += '<button id="removeRow" type="button" class="btn btn-danger">Remove</button>';
        html += '</div>';
        html += '</div>';

        $('#newRow').append(html);
    });

    // remove row
    $(document).on('click', '#removeRow', function () {
        $(this).closest('#inputFormRow').remove();
    });
</script>
</html>
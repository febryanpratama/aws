@extends('layouts.main')

@section('custom-asset')
<style>
    .hidden {
        display: none;
        visibility: hidden;
        opacity: 0;
    }

    .textarea {
        border: none;
        width: 100%;
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

    .date{
        border: 1px solid #ddd;
        position: relative;
        top: -3px;
    }
</style>
@endsection

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
                                    <i class="feather icon-check mr-1"></i>
                                    My Daily Activites
                                </div>
                                <div>
                                    <button type="button" class="btn btn-primary" id="button">
                                        <i class="feather icon-plus mr-1"></i>
                                        Add New
                                    </button>
                                </div>
                            </h5>
                        </div>
                        <p class="mb-0">It's a feature of your daily activities report.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-12 col-xl-4 hidden" id="wrapper">
                <form method="post" action="{{ route('dailyActivitiesPost') }}" class="card trnasiction-card" id="form">
                    <div class="card-header d-flex justify-content-between">
                        @csrf
                        <input type="date" class="date" placeholder="Select date" name="date_activities">
                        <h6>
                            <a href="#" class="text-dark" id="save">
                                <i class="feather icon-save mr-3"></i>
                            </a>
                            <a href="#" class="text-dark" id="cancel">
                                <i class="feather icon-x"></i>
                            </a>
                        </h6>
                    </div>
                    <div class="card-body">
                        <textarea name="detail_activities" rows="17" class="textarea" placeholder="Type your activities here..."></textarea>
                    </div>
                </form>
            </div>
            @foreach($activities as $key => $activity)
            <div class="col-lg-12 col-xl-4">
                <form method="post" action="{{ route('dailyActivityUpdate', $activity->id) }}" class="card trnasiction-card" id="form-{{ $key }}">
                    @csrf
                    <div class="card-header d-flex justify-content-between">
                        <h6>{{ indonesianDate($activity->date_activities) }}</h6>
                        <h6>
                            <a href="#" class="text-dark" onclick="save({{ $key }})">
                                <i class="feather icon-save mr-3"></i>
                            </a>
                            <a href="{{ route('dailyActivityDelete', $activity->id) }}" class="text-dark">
                                <i class="feather icon-trash"></i>
                            </a>
                        </h6>
                    </div>
                    <div class="card-body">
                        <textarea name="detail_activities" rows="17" class="textarea" id="textarea-{{ $key }}">{{ $activity->detail_activities }}</textarea>
                    </div>
                </form>
            </div>
            @endforeach
        </div>



    </div>
</div>
@endsection

@section('custom-script')
<script>
    function save(id){
        var val = $('#textarea-'+id).val();
        if(val == 0){
            return false;
        }
        $('#form-'+id).submit();
    }
    $('#button, #cancel').click(() => {
        $('#wrapper').toggleClass('hidden');
    });
    $('#save').click(() => {
        $('#form').submit();
    });
</script>
@endsection
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
                                    <i class="feather icon-map-pin mr-1"></i>
                                    Your Attendance History
                                </div>
                                <form method="post" action="{{ route('attendanceOut') }}">
                                    @csrf
                                    <input type="hidden" id="latitude" name="latitude">
                                    <input type="hidden" id="longitude" name="longitude">
                                    <button type="submit" name="submit" class="btn btn-danger btn-sm">
                                        <i class="feather icon-map-pin mr-1"></i>
                                        Exit Work
                                    </button>
                                </form>
                            </h5>
                        </div>
                        <p class="mb-0">GPS-based Website attendance application. Stop leaning on to fingerprint machine and you can track or document it in a simpler, faster way.</p>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">

            <div class="col-xl-12 col-md-12">
                <div class="card table-card">
                    <div class="card-header">
                        <h5>History</h5>
                        <div class="card-header-right">
                            <div class="btn-group card-option">
                                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="feather icon-more-horizontal"></i>
                                </button>
                                <ul class="list-unstyled card-option dropdown-menu dropdown-menu-right">
                                    <li class="dropdown-item full-card"><a href="#!"><span><i class="feather icon-maximize"></i> maximize</span><span style="display:none"><i class="feather icon-minimize"></i> Restore</span></a></li>
                                    <li class="dropdown-item minimize-card"><a href="#!"><span><i class="feather icon-minus"></i> collapse</span><span style="display:none"><i class="feather icon-plus"></i> expand</span></a></li>
                                    <li class="dropdown-item close-card"><a href="#!"><i class="feather icon-trash"></i> remove</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                        <div class="card-body p-0">
                            <div class="table-responsive custom-scroll" style="max-height: 500px;">
                                <table class="table table-hover m-b-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>IP Address</th>
                                            <th>Platform</th>
                                            <th>Type</th>
                                            <th>Map</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($activities as $key => $activity)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ indonesianDate($activity->created_at) }}</td>
                                            <td>{{ $activity->ip_address }}</td>
                                            <td>
                                                {{ $activity->user_agent }}
                                            </td>
                                            <td>
                                                <span class="pcoded-badge badge badge-{{ ($activity->type == 'in') ? 'primary' : 'danger' }}">{{ $activity->type }}</span>
                                            </td>
                                            <td>
                                                <a href="https://maps.google.com/maps?q={{ $activity->latitude }},{{ $activity->longitude }}" target="__blank">
                                                    <button type="button" class="btn btn-sm bg-c-purple text-white py-0 px-2">
                                                        <small>
                                                            <i class="feather icon-map-pin mr-1"></i>
                                                            Open Map
                                                        </small>
                                                    </button>
                                                </a>
                                                <!-- <iframe
                                                    width="150"
                                                    height="150"
                                                    style="border:0; border-radius: 10px"
                                                    src = "https://maps.google.com/maps?q={{ $activity->latitude }},{{ $activity->longitude }}&hl=es;z=14&output=embed">        
                                                </iframe> -->
                                            </td>
                                        </tr>
                                        @endforeach

                                        @if(count($activities) == 0)
                                        <tr>
                                            <td colspan="6" class="text-center">
                                                Theres nothing in here.
                                            </td>
                                        </tr>
                                        @endif
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

@section("custom-script")
<script>
    let latitude = localStorage.getItem('latitude');
    let longitude = localStorage.getItem('longitude');
    $('#latitude').val(latitude);
    $('#longitude').val(longitude);
</script>
@endsection
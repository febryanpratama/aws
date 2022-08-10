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
                                    User Attendance History
                                </div>
                            </h5>
                        </div>
                        <p class="mb-0">GPS-based Website attendance application. Stop leaning on to fingerprint machine and you can track or document it in a simpler, faster way.</p>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            @if(Auth::user()->level == "admin")
            <div class="col-xl-6 col-md-6">
                <div class="card table-card">
                    <div class="card-header">
                        <h5 class="border-bottom pb-3">Attendance Chart</h5>
                        <div class="mb-0 mt-3">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-lg-4 col-sm-12 mt-2">
                                            <div class="mb-2">User:</div>
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="feather icon-user"></i>
                                                    </span>
                                                </div>
                                                <!-- <input type="date" class="form-control date-picker"> -->
                                                <select name="user_id" id="attendance_user_id" class="form-control">
                                                    @foreach($users as $key => $user)
                                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-12 mt-2">
                                            <div class="mb-2">Month:</div>
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="feather icon-clock"></i>
                                                    </span>
                                                </div>
                                                <!-- <input type="date" class="form-control date-picker"> -->
                                                <select name="month" id="attendance_month" class="form-control">
                                                    @for($i = 1; $i <= 12; $i++)
                                                        @if(old('month') <> '')
                                                        <option value="{{ $i }}" {{ (old('month') == $i) ? 'selected=""' : '' }}>{{ getMonthCode($i) }}</option>
                                                        @else
                                                        <option value="{{ $i }}" {{ (date('n') == $i) ? 'selected=""' : '' }}>{{ getMonthCode($i) }}</option>
                                                        @endif
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-12 mt-2">
                                            <div class="mb-2">Year:</div>
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="feather icon-clock"></i>
                                                    </span>
                                                </div>
                                                <!-- <input type="date" class="form-control date-picker"> -->
                                                <select name="year" id="attendance_year" class="form-control">
                                                @for($i = date('Y'); $i > (date('Y') - 5); $i--)
                                                    @if(old('year') <> '')
                                                    <option value="{{ $i }}" {{ (old('year') == $i) ? 'selected=""' : '' }}>{{ $i }}</option>
                                                    @else
                                                    <option value="{{ $i }}" {{ (date('Y') == $i) ? 'selected=""' : '' }}>{{ $i }}</option>
                                                    @endif
                                                @endfor
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <canvas id="chart-1"></canvas>
                    </div>
                </div>
            </div>

            
            <div class="col-xl-6 col-md-6">
                <div class="card table-card">
                    <div class="card-header">
                        <h5 class="border-bottom pb-3">Discipline Chart</h5>
                        <div class="mb-0 mt-3">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-lg-4 col-sm-12 mt-2">
                                            <div class="mb-2">User:</div>
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="feather icon-user"></i>
                                                    </span>
                                                </div>
                                                <!-- <input type="date" class="form-control date-picker"> -->
                                                <select name="user_id" id="discipline_user_id" class="form-control">
                                                    @foreach($users as $key => $user)
                                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-12 mt-2">
                                            <div class="mb-2">Month:</div>
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="feather icon-clock"></i>
                                                    </span>
                                                </div>
                                                <!-- <input type="date" class="form-control date-picker"> -->
                                                <select name="month" id="discipline_month" class="form-control">
                                                    @for($i = 1; $i <= 12; $i++)
                                                        @if(old('month') <> '')
                                                        <option value="{{ $i }}" {{ (old('month') == $i) ? 'selected=""' : '' }}>{{ getMonthCode($i) }}</option>
                                                        @else
                                                        <option value="{{ $i }}" {{ (date('n') == $i) ? 'selected=""' : '' }}>{{ getMonthCode($i) }}</option>
                                                        @endif
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-12 mt-2">
                                            <div class="mb-2">Year:</div>
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="feather icon-clock"></i>
                                                    </span>
                                                </div>
                                                <!-- <input type="date" class="form-control date-picker"> -->
                                                <select name="year" id="discipline_year" class="form-control">
                                                @for($i = date('Y'); $i > (date('Y') - 5); $i--)
                                                    @if(old('year') <> '')
                                                    <option value="{{ $i }}" {{ (old('year') == $i) ? 'selected=""' : '' }}>{{ $i }}</option>
                                                    @else
                                                    <option value="{{ $i }}" {{ (date('Y') == $i) ? 'selected=""' : '' }}>{{ $i }}</option>
                                                    @endif
                                                @endfor
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="margin: auto; position: relative; top: 10px">
                            <canvas id="chart-2"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            @endif

            <div class="col-xl-12 col-md-12">
                <div class="card table-card">
                    <form class="card-header" method="get" action="{{ route('attendanceSearch') }}">
                        <h5 class="border-bottom pb-3">History</h5>
                        <div class="mt-4 mb-0">
                            <span>Search by dates:</span>
                            <div class="row">
                                <div class="col-5">
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-12 mt-2">
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">From</span>
                                                </div>
                                                <input type="date" name="from" class="form-control date-picker" value="{{ old('from') }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-12 mt-2">
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">To</span>
                                                </div>
                                                <input type="date" name="to" class="form-control date-picker" value="{{ old('to') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-0">
                            <div class="row">
                                <div class="col-5">
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-12 mt-2">
                                            <div class="mb-2">Search by user:</div>
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="feather icon-user"></i>
                                                    </span>
                                                </div>
                                                <!-- <input type="date" class="form-control date-picker"> -->
                                                <select name="user_id" id="user_id" class="form-control">
                                                    <option value="all">All</option>
                                                    @foreach($users as $key => $user)
                                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-12 mt-2">
                                            <div class="mb-2">Search by type:</div>
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="feather icon-check"></i>
                                                    </span>
                                                </div>
                                                <!-- <input type="date" class="form-control date-picker"> -->
                                                <select name="type" id="id" class="form-control">
                                                    <option value="all">All</option>
                                                    <option value="in">in</option>
                                                    <option value="out">out</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2 mb-4">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="feather icon-search mr-1"></i>
                                Search
                            </button>
                        </div>
                        <div class="card-header-right">
                            <div class="btn-group card-option">
                                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="feather icon-more-horizontal"></i>
                                </button>
                                <ul class="list-unstyled card-option dropdown-menu dropdown-menu-right">
                                    <li class="dropdown-item full-card"><a href="#!"><span><i class="feather icon-maximize"></i> maximize</span><span style="display:none"><i class="feather icon-minimize"></i> Restore</span></a></li>
                                    <li class="dropdown-item minimize-card"><a href="#!"><span><i class="feather icon-minus"></i> collapse</span><span style="display:none"><i class="feather icon-plus"></i> expand</span></a></li>
                                    <li class="dropdown-item close-card"><a href="#!"><i class="feather icon-trash"></i> remove</a></li>
                                    <li class="dropdown-item"><a id="btn-print"><i class="feather icon-printer"></i> print</a></li>
                                </ul>
                            </div>
                        </div>
                    </form>
                    <div class="card-body p-0">
                        <div class="table-responsive custom-scroll" style="max-height: 500px;">
                            <table class="table table-hover m-b-0" id="printTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>User</th>
                                        <th>Date</th>
                                        <th class="exclude-printed">IP Address</th>
                                        <th class="exclude-printed">Platform</th>
                                        <th>Type</th>
                                        <th class="exclude-printed">Map</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($activities as $key => $activity)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            <div>
                                                <img src="{{ asset('assets/images/user/'.$activity->avatar) }}" alt="Avatar" class="exclude-printed img-radius mr-2" width="25">
                                                {{ $activity->name }}
                                            </div>
                                        </td>
                                        <td>{{ indonesianDate($activity->activites_created_at) }}</td>
                                        <td class="exclude-printed">{{ $activity->ip_address }}</td>
                                        <td class="exclude-printed">
                                            {{ $activity->user_agent }}
                                        </td>
                                        <td>
                                            <span class="pcoded-badge badge badge-{{ ($activity->type == 'in') ? 'primary' : 'danger' }}">{{ $activity->type }}</span>
                                        </td>
                                        <td class="exclude-printed">
                                            <a href="https://maps.google.com/maps?q={{ $activity->latitude }},{{ $activity->longitude }}" target="__blank">
                                                <button type="button" class="btn btn-sm bg-c-purple text-white py-0 px-2">
                                                    <small>
                                                        <i class="feather icon-map-pin mr-1"></i>
                                                        Open Map
                                                    </small>
                                                </button>
                                            </a>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
<script>

  const labels = [
    'Attendance In',
    'With Permission',
    'Without Explanation',
  ];

  const data = {
    labels: labels,
    datasets: [{
      label: 'Chart',
      backgroundColor: ['#4099ff', '#ff9800', '#f44336'],
      borderColor: 'rgb(255, 99, 132)',
      data: [124, 423, 212],
      datalabels: {
          color: 'black',
          anchor: 'center',
        //   align: 'cen',
        //   offset: 10,
      }
    }]
  };

const data2 = {
  labels: [
    'Total Late Days',
    'Working Hours',
  ],
  datasets: [{
    label: 'Chart',
    data: [612, 933],
    datalabels: {
        color: 'black',
        anchor: 'center',
    //   align: 'cen',
    //   offset: 10,
    },
    backgroundColor: [
      'rgb(255, 99, 132)',
      'rgb(54, 162, 235)'
    ],
    hoverOffset: 4
  }]
};

const config = {
    type: 'bar',
    data: data,
    plugins: [ChartDataLabels],
    options: {
        plugins: {
            legend: {
                display: false,
            }
        }
    },
};
const config2 = {
    type: 'bar',
    data: data2,
    plugins: [ChartDataLabels],
    options: {
        plugins: {
            legend: {
                display: false,
            }
        }
    },
};
</script>
<script>
  const myChart = new Chart(
    document.getElementById('chart-1'),
    config
  );

  function change_chart_1(){
    var attendance_user_id = $("#attendance_user_id").val();
    var attendance_month = $("#attendance_month").val();
    var attendance_year = $("#attendance_year").val();
    var json_url = "{!! url('/') !!}/api/chart/attendance/"+attendance_user_id+"/"+attendance_month+"/"+attendance_year;

    ajax_chart(myChart, json_url);
  }
  change_chart_1();

  $('#attendance_user_id, #attendance_month, #attendance_year').change(() => {
      change_chart_1();
  });

function ajax_chart(chart, url, data) {
    var data = data || {};

    $.getJSON(url, data).done(function(response) {
        // chart.data.labels = response.labels;
        chart.data.datasets[0].data = response; // or you can iterate for multiple datasets
        // alert(response.data);
        chart.update(); // finally update our chart
    });
}


  const myChart2 = new Chart(
    document.getElementById('chart-2'),
    config2
  );

  function change_chart_2(){
    var discipline_user_id = $('#discipline_user_id').val();
    var discipline_month = $('#discipline_month').val();
    var discipline_year = $('#discipline_year').val();
    var json_url = "{!! url('/') !!}/api/chart/discipline/"+discipline_user_id+"/"+discipline_month+"/"+discipline_year;

    ajax_chart(myChart2, json_url);
  }

  change_chart_2();

  $('#discipline_user_id, #discipline_month, #discipline_year').change(() => {
      change_chart_2();
  });
</script>
<script>
    

    let latitude = localStorage.getItem('latitude');
    let longitude = localStorage.getItem('longitude');
    $('#latitude').val(latitude);
    $('#longitude').val(longitude);

    function printData() {
        var divToPrint = document.getElementById("printTable");
        var string = '<style>h3{text-align:center;font-family:sans-serif;color:#444;-webkit-print-color-adjust: exact;}.badge-primary{color: white; background: #4099ff; padding: 1px 4px; border-radius: 5px; -webkit-print-color-adjust: exact;}.badge-danger{color: white; background: #ff5370; padding: 1px 4px; border-radius: 5px; -webkit-print-color-adjust: exact;}.table{width: 100%; font-family: sans-serif; color: #444; border-collapse: collapse; border: 1px solid #f2f5f7;}.table tr th{background: #35A9DB; -webkit-print-color-adjust: exact; color: #fff; font-weight: normal; text-align: left}.table, th, td{padding: 8px 20px; }.table tr:hover{background-color: #f5f5f5;}.table tr:nth-child(even){background-color: #f2f2f2; -webkit-print-color-adjust: exact; }</style>';

        string  += '<h3>Alatan Indonesia User Attendance Report</h3>';
        
        newWin = window.open("");

        newWin.document.write(string + divToPrint.outerHTML);

        const removeElements = (elms) => elms.forEach(el => el.remove());
        removeElements(newWin.document.querySelectorAll(".exclude-printed"));
        newWin.print();
        newWin.close();
    }

    $('#btn-print').click(function(){
        printData();
    });
</script>
@endsection
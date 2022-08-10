@extends('layouts.main')

@section('custom-asset')
<style>
    .hidden {
        display: none;

    }
</style>
@endsection

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">

        <!-- <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Dashboard</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i> Dashboard</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div> -->


        <div class="row">
            

        <div class="col-xl-4 col-lg-12">
                <div class="row">

                    <div class="card user-card" style="min-width: 100%;">
                        <div class="card-header">
                            <h5>Profile</h5>
                        </div>
                        <div class="card-body">
                            <div class="usre-image">
                                <img src="{{ asset('assets/images/user/'.Auth::user()->avatar) }}" width="100" class="img-radius" alt="User-Profile-Image">
                            </div>
                            <h6 class="f-w-600 m-t-15 m-b-10">{{ Auth::user()->name }}</h6>
                            <p class="text-muted">{{ Auth::user()->job_title }}</p>
                            <hr />
                            <p class="m-t-15 text-muted py-3">{{ Auth::user()->bio }}</p>
                            <hr />
                            <div class="row justify-content-center user-social-link">
                                <div class="col-auto"><a href="{{ Auth::user()->facebook }}" target="_blank"><i class="fab fa-facebook text-facebook"></i></a></div>
                                <div class="col-auto"><a href="{{ Auth::user()->twitter }}" target="_blank"><i class="fab fa-twitter text-twitter"></i></a></div>
                                <div class="col-auto"><a href="{{ Auth::user()->instagram }}" target="_blank"><i class="fab fa-instagram text-c-red"></i></a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Feeds -->
            <div class="col-lg-4 col-md-12">
                <div class="hidden" id="news"></div>

                <div class="card">
                    <div class="card-header">
                        <h5>Instagram Feeds</h5>
                    </div>
                    <div class="card-body">
                        <div class="popular-img-block" id="feeds">

                        </div>
                        <div class="text-center m-t-15">
                            <button class="btn btn-outline-primary btn-round btn-sm" onclick='window.open("https://instagram.com/alatanindonesia", "_blank")'>Visit Account</button>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Total -->
            <div class="col-xl-4 col-lg-12">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card seo-card">
                            <img src="{{ asset('assets/images/night-city.jpg') }}" alt="seo bg" class="img-fluid">
                            <div class="overlay-bg"></div>
                            <div class="card-body seo-content">
                                <h6 class="text-white" id="weather-city">Jakarta Pusat</h6>
                                <p class="m-b-5 m-t-15">
                                    <i class="feather icon-sun text-c-yellow m-r-4"></i>
                                    <span id="weather-temperature">25 C°</span>
                                </p>
                                <p class="m-b-0" id="weather-desc">Cerah</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="card prod-p-card bg-c-purple">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-b-5 text-white">Working Days</h6>
                                        <h3 class="m-b-0 text-white">{{ workingDays(Auth::user()->id) }} <small>Days</small></h3>
                                    </div>
                                    <div class="col-auto">
                                        <i class="feather icon-calendar text-white"></i>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="card prod-p-card bg-c-blue">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-b-5 text-white">Your Files</h6>
                                        <h3 class="m-b-0 text-white">{{ myFiles(Auth::user()->id) }} <small>Files</small></h3>
                                    </div>
                                    <div class="col-auto">
                                        <i class="feather icon-file text-white"></i>
                                    </div>
                                </div>

                            </div>
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
    // Weather
    $.ajax({
        type: "GET",
        url: "/api/weather",
        success: function(response){
            var weather = response.data.weather[1];
            $('#weather-city').html(weather["Kota"]);
            $('#weather-desc').html(weather["Dini Hari"]);
            $('#weather-temperature').html(weather["Suhu"] + " C°");
        }
    });

    // Hot News
    $.ajax({
        type: "GET",
        url: "https://newsapi.org/v2/top-headlines?country=id&apiKey=d3c3ac643551434988ef2951a1997f6e",
        success: function(response) {
            var options = {
                year: "numeric",
                month: "long",
                day: "numeric"
            };
            var articles = response.articles;
            var template = '<div class="card bg-facebook social-card"> <div class="card-body"><div id="fb-slider" class="social-slider carousel slide" data-ride="carousel">';
            var items = '<div class="carousel-inner">';
            var indicators = '<ol class="carousel-indicators position-relative mb-0">';
            $.each(articles, function(index, article) {
                if (index <= 5) {
                    var active = (index == 0) ? "active" : "";
                    var date = new Date(article.publishedAt).toLocaleString(undefined, options);

                    items += '<div class="carousel-item ' + active + '"><div class="row"><div class="col align-self-start"><h6 class="text-white mb-3">Hot News</h6></div><div class="col align-self-start text-right"><span style="cursor: pointer" onclick="window.open(\'' + article.url + '\', \'_blank\')">' + article.source.name + '</span></div></div><p class="m-t-10">' + article.title + '</p><p class="m-t-10 m-b-0"><small>' + date + '</small></p></div>';

                    indicators += '<li data-target="#fb-slider" data-slide-to="' + index + '" class="' + active + '"></li>';
                }
            });

            indicators += '</ol>';
            items += '</div>';
            template += items;
            template += indicators;
            template += '</div></div></div>';
            $('#news').removeClass('hidden');
            $('#news').append(template);
        },
    });

    // Instagram Feeds
    $.ajax({
        type: "GET",
        url: "/api/instagram/feeds/alatanindonesia",
        beforeSend: function() {
            $('#feeds').html('<div class="spinner-border spinner-border-sm" role="status"><span class="sr-only">Please wait ...</span></div> <span class="ml-1">Please wait ...</span>');
        },
        success: function(response) {
            $('#feeds').html('');
            $.each(response.data.medias, function(index, media) {
                if(index <= 7){
                    var template = '<a href="' + media["url"] + '" target="__blank"><img class="img-fluid" src="' + media["thumbnail"] + '" alt="Gallery-' + index + '"></a>';
                    $('#feeds').append(template);
                }
            });
        },
        error: function() {
            $('#feeds').html('<div class="alert alert-danger" role="danger"><h4 class="alert-heading">Uh Aw! Sorry</h4><p>Fetching Instagram API currently not available for this momment. Please try again later!</p><hr><p class="mb-0">This is happen because you\'re requesting too many times. You can simply visit Alatan\'s Instagram by clicking button below.</p></div>');
        }
    });
</script>
@endsection
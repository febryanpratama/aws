<script src="{{ asset('assets/js/vendor-all.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/pcoded.min.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(!Auth::guest())
<script>
var id = {!! Auth::user()->id !!};
$.ajax({
	type: 'GET',
	url: '/api/notifications/'+id,
	success: function(response){
		$('#notifications').html('');
		$.each(response.data, function(index, notification){
			var template = '<li class="notification"> <div class="media"> <img class="img-radius" src="/assets/images/user/'+notification["avatar"]+'" alt="Avatar"> <div class="media-body"> <p><strong>'+notification["name"]+'</strong><span class="n-time text-muted"><i class="icon feather icon-clock m-r-10"></i>'+notification["datetime"]+'</span></p><p>'+notification["message"]+'</p></div></div></li>';
			$('#notifications').append(template);
		});
		if(response.data.length == 0){
			$('#notifications').html('<li class="notification text-center py-3"><b>There is no notification for you.</b></li>');
		}
	}
});
</script>
@endif

<script>
    MIN_ACCEPTABLE_ACCURACY = 20; // Minimum accuracy in metres that is acceptable as an "accurate" position

    if (!navigator.geolocation) {
        console.warn("Geolocation not supported by the browser");
    }

    navigator.geolocation.watchPosition(function(position) {

        if (position.accuracy > MIN_ACCEPTABLE_ACCURACY) {
            console.warn("Position is too inaccurate; accuracy=" + position.accuracy);
        } else {
            // Do something with the position

            // This is the current position of your user
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;
            localStorage.setItem("latitude", latitude);
            localStorage.setItem("longitude", longitude);
        }

    }, function(error) {
        switch (error.code) {
            case error.PERMISSION_DENIED:
                console.error("User denied the request for Geolocation.");
                break;
            case error.POSITION_UNAVAILABLE:
                console.error("Location information is unavailable.");
                break;
            case error.TIMEOUT:
                console.error("The request to get user location timed out.");
                break;
            case error.UNKNOWN_ERROR:
                console.error("An unknown error occurred.");
                break;
        }
    }, {
        timeout: 30000, // Report error if no position update within 30 seconds
        maximumAge: 30000, // Use a cached position up to 30 seconds old
        enableHighAccuracy: true // Enabling high accuracy tells it to use GPS if it's available  
    });
    // if (navigator.geolocation) {
    //     navigator.geolocation.getCurrentPosition(function(position){
    //         localStorage.setItem("latitude", position.coords.latitude);
    //         localStorage.setItem("longitude", position.coords.longitude);
    //     });
    // }
</script>

@if(Session::get('modal'))
<script>
    Swal.fire('{!! Session::get("modal_title") !!}', '{!! Session::get("modal_message") !!}', '{!! Session::get("modal_type") !!}');
</script>
@endif

@if(!Auth::guest())
<script src="assets/js/menu-setting.min.js"></script>
@endif
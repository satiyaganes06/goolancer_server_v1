@extends('admin.admin_dashboard')
@section('admin_content')
<style>
    
    .container {
        max-width: 600px;
        padding: 20px;
    }
    .container h1 {
        font-size: 48px;
        margin: 0;
    }
    .container p {
        font-size: 18px;
    }
    .container .countdown {
        font-size: 24px;
        margin-top: 20px;
    }
</style>

<div class="page-content">
    
    <div class="container text-center mt-5">
        <h1>Coming Soon</h1>
        <p>Our website is under construction. We'll be here soon with our new awesome site.</p>
        <div class="countdown" id="countdown"></div>
    </div>

</div>
    <script>
        // Set the date we're counting down to
        var countDownDate = new Date("Jul 1, 2024 00:00:00").getTime();

        // Update the count down every 1 second
        var x = setInterval(function() {
            var now = new Date().getTime();
            var distance = countDownDate - now;

            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById("countdown").innerHTML = days + "d " + hours + "h "
            + minutes + "m " + seconds + "s ";

            if (distance < 0) {
                clearInterval(x);
                document.getElementById("countdown").innerHTML = "EXPIRED";
            }
        }, 1000);
    </script>
@endsection

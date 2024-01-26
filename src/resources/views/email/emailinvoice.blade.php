<!DOCTYPE html>

<html>

<head>

    <title>{{$title}}</title>

</head>

<body>

    <div>

        <div>

            <p>Dear <b>{{$customer_name}}</b>,</p>



            <p>We are pleased to confirm that we have received your Booking.</p>



            <p><b>Booking Details</b></p>



            Booking Number : <b>#{{$booking_number}}</b><br>

            Pickup-Date : <b>{{$checkin_date}}</b><br>

            PickupIn Time : <b>{{$checkin_date}}</b><br>

            Pickup location : <b>{{$checkin_location}}</b><br>

            Dropoff Date : <b>{{$checkout_date}}</b><br>

            Dropoff Time : <b>{{$checkout_time}}</b><br>

            Dropoff Location : <b>{{$checkout_location}}</b><br>

            Total Amount : <b>{{helper::currency_formate($grand_total,$vendor_id)}}</b><br>
            <p>Click here : <a href="{{ $traceurl }}">Track Order Details</a></p>
            <p>Thank you for choosing <b>{{$company_name}}</b>.</p>
            <p>Sincerely,<br>
            {{$company_name}}
            </p>

        </div>

    </div>

</body>

</html>
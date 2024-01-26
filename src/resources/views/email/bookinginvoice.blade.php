<!DOCTYPE html>
<html>
<head>
    <title>{{$title}}</title>
</head>
<body>
    <div>
        <div>
            <p>Dear <b>{{ $customer_name }}</b>,</p>

            <p>We are writing to confirm that you have received new Booking.</p>

            <p><b>Booking Details</b></p>

            Booking Number : <b>#{{$booking_number}}</b><br>
            checkIn-Date : <b>{{$checkin_date}}</b><br>
            checkIn Time : <b>{{$checkin_date}}</b><br>
            checkIn location : <b>{{$checkin_location}}</b><br>
            checkOut Date : <b>{{$checkout_date}}</b><br>
            checkOut Time : <b>{{$checkout_time}}</b><br>
            checkOut Location : <b>{{$checkout_location}}</b><br>
            Total Amount : <b>{{helper::currency_formate($grand_total,$vendor_id)}}</b><br>

            <p>Sincerely,<br>
            {{$customer_name}}
            </p>
        </div>
    </div>
</body>
</html>

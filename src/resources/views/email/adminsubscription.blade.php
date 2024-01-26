<!DOCTYPE html>
<html>
<head>
    <title>{{$title}}</title>
</head>
<body>
    <div>
        <div style="background:#ffffff;padding:15px">
            <p>Dear <b>{{$admin_name}}</b>,</p>

            <p>I am writing to inform you that a new subscription has been purchased for our service. The details of the subscription are as follows:</p>

            Name of Subscriber: <b>{{$vendor_name}}</b><br><br>
            Subscription Plan: <b>{{$plan_name}}</b><br>
            Subscription Duration: <b>{{$duration}}</b><br>
            Subscription Cost: <b>{{$price}}</b><br><br>

            Payment Method: <b>{{$payment_method}}</b><br>
            Transaction ID: <b>{{$transaction_id}}</b><br>

            <p>The payment for the subscription has been successfully processed, and the subscriber is now able to access the features of their subscription.</p>

            <p>Best regards,</p>

            {{$vendor_name}}<br>
            {{$vendor_email}}
        </div>
    </div>
</body>
</html>

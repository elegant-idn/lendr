<!DOCTYPE html>
<html>
<head>
    <title>{{$title}}</title>
</head>
<body>
    <div>
        <div style="background:#ffffff;padding:15px">
            <p>Dear <b>{{$vendor_name}}</b>,</p>

            <p>I am writing to inform you that your recent bank transfer request has been rejected. After careful review of your account and the transaction, we have identified a some issues.</p>

            <p>Here are the details of your purchase:</p>

            Subscription Plan: <b>{{$plan_name}}</b><br>
            Payment Method: <b>{{$payment_method}}</b><br>

            <p>You can take benefits of our online payment system</p>

            <p>If you have any questions or concerns regarding your subscription, please do not hesitate to contact our customer support team. We are always available to assist you with any queries you may have.</p>

            <p>Thank you once again for choosing us as your preferred service provider. We look forward to providing you with the best experience possible.</p>

            <p>Sincerely,</p>

            {{$admin_name}}<br>
            {{$admin_email}}
        </div>
    </div>
</body>
</html>

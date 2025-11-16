<!DOCTYPE html>
<html>

<head>
    <title>Verify Event</title>
</head>

<body>
    <div class="greeting" style="margin-bottom : 20px">
        <span>
            <strong>Dear Mr/Mrs {{ $toName }},</strong>
        </span>
    </div>
    <div class="body">
        Event {{ $eventNumber }} <br>
        {{ $eventTitle }} <br>
        Need to be verified by you, Please click link this to detail <br>
        <a href="{{ $url }}">Detail</a>
    </div><br>

    <div class="thanks" style="margin-top:20px">
        <span>
            Best Regards,<br><strong>{{ config('app.name') }}</strong>
        </span>
    </div>
</body>

</html>

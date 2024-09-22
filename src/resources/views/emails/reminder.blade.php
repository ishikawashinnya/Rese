<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>予約リマインダー</title>
</head>
<body>
    <header>
        <h2>Reseからのお知らせ</h2>
    </header>

    <main>
        <h3>{{ $reservation->user->name }}様</h3>
        <p>
            この度はReseをご利用いただき、誠にありがとうございます。<br>
            ご予約当日となりますので、メールにてお知らせいたします。
        </p>

        <p><strong>ご予約内容</strong></p>

        <p>ご予約店舗: {{$reservation->shop->name }}</p>
        <p>ご予約日: {{$reservation->reservation_date }}</p>
        <p>ご予約時間: {{ \Carbon\Carbon::parse($reservation->reservation_time)->format('H:i') }}</p>
        <p>ご予約人数: {{$reservation->reservation_num }}名様</p>
        
        <p>ご来店いただいた際に、下記QRコードをスキャンしてお手続きをいたしますので、ご提示をお願いいたします。</p>
        {!! $qrCode !!}

        <p>ご来店心よりお待ちしております。</p>
    </main>  
</body>
</html>
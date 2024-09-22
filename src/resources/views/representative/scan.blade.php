<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rese QRコードスキャン</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/representative/scan.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/jsqr/dist/jsQR.js"></script>
</head>
<body>
    <div class="scan__content">
        <div class="content__ttl">
            <h2>QRコードをスキャンしてください</h2>
        </div>
        <video id="video"></video>
        <p id="result"></p>
        <div class="return__link">
            <a href="{{ route('mypage') }}" class="back__button">戻る</a>
        </div>
    </div>

    <script>
        const video = document.getElementById('video');
        const resultText = document.getElementById('result');


        navigator.mediaDevices.getUserMedia({ video: {facingMode: "environment" } })
            .then(stream => {
                video.srcObject = stream;
                video.setAttribute("playsinline", true);
                video.play();
                requestAnimationFrame(scan);
            })
            .catch(err => {
            console.error("カメラの起動に失敗しました:", err);
        });

        let scanning = true;

        function scan() {
            if (video.readyState === video.HAVE_ENOUGH_DATA) {
                const canvas = document.createElement('canvas');
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;

                const context = canvas.getContext('2d');
                context.drawImage(video, 0, 0, canvas.width, canvas.height);

                const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
                const code =jsQR(imageData.data, canvas.width, canvas.height);

                if (code) {
                    resultText.innerText = `QRコードの内容: ${code.data}`;

                    if (isValidURL(code.data)) {
                    window.location.href = code.data;
                    } else {
                    alert('有効なURLではありません。')
                    }

                    scanning = false;
                }
            }

            if (scanning) {
                requestAnimationFrame(scan); 
            } 
        }

        function isValidURL(string) {
            try {
                new URL(string);
                return true;
            } catch (_) {
                return false;
            }
        }

        function confirmVisit(reservationId) {
            fetch(`/reservation/check/${reservationId}`)
                .then(response => response.json())
                .then(data => {
                    alert("来店確認が完了しました");
                    resultText.innerText = data.message;
                    stopVideoStream();
                })
                .catch(error => {
                    console.error("来店確認中にエラーが発生しました:", error);
                });
        }

        function stopVideoStream() {
            const stream = video.srcObject;
            const tracks = stream.getTracks();
            tracks.forEach(track => track.stop());
            video.srcObject = null;
        }
    </script>
</body>
</html>
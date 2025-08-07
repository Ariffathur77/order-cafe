<!DOCTYPE html>
<html>

<head>
    <title>Bayar Pesanan</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>

    <button id="pay-button">Bayar dengan QRIS</button>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>
    <script>
        document.getElementById('pay-button').addEventListener('click', function() {
            fetch("{{ route('payment.token') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'),
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({}) // kirim data jika perlu
                })
                .then(response => response.json())
                .then(data => {
                    snap.pay(data.token);
                });
        });
    </script>

</body>

</html>

<!DOCTYPE html>
<html>
<head>
    <title>Struk Pembayaran</title>
    <style>
        body {
            font-family: monospace;
            width: 300px;
            margin: auto;
        }
        .center {
            text-align: center;
        }
        hr {
            border: 1px dashed #000;
        }
    </style>
</head>
<body onload="window.print()">

    <div class="center">
        <h4>PERPUSTAKAAN</h4>
        <p>Bukti Pembayaran</p>
    </div>

    <hr>

    <p>Nama : {{ $p->user->name }}</p>
    <p>Buku : {{ $p->buku->judul_buku }}</p>
    <p>Tanggal : {{ $p->tanggal_bayar ?? '-' }}</p>

    <hr>

    <p>Kondisi : {{ ucfirst($p->kondisi_buku ?? '-') }}</p>
    <p>Denda : Rp {{ number_format($p->denda) }}</p>
    <p>Metode : {{ ucfirst($p->metode_pembayaran) }}</p>

    <hr>

    <div class="center">
        <p>Terima Kasih 🙏</p>
    </div>

</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <title>Cetak PDF Laporan</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        .header { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <h2>NA CELLULER - LAPORAN PENGELUARAN</h2>
        <p>Periode: <?= $awal ?> s/d <?= $akhir ?></p>
    </div>
    <table>
        <thead>
            <tr><th>No</th><th>Tanggal</th><th>Invoice</th><th>Barang</th><th>Qty</th><th>Total</th></tr>
        </thead>
        <tbody>
            <?php $i=1; $total=0; foreach($data as $d): $total+=$d['total_harga']; ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= $d['tgl_keluar'] ?></td>
                <td><?= $d['no_invoice'] ?></td>
                <td><?= $d['nama_barang'] ?></td>
                <td><?= $d['qty_jual'] ?></td>
                <td>Rp <?= number_format($d['total_harga']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr><th colspan="5">GRAND TOTAL</th><th>Rp <?= number_format($total) ?></th></tr>
        </tfoot>
    </table>
</body>
</html>
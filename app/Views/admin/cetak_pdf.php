<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuntungan - NA Celluler</title>
    <style>
        body { font-family: 'Helvetica', Arial, sans-serif; color: #333; font-size: 12px; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header h2 { margin: 0; font-size: 20px; text-transform: uppercase; }
        .header p { margin: 2px 0; }
        
        .info-table { width: 100%; margin-bottom: 15px; }
        
        table.main-table { width: 100%; border-collapse: collapse; }
        table.main-table th { background-color: #f2f2f2; border: 1px solid #000; padding: 8px; text-transform: uppercase; font-size: 11px; }
        table.main-table td { border: 1px solid #000; padding: 8px; }
        
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .fw-bold { font-weight: bold; }
        .bg-laba { background-color: #e8f5e9; font-weight: bold; } /* Hijau Muda untuk Laba */
        
        .footer-sign { margin-top: 50px; width: 100%; }
        .sign-box { float: right; width: 200px; text-align: center; }
        .sign-space { height: 70px; }
        
        @media print {
            @page { margin: 1cm; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="header">
        <h2>NA CELLULER</h2>
        <p>Jl. Padang Rajo, Kec.Kinali, Kab.Pasaman Barat</p>
        <p style="font-size: 16px; font-weight: bold; margin-top: 10px;">LAPORAN KEUNTUNGAN BERSIH (LABA RUGI)</p>
    </div>

    <table class="info-table">
        <tr>
            <td width="15%">Periode Laporan</td>
            <td>: <strong><?= date('d/m/Y', strtotime($awal)) ?> s/d <?= date('d/m/Y', strtotime($akhir)) ?></strong></td>
            <td width="15%" class="text-right">Tanggal Cetak</td>
            <td width="20%" class="text-right">: <?= date('d/m/Y H:i') ?></td>
        </tr>
    </table>

    <table class="main-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Barang</th>
                <th>Qty</th>
                <th>Modal (Total)</th>
                <th>Jual (Total)</th>
                <th>Laba Bersih</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $i = 1; 
            $grand_modal = 0; 
            $grand_jual = 0; 
            $grand_laba = 0; 

            foreach($data as $d): 
                $total_modal = $d['qty_jual'] * $d['harga_beli_akhir'];
                $total_jual  = $d['total_harga'];
                $laba_bersih = $total_jual - $total_modal;

                $grand_modal += $total_modal;
                $grand_jual  += $total_jual;
                $grand_laba  += $laba_bersih;
            ?>
            <tr>
                <td class="text-center"><?= $i++ ?></td>
                <td class="text-center"><?= date('d/m/y', strtotime($d['tgl_keluar'])) ?></td>
                <td><?= $d['nama_barang'] ?></td>
                <td class="text-center"><?= $d['qty_jual'] ?></td>
                <td class="text-right">Rp <?= number_format($total_modal, 0, ',', '.') ?></td>
                <td class="text-right">Rp <?= number_format($total_jual, 0, ',', '.') ?></td>
                <td class="text-right bg-laba">Rp <?= number_format($laba_bersih, 0, ',', '.') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr style="background-color: #eee; font-weight: bold;">
                <td colspan="4" class="text-right">TOTAL KESELURUHAN</td>
                <td class="text-right">Rp <?= number_format($grand_modal, 0, ',', '.') ?></td>
                <td class="text-right">Rp <?= number_format($grand_jual, 0, ',', '.') ?></td>
                <td class="text-right" style="background-color: #4caf50; color: white;">
                    Rp <?= number_format($grand_laba, 0, ',', '.') ?>
                </td>
            </tr>
        </tfoot>
    </table>

    <div style="margin-top: 20px;">
        <p><strong>Ringkasan Keuangan:</strong></p>
        <p>Berdasarkan data di atas, total keuntungan bersih yang didapatkan selama periode ini adalah sebesar 
           <strong>Rp <?= number_format($grand_laba, 0, ',', '.') ?></strong>.</p>
    </div>

        <div class="sign-box">
            <p>Disetujui Oleh,<br>Owners NA Celluler</p>
            <div class="sign-space"></div>
            <p><strong>( .................................... )</strong></p>
        </div>
        <div style="clear: both;"></div>
    </div>

</body>
</html>
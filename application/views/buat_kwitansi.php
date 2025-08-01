<div class="col-lg-12 font-cmu" style="background-image: url(<?= base_url("assets/dist/img/kwidig.jpg"); ?>);background-size:cover;width:21cm;height:15.4cm;background-position:center;margin-left:auto;margin-right:auto;" id="div_kwidig">
    <div style="position:relative;top:1.67cm;padding-right:8.10cm;text-align:right;font-size:14px;font-weight:bold;font-family:verdana;color:red;"><?= sprintf("%08d", $jpt_kw_nomor); ?></div>
    <div style="position:relative;top:1.85cm;padding-right:8.10cm;text-align:right;font-size:14px;font-weight:bold;font-family:verdana;"><?= date("d/m/Y", strtotime($jpt_tgl_jemput)); ?></div>
    <div style="position:relative;top:4.5cm;padding-left:1.3cm;text-align:left;"><?= ucwords(strtolower($don_nama)); ?></div>
    <div style="position:relative;top:5.50cm;padding-left:1.3cm;text-align:left;"><?= "{$don_wa}"; ?></div>
    <div style="position:relative;top:6.20cm;padding-left:1.4cm;text-align:left;font-size:16px;">&#10004;</div>
    <div style="position:relative;top:5.65cm;padding-left:3.5cm;text-align:left;">Kotak Infaq</div>
    <div style="position:relative;top:5.20cm;padding-right:7.1cm;text-align:right;"><?= number_format($jml, 0, ",", "."); ?></div>
    <div style="position:relative;top:2.65cm;padding-right:3.90cm;text-align:right;"><?= isset($arrPecahan[100]) ? $arrPecahan[100] : "&nbsp;"; ?></div>
    <div style="position:relative;top:2.65cm;padding-right:3.90cm;text-align:right;"><?= isset($arrPecahan[200]) ? $arrPecahan[200] : "&nbsp;"; ?></div>
    <div style="position:relative;top:2.66cm;padding-right:3.90cm;text-align:right;"><?= isset($arrPecahan[500]) ? $arrPecahan[500] : "&nbsp;"; ?></div>
    <div style="position:relative;top:2.66cm;padding-right:3.90cm;text-align:right;"><?= isset($arrPecahan[1000]) ? $arrPecahan[1000] : "&nbsp;"; ?></div>
    <div style="position:relative;top:2.7cm;padding-right:3.90cm;text-align:right;"><?= isset($arrPecahan[2000]) ? $arrPecahan[2000] : "&nbsp;"; ?></div>
    <div style="position:relative;top:2.73cm;padding-right:3.90cm;text-align:right;"><?= isset($arrPecahan[5000]) ? $arrPecahan[5000] : "&nbsp;"; ?></div>
    <div style="position:relative;top:2.73cm;padding-right:3.90cm;text-align:right;"><?= isset($arrPecahan[10000]) ? $arrPecahan[10000] : "&nbsp;"; ?></div>
    <div style="position:relative;top:2.74cm;padding-right:3.90cm;text-align:right;"><?= isset($arrPecahan[20000]) ? $arrPecahan[20000] : "&nbsp;"; ?></div>
    <div style="position:relative;top:2.74cm;padding-right:3.90cm;text-align:right;"><?= isset($arrPecahan[50000]) ? $arrPecahan[50000] : "&nbsp;"; ?></div>
    <div style="position:relative;top:2.77cm;padding-right:3.90cm;text-align:right;"><?= isset($arrPecahan[100000]) ? $arrPecahan[100000] : "&nbsp;"; ?></div>
    <div style="position:relative;top:2.0cm;padding-right:7.1cm;text-align:right;font-weight:bold;"><?= number_format($jml, 0, ",", "."); ?></div>
    <div style="position:relative;top:2.30cm;padding-left:3.30cm;text-align:left;font-weight:bold;"><?= terbilang($jml); ?> Rupiah</div>
    <div style="position:relative;top:3.3cm;left:4.5cm;background-image: url(<?= base_url("assets/files/spesimen/{$penyetor->sps_foto}"); ?>);background-size:contain;background-repeat:no-repeat;width:3cm;height:1.5cm;"></div>
    <div style="position:relative;top:2.9cm;right:5.6cm;text-align:center;font-weight:bold;"><?= $penyetor ? $penyetor->sps_nama : ""; ?></div>
    <div style="position:relative;top:1.30cm;left:8cm;background-image: url(<?= base_url("assets/files/spesimen/{$penerima->sps_foto}"); ?>);background-size:contain;background-repeat:no-repeat;width:3cm;height:1.5cm;"></div>
    <div style="position:relative;top:0.9cm;right:2.5cm;text-align:center;font-weight:bold;"><?= $penerima ? $penerima->sps_nama : ""; ?></div>
    <div id="stempel" style="position:relative;top:-0.6cm;left:6.8cm;transform:rotate(-20deg); background-image: url(<?= base_url("assets/dist/img/logo.png"); ?>);background-size:contain;background-repeat:no-repeat;width:1.6cm;height:1.6cm;"></div>
</div>
<div class="col-lg-12 col-xs-12 text-center">
    <img src="" id="hasil_kwidig" style="display:none;">
</div>

<script src="<?= base_url("assets"); ?>/plugins/jquery/jquery.min.js"></script>
<script src="<?= base_url("assets/"); ?>dist/js/html2canvas.js"></script>
<script>
    html2canvas($("#div_kwidig").get(0)).then(function(canvas) {
        var myImage = canvas.toDataURL("image/png", 1);
        $.post("<?= base_url() ?>" + "Kwitansi/simpan_kwitansi", {
            jpt_id: <?= $jpt_id ?>,
            foto: myImage
        }, function(d) {
            if (d) {
                $("#hasil_kwidig").attr("src", myImage);
                $("#div_kwidig").hide();
                $("#hasil_kwidig").show();
                document.location.href = "../tampil";
            }
        });
    });
</script>

<?php
function terbilang($angka)
{
    // pastikan kita hanya berususan dengan tipe data numeric
    $angka = (float)$angka;

    // array bilangan 
    // sepuluh dan sebelas merupakan special karena awalan 'se'
    $bilangan = array(
        '',
        'Satu',
        'Dua',
        'Tiga',
        'Empat',
        'Lima',
        'Enam',
        'Tujuh',
        'Delapan',
        'Sembilan',
        'Sepuluh',
        'Sebelas'
    );

    // pencocokan dimulai dari satuan angka terkecil
    if ($angka < 12) {
        // mapping angka ke index array $bilangan
        return $bilangan[$angka];
    } else if ($angka < 20) {
        // bilangan 'belasan'
        // misal 18 maka 18 - 10 = 8
        return $bilangan[$angka - 10] . ' Belas';
    } else if ($angka < 100) {
        // bilangan 'puluhan'
        // misal 27 maka 27 / 10 = 2.7 (integer => 2) 'Dua'
        // untuk mendapatkan sisa bagi gunakan modulus
        // 27 mod 10 = 7 'Tujuh'
        $hasil_bagi = (int)($angka / 10);
        $hasil_mod = $angka % 10;
        return trim(sprintf('%s Puluh %s', $bilangan[$hasil_bagi], $bilangan[$hasil_mod]));
    } else if ($angka < 200) {
        // bilangan 'seratusan' (itulah indonesia knp tidak satu ratus saja? :))
        // misal 151 maka 151 = 100 = 51 (hasil berupa 'puluhan')
        // daripada menulis ulang rutin kode puluhan maka gunakan
        // saja fungsi rekursif dengan memanggil fungsi terbilang(51)
        return sprintf('Seratus %s', terbilang($angka - 100));
    } else if ($angka < 1000) {
        // bilangan 'ratusan'
        // misal 467 maka 467 / 100 = 4,67 (integer => 4) 'Empat'
        // sisanya 467 mod 100 = 67 (berupa puluhan jadi gunakan rekursif terbilang(67))
        $hasil_bagi = (int)($angka / 100);
        $hasil_mod = $angka % 100;
        return trim(sprintf('%s Ratus %s', $bilangan[$hasil_bagi], terbilang($hasil_mod)));
    } else if ($angka < 2000) {
        // bilangan 'seribuan'
        // misal 1250 maka 1250 - 1000 = 250 (ratusan)
        // gunakan rekursif terbilang(250)
        return trim(sprintf('Seribu %s', terbilang($angka - 1000)));
    } else if ($angka < 1000000) {
        // bilangan 'ribuan' (sampai ratusan ribu
        $hasil_bagi = (int)($angka / 1000); // karena hasilnya bisa ratusan jadi langsung digunakan rekursif
        $hasil_mod = $angka % 1000;
        return sprintf('%s Ribu %s', terbilang($hasil_bagi), terbilang($hasil_mod));
    } else if ($angka < 1000000000) {
        // bilangan 'jutaan' (sampai ratusan juta)
        // 'satu puluh' => SALAH
        // 'satu ratus' => SALAH
        // 'satu juta' => BENAR 
        // @#$%^ WT*

        // hasil bagi bisa satuan, belasan, ratusan jadi langsung kita gunakan rekursif
        $hasil_bagi = (int)($angka / 1000000);
        $hasil_mod = $angka % 1000000;
        return trim(sprintf('%s Juta %s', terbilang($hasil_bagi), terbilang($hasil_mod)));
    } else if ($angka < 1000000000000) {
        // bilangan 'milyaran'
        $hasil_bagi = (int)($angka / 1000000000);
        // karena batas maksimum integer untuk 32bit sistem adalah 2147483647
        // maka kita gunakan fmod agar dapat menghandle angka yang lebih besar
        $hasil_mod = fmod($angka, 1000000000);
        return trim(sprintf('%s Milyar %s', terbilang($hasil_bagi), terbilang($hasil_mod)));
    } else if ($angka < 1000000000000000) {
        // bilangan 'triliun'
        $hasil_bagi = $angka / 1000000000000;
        $hasil_mod = fmod($angka, 1000000000000);
        return trim(sprintf('%s Triliun %s', terbilang($hasil_bagi), terbilang($hasil_mod)));
    } else {
        return 'Wow...';
    }
}
?>
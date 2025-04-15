<?php
$hargaawal = isset($_POST['hargaawal']) ? $_POST['hargaawal'] : '';
$diskon = isset($_POST['diskon']) ? $_POST['diskon'] : '';
$currency = isset($_POST['currency']) ? $_POST['currency'] : 'IDR';

$hargadiskon = 0;
$hargatotal = 0;

function getCurrencySymbol($currency)
{
    switch ($currency) {
        case 'USD':
            return '$';
        case 'EUR':
            return '€';
        case 'JPY':
            return '¥';
        case 'IDR':
            return 'Rp';
        default:
            return '';
    }
}

$symbol = getCurrencySymbol($currency);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($hargaawal === "") {
        echo "<script>alert('Silahkan masukkan harga awal'); window.location='index1.php';</script>";
    } elseif ($diskon === "") {
        echo "<script>alert('Silahkan masukkan diskon barang'); window.location='index1.php';</script>";
    } elseif (!is_numeric($hargaawal) || !is_numeric($diskon)) {
        echo "<script>alert('Harga dan diskon harus berupa angka!'); window.location='index1.php';</script>";
    } elseif ($diskon > 100) {
        echo "<script>alert('Diskon Terlalu Banyak'); window.location='index1.php';</script>";
    } elseif ($diskon < 0) {
        echo "<script>alert('Diskon tidak valid'); window.location='index1.php';</script>";
    } else {
        $hargadiskon = ($hargaawal * $diskon) / 100;
        $hargatotal = $hargaawal - $hargadiskon;
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hitung Diskon</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: url('img/mall.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            background-color: #14f0ed;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }

        .form-box {
            background-color: #07939a;
            padding: 20px;
            border-radius: 8px;
        }

        .form-title {
            text-align: center;
            color: white;
            margin-bottom: 20px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 15px;
            color: white;
        }

        .label {
            flex: 1 0 35%;
            padding: 5px;
        }

        .input {
            flex: 1 0 65%;
            padding: 5px;
        }

        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 8px;
            border: none;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: rgb(240, 80, 44);
            color: black;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: rgb(200, 0, 23);
        }

        .hasil-box {
            background-color: rgb(173, 68, 36);
            margin-top: 20px;
            padding: 15px;
            border-radius: 5px;
            color: white;
        }

        .hasil-box h3 {
            text-align: center;
            margin-top: 0;
        }

        .hasil-item strong {
            font-size: 18px;
            color: rgb(24, 27, 30);
        }

        @media (max-width: 600px) {
            .row {
                flex-direction: column;
            }

            .label,
            .input {
                flex: 1 0 100%;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <center>
            <img src="img/tran.png" width="120" alt="logo">
        </center>
        <div class="form-box">
            <h2 class="form-title">Aplikasi Menghitung Diskon</h2>
            <form method="post" action="">
                <div class="row">
                    <div class="label"><label for="hargaawal">Harga Awal</label></div>
                    <div class="input">
                        <input type="number" name="hargaawal" id="hargaawal" min="0"
                            value="<?php echo htmlspecialchars($hargaawal); ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="label"><label for="diskon">Diskon (%)</label></div>
                    <div class="input">
                        <input type="number" name="diskon" id="diskon" min="0" max="100"
                            value="<?php echo htmlspecialchars($diskon); ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="label"><label for="currency">Mata Uang</label></div>
                    <div class="input">
                        <select name="currency" id="currency">
                            <option value="IDR" <?php if ($currency == 'IDR')
                                echo 'selected'; ?>>IDR (Rupiah)</option>
                            <option value="USD" <?php if ($currency == 'USD')
                                echo 'selected'; ?>>USD (Dollar)</option>
                            <option value="EUR" <?php if ($currency == 'EUR')
                                echo 'selected'; ?>>EUR (Euro)</option>
                            <option value="JPY" <?php if ($currency == 'JPY')
                                echo 'selected'; ?>>JPY (Yen)</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="input" style="margin-left: auto;">
                        <input type="submit" value="Hitung">
                    </div>
                </div>
            </form>

            <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && is_numeric($hargaawal) && is_numeric($diskon) && $diskon >= 0 && $diskon <= 100): ?>
                <div class="hasil-box">
                    <h3>Hasil Perhitungan</h3>
                    <div class="hasil-item">Harga Awal: <?php echo $symbol . ' ' . number_format($hargaawal, 2); ?>
                        (<?php echo $currency; ?>)</div>
                    <div class="hasil-item">Diskon: <?php echo $diskon; ?>%</div>
                    <div class="hasil-item">Potongan Harga: <?php echo $symbol . ' ' . number_format($hargadiskon, 2); ?>
                    </div>
                    <div class="hasil-item">Harga Akhir:
                        <strong><?php echo $symbol . ' ' . number_format($hargatotal, 2); ?>
                            (<?php echo $currency; ?>)</strong>
                    </div>
                </div>
            <?php endif; ?>
            <center>
                <h4>Wiki Ramadan</h4>
                <h4>Xll RPL</h4>
            </center>
        </div>
    </div>
</body>

</html>
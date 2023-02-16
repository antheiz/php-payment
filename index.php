<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Integrasi midtrans di aplikasi payment sederhana</title>
</head>

<body>
    <?php $base = $_SERVER['REQUEST_URI']; ?>

    <h3>Keranjang kamu:</h3>
    <ul>
        <li>Ebook Belajar PHP Dasar = Rp80.000,</li>
        <li>Ebook Belajar PHP OOP = Rp50.000,</li>
    </ul>

    <h4>Total: Rp 130.000</h4>

    <form action="<?php echo $base ?>checkout-process.php" method="POST">
        <input type="hidden" name="amount" value="130000" />
        <button type="submit">Checkout</button>
    </form>

</body>

</html>
<?php
require "session.php";
require "../koneksi.php";

$queryKategori = mysqli_query($conn, "SELECT * FROM kategori");
$jumlahKategori = mysqli_num_rows($queryKategori);

$queryProduct = mysqli_query($conn, "SELECT * FROM product");
$jumlahProduct = mysqli_num_rows($queryProduct);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
</head>

<style>
    .kotak {
        border: solid;
    }

    .summary-kategori {
        background-color: #0e9e7e;
        border-radius: 10px;
    }

    .summary-produk {
        background-color: #0996bc;
        border-radius: 15px;
    }

    .no-decoration {
        text-decoration: none;
    }
</style>

<body>
    <?php require "navbar.php"; ?>

    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="fas fa-house me-2"></i> Home
                </li>
            </ol>
        </nav>
        <h1> Hallo <?php echo $_SESSION['username'] ?> </h1>

        <div class="container mt-4">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-12 mb-3">
                    <div class="summary-kategori p-3">
                        <div class="row">
                            <div class="col-6">
                                <i class="fas fa-list fa-6x text-black-50"></i>
                            </div>
                            <div class="col-6 text-light">
                                <h3 class="fs-2">Kategori</h3>
                                <p class="fs-4"><?php echo $jumlahKategori; ?> Kategori</p>
                                <a href="kategori.php" class="text-light no-decoration"> Lihat detail</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-col-12 mb-3">
                    <div class="summary-produk p-3">
                        <div class="row">
                            <div class="col-6">
                                <i class="fa-brands fa-shopify fa-6x text-black-50"></i>
                            </div>
                            <div class="col-6 text-light">
                                <h3 class="fs-2">Produk</h3>
                                <p class="fs-4"><?php echo $jumlahProduct; ?> Produk</p>
                                <a href="product.php" class="text-light no-decoration"> Lihat detail</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>



</body>
<script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../fontawesome/js/all.min.js"></script>

</html>
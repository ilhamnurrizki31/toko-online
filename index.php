<?php 
    require "koneksi.php";

    $queryProduct = mysqli_query($conn, "SELECT id, nama, harga, foto, detail FROM product Limit 6")
?>
<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content ="IE=edge" >
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Online | Home</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
    <?php require "navbar.php";?>

    <!-- banner -->
    <div class="container-fluid banner d-flex align-items-center">
        <div class="container text-center text-light">
            <h1>Toko Online Fashion</h1> 
            <h3>Mau cari apa</h3>
            <div class="col-md-6 offset-md-3">
                <form action="product.php" method="get">
                <div class="input-group input-group-lg my-3">
                    <input type="text" class="form-control" placeholder="Cari Produk" aria-label="Recipient's username" aria-describedby="basic-addon2" name="keyword">
                    <button type="submit" class="btn warna1 text-light">Telusuri</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Highlight Kategori -->
     <div class="container-fluid py-5 ">
        <div class="container text-center">
            <h2>Kategori Terlaris</h2>

            <div class="row mt-3 py-3">
                <div class="col-md-4 mb-3">
                    <div class="highlighted-kategori kategori-baju-pria d-flex justify-content-center align-items-center">
                    <h4 class="text-light"><a class="no-decoration" href="product.php?kategori=Baju Pria"> Baju Pria </a></h4>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="highlighted-kategori kategori-baju-wanita d-flex justify-content-center align-items-center">
                    <h4 class="text-light"><a class="no-decoration" href="product.php?kategori=Baju Wanita"> Baju Wanita </a></h4>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="highlighted-kategori kategori-sepatu d-flex justify-content-center align-items-center">
                    <h4 class="text-light"><a class="no-decoration" href="product.php?kategori=Sepatu"> Sepatu</a></h4>
                    </div>
                </div>
            </div>
        </div>
     </div>

     <!-- Tentang Kami  -->
      <div class="container-fluid warna2 py-5">
        <div class="container text-center">
            <h3>Tentang Kami</h3>
            <p class="fs-5 mt-3" >Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime ex officia vel. Vitae repellat mollitia sapiente, corporis expedita nihil temporibus recusandae voluptate ipsum possimus atque saepe dolorum eos placeat distinctio vel tenetur ullam dicta! Eveniet quam, veniam mollitia est perferendis repellat quis alias blanditiis, incidunt provident error saepe esse assumenda sunt quos explicabo quas dolores maiores dicta, laborum numquam iure unde fugiat ut! Harum illum nobis est? Deserunt ipsum labore fugit. Consequatur expedita enim facere laudantium pariatur amet, nulla soluta!</p>
        </div>
      </div>

    <!-- produk -->
    <div class="container-fluid py-5"> 
        <div class="container text-center">
            <h3>Produk</h3>
            <div class="row mt-5">
                <?php while($data = mysqli_fetch_array($queryProduct)) { ?>
                <div class="col-sm-6 col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="image-box">
                        <img src="image/<?php echo $data['foto']?>" class="card-img-top" alt="...">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $data['nama'] ?></h5>
                            <p class="card-text text-truncate"><?php echo $data['detail'] ?></p>
                            <p class="card-text text-harga">Rp <?php echo $data['harga'] ?> </p>
                            <a href="produk-detail.php?nama=<?php echo $data['nama'] ?>" class="btn warna2">Detail Produk</a>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <a class="btn btn-outline-primary mt-3" href="product.php">See More</a>
        </div>
    </div> 
    
    <!-- footer -->
    <?php require "footer.php"; ?>

</body>
<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="fontawesome/js/all.min.js"></script>

</html>
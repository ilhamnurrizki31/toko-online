
<?php
    require "koneksi.php";

    $queryKategori = mysqli_query($conn,"SELECT * FROM kategori");
   
    //get produk by keyword
    if (isset($_GET['keyword'])){
        $queryProduk = mysqli_query($conn, "SELECT * FROM product WHERE nama LIKE '%$_GET[keyword]%'");
    }
    //get produk by kategori 
    else if (isset($_GET['kategori'])){
        $queryGetKategoriId = mysqli_query($conn, "SELECT id From kategori where nama='$_GET[kategori]'");
        $kategoriId = mysqli_fetch_array($queryGetKategoriId);

        $queryProduk= mysqli_query($conn, "SELECT * FROM product WHERE kategori_id=$kategoriId[id]");
    }
    // get produk default 
    else {
        $queryProduk = mysqli_query($conn, "SELECT * FROM product");
    }
    $countData =  mysqli_num_rows($queryProduk);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Online | Kategori Produk</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
    <?php require "navbar.php"; ?>
     <div class="container py-5">
        <h1 class="text-center py-5" >Kategori</h1>
        <div class="row">
          <div class="col-lg-3 mb-5"> 
            <h3>Kategori</h3>
            <ul class="list-group">
                <?php while($kategori = mysqli_fetch_array($queryKategori)){ ?>
                <a class="no-decoration" href="product.php?kategori=<?php echo $kategori['nama'] ?>">    
                    <li class="list-group-item"> <?php echo $kategori['nama'] ?> </li>
                </a>
                <?php } ?>
            </ul>
          </div>
          <div class="col-lg-9">
           <h3 class="text-center mb-3">Produk</h3> 
           <div class="row">

            <?php
            if ($countData<1){
            ?>
                <h4 class="text-center my-5"> Produk tidak tersedia / Keyword tidak dapat ditemukan</h4>
            <?php      
                } 
            ?>
                <?php while($produk = mysqli_fetch_array($queryProduk)){ ?>
            <div class="col-md-4 mb-4">
            <div class="card h-100">
                        <div class="image-box">
                            <img src="image/<?php echo $produk ['foto'] ?>" class="card-img-top" alt="...">
                        </div>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $produk ['nama'] ?></h5>
                                <p class="card-text text-truncate"><?php echo $produk ['detail'] ?></p>
                                <p class="card-text text-harga">Rp <?php echo $produk ['harga'] ?></p>
                                <a href="produk-detail.php?nama=<?php echo $produk['nama'] ?>" class="btn warna2">Detail Produk</a>
                            </div>
                    </div>
                </div>
                <?php } ?>
           </div>
        </div>  
        </div>
     </div>   

    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/js/all.min.js"></script>
</body>
</html>
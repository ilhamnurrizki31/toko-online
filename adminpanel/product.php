<?php 
    require "session.php";
    require "../koneksi.php";   
    $queryProduct = mysqli_query($conn, "SELECT a.*, b.nama AS nama_kategori FROM product a JOIN kategori b ON a.kategori_id=b.id");
    $jumlahProduct = mysqli_num_rows($queryProduct);

    $queryKategorii = mysqli_query($conn, "SELECT * FROM kategori");

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
    
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
    
        return $randomString;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">

</head>

<style>
    .no-decoration{
        text-decoration: none;

    }

    form div{
        margin-bottom: 10px;
    }

</style>

<body>
    <?php require 'navbar.php' ?>
<div class="container mt-5">
    <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="index.php" class="no-decoration text-muted">
                        <i class="fas fa-house me-2">
                        </i> Home
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="fa-brands fa-shopify  me-2"></i> Product
                </li>
            </ol>
        </nav>

<!-- Form Tambah product -->
    <div class=" my-5 col-12 col-md-6"> 
    <h3>Tambah Produk</h3>

    <form action="" method="post" enctype="multipart/form-data">
        <div>
            <label for="nama"> Nama </label>
            <input type="text" id="nama" name="nama" class="form-control" autocomplete="off" required >
        </div>
        <div>
            <label for="kategori">Kategori</label>
            <select name="kategori" id="kategori" class="form-control" required> 
                <option value="">Pilih satu Kategori</option>
                <?php
                while($data=mysqli_fetch_array($queryKategorii)){
                    ?>
                    <option value="<?php echo $data['id'] ?>"> <?php echo $data['nama'] ?></option>
                    <?php
                }

                ?>
            </select>
        </div>
        
        <div>
            <label for="harga"> Harga </label>
            <input type="number" id="harga" name="harga" class="form-control" autocomplete="off" required>
        </div>

        <div>
            <label for="foto">Foto</label>
            <input type="file" name="foto" id="foto" class="form-control ">
        </div>

        <div>
            <label for="detail">Detail</label>
            <textarea name="detail" id="detail" cols="30" rows="10" class="form-control"></textarea>
        </div>
        
        <div>
            <label for="ketersediaan_stok"> Ketersediaan Stok</label>
            <select name="ketersediaan_stok" id="ketersediaan_stok" class="form-control">
                <option value="tersedia">Tersedia</option>
                <option value="habis">Habis</option>
            </select>
        </div>

        <div>
            <button class="btn btn-primary mt-3" type="submit" name="simpan_produk"> Simpan </button>
       </div>

    </form>
        <!-- Validasi form backend -->
    <?php
    if(isset($_POST['simpan_produk'])){
        $nama = htmlspecialchars($_POST['nama']);
        $kategori = htmlspecialchars($_POST['kategori']);
        $harga = htmlspecialchars($_POST['harga']);
        $detail = htmlspecialchars($_POST['detail']);
        $ketersediaan_stok = htmlspecialchars($_POST['ketersediaan_stok']);

        $target_dir = "../image/";
        $nama_file =basename($_FILES["foto"]["name"]);
        $target_file = $target_dir . $nama_file;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $image_size = $_FILES["foto"]["size"];
        $random_name = generateRandomString();
        $new_name = $random_name . "." . $imageFileType; 


        if($nama=='' || $kategori=='' ||$harga==''){
            ?>
             <div class="alert alert-warning mt-3" role="alert">
                      Nama Kategori harus diisi
            </div>
            <?php
        }else{

            if($nama_file!=''){
                if($image_size > 5000000){
            ?>
            <div class="alert alert-warning mt-3" role="alert">
                     File lebih dari 500kb
            </div>
            <?php
                }else{
                    if($imageFileType != 'jpg' && $imageFileType != 'jpeg' && $imageFileType != 'png' ){
                ?>
                <div class="alert alert-warning mt-3" role="alert">
                     File harus berupa jpg, jpeg, dan png
                </div>
            <?php
                    }else{
                        move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $new_name);
                    }
                }
            }

            // query untuk menyimpan kedalam database / insert product table
            $queryTambah = mysqli_query($conn, "INSERT INTO product (kategori_id, nama, harga, foto, detail, ketersediaan_stok) VALUES ('$kategori', '$nama', '$harga', '$new_name ', '$detail','$ketersediaan_stok')");
            
            if($queryTambah){
            ?>
            
            <div class="alert alert-success mt-3" role="alert">
                            Produk Berhasil tersimpan
                        </div>
                        <meta http-equiv="refresh" content="1; url =product.php ">
            <?php
            }else{
                echo mysqli_error($conn);
            }
            

        }
    }
    ?>

    </div>


        <div class="mt-3 mb-5">
            <h2>List Product</h2>
            <div class="table-responsive mt-5">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Ketersediaan Stock</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if($jumlahProduct == 0){
                            ?>
                                <tr>
                                    <td class="text-center" colspan="6" >Data Product tidak tersedia</td>
                                </tr>
                            <?php
                        }else {
                            $jumlah =1;
                            while($data = mysqli_fetch_array($queryProduct)){
                                ?>
                                <tr>
                                    <td> <?php echo $jumlah; ?> </td>
                                    <td> <?php echo $data['nama'] ?></td>
                                    <td> <?php echo $data['nama_kategori'] ?></td>
                                    <td> <?php echo $data['harga'] ?></td>
                                    <td> <?php echo $data['ketersediaan_stok'] ?></td>
                                    <td>
                                        <a href="product-detail.php?p=<?php echo $data['id']; ?>" class="btn btn-info"> <i class="fas fa-search"></i></a>
                                    </td>
                                </tr>
                                <?php
                                $jumlah++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    
</div>
</body>

<script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../fontawesome/js/all.min.js"></script>
</html>
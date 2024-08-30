<?php
    require "session.php";
    require "../koneksi.php";

    $id = $_GET['p'];
    $query = mysqli_query($conn, "SELECT a.*, b.nama AS nama_kategori FROM product a JOIN kategori b ON a.kategori_id=b.id WHERE a.id='$id'");
    $data = mysqli_fetch_array($query);

    $queryKategorii = mysqli_query($conn, "SELECT * FROM kategori WHERE id!='$data[kategori_id]'");

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
    <title>Detail Produk</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">

</head>

    <style>
        form div{
            margin-bottom: 10px
        }
    </style>


<body>
    <?php require 'navbar.php' ?>
    
    <div class="container mt-5">
        <h2>Detail Produk</h2>

            <div class="col-12 col-md-6">
                <form action="" method="post" enctype="multipart/form-data">
                    <div>
                        <label for="nama"> Nama </label>
                        <input type="text" id="nama" name="nama" value="<?php echo $data['nama']; ?>" class="form-control" autocomplete="off" required >
                    </div>
                    <div>
                        <label for="kategori">Kategori</label>
                        <select name="kategori" id="kategori" class="form-control" required> 
                                <option value="<?php echo $data['kategori_id']; ?>"><?php echo $data['nama_kategori'] ?></option>
                                <?php
                                while($dataKategori=mysqli_fetch_array($queryKategorii)){
                                ?>
                                    <option value="<?php echo $dataKategori['id'] ?>"> <?php echo $dataKategori['nama'] ?></option>
                                <?php
                                }
                                ?>  
                        </select>
                    </div>
                    <div>
                        <label for="harga">Harga</label>
                        <input type="text" id="harga" name="harga" class="form-control" autocomplete="off"  value="<?php echo $data['harga']; ?>" required>
                    </div>
                    <div>
                        <label for="currentfoto" class="mb-2">Foto Produk</label> <br>
                        <img src="../image/<?php echo $data['foto']; ?>" alt="" width="250px">
                    </div>
                    <div>
                        <label for="foto">Foto</label>
                        <input type="file" name="foto" id="foto" class="form-control"> 
                    </div>
                    <div>
                        <label for="detail">Detail</label>
                        <textarea name="detail" id="detail" cols="30" rows="10" class="form-control">
                            <?php echo $data['detail'];?>
                        </textarea>
                    </div>
                    <div>
                        <label for="ketersediaan_stok"> Ketersediaan Stok</label>
                        <select name="ketersediaan_stok" id="ketersediaan_stok" class="form-control">
                            <option value="<?php echo $data['ketersediaan_stok']; ?>"><?php echo $data['ketersediaan_stok']; ?></option>
                            
                            <?php
                                if($data['ketersediaan_stok']=='tersedia'){
                            ?>
                                <option value="habis">habis</option>
                            <?php
                                }else {
                            ?>
                                <option value="tersedia">tersedia</option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                    <div class="mt-5 d-flex justify-content-between" >
                            <button class="btn btn-primary mt-3" type="submit" name="edit_produk"> Edit </button>
                            <button type="submit" class="btn btn-danger mt-3" name="hapusBtn"> Delete </button>

                    </div>
                </form>
                <?php
                if(isset($_POST['edit_produk'])){
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

                    if($nama=='' || $kategori=='' || $harga==''){
                ?>
                     <div class="alert alert-warning mt-3" role="alert">
                      Nama Kategori harus diisi
                    </div>
                <?php
                    }else{
                        $queryUpdate = mysqli_query($conn, "UPDATE product SET kategori_id='$kategori', nama='$nama', harga='$harga', detail='$detail', ketersediaan_stok='$ketersediaan_stok' WHERE id='$id'");

                        if($nama_file!=''){
                            if($image_size > 5000000) {
                ?>
                                <div class="alert alert-warning mt-3" role="alert">
                                    File lebih dari 500kb
                                </div>
                <?php
                            } else {
                                if($imageFileType != 'jpg' && $imageFileType != 'jpeg' && $imageFileType != 'png' ){
                ?>
                            <div class="alert alert-warning mt-3" role="alert">
                                File harus berupa jpg, jpeg, dan png
                            </div>
                <?php
                                } else {
                                    move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $new_name);

                                    $queryUpdate = mysqli_query($conn, "UPDATE product SET foto='$new_name' WHERE id='$id'");
                                    
                                    if($queryUpdate){
                    ?>
                                <div class="alert alert-success mt-3" role="alert">
                                Produk berhasil di update 
                                </div>

                                <meta http-equiv="refresh" content="1; url =product.php ">
                    <?php
                                    }else {
                                        echo mysqli_error($conn);
                                    }
                                }
                            }
                        }
                    }
                }

                if (isset($_POST['hapusBtn'])) {
                    $queryHapus = mysqli_query($conn, "DELETE FROM product WHERE id='$id'");

                    if($queryHapus){
                        ?>
                        <div class="alert alert-success mt-3" role="alert">
                            Kategori Berhasil dihapus
                        </div>
                        <meta http-equiv="refresh" content="2   ; url =product.php ">
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    
</body>
<script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../fontawesome/js/all.min.js"></script>

</html>
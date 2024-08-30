<?php
require "session.php";
require "../koneksi.php";

$queryKategori = mysqli_query($conn, "SELECT * FROM kategori");
$jumlahKategori = mysqli_num_rows($queryKategori);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">

</head>

<style>
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
                    <a href="index.php" class="no-decoration text-muted">
                        <i class="fas fa-house me-2">
                        </i> Home
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="fas fa-list me-2"></i> Kategori
                </li>
            </ol>
        </nav>

        <div class="my-5 col-12 col-md-6">
            <h3>Tambah Kategori</h3>

            <form action="" method="post">
                <div>
                    <label for="kategori"> Kategori </label>
                    <input type="text" name="kategori" id="kategori" placeholder="input nama kategori" class="form-control mt-1">
                </div>
                <div>
                    <button class="btn btn-primary mt-3" type="submit" name="simpan_kategori"> Simpan </button>
                </div>
            </form>

            <?php
            if (isset($_POST['simpan_kategori'])) {
                $kategori = htmlspecialchars($_POST['kategori']);

                $checkNameKategori = mysqli_query($conn, "SELECT nama FROM kategori WHERE nama = '$kategori'");
                $jumlahDataBaru = mysqli_num_rows($checkNameKategori);

                if ($jumlahDataBaru > 0) {
            ?>
                    <div class="alert alert-warning mt-3" role="alert">
                        Data Nama Kategori sudah tersedia
                    </div>

                    <?php
                } else {
                    $querySimpan = mysqli_query($conn, "INSERT INTO kategori(nama) VALUES ('$kategori')");
                    if ($querySimpan) {
                    ?>
                        <div class="alert alert-success mt-3" role="alert">
                            Kategori Berhasil tersimpan
                        </div>
                        <meta http-equiv="refresh" content="1; url =kategori.php ">
            <?php
                    } else {
                        echo mysqli_error($conn);
                    }
                }
            }
            ?>

        </div>

        <div class="mt-3">
            <h2>List Kategori</h2>
            <div class="table-responsive mt-5">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($jumlahKategori == 0) {
                        ?>
                            <tr>
                                <td colspan=3 class="text-center">Data kategori tidak ada</td>
                            </tr>
                            <?php
                        } else {
                            $no = 1;
                            while ($data = mysqli_fetch_array($queryKategori)) {
                            ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td> <?php echo $data['nama']  ?> </td>
                                    <td>
                                        <a href="kategori-detail.php?k=<?php echo $data['id']; ?>" class="btn btn-info"> <i class="fas fa-search"></i></a>
                                    </td>
                                </tr>
                        <?php
                            }
                            $no++;
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
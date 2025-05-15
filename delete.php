<?php
$koneksi = mysqli_connect("localhost", "root", "", "todo");
if (mysqli_connect_errno()) {
    die("Koneksi database gagal : " . mysqli_connect_error());
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    $delete = mysqli_query($koneksi, "DELETE FROM main WHERE id=$id");
    if ($delete) {
        header("Location: index.php?deleted=1");
        exit();
    } else {
        echo "Gagal menghapus data: " . mysqli_error($koneksi);
    }
} else {
    echo "ID tidak valid.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hapus Task</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6fb;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .message {
            margin-top: 60px;
            background: #fff;
            padding: 32px 40px;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            font-size: 1.2rem;
            color: #333;
        }
        a {
            display: inline-block;
            margin-top: 24px;
            font-size: 1rem;
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="message">
        <?php
        
        ?>
        <a href="index.php"><i class="bi bi-arrow-left"></i> Kembali ke Daftar</a>
    </div>
</body>
</html>
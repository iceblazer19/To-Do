<?php
$koneksi = mysqli_connect("localhost", "root", "", "todo");
if (mysqli_connect_errno()) {
    die("Koneksi database gagal : " . mysqli_connect_error());
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task = $_POST['task'];
    $createDate = date('Y-m-d');
    $deadline = $_POST['deadline'];
    $status = 1;

    $now = date('Y-m-d\TH:i');
    if ($deadline < $now) {
        $error = "Deadline tidak boleh sebelum waktu saat ini.";
    } elseif (mb_strlen($task) > 100) {
        $error = "Task tidak boleh lebih dari 100 karakter.";
    } else {
        $stmt = mysqli_prepare($koneksi, "INSERT INTO main (task, createDate, deadline, status) VALUES (?, ?, ?, ?)");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssi", $task, $createDate, $deadline, $status);
            if (mysqli_stmt_execute($stmt)) {
                header("Location: index.php");
                exit();
            } else {
                $error = "Gagal menambah data: " . mysqli_stmt_error($stmt);
            }
            mysqli_stmt_close($stmt);
        } else {
            $error = "Gagal menyiapkan statement: " . mysqli_error($koneksi);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Task</title>
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
        h2 {
            font-size: 2.2rem;
            margin-top: 40px;
            color: #333;
        }
        form {
            background: #fff;
            padding: 32px 40px;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            display: flex;
            flex-direction: column;
            gap: 18px;
            min-width: 340px;
        }
        label {
            font-size: 1.1rem;
            margin-bottom: 6px;
        }
        input[type="text"],
        input[type="datetime-local"] {
            font-size: 1.1rem;
            padding: 10px;
            border: 1px solid #bbb;
            border-radius: 6px;
            margin-bottom: 10px;
        }
        button[type="submit"] {
            font-size: 1.1rem;
            padding: 12px;
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.2s;
        }
        button[type="submit"]:hover {
            background: #0056b3;
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
    <h2>Tambah Task</h2>
    <?php if ($error): ?>
        <div style="color: #c82333; background: #fff3f3; border: 1px solid #f5c2c7; padding: 10px 18px; border-radius: 6px; margin-bottom: 18px;">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>
    <form method="POST" action="">
        <label>Task:</label>
        <input type="text" name="task" required maxlength="100">
        <label>Deadline:</label>
        <input type="datetime-local" name="deadline" required min="<?php echo date('Y-m-d\TH:i'); ?>">
        <button type="submit">Simpan</button>
    </form>
    <a href="index.php"><i class="bi bi-arrow-left"></i> Kembali ke Daftar</a>
</body>
</html>
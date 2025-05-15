<?php
$koneksi = mysqli_connect("localhost", "root", "", "todo");
if (mysqli_connect_errno()) {
    die("Koneksi database gagal : " . mysqli_connect_error());
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$query = mysqli_query($koneksi, "SELECT * FROM main WHERE id=$id");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    die("Task tidak ditemukan.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task = mysqli_real_escape_string($koneksi, $_POST['task']);
    $deadline = mysqli_real_escape_string($koneksi, $_POST['deadline']);
    $status = intval($_POST['status']);

    $update = mysqli_query($koneksi, "UPDATE main SET task='$task', deadline='$deadline', status=$status WHERE id=$id");
    if ($update) {
        header("Location: index.php");
        exit();
    } else {
        echo "Gagal update data: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Task</title>
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
        input[type="datetime-local"],
        select {
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
    <h2>Edit Task</h2>
    <form method="POST">
        <label>Task:</label>
        <input type="text" name="task" value="<?php echo htmlspecialchars($data['task']); ?>" required>
        <label>Deadline:</label>
        <input type="datetime-local" name="deadline" value="<?php echo date('Y-m-d\TH:i', strtotime($data['deadline'])); ?>" required>
        <label>Status:</label>
        <select name="status">
            <option value="1" <?php if($data['status']==1) echo 'selected'; ?>>In Progress</option>
            <option value="0" <?php if($data['status']==0) echo 'selected'; ?>>Done</option>
        </select>
        <button type="submit">Update</button>
    </form>
    <a href="index.php"><i class="bi bi-arrow-left"></i> Kembali ke Daftar</a>
</body>
</html>
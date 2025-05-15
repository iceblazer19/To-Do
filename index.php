<?php
$koneksi = mysqli_connect("localhost", "root", "", "todo");

if (mysqli_connect_errno()) {
    die("Koneksi database gagal : " . mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>To-Do List</title>
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
        header {
            margin-top: 40px;
            margin-bottom: 24px;
        }
        h2 {
            font-size: 2.2rem;
            color: #333;
        }
        main {
            width: 100%;
            max-width: 900px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        section {
            width: 100%;
        }
        .add-task-link {
            margin-bottom: 16px;
            display: inline-block;
            font-size: 1.1rem;
            color: #007BFF;
            text-decoration: none;
            font-weight: bold;
        }
        .add-task-link:hover {
            text-decoration: underline;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            overflow: hidden;
            margin-top: 16px;
        }
        th, td {
            padding: 16px 18px;
            text-align: left;
            border-bottom: 1px solid #eee;
            font-size: 1.1rem;
        }
        th {
            background-color: #f4f4f4;
            font-size: 1.15rem;
        }
        tr:last-child td {
            border-bottom: none;
        }
        td a {
            font-size: 1rem;
            color: #007bff;
            margin-right: 8px;
            text-decoration: none;
        }
        td a:last-child {
            margin-right: 0;
        }
        td a i {
            font-size: 1.3rem;
            vertical-align: middle;
            transition: color 0.2s;
        }
        td a[title="Edit"]:hover i {
            color: #15e684;
        }
        td a[title="Hapus"]:hover i {
            color: #c82333;
        }
        @media (max-width: 700px) {
            main {
                max-width: 100%;
                padding: 0 8px;
            }
            table, th, td {
                font-size: 1rem;
                padding: 10px 6px;
            }
        }
    </style>
</head>
<body>
    <header>
        <h2>To Do CRUD</h2>
    </header>
    <main>
        <section>
            <a href="tambah.php" class="add-task-link"><i class="bi bi-plus-circle"></i> Tambah Task</a>
        </section>
        <section>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Task</th>
                        <th>Created Date</th>
                        <th>Deadline</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $data = mysqli_query($koneksi, "SELECT * FROM main");
                    while ($d = mysqli_fetch_array($data)) :
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo htmlspecialchars($d['task']); ?></td>
                        <td><?php echo htmlspecialchars($d['createDate']); ?></td>
                        <td><?php echo htmlspecialchars($d['deadline']); ?></td>
                        <td>
                            <?php
                                if ($d['status'] == 0) {
                                    echo "Done";
                                } elseif ($d['status'] == 1) {
                                    echo "In Progress";
                                } else {
                                    echo "Invalid Status : " . htmlspecialchars($d['status']);
                                }
                            ?>
                        </td>
                        <td>
                            <?php
                                $todayDate = strtotime(date('Y-m-d'));
                                $deadline = strtotime($d['deadline']);
                                $diff = ($deadline - $todayDate) / (60 * 60 * 24);
                                echo ($diff < 2) ? "High" : "Low";
                            ?>
                        </td>
                        <td>
                            <a href="edit.php?id=<?php echo $d['id']; ?>" title="Edit"><i class="bi bi-pencil-square"></i></a>
                            <a href="delete.php?id=<?php echo $d['id']; ?>" title="Hapus" onclick="return confirm('Yakin ingin menghapus data ini?');"><i class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>
    </main>
    <?php if (isset($_GET['deleted'])): ?>
    <script>
        alert('Data berhasil dihapus!');
        if (window.history.replaceState) {
            const url = new URL(window.location);
            url.searchParams.delete('deleted');
            window.history.replaceState({}, document.title, url.pathname + url.search);
        }
    </script>
    <?php endif; ?>
</body>
</html>
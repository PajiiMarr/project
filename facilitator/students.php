<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once '../utilities/__link.php'; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students</title>
    <link rel="stylesheet" href="../node_modules/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../node_modules/datatables/css/dataTables.min.css">
</head>
<body>
    <header>
        <?php require_once 'facilitator_sidebar.php'; ?>
    </header>
    <main class="content-page">
        <h1>Students</h1>
        <table id="students-table" class="display">
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Course</th>
                    <th>Section</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <!-- Placeholder for student data -->
            </tbody>
        </table>
    </main>
    <?php require_once '../utilities/__scripts.php'; ?>
</body>
</html>

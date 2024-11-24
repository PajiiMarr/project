<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once '../utilities/__link.php'; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>
<body>
    <header>
        <?php require_once 'facilitator_sidebar.php'; ?>
    </header>
    <main class="content-page">
        <h1>Profile</h1>
        <form id="profile-form">
            <div>
                <label for="name">Name</label>
                <input type="text" id="name" name="name" readonly>
            </div>
            <div>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" readonly>
            </div>
            <div>
                <label for="password">Password</label>
                <input type="password" id="password" name="password">
            </div>
            <button type="submit">Update</button>
        </form>
    </main>
    <?php require_once '../utilities/__scripts.php'; ?>
</body>
</html>

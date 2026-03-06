<!-- app/Views/user/layouts/master.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> | User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <style>
        body { font-family: 'Inter', sans-serif; background: #f8fafc; margin:0; }
        .sidebar {
            background: #1e293b;
            color: #fff;
            padding: 1rem;
            height: 100vh;
            width: 220px;
            float: left;
        }
        .sidebar a { color: #94a3b8; display:block; margin:0.5rem 0; text-decoration:none; }
        .sidebar a:hover { color: #fff; }
        .main-content { margin-left: 220px; padding: 2rem; }
        .top-bar { display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem; }
        .breadcrumb { font-size: 0.85rem; color: #6b7280; }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h4>Welcome <?= session()->get('userName') ?? 'User' ?></h4>
    <a href="/user/dashboard"><i class="fas fa-home"></i> Dashboard</a>
    <a href="/user/profile"><i class="fas fa-user"></i> Profile</a>
    <a href="/logout" class="text-danger"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

<!-- MAIN CONTENT -->
<div class="main-content">
    <?= $this->renderSection('content') ?>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?= $this->renderSection('scripts') ?>
</body>
</html>
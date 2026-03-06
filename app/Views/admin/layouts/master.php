<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> | Admin Panel</title>
    
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Google Font: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: #f0f4f8;
            min-height: 100vh;
            display: flex;
            color: #1e293b;
        }
        .dashboard { display: flex; width: 100%; }

        /* ————— SIDEBAR ————— */
        .menu {
            width: 280px;
            background: #1e2b3c;
            border-right: 1px solid #2d3a4b;
            display: flex;
            flex-direction: column;
            transition: width 0.2s ease;
            box-shadow: 4px 0 12px rgba(0,0,0,0.06);
        }
        .menu-header {
            padding: 28px 24px 20px;
            border-bottom: 1px solid #334153;
        }
        .logo-area {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 600;
            font-size: 1.2rem;
            color: #ecf3fa;
        }
        .logo-icon {
            background: #4f77ff;
            color: white;
            width: 38px;
            height: 38px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }
        .menu-nav { flex: 1; padding: 28px 16px; }
        .menu-nav ul { list-style: none; display: flex; flex-direction: column; gap: 8px; }
        .menu-nav li { border-radius: 14px; transition: background 0.15s; }
        .menu-nav li.active { background: #2f4057; }
        .menu-nav li.active .nav-link { color: white; font-weight: 500; }
        .nav-link {
            display: flex; align-items: center; gap: 14px; padding: 12px 20px;
            text-decoration: none; color: #b4c6e0; font-weight: 500; font-size: 0.95rem;
            border-radius: 14px;
        }
        .nav-link i { width: 24px; font-size: 1.2rem; color: #8ca3c0; }
        .nav-link:hover { background: #293b52; color: #deecff; }
        .menu-footer {
            padding: 24px 20px 28px; border-top: 1px solid #334153;
            font-size: 0.9rem; color: #a2b9d4; display: flex; align-items: center; gap: 10px;
        }
        .menu-footer i { font-size: 1.4rem; color: #7f9bc0; }

        /* ————— MAIN CONTENT ————— */
        .main {
            flex: 1; display: flex; flex-direction: column; overflow-y: auto;
            background: #f8fafd;
        }
        .top-bar {
            background: white; padding: 16px 30px; display: flex; align-items: center;
            justify-content: space-between; border-bottom: 1px solid #e7edf4;
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        }
        .page-title h1 {
            font-size: 1.7rem; font-weight: 600; color: #142435; letter-spacing: -0.3px;
        }
        .page-title .breadcrumb { font-size: 0.85rem; color: #617388; margin-top: 4px; }
        .user-profile { display: flex; align-items: center; gap: 20px; }
        .user-profile i { 
            font-size: 1.3rem; color: #4a5f7a; background: #f0f5fb; padding: 8px; border-radius: 50%; 
        }

        /* stats cards */
        .stats-cards {
            display: flex; gap: 20px; padding: 28px 30px 20px; flex-wrap: wrap;
        }
        .stat-card {
            background: white; border-radius: 24px; padding: 20px 25px;
            box-shadow: 0 5px 16px rgba(0,0,0,0.02); flex: 1 1 160px;
            border: 1px solid #e5ecf5; display: flex; align-items: center; gap: 18px;
        }
        .stat-icon {
            background: #e7f0fe; width: 56px; height: 56px; border-radius: 20px;
            display: flex; align-items: center; justify-content: center; color: #2d5fcf; font-size: 1.8rem;
        }
        .stat-content h3 { font-size: 1.9rem; font-weight: 600; line-height: 1.2; }
        .stat-content p { color: #5d718b; font-size: 0.9rem; }

        /* ===== DATATABLE CARD ===== */
        .table-container {
            margin: 0 30px 30px; background: white; border-radius: 28px;
            border: 1px solid #e2eaf2; box-shadow: 0 18px 36px -14px rgba(20,40,70,0.12);
            padding: 20px 24px 28px;
        }
        .table-header {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 24px; flex-wrap: wrap; gap: 15px;
        }
        .table-header h2 {
            font-weight: 600; font-size: 1.4rem; display: flex; align-items: center; gap: 8px;
        }
        .table-header h2 i { color: #2d5fcf; background: #e7f0fe; padding: 8px; border-radius: 16px; }

        /* DataTables adjustments */
        .dataTables_wrapper .dataTables_length, 
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 1rem;
        }
        .dataTables_wrapper .dataTables_filter input {
            border-radius: 40px !important; padding: 8px 18px !important;
            border: 1px solid #dae1eb !important; background: #f9fcff;
        }
        table.dataTable thead th {
            background: #f3f8ff; color: #1d3a5c; font-weight: 600; border-bottom: 2px solid #ccddec;
        }
        table.dataTable tbody td {  border: 1px solid black; padding: 2px 2px; color: #203141; }
        .badge {
            font-weight: 500; padding: 5px 14px; border-radius: 40px; font-size: 0.8rem;
        }
        .badge-pending { background: #fff3d4; color: #aa5f18; }
        .badge-approved { background: #ddf4e6; color: #136b41; }
        .badge-rejected { background: #ffe8e8; color: #b13e3e; }

        .action-btn {
            border: none; background: none; font-size: 0.8rem; font-weight: 500;
            padding: 2px 2px; border-radius: 40px; transition: 0.1s; margin: 2px;
            cursor: pointer;
        }
        .btn-approve { background: #e0f2e5; color: #166534; }
        .btn-reject  { background: #fee7e7; color: #a13d3d; }
        .btn-view    { background: #e9eef7; color: #2e4d7a; }
        .btn-approve i, .btn-reject i, .btn-view i { margin-right: 4px; }

        .pagination .paginate_button.current {
            background: #1e3c72 !important; border-color: #17345c !important; color: white !important;
        }
        
        /* DataTables custom */
        .dataTables_filter input:focus { 
            outline: none; border-color: #6180dd !important; box-shadow: 0 0 0 3px rgba(97,128,221,0.1); 
        }
        .dataTables_length select { 
            border-radius: 30px; padding: 6px 24px 6px 12px; border: 1px solid #d3deed; 
        }
        .dataTables_paginate .paginate_button { border-radius: 30px !important; margin: 0 3px; }
        
        @media (max-width: 800px) {
            .menu { width: 90px; overflow: hidden; }
            .menu .logo-area span:not(.logo-icon), .nav-link span, .menu-footer span { display: none; }
            .menu-footer i { margin: 0 auto; }
            .nav-link { justify-content: center; }
        }
    </style>
    
    <?= $this->renderSection('styles') ?>
</head>
<body>
<div class="dashboard">
    <!-- ========== SIDEBAR ========= -->
    <aside class="menu">
        <div class="menu-header">
            <div class="logo-area">
                <div class="logo-icon"><i class="fas fa-table-cells-large"></i></div>
                <span>AdminHub</span>
            </div>
        </div>
        <nav class="menu-nav">
            <ul>
                <li class="<?= (current_url() == base_url('admin/dashboard')) ? 'active' : '' ?>">
                    <a href="<?= base_url('admin/dashboard') ?>" class="nav-link">
                        <i class="fas fa-gauge-high"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li class="<?= (current_url() == base_url('admin/userlist')) ? 'active' : '' ?>">
                    <a href="<?= base_url('admin/userlist') ?>" class="nav-link">
                        <i class="fas fa-users"></i> <span>Users</span>
                    </a>
                </li>
               
                <li style="margin-top: 20px;">
                    <a href="<?= base_url('/admin/logout') ?>" class="nav-link" style="color: #dc2626;">
                        <i class="fas fa-sign-out-alt" style="color: #dc2626;"></i> <span>Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
     
    </aside>

    <!-- ========== MAIN PANEL ========= -->
    <main class="main">
        <!-- Top Bar -->
        <div class="top-bar">
            <div class="page-title">
                <h1><?= $this->renderSection('page-title') ?></h1>
                <div class="breadcrumb"><?= $this->renderSection('breadcrumb') ?></div>
            </div>
          
        </div>

        <!-- Page Content -->
        <?= $this->renderSection('content') ?>
    </main>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?= $this->renderSection('scripts') ?>
</body>
</html>
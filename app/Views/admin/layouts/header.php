<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> | User Panel</title>
    
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Google Font: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600&display=swap" rel="stylesheet">
    <!-- DataTables CSS (for dashboard) -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: #f4f6fa;
            min-height: 100vh;
            display: flex;
            color: #1e293b;
        }

        .dashboard {
            display: flex;
            width: 100%;
        }

        /* Main content area */
        .main {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            background: #f9fbfd;
        }

        /* top bar */
        .top-bar {
            background: #ffffff;
            padding: 16px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #eef2f6;
            box-shadow: 0 2px 6px rgba(0,0,0,0.01);
        }

        .page-title h1 {
            font-size: 1.6rem;
            font-weight: 600;
            color: #0b1a2f;
            letter-spacing: -0.3px;
        }

        .page-title .breadcrumb {
            font-size: 0.85rem;
            color: #5f6c84;
            margin-top: 4px;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-profile i {
            font-size: 1.3rem;
            color: #54657e;
            background: #f1f4f9;
            padding: 8px;
            border-radius: 50%;
        }

        /* stats cards */
        .stats-cards {
            display: flex;
            gap: 20px;
            padding: 28px 30px 20px;
            flex-wrap: wrap;
        }

        .stat-card {
            background: white;
            border-radius: 22px;
            padding: 20px 25px;
            box-shadow: 0 5px 18px rgba(0,0,0,0.02);
            flex: 1 1 160px;
            border: 1px solid #eef2f8;
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .stat-icon {
            background: #e9effa;
            width: 52px;
            height: 52px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2563eb;
            font-size: 1.6rem;
        }

        .stat-content h3 {
            font-size: 1.8rem;
            font-weight: 600;
            line-height: 1.2;
        }

        .stat-content p {
            color: #5f6c84;
            font-size: 0.9rem;
        }

        /* table container */
        .table-container {
            margin: 0 30px 30px;
            background: #ffffff;
            border-radius: 26px;
            border: 1px solid #eef2f6;
            box-shadow: 0 15px 30px -12px rgba(0,0,0,0.05);
            overflow: hidden;
            padding: 20px 24px 28px;
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .table-header h2 {
            font-weight: 600;
            font-size: 1.4rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .table-header h2 i {
            color: #3b82f6;
            background: #e8effd;
            padding: 8px;
            border-radius: 14px;
            font-size: 1rem;
        }

        /* profile container */
        .profile-container {
            max-width: 800px;
            margin: 30px;
            background: #ffffff;
            border-radius: 32px;
            border: 1px solid #eef2f6;
            box-shadow: 0 20px 40px -14px rgba(0,0,0,0.08);
            padding: 36px 40px;
        }

        .profile-header {
            display: flex;
            align-items: center;
            gap: 24px;
            margin-bottom: 40px;
        }

        .profile-avatar {
            width: 88px;
            height: 88px;
            background: linear-gradient(135deg, #3b82f6, #7f5af0);
            border-radius: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2.8rem;
            box-shadow: 0 12px 22px -10px #3b82f6;
        }

        .profile-header h2 {
            font-size: 2rem;
            font-weight: 600;
            color: #0f263b;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 26px 30px;
            margin-top: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group.full-width {
            grid-column: span 2;
        }

        .form-group label {
            font-weight: 600;
            font-size: 0.85rem;
            color: #455e7e;
            letter-spacing: 0.3px;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .form-group label i {
            color: #3b82f6;
            font-size: 1rem;
            width: 20px;
        }

        .form-control {
            background: #f8fafd;
            border: 1.5px solid #e3eaf2;
            border-radius: 20px;
            padding: 14px 20px;
            font-size: 1rem;
            font-family: 'Inter', sans-serif;
            color: #1f3145;
            transition: 0.15s;
        }

        .form-control:focus {
            outline: none;
            border-color: #3b82f6;
            background: white;
            box-shadow: 0 0 0 4px rgba(59,130,246,0.1);
        }

        .form-control[readonly] {
            background: #f1f5f9;
            border-color: #d9e2ef;
            color: #62748e;
            cursor: not-allowed;
        }

        .btn-update {
            background: #1d4ed8;
            border: none;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            padding: 16px 38px;
            border-radius: 40px;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            margin-top: 38px;
            cursor: pointer;
            transition: 0.15s;
            border: 1px solid #1e3f96;
            box-shadow: 0 12px 26px -10px #1d4ed8;
        }

        .btn-update:hover {
            background: #2563eb;
        }

        @media (max-width: 800px) {
            .menu {
                width: 90px;
                overflow: hidden;
            }
            .menu .logo-area span:not(.logo-icon),
            .nav-link span,
            .menu-footer span {
                display: none;
            }
            .menu-footer i {
                margin: 0 auto;
            }
            .nav-link {
                justify-content: center;
            }
        }
    </style>
    
    <?= $this->renderSection('styles') ?>
</head>
<body>
<div class="dashboard">
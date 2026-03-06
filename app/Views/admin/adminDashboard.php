<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proper Dashboard · one menu + datatable</title>
    <!-- Font Awesome 6 (free) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Google Font: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600&display=swap" rel="stylesheet">
    <!-- Simple datatable styling (no external lib, pure minimal design) -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: #f4f6fa;
            height: 100vh;
            display: flex;
            color: #1e293b;
        }

        /* ========== LAYOUT ========== */
        .dashboard {
            display: flex;
            width: 100%;
        }

        /* ————— SIDEBAR / MENU ————— */
        .menu {
            width: 280px;
            background: #dfcccc;
            border-right: 1px solid #e9eef2;
            display: flex;
            flex-direction: column;
            transition: width 0.2s ease;
            box-shadow: 2px 0 12px rgba(0,0,0,0.02);
        }

        .menu-header {
            padding: 24px 24px 20px;
            border-bottom: 1px solid #edf2f6;
        }

        .logo-area {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
            font-size: 1.2rem;
            color: #0f1825;
        }

        .logo-icon {
            background: #3b82f6;
            color: white;
            width: 34px;
            height: 34px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .menu-nav {
            flex: 1;
            padding: 28px 16px;
        }

        .menu-nav ul {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .menu-nav li {
            border-radius: 12px;
            transition: background 0.15s;
        }

        .menu-nav li.active {
            background: #eef2ff;
        }

        .menu-nav li.active .nav-link {
            color: #1d4ed8;
            font-weight: 500;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 18px;
            text-decoration: none;
            color: #475569;
            font-weight: 500;
            font-size: 0.95rem;
            border-radius: 12px;
        }

        .nav-link i {
            width: 22px;
            font-size: 1.2rem;
            color: #64748b;
        }

        .nav-link:hover {
            background: #f8fafd;
            color: #1e293b;
        }

        .menu-footer {
            padding: 24px 20px 28px;
            border-top: 1px solid #edf2f6;
            font-size: 0.9rem;
            color: #68748b;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .menu-footer i {
            font-size: 1.2rem;
            color: #94a3b8;
        }

        /* ————— MAIN CONTENT ————— */
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

        /* dashboard cards (optional but enriches look) */
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

        /* ===== DATATABLE SECTION ===== */
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

        .table-controls {
            display: flex;
            gap: 10px;
        }

        .search-box {
            display: flex;
            align-items: center;
            background: #f3f6fb;
            border-radius: 40px;
            padding: 0 16px;
            border: 1px solid #e2e8f0;
        }

        .search-box i {
            color: #8192aa;
            font-size: 0.9rem;
        }

        .search-box input {
            border: none;
            background: transparent;
            padding: 10px 10px 10px 10px;
            font-size: 0.9rem;
            width: 200px;
            outline: none;
        }

        .filter-btn {
            background: #f3f6fb;
            border: 1px solid #e2e8f0;
            border-radius: 40px;
            padding: 8px 18px;
            color: #344767;
            font-weight: 500;
            cursor: default;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* pure datatable – no external, clean design */
        .datatable {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.95rem;
        }

        .datatable thead tr {
            background: #f8fafd;
            border-bottom: 2px solid #e2eaf2;
        }

        .datatable th {
            text-align: left;
            padding: 18px 16px;
            font-weight: 600;
            color: #334155;
            white-space: nowrap;
        }

        .datatable td {
            padding: 16px 16px;
            border-bottom: 1px solid #ecf1f7;
            color: #1f2a41;
        }

        .datatable tbody tr:hover {
            background-color: #f6f9ff;
            transition: 0.1s;
        }

        .badge {
            background: #e3f0ff;
            color: #1a4cbc;
            font-weight: 500;
            font-size: 0.8rem;
            padding: 5px 12px;
            border-radius: 50px;
            display: inline-block;
        }

        .badge.success {
            background: #e3f9ee;
            color: #0e7b4c;
        }

        .badge.warning {
            background: #fff1dd;
            color: #aa5b00;
        }

        .actions i {
            color: #8195b0;
            margin: 0 6px;
            font-size: 1.1rem;
            cursor: default;
        }

        .footer-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 25px;
            font-size: 0.9rem;
            color: #576c85;
            border-top: 1px solid #edf2f8;
            padding-top: 20px;
        }

        .pagination {
            display: flex;
            gap: 8px;
        }

        .page-item {
            background: white;
            border: 1px solid #dee7f0;
            color: #3f5575;
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            font-weight: 500;
            cursor: default;
        }

        .page-item.active-page {
            background: #1d4ed8;
            border-color: #1d4ed8;
            color: white;
        }

        .page-item i {
            font-size: 0.8rem;
        }

        /* responsive */
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
            .stats-cards {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
<div class="dashboard">
    <!-- ========== LEFT MENU (the one and only menu) ========= -->
    <aside class="menu">
        <div class="menu-header">
            <div class="logo-area">
                <div class="logo-icon"><i class="fas fa-chart-pie"></i></div>
                <span>DatumBoard</span>
            </div>
        </div>

        <nav class="menu-nav">
            <ul>
                <!-- active state indicates dashboard (main section) -->
                <li class="active"><a href="#" class="nav-link"><i class="fas fa-th-large"></i> <span>Dashboard</span></a></li>
                <li><a href="#" class="nav-link"><i class="fas fa-table"></i> <span>Data views</span></a></li>
                <li><a href="#" class="nav-link"><i class="fas fa-chart-line"></i> <span>Analytics</span></a></li>
                <li><a href="#" class="nav-link"><i class="fas fa-users"></i> <span>Clients</span></a></li>
                <li><a href="#" class="nav-link"><i class="fas fa-cog"></i> <span>Settings</span></a></li>
                <li><a href="#" class="nav-link"><i class="fas fa-file-alt"></i> <span>Reports</span></a></li>
            </ul>
        </nav>

        <div class="menu-footer">
            <i class="fas fa-circle-user"></i>
            <span>adrian@datumbox</span>
        </div>
    </aside>

    <!-- ========== MAIN PANEL ========= -->
    <main class="main">
        <!-- top app bar -->
        <div class="top-bar">
            <div class="page-title">
                <h1>Your data</h1>
                <div class="breadcrumb"><i class="fas fa-home"></i>  /  Dashboard  /  Data table</div>
            </div>
            <div class="user-profile">
                <i class="fas fa-bell"></i>
                <i class="fas fa-message"></i>
                <i class="fas fa-user-circle" style="font-size: 2rem; background: none;"></i>
            </div>
        </div>

        <!-- small kpi cards (nice surrounding) -->
        <div class="stats-cards">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-database"></i></div>
                <div class="stat-content">
                    <h3>248</h3>
                    <p>total entries</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-user-check"></i></div>
                <div class="stat-content">
                    <h3>1,245</h3>
                    <p>active users</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-chart-simple"></i></div>
                <div class="stat-content">
                    <h3>23</h3>
                    <p>new today</p>
                </div>
            </div>
        </div>

        <!-- DATATABLE CARD (clean design) -->
        <div class="table-container">
            <div class="table-header">
                <h2><i class="fas fa-list-ul"></i> Orders & customers</h2>
                <div class="table-controls">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Search records...">
                    </div>
                    <div class="filter-btn"><i class="fas fa-sliders-h"></i> Filter</div>
                </div>
            </div>

            <!-- the actual data table -->
            <table class="datatable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Product</th>
                        <th>Status</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><b>#OR954</b></td>
                        <td>Olivia Chen</td>
                        <td>Ergo Monitor</td>
                        <td><span class="badge success">completed</span></td>
                        <td>$412.00</td>
                        <td>2025-02-18</td>
                        <td class="actions"><i class="far fa-eye"></i> <i class="far fa-edit"></i></td>
                    </tr>
                    <tr>
                        <td><b>#OR955</b></td>
                        <td>Michael Rostov</td>
                        <td>Wireless KB</td>
                        <td><span class="badge warning">pending</span></td>
                        <td>$89.00</td>
                        <td>2025-02-17</td>
                        <td class="actions"><i class="far fa-eye"></i> <i class="far fa-edit"></i></td>
                    </tr>
                    <tr>
                        <td><b>#OR956</b></td>
                        <td>Zara Hassan</td>
                        <td>Laptop stand</td>
                        <td><span class="badge success">shipped</span></td>
                        <td>$159.90</td>
                        <td>2025-02-16</td>
                        <td class="actions"><i class="far fa-eye"></i> <i class="far fa-edit"></i></td>
                    </tr>
                    <tr>
                        <td><b>#OR957</b></td>
                        <td>James Wu</td>
                        <td>4K webcam</td>
                        <td><span class="badge">processing</span></td>
                        <td>$210.45</td>
                        <td>2025-02-16</td>
                        <td class="actions"><i class="far fa-eye"></i> <i class="far fa-edit"></i></td>
                    </tr>
                    <tr>
                        <td><b>#OR958</b></td>
                        <td>Elena Costa</td>
                        <td>Dock station</td>
                        <td><span class="badge success">completed</span></td>
                        <td>$327.70</td>
                        <td>2025-02-15</td>
                        <td class="actions"><i class="far fa-eye"></i> <i class="far fa-edit"></i></td>
                    </tr>
                    <tr>
                        <td><b>#OR959</b></td>
                        <td>David Park</td>
                        <td>Noise headset</td>
                        <td><span class="badge warning">backorder</span></td>
                        <td>$94.99</td>
                        <td>2025-02-14</td>
                        <td class="actions"><i class="far fa-eye"></i> <i class="far fa-edit"></i></td>
                    </tr>
                    <tr>
                        <td><b>#OR960</b></td>
                        <td>Nadia Kline</td>
                        <td>USB-C hub</td>
                        <td><span class="badge success">delivered</span></td>
                        <td>$72.50</td>
                        <td>2025-02-13</td>
                        <td class="actions"><i class="far fa-eye"></i> <i class="far fa-edit"></i></td>
                    </tr>
                </tbody>
            </table>

            <!-- footer with pagination (static for design) -->
            <div class="footer-info">
                <div>Showing 1‒7 of 24 results</div>
                <div class="pagination">
                    <span class="page-item"><i class="fas fa-chevron-left"></i></span>
                    <span class="page-item active-page">1</span>
                    <span class="page-item">2</span>
                    <span class="page-item">3</span>
                    <span class="page-item">4</span>
                    <span class="page-item"><i class="fas fa-chevron-right"></i></span>
                </div>
            </div>
        </div>
    </main>
</div>
<!-- subtle extra: ensures no external library, just design -->
</body>
</html>
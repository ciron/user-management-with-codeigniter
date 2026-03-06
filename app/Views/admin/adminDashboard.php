<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin · Server-side Users</title>
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Google Font: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <!-- DataTables & jQuery (for server-side processing) -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: #f0f4f8;
            height: 100vh;
            display: flex;
            color: #1e293b;
        }
        .dashboard { display: flex; width: 100%; }

        /* ————— SIDEBAR (fresh indigo, but different from original) ————— */
        .menu {
            width: 280px;
            background: #1e2b3c;  /* dark blue-grey */
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
        .user-profile i { font-size: 1.3rem; color: #4a5f7a; background: #f0f5fb; padding: 8px; border-radius: 50%; }

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

        /* DataTables adjustments (clean integration) */
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
        table.dataTable tbody td { padding: 2px 2px; color: #203141; }
        .badge {
            font-weight: 500; padding: 5px 14px; border-radius: 40px; font-size: 0.8rem;
        }
        .badge-pending { background: #fff3d4; color: #aa5f18; }
        .badge-approved { background: #ddf4e6; color: #136b41; }
        .badge-rejected { background: #ffe8e8; color: #b13e3e; }

        .action-btn {
            border: none; background: none; font-size: 0.8rem; font-weight: 500;
            padding: 2px 2px; border-radius: 40px; transition: 0.1s; margin: 2px;
        }
        .btn-approve { background: #e0f2e5; color: #166534; }
        .btn-reject  { background: #fee7e7; color: #a13d3d; }
        .btn-view    { background: #e9eef7; color: #2e4d7a; }
        .btn-approve i, .btn-reject i, .btn-view i { margin-right: 4px; }

        .pagination .paginate_button.current {
            background: #1e3c72 !important; border-color: #17345c !important; color: white !important;
        }
        @media (max-width: 800px) {
            .menu { width: 90px; overflow: hidden; }
            .menu .logo-area span:not(.logo-icon), .nav-link span, .menu-footer span { display: none; }
            .menu-footer i { margin: 0 auto; }
            .nav-link { justify-content: center; }
        }
    </style>
</head>
<body>
<div class="dashboard">
    <!-- ========== LEFT MENU (only one) ========= -->
    <aside class="menu">
        <div class="menu-header">
            <div class="logo-area">
                <div class="logo-icon"><i class="fas fa-table-cells-large"></i></div>
                <span>UserHub</span>
            </div>
        </div>
        <nav class="menu-nav">
            <ul>
                <li class="active"><a href="#" class="nav-link"><i class="fas fa-gauge-high"></i> <span>Dashboard</span></a></li>
                <li><a href="#" class="nav-link"><i class="fas fa-users"></i> <span>Users</span></a></li>
            </ul>
        </nav>
        <div class="menu-footer">
            <i class="fas fa-circle-user"></i>
            <span><?= esc($adminEmail) ?></span>
        </div>
    </aside>

    <!-- MAIN PANEL -->
    <main class="main">
        <div class="top-bar">
            <div class="page-title">
                <h1>User management</h1>
                <div class="breadcrumb"><i class="fas fa-house"></i>  /  Dashboard  /  Server-side users</div>
            </div>
            <div class="user-profile">
                <i class="fas fa-bell"></i>
                <i class="fas fa-message"></i>
                <i class="fas fa-circle-user" style="font-size: 2rem; background: none;"></i>
            </div>
        </div>

        <!-- KPI cards (static for design) -->
         <div class="stats-cards">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-user-clock"></i></div>
                <div class="stat-content">
                    <h3><?= esc($pendingCount) ?></h3>
                    <p>pending users</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-user-check"></i></div>
                <div class="stat-content">
                    <h3><?= esc($activeCount) ?></h3>
                    <p>active users</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-calendar-plus"></i></div>
                <div class="stat-content">
                    <h3><?= esc($newTodayCount) ?></h3>
                    <p>new today</p>
                </div>
            </div>
        </div>

        <!-- DATATABLE CONTAINER -->
        <div class="table-container">
            <div class="table-header">
                <h2><i class="fas fa-list-check"></i> Registered users</h2>
               
            </div>

            <!-- DataTable will be injected here -->
            <table id="usersTable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th >ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </main>
</div>

<!-- scripts -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {

   var table = $('#usersTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: '/admin/getUsers',
        type: 'GET',
        dataType: 'json',
        error: function(xhr, error, thrown) {
            console.log('DataTable error:', error);
            if (xhr.status === 403 || xhr.status === 401) {
                Swal.fire('Session expired', 'Please login again', 'error');
            }
        }
    },
    columns: [
        { data: 0 }, // ID
        { data: 1 }, // Name
        { data: 2 }, // Email
        { data: 3 }, // Phone
        { data: 4 }, // Address
        { 
            data: 5, // Status
            render: function(data, type, row) {
                if (!data) data = 'pending';
                let cls = 'badge-pending';
                if (data.toLowerCase() === 'approved') cls = 'badge-approved';
                else if (data.toLowerCase() === 'rejected') cls = 'badge-rejected';
                return `<span class="badge ${cls}">${data.charAt(0).toUpperCase() + data.slice(1)}</span>`;
            }
        },
        { data: 6 }, // Created At
        {
            data: 0, // Actions
            orderable: false,
            searchable: false,
            render: function(data, type, row) {
                const id = row[0];
                const status = (row[5] || 'pending').toLowerCase();
                let buttons = '';

                if (status === 'pending') {
                    buttons += `<button class="action-btn btn-approve" onclick="updateUserStatus('${id}','approved')"><i class="fas fa-check-circle"></i> Approve</button>`;
                    buttons += `<button class="action-btn btn-reject" onclick="updateUserStatus('${id}','rejected')"><i class="fas fa-times-circle"></i> Reject</button>`;
                } else if (status === 'approved') {
                    buttons += `<button class="action-btn btn-reject" onclick="updateUserStatus('${id}','rejected')"><i class="fas fa-times-circle"></i> Reject</button>`;
                } else if (status === 'rejected') {
                    buttons += `<button class="action-btn btn-approve" onclick="updateUserStatus('${id}','approved')"><i class="fas fa-check-circle"></i> Approve</button>`;
                }

                buttons += `<button class="action-btn btn-view" onclick="viewUser('${id}')"><i class="fas fa-eye"></i> View</button>`;
                return buttons;
            }
        }
    ],
    order: [[6, 'desc']], // Sort by Created At
    pageLength: 10,
    lengthMenu: [5, 10, 25, 50],
    language: {
        search: "_INPUT_",
        searchPlaceholder: "Search users..."
    }
});
 
    window.updateUserStatus = function(userId, newStatus) {
        Swal.fire({
            title: 'Change status',
            text: `Set user  to ${newStatus}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: newStatus === 'approved' ? '#2e7d5e' : '#d26b6b',
            confirmButtonText: `Yes, ${newStatus}`
        }).then(result => {
            if (result.isConfirmed) {

                Swal.fire({
                    title: 'Updated',
                    text: `User status changed to ${newStatus} `,
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false
                });
          
                table.ajax.reload(null, false); 
            }
        });
    };

    window.viewUser = function(userId) {

  

    $.get('/admin/getUserById/' + userId, function(response) {
  console.log(response);
        if(response.status === 'success'){

            let user = response.data;

            Swal.fire({
                title: 'User Details',
                html: `
                    <div style="text-align:left">
                        <p><b>Name:</b> ${user.name}</p>
                        <p><b>Email:</b> ${user.email}</p>
                        <p><b>Phone:</b> ${user.phone}</p>
                        <p><b>Address:</b> ${user.address}</p>
                        <p><b>Status:</b> ${user.status}</p>
                      
                        <p><b>Created:</b> ${user.created_at}</p>
                    </div>
                `,
                icon: 'info',
                confirmButtonColor: '#3f6e9c'
            });

        }else{
            Swal.fire('Error', 'User not found', 'error');
        }

    }, 'json');

};
});
</script>

<style>
 
    .dataTables_filter input:focus { outline: none; border-color: #6180dd !important; box-shadow: 0 0 0 3px rgba(97,128,221,0.1); }
    .dataTables_length select { border-radius: 30px; padding: 6px 24px 6px 12px; border: 1px solid #d3deed; }
    .dataTables_paginate .paginate_button { border-radius: 30px !important; margin: 0 3px; }
    .filter-btn { cursor: default; }
</style>

</body>
</html>
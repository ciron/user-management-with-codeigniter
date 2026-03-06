<?= $this->extend('admin/layouts/master') ?>

<?= $this->section('title') ?>User List<?= $this->endSection() ?>

<?= $this->section('page-title') ?>User Management<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<i class="fas fa-house"></i> / Dashboard / User List
<?= $this->endSection() ?>

<?= $this->section('content') ?>



<!-- DataTable Container -->
<div class="table-container">
    <div class="table-header">
        <h2><i class="fas fa-list-check"></i> Registered Users</h2>
    </div>

    <table id="usersTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
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

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
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
            { data: 0 }, 
            { data: 1 }, 
            { data: 2 }, 
            { data: 3 }, 
            { data: 4 }, 
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
                data: 0,
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
        order: [[6, 'desc']],
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
            text: `Set user to ${newStatus}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: newStatus === 'approved' ? '#2e7d5e' : '#d26b6b',
            confirmButtonText: `Yes, ${newStatus}`
        }).then(result => {
            if (result.isConfirmed) {
                // Make AJAX call to update status
                $.post('/admin/updateStatus', { id: userId, status: newStatus })
                    .done(function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                title: 'Updated',
                                text: `User status changed to ${newStatus}`,
                                icon: 'success',
                                timer: 1500,
                                showConfirmButton: false
                            });
                            table.ajax.reload(null, false);
                        } else {
                            Swal.fire('Error', response.message || 'Update failed', 'error');
                        }
                    })
                    .fail(function() {
                        Swal.fire('Error', 'Could not connect to server', 'error');
                    });
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
                            <p><b>Address:</b> ${user.address || 'N/A'}</p>
                            <p><b>Status:</b> ${user.status}</p>
                            <p><b>Created:</b> ${user.created_at}</p>
                        </div>
                    `,
                    icon: 'info',
                    confirmButtonColor: '#3f6e9c'
                });
            } else {
                Swal.fire('Error', 'User not found', 'error');
            }
        }, 'json');
    };
});
</script>
<?= $this->endSection() ?>
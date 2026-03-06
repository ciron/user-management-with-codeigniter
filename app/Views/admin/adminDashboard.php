<?= $this->extend('admin/layouts/master') ?>

<?= $this->section('title') ?>Dashboard<?= $this->endSection() ?>

<?= $this->section('page-title') ?>Dashboard<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<i class="fas fa-house"></i> / Dashboard / Overview
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- KPI Cards -->
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

<!-- Welcome Section -->
<div class="table-container">
    <div class="table-header">
        <h2><i class="fas fa-chart-pie"></i> Welcome to Admin Dashboard</h2>
    </div>
    <div style="padding: 20px; text-align: center;">
        <i class="fas fa-chart-line" style="font-size: 4rem; color: #2d5fcf; opacity: 0.5; margin-bottom: 20px;"></i>
        <h3 style="margin-bottom: 15px;">Manage your users efficiently</h3>
        <p style="color: #5d718b; max-width: 600px; margin: 0 auto;">
            Use the navigation menu to access the user list where you can view, approve, reject, and manage all registered users.
        </p>
        <a href="<?= base_url('admin/userlist') ?>" class="btn-update" style="display: inline-block; margin-top: 25px; text-decoration: none;">
            <i class="fas fa-arrow-right"></i> Go to User List
        </a>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<style>
    .btn-update {
        background: linear-gradient(135deg, #667eea, #764ba2);
        border: none;
        color: white;
        font-weight: 600;
        padding: 12px 30px;
        border-radius: 60px;
        transition: all 0.3s ease;
        box-shadow: 0 10px 25px -5px rgba(102, 126, 234, 0.4);
    }
    .btn-update:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 30px -5px rgba(102, 126, 234, 0.5);
        color: white;
    }
</style>
<?= $this->endSection() ?>
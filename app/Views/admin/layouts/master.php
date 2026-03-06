<?= $this->include('header') ?>

<?= $this->include('sidebar') ?>

<!-- ========== MAIN CONTENT ========= -->
<main class="main">
    <!-- top bar -->
    <div class="top-bar">
        <div class="page-title">
            <h1><?= $this->renderSection('page-title') ?></h1>
            <div class="breadcrumb"><?= $this->renderSection('breadcrumb') ?></div>
        </div>
        <div class="user-profile">
            <i class="fas fa-bell"></i>
            <i class="fas fa-message"></i>
            <i class="fas fa-user-circle" style="font-size: 2rem; background: none;"></i>
        </div>
    </div>

    <!-- page content -->
    <?= $this->renderSection('content') ?>
</main>

<?= $this->include('footer') ?>
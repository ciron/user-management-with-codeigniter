<?= $this->extend('user/layouts/master') ?>

<?= $this->section('title') ?>Dashboard<?= $this->endSection() ?>

<?= $this->section('page-title') ?>Welcome, <?= session()->get('userName') ?? 'User' ?><?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<i class="fas fa-home"></i> / Dashboard / Welcome
<?= $this->endSection() ?>

<?= $this->section('content') ?>

    <!-- MAIN PANEL -->
    <main class="main">
        <div class="top-bar">
            <div class="page-title">
                <h1>User management</h1>
                <div class="breadcrumb"><i class="fas fa-house"></i>  /  Dashboard </div>
            </div>
           
        </div>
    </main
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<?= $this->endSection() ?>
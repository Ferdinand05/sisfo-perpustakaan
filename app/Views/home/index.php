<?= $this->extend('template/index'); ?>




<?= $this->section('content-title'); ?>
Dashboard
<?= $this->endSection(); ?>

<?= $this->section('content-subtitle'); ?>
Welcome to Sistem Informasi Perpustakaan
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="card-deck">



    <div class="card text-white bg-primary mb-3">
        <div class="card-header">Peminjaman <i class="fas fa-cart-arrow-down"></i> </div>
        <div class="card-body">
            <h5 class="card-title">Ada <?= $peminjaman; ?> Peminjaman yang belum Dikembalikan</h5>
        </div>
    </div>
    <div class="card text-white bg-secondary mb-3">
        <div class="card-header">Pengembalian <i class="fas fa-exchange-alt"></i> </div>
        <div class="card-body">
            <h5 class="card-title">Ada <?= $pengembalian; ?> Data Pengembalian, dengan <?= $pengembalianDenda; ?> Pengembalian Dikenakan Denda.</h5>
        </div>
    </div>
    <div class="card text-white bg-success mb-3">
        <div class="card-header">Buku <i class="fas fa-book"></i> </div>
        <div class="card-body">
            <h5 class="card-title">Ada <?= $buku; ?> Buku yang terdaftar di dalam Sistem dengan <?= $kategori; ?> Kategori.</h5>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('content-footer'); ?>
<?= $this->endSection(); ?>
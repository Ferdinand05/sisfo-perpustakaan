<?= $this->extend('template/index'); ?>

<?= $this->section('content-title'); ?>
Daftar Pengembalian Buku
<?= $this->endSection(); ?>

<?= $this->section('content-subtitle'); ?>
<button type="button" class="btn btn-success" id="btnTambahPengembalian" data-toggle="tooltip" data-placement="bottom" title="Tombol Tambah Data Pengembalian"><i class="fas fa-undo-alt"></i> Pengembalian</button>

<script>
    $(document).ready(function() {
        $('#btnTambahPengembalian').tooltip();
    });
</script>
<?= $this->endSection(); ?>


<?= $this->section('content'); ?>






<?= $this->endSection(); ?>


<?= $this->section('content-footer'); ?>
<?= $this->endSection(); ?>
<?= $this->extend('template/index'); ?>


<?= $this->section('content-title'); ?>
Daftar Petugas Perpustakaan &nbsp; <i class="fa fa-user-shield"></i>
<?= $this->endSection(); ?>

<?= $this->section('content-subtitle'); ?>
<button type="button" class="btn btn-success" id="btnModalPetugas"><i class="fa fa-plus"></i> Petugas</button>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <table class="table table-bordered table-hover dataTable dtr-inline collapsed" style="width: 100%;" id="tablePetugas">
        <thead class="bg-dark">
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>Telepon</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>

<div class="viewModalPetugas"></div>

<script>
    function listDataPetugas() {

        $('#tablePetugas').DataTable({

            destroy: true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "/petugas/listDataPetugas",
                "type": "POST",
            },
            "columnDefs": [{
                "targets": [0, 4],
                "orderable": false,
            }, ],
        })
    }

    $(document).ready(function() {
        listDataPetugas();

        $('#btnModalPetugas').click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: "/petugas/modalTambahPetugas",
                dataType: "json",
                success: function(response) {
                    $('.viewModalPetugas').html(response.data);
                    $('#modalTambahPetugas').modal('show');
                }
            });
        });

    });
</script>


<?= $this->endSection(); ?>




<?= $this->section('content-footer'); ?>
<?= $this->endSection(); ?>
<?= $this->extend('template/index'); ?>

<?= $this->section('content-title'); ?>
Daftar Pengembalian Buku
<?= $this->endSection(); ?>

<?= $this->section('content-subtitle'); ?>
<button type="button" class="btn btn-success" id="btnTambahPengembalian" data-toggle="tooltip" data-placement="bottom" title="Tombol Tambah Data Pengembalian"><i class="fas fa-undo-alt"></i> Pengembalian</button>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <table class="table table-bordered table-hover dataTable dtr-inline collapsed" style="width: 100%;" id="tablePengembalian">
        <thead class="bg-dark">
            <th>No.</th>
            <th>Nama</th>
            <th>Jatuh Tempo</th>
            <th>Tanggal Pengembalian</th>
            <th>Judul Buku</th>
            <th>Denda</th>
            <th style="width: 14%;">Aksi</th>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>


<div class="viewModalPengembalian"></div>


<script>
    function listDataPengembalian() {

        $('#tablePengembalian').DataTable({

            destroy: true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "/pengembalian/listDataPengembalian",
                "type": "POST",
            },
            "columnDefs": [{
                "targets": [0, 4, 5, 6],
                "orderable": false,
            }, ],
        })
    }

    function editPengembalian(id_pengembalian) {
        $.ajax({
            type: "post",
            url: "/pengembalian/modalEditPengembalian",
            data: {
                id_pengembalian: id_pengembalian
            },
            dataType: "json",
            success: function(response) {

                if (response.data) {
                    let d = response.data;
                    $('.viewModalPengembalian').html(response.data);
                    $('#modalEditPengembalian').modal('show');
                }
            }
        });
    }

    function deletePengembalian(id_pengembalian) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Delete'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "/pengembalian/deletePengembalian",
                    data: {
                        id_pengembalian: id_pengembalian
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            Swal.fire(
                                'Good job!',
                                response.success,
                                'success'
                            )
                            listDataPengembalian();
                        }
                    }
                });
            }
        })
    }

    function detailPengembalian(id_pengembalian) {
        $.ajax({
            type: "post",
            url: "/pengembalian/detailPengembalian",
            data: {
                id_pengembalian: id_pengembalian
            },
            dataType: "json",
            success: function(response) {
                $('.viewModalPengembalian').html(response.data);
                $('#modalDetailPengembalian').modal('show');
            }
        });
    }






    $('#btnTambahPengembalian').click(function(e) {
        e.preventDefault();
        $.ajax({
            type: "post",
            url: "/pengembalian/modalTambahPengembalian",
            dataType: "json",
            beforeSend: function() {
                $('#btnTambahPengembalian').prop('disabled', true);
                $('#btnTambahPengembalian').html('<i class="fa fa-spinner fa-spin"></i>');
            },
            complete: function() {
                $('#btnTambahPengembalian').prop('disabled', false);
                $('#btnTambahPengembalian').html('<i class="fas fa-undo-alt"></i> Pengembalian');

            },
            success: function(response) {
                $('.viewModalPengembalian').html(response.data);
                $('#modalTambahPengembalian').modal('show');
            }
        });
    });

    $(document).ready(function() {
        listDataPengembalian();



        $('#btnTambahPengembalian').tooltip();
    });
</script>
<?= $this->endSection(); ?>


<?= $this->section('content-footer'); ?>
<?= $this->endSection(); ?>
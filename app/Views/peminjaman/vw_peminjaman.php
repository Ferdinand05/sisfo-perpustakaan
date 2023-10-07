<?= $this->extend('template/index'); ?>


<?= $this->section('content-title'); ?>
Peminjaman Buku
<?= $this->endSection(); ?>

<?= $this->section('content-subtitle'); ?>
<button type="button" class="btn btn-success" id="btnModalPinjam"><i class="fa fa-book"></i> Pinjam</button>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<dvi class="container-fluid">
    <table class=" table table-bordered table-hover dataTable dtr-inline collapsed" style="width: 100%;" id="tablePeminjaman">
        <thead class="bg-dark">
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th style="width:14%;">Tanggal Peminjaman</th>
                <th style="width: 14%;">Tanggal Jatuh Tempo</th>
                <th>Judul Buku</th>
                <th>Petugas</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</dvi>

<div class="viewModalPeminjaman"></div>


<script>
    function listDataPeminjaman() {

        $('#tablePeminjaman').DataTable({

            destroy: true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "/peminjaman/listDataPeminjaman",
                "type": "POST",
            },
            "columnDefs": [{
                "targets": [4, 5, 6],
                "orderable": false,
            }, ],
        })
    }


    function hapusPeminjaman(id_peminjaman) {
        Swal.fire({
            title: 'Delete!',
            text: "Apakah anda yakin?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Delete'
        }).then((result) => {
            if (result.isConfirmed) {

                // ajax
                $.ajax({
                    type: "post",
                    url: "/peminjaman/deletePeminjaman",
                    data: {
                        id_peminjaman: id_peminjaman
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: response.success,
                                showConfirmButton: false,
                                timer: 1200
                            })
                            listDataPeminjaman();
                        }
                    }
                });

            }
        })
    }

    function detailPeminjaman(id_peminjaman) {
        $.ajax({
            type: "post",
            url: "/peminjaman/showModalDetail",
            data: {
                id_peminjaman: id_peminjaman
            },
            dataType: "json",
            success: function(response) {
                $('.viewModalPeminjaman').html(response.data);
                $('#modalDetailPeminjaman').modal('show');
            }
        });
    }


    function editPeminjaman(id_peminjaman) {
        $.ajax({
            type: "post",
            url: "/peminjaman/modalEdit",
            data: {
                id_peminjaman: id_peminjaman
            },
            dataType: "json",
            success: function(response) {
                $('.viewModalPeminjaman').html(response.data);
                $('#modalEditPeminjaman').modal('show');
            }
        });
    }




    $('#btnModalPinjam').click(function(e) {
        e.preventDefault();
        $.ajax({
            type: "post",
            url: "/peminjaman/modalTambahPeminjam",
            dataType: "json",
            beforeSend: function() {
                $('#btnModalPinjam').prop('disabled', true);
                $('#btnModalPinjam').html('<i class="fas fa-spinner fa-spin"></i>');
            },
            complete: function() {
                $('#btnModalPinjam').prop('disabled', false);
                $('#btnModalPinjam').html('<i class="fa fa-book"></i> Pinjam');
            },
            success: function(response) {
                $('.viewModalPeminjaman').html(response.data);
                $('#modalTambahPeminjam').modal('show');
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    });




    $(document).ready(function() {
        listDataPeminjaman();
    });
</script>

<?= $this->endSection(); ?>


<?= $this->section('content-footer'); ?>
<?= $this->endSection(); ?>
<?= $this->extend('template/index'); ?>




<?= $this->section('content-title'); ?>
Daftar Buku
<?= $this->endSection(); ?>

<?= $this->section('content-subtitle'); ?>
<button type="button" class="btn btn-success " id="btnTambahBuku"><i class="fas fa-plus-circle"></i> Buku</button>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <table class="table table-bordered table-hover dataTable dtr-inline collapsed" style="width: 100%;" id="tableBuku">
        <thead class="bg-dark">
            <tr>
                <th>No</th>
                <th>Kode Buku</th>
                <th>Judul Buku</th>
                <th>Penulis</th>
                <th>Penerbit</th>
                <th>Tahun Penerbit</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>

<div class="viewModalBuku"></div>

<script>
    function listDataBuku() {

        $('#tableBuku').DataTable({

            destroy: true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "/buku/listDataBuku",
                "type": "POST",
            },
            "columnDefs": [{
                "targets": [0, 5],
                "orderable": false,
            }, ],
        })
    }

    function hapusBuku(id) {

        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Buku yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Delete'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "/buku/hapusBuku",
                    data: {
                        id_buku: id
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire(
                                'Good job!',
                                response.sukses,
                                'success'
                            );
                            listDataBuku();
                        }
                    }
                });
            }
        })



    }



    $('#btnTambahBuku').click(function(e) {
        e.preventDefault();
        $.ajax({
            type: "post",
            url: "/buku/modalTambahBuku",
            dataType: "json",
            success: function(response) {
                $('.viewModalBuku').html(response.data);
                $('#modalTambahBuku').modal('show');
            }
        });
    });

    $(document).ready(function() {
        listDataBuku();
    });
</script>


<?= $this->endSection(); ?>

<?= $this->section('content-footer'); ?>
<button class="btn btn-primary"></button>
<?= $this->endSection(); ?>
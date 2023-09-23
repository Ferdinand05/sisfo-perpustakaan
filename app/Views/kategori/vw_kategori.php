<?= $this->extend('template/index'); ?>




<?= $this->section('content-title'); ?>
Kategori Buku
<?= $this->endSection(); ?>

<?= $this->section('content-subtitle'); ?>
<button class="btn btn-success" id="btnModalKategori"><i class="fa fa-plus"></i> Kategori</button>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="container">
    <table class="table table-bordered table-hover dataTable dtr-inline collapsed" style="width: 100%;" id="tableKategori">
        <thead class="bg-dark">
            <tr>
                <th>No</th>
                <th>Nama Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>

<div class="viewModalKategori"></div>

<script>
    function listDataKategori() {

        $('#tableKategori').DataTable({

            destroy: true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "/kategori/listDataKategori",
                "type": "POST",
            },
            "columnDefs": [{
                "targets": [0, 2],
                "orderable": false,
            }, ],
        })
    }

    function hapusKategori(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Kategori yang dihapus Tidak Bisa Dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "/kategori/hapusKategori",
                    data: {
                        id_kategori: id
                    },
                    dataType: "json",
                    success: function(response) {
                        Swal.fire(
                            'Good job!',
                            response.sukses,
                            'success'
                        )
                        listDataKategori();
                    }
                });
            }
        })
    }


    $('#btnModalKategori').click(function(e) {
        e.preventDefault();
        $.ajax({
            type: "post",
            url: "/kategori/modalTambahKategori",
            dataType: "json",
            success: function(response) {
                $('.viewModalKategori').html(response.data);
                $('#modalTambahKategori').modal('show');
            }
        });
    });



    $(document).ready(function() {
        listDataKategori()
    });
</script>
<?= $this->endSection(); ?>

<?= $this->section('content-footer'); ?>
<?= $this->endSection(); ?>
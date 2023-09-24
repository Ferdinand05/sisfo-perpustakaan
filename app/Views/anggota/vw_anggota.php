<?= $this->extend('template/index'); ?>


<?= $this->section('content-title'); ?>
Daftar Anggota &nbsp;&nbsp;<i class="fas fa-users"></i>
<?= $this->endSection(); ?>

<?= $this->section('content-subtitle'); ?>
<button type="button" class="btn btn-success" id="btnModalAnggota"><i class="fa fa-plus"></i> Angggota</button>
<?= $this->endSection(); ?>


<?= $this->section('content'); ?>
<div class="container-fluid">
    <table class="table table-bordered table-hover dataTable dtr-inline collapsed" style="width: 100%;" id="tableAnggota">
        <thead class="bg-dark">
            <tr>
                <th>No.</th>
                <th>NIM</th>
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

<div class="viewModalAnggota"></div>

<script>
    function listDataAnggota() {

        $('#tableAnggota').DataTable({

            destroy: true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "/anggota/listDataAnggota",
                "type": "POST",
            },
            "columnDefs": [{
                "targets": [0, 3, 4, 5],
                "orderable": false,
            }, ],
        })
    }

    function hapusAnggota(id_anggota) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Anggota yang dihapus tidak bisa Dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    type: "post",
                    url: "/anggota/hapusAnggota",
                    data: {
                        id_anggota: id_anggota
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire(
                                'Deleted!',
                                response.sukses,
                                'success'
                            )
                            listDataAnggota();
                        }
                    }
                });

            }
        })
    }

    function editAnggota(id_anggota) {
        $.ajax({
            type: "post",
            url: "/anggota/modalEditAnggota",
            data: {
                id_anggota: id_anggota
            },
            dataType: "json",
            success: function(response) {
                $('.viewModalAnggota').html(response.data);
                $('#modalEditAnggota').modal('show')
            }
        });
    }




    $(document).ready(function() {
        listDataAnggota();


        $('#btnModalAnggota').click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: "/anggota/modalTambahAnggota",
                dataType: "json",
                success: function(response) {
                    $('.viewModalAnggota').html(response.data);
                    $('#modalTambahAnggota').modal('show');
                }
            });
        });

    });
</script>


<?= $this->endSection(); ?>


<?= $this->section('content-footer'); ?>
<?= $this->endSection(); ?>
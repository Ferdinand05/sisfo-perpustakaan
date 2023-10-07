<!-- Modal -->
<div class="modal fade" id="modalTambahPengembalian" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Data Pengembalian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= form_open('/pengembalian/addPengembalian', ['class' => 'formPengembalian']); ?>
                <?= csrf_field() ?>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tgl_pengembalian">
                                Tanggal Pengembalian Buku
                            </label>
                            <div class="input-group">
                                <input type="date" class="form-control" name="tgl_pengembalian" id="tgl_pengembalian" value="<?= date('Y-m-d'); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-md">
                        <label for="" class="small text-danger">Notes</label>
                        <p class="small ">Jika Tanggal Pengembalian Melewati Jatuh Tempo Akan dikenakan Denda sebesar Rp.15.000</p>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Cari Data Peminjaman</label>
                            <div class="input-group">
                                <button type="button" class="btn btn-info btn-block" id="btnListPeminjaman" data-toggle="tooltip" data-placement="bottom" title="Click Untuk Mencari List"><i class="fa fa-list"></i></button>
                                <input type="hidden" id="id_peminjaman">
                                <input type="hidden" name="id_petugas" id="id_petugas">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="nama">Nama Anggota</label>
                            <div class="input-group">
                                <input type="text" name="nama" id="nama" class="form-control" disabled>
                                <input type="hidden" name="id_anggota" id="id_anggota">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="judul_buku">Judul Buku</label>
                            <div class="input-group">
                                <input type="text" name="judul_buku" id="judul_buku" class="form-control" disabled>
                                <input type="hidden" name="id_buku" id="id_buku">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="jatuhTempo">Tanggal Jatuh Tempo</label>
                            <div class="input-group">
                                <input type="date" name="jatuhTempo" id="jatuhTempo" class="form-control" disabled>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10">
                        <div class="input-group">
                            <button type="submit" class="btn btn-warning btn-block" title="Selesaikan">Submit</button>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="input-group">
                            <button type="reset" class="btn btn-dark" title="Reset Form"><i class="fa fa-sync-alt"></i></button>
                        </div>
                    </div>
                </div>
                <?= form_close(); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="viewModalListPengembalian"></div>

<script>
    $('#btnListPeminjaman').click(function(e) {
        e.preventDefault();
        $.ajax({
            type: "post",
            url: "/pengembalian/modalListPengembalian",
            dataType: "json",
            success: function(response) {
                $('.viewModalListPengembalian').html(response.data);
                $('#modalListPeminjaman').modal('show');
            }
        });
    });

    $('.formPengembalian').submit(function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Apakah anda yakin ?',
            text: "Data Akan Disimpan",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Submit'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "/pengembalian/addPengembalian",
                    data: {
                        id_peminjaman: $('#id_peminjaman').val(),
                        tgl_pengembalian: $('#tgl_pengembalian').val(),
                        id_anggota: $('#id_anggota').val(),
                        id_buku: $('#id_buku').val(),
                        id_petugas: $('#id_petugas').val()
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            Swal.fire(
                                'Good job!',
                                response.success,
                                'success'
                            );
                            $('#modalTambahPengembalian').modal('hide');
                            listDataPengembalian();
                        }
                    }
                });
            }
        })
    });


    $(document).ready(function() {
        $('#btnListPeminjaman').tooltip();



    });
</script>
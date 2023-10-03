<!-- Modal -->
<div class="modal fade" id="modalEditPeminjaman" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Edit Data Peminjaman</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="container">
                <div class="modal-body">
                    <?= form_open('/peminjaman/editPeminjaman', ['class' => 'formEditPeminjaman']); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Tanggal Peminjaman</label>
                                <div class="input-group">
                                    <input type="date" name="" id="" class="form-control" value="<?= $peminjaman['tanggal_pinjam']; ?>" disabled>
                                    <input type="hidden" name="id-peminjaman" id="id-peminjaman" value="<?= $peminjaman['id_peminjaman']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tgl_pengembalian">Tanggal Pengembalian*</label>
                                <div class="input-group">
                                    <input type="date" name="tgl_pengembalian" id="tgl_pengembalian" class="form-control" value="<?= $peminjaman['tanggal_kembali']; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="buku-pinjam">List Buku Tersedia*</label>
                                <div class="input-group">
                                    <button type="button" class="btn btn-primary btn-block" id="btnListBuku" data-toggle="tooltip" data-placement="bottom" title="Click untuk melihat List Buku"><i class="fas fa-book-open"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Nama Buku</label>
                                <div class="input-group">
                                    <input type="text" name="nama-buku" id="nama-buku" value="<?= $buku['judul_buku']; ?>" disabled class="form-control">
                                    <input type="hidden" name="id-buku" id="id-buku" value="<?= $peminjaman['id_buku']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Penulis</label>
                                <div class="input-group">
                                    <input type="text" name="nama-penulis" id="nama-penulis" disabled class="form-control" value="<?= $buku['penulis_buku']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Tahun</label>
                                <div class="input-group">
                                    <input type="text" name="tahun-buku" id="tahun-buku" class="form-control" disabled value="<?= $buku['tahun_penerbit']; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="petugas">Petugas*</label>
                                <div class="input-group">
                                    <select name="petugas" id="petugas" class="form-control">
                                        <?php foreach ($allPetugas as $ap) : ?>

                                            <?php if ($ap['id_petugas'] == $selectedPetugas['id_petugas']) : ?>
                                                <option value="<?= $ap['id_petugas']; ?>" selected><?= $ap['nama_petugas']; ?></option>
                                            <?php else : ?>
                                                <option value="<?= $ap['id_petugas']; ?>"><?= $ap['nama_petugas']; ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <dov class="col-md-6">
                            <div class="input-group">
                                <button type="submit" class="btn btn-warning btn-block">Submit</button>
                            </div>
                        </dov>
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
</div>

<div class="viewModalList"></div>

<script>
    $('#btnListBuku').tooltip();

    $('#btnListBuku').click(function(e) {
        e.preventDefault();
        $.ajax({
            type: "post",
            url: "/peminjaman/modalListBuku",
            dataType: "json",
            success: function(response) {
                $('.viewModalList').html(response.data);
                $('#modalListBuku').modal('show');
            }
        });
    });

    $('.formEditPeminjaman').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "post",
            url: "/peminjaman/editPeminjaman",
            data: {
                tgl_pengembalian: $('#tgl_pengembalian').val(),
                id_buku: $('#id-buku').val(),
                id_petugas: $('#petugas').val(),
                id_peminjaman: $('#id-peminjaman').val()
            },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    Swal.fire(
                        'Good job!',
                        response.success,
                        'success'
                    )
                    listDataPeminjaman();
                    $('#modalEditPeminjaman').modal('hide');
                }
            }
        });

    });
</script>
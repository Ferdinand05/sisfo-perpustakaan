<!-- Modal -->
<div class="modal fade" id="modalEditPengembalian" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Edit Data Pengembalian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= form_open('/pengembalian/editPengembalian', ['class' => 'formEditPengembalian']); ?>
                <?= csrf_field() ?>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tgl_pengembalian">
                                Tanggal Pengembalian Buku
                            </label>
                            <div class="input-group">
                                <input type="date" class="form-control" name="tgl_pengembalian" id="tgl_pengembalian" value="<?= $pengembalian['tanggal_pengembalian']; ?>">
                                <input type="hidden" id="id_pengembalian" value="<?= $pengembalian['id_pengembalian']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class=" col-md">
                        <label for="" class="small text-danger">Notes</label>
                        <p class="small ">Jika Tanggal Pengembalian Melewati Jatuh Tempo Akan dikenakan Denda sebesar Rp.15.000</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="nama">Nama Anggota</label>
                            <div class="input-group">
                                <input type="text" name="nama" id="nama" class="form-control" value="<?= $anggota['nama_anggota']; ?>" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="judul_buku">Judul Buku</label>
                            <div class="input-group">
                                <input type="text" name="judul_buku" id="judul_buku" class="form-control" value="<?= $buku['judul_buku']; ?>" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="form-group">
                            <label for="jatuhTempo">Tanggal Jatuh Tempo</label>
                            <div class="input-group">
                                <input type="date" name="jatuhTempo" id="jatuhTempo" class="form-control" value="<?= $pengembalian['jatuhtempo']; ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="petugas">Petugas</label>
                            <div class="input-group">
                                <select name="petugas" id="petugas" class="form-control">

                                    <?php foreach ($allPetugas as $p) : ?>

                                        <?php if ($petugas['id_petugas'] == $p['id_petugas']) : ?>
                                            <option value="<?= $p['id_petugas']; ?>" selected><?= $p['nama_petugas']; ?></option>
                                        <?php else : ?>
                                            <option value="<?= $p['id_petugas']; ?>"><?= $p['nama_petugas']; ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="denda">Denda</label>
                            <div class="input-group">
                                <input type="number" name="denda" id="denda" class="form-control" value="<?= $pengembalian['denda']; ?>" disabled>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10">
                        <div class="input-group">
                            <button type="submit" class="btn btn-warning btn-block" title="Selesaikan">Update</button>
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
    $('.formEditPengembalian').submit(function(e) {
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
                    url: "/pengembalian/editPengembalian",
                    data: {
                        tgl_pengembalian: $('#tgl_pengembalian').val(),
                        petugas: $('#petugas').val(),
                        tgl_jatuhtempo: $('#jatuhTempo').val(),
                        denda: $('#denda').val(),
                        id_pengembalian: $('#id_pengembalian').val()
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            Swal.fire(
                                'Good job!',
                                response.success,
                                'success'
                            );
                            $('#modalEditPengembalian').modal('hide');
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
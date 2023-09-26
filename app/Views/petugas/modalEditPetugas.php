<!-- Modal -->
<div class="modal fade" id="modalEditPetugas" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Edit Petugas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <?= form_open('/petugas/updatePetugas', ['class' => 'formEditPetugas']); ?>
                    <div class="form-group">
                        <label for="nama_petugas">Nama Petugas</label>
                        <input type="hidden" value="<?= $petugas['id_petugas']; ?>" id="id_petugas" name="id_petugas">
                        <div class="input-group">
                            <input type="text" name="nama_petugas" id="nama_petugas" class="form-control" placeholder="Nama..." value="<?= $petugas['nama_petugas']; ?>">
                            <div class="invalid-feedback errorNama"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="telp_petugas">Telepon</label>
                        <div class="input-group">
                            <input type="text" name="telp_petugas" id="telp_petugas" class="form-control" placeholder="089234571221" value="<?= $petugas['no_telp_petugas']; ?>">
                            <div class="invalid-feedback errorTelp"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="alamat_petugas">Alamat Petugas</label>
                        <div class="input-group">
                            <textarea name="alamat_petugas" id="alamat_petugas" rows="3" class="form-control"><?= $petugas['alamat_petugas']; ?></textarea>
                            <div class="invalid-feedback errorAlamat"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <button type="submit" class="btn btn-warning btn-block">Submit</button>
                        </div>
                    </div>
                    <?= form_close(); ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $('.formEditPetugas').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "post",
            url: "/petugas/updatePetugas",
            data: {
                nama_petugas: $('#nama_petugas').val(),
                telp_petugas: $('#telp_petugas').val(),
                alamat_petugas: $('#alamat_petugas').val(),
                id_petugas: $('#id_petugas').val()
            },
            dataType: "json",
            success: function(response) {
                if (response.error) {
                    let e = response.error;

                    if (e.errorNama) {
                        $('#nama_petugas').addClass('is-invalid');
                        $('.errorNama').html(e.errorNama);
                    }

                    if (e.errorTelp) {
                        $('#telp_petugas').addClass('is-invalid');
                        $('.errorTelp').html(e.errorTelp);
                    }

                    if (e.errorAlamat) {
                        $('#alamat_petugas').addClass('is-invalid');
                        $('.errorAlamat').html(e.errorAlamat);
                    }

                }

                if (response.sukses) {
                    Swal.fire(
                        'Good job!',
                        response.sukses,
                        'success'
                    );
                    $('#modalEditPetugas').modal('hide');
                    listDataPetugas();
                }


            }
        });
    });
</script>
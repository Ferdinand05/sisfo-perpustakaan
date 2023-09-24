<!-- Modal -->
<div class="modal fade" id="modalEditAnggota" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Edit Anggota</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <?= form_open('/anggota/updateAnggota', ['class' => 'formAnggota']); ?>
                    <div class="form-group">
                        <label for="nim">NIM*</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="nim" id="nim" placeholder="19220032" disabled value="<?= $anggota['nim']; ?>">
                            <input type="hidden" name="id_anggota" id="id_anggota" value="<?= $anggota['id_anggota']; ?>">
                            <div class="invalid-feedback errorNim"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="nama_anggota" id="nama_anggota" value="<?= $anggota['nama_anggota']; ?>">
                            <div class="invalid-feedback errorNama"></div>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="no_telp">Telepon</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="no_telp" id="no_telp" placeholder="089662006804" value="<?= $anggota['no_telp']; ?>">
                            <div class="invalid-feedback errorTelp"></div>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="alamat_anggota">Alamat</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="alamat_anggota" id="alamat_anggota" placeholder="Alamat anda..." value="<?= $anggota['alamat_anggota']; ?>">
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
    $('.formAnggota').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "post",
            url: "/anggota/updateAnggota",
            data: {
                nim: $('#nim').val(),
                nama_anggota: $('#nama_anggota').val(),
                no_telp: $('#no_telp').val(),
                alamat_anggota: $('#alamat_anggota').val(),
                id_anggota: $('#id_anggota').val()
            },
            dataType: "json",
            success: function(response) {

                // invalid validation
                if (response.error) {
                    let e = response.error;

                    if (e.errorNim) {
                        $('#nim').addClass('is-invalid');
                        $('.errorNim').html(e.errorNim);
                    }
                    if (e.errorNama) {
                        $('#nama_anggota').addClass('is-invalid');
                        $('.errorNama').html(e.errorNama);
                    }
                    if (e.errorTelp) {
                        $('#no_telp').addClass('is-invalid');
                        $('.errorTelp').html(e.errorTelp);
                    }
                    if (e.errorAlamat) {
                        $('#alamat_anggota').addClass('is-invalid');
                        $('.errorAlamat').html(e.errorAlamat);
                    }
                }

                // valid
                if (response.sukses) {

                    Swal.fire(
                        'Good job!',
                        response.sukses,
                        'success'
                    )

                    $('#modalEditAnggota').modal('hide');
                    listDataAnggota();
                }

            }
        });
    });
</script>
<!-- Modal -->
<div class="modal fade" id="modalEditKategori" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Edit Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <?= form_open('/kategori/updateKategori', ['class' => 'formEditKategori']); ?>
                    <div class="form-group mb-3">
                        <label for="namaKategori">Nama Kategori</label>
                        <div class="input-group">
                            <input type="text" name="namaKategori" id="namaKategori" class="form-control" value="<?= $kategori['nama_kategori']; ?>">
                            <input type="hidden" name="id_kategori" id="id_kategori" value="<?= $kategori['id_kategori']; ?>">
                            <div class="invalid-feedback errorKategori">

                            </div>
                        </div>
                    </div>
                    <div class="input-group">
                        <button type="submit" class="btn btn-warning btn-block">Submit</button>
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
    $('.formEditKategori').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "post",
            url: "/kategori/updateKategori",
            data: {
                kategori: $('#namaKategori').val(),
                id_kategori: $('#id_kategori').val()
            },
            dataType: "json",
            success: function(response) {
                if (response.errorKategori) {
                    $('#namaKategori').addClass('is-invalid');
                    $('.errorKategori').html(response.errorKategori);
                }

                if (response.sukses) {
                    Swal.fire(
                        'Good job!',
                        response.sukses,
                        'success'
                    )
                    $('#modalEditKategori').modal('hide');
                    listDataKategori();
                }

            }
        });
    });
</script>
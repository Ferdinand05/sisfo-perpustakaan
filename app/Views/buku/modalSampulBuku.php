<!-- Modal -->
<div class="modal fade" id="modalSampulBuku" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Upload Cover/Sampul Buku</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open_multipart('/buku/uploadSampul', ['class' => 'formSampul']) ?>
            <?= csrf_field(); ?>
            <div class="container">


                <div class="modal-body">

                    <div class="row">
                        <div class="col-md">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Upload Sampul</span>
                                </div>
                                <input type="hidden" value="<?= $id_buku; ?>" id="idBuku" name="idBuku">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="sampulBuku" name="sampulBuku">
                                    <label class="custom-file-label" for="sampulBuku">Choose file</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md">
                            <div class="errorSampulBuku small" id="errorSampul" style="color: red;">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="btnSampul">Save changes</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>


<script>
    $('.formSampul').submit(function(e) {
        e.preventDefault();
        let form = $('.formSampul')[0];
        let data = new FormData(form);

        $.ajax({
            type: "post",
            url: "/buku/uploadSampul",
            data: data,
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            cache: false,
            dataType: "json",
            success: function(response) {
                if (response.error) {

                    let e = response.error;
                    if (e.errorSampul) {
                        $('#sampulBuku').addClass('is-invalid');
                        $('.errorSampulBuku').html(e.errorSampul);
                        $('#errorSampul').html(e.errorSampul);
                    }

                }

                if (response.sukses) {
                    $('#modalSampulBuku').modal('hide');
                    Swal.fire({
                        title: 'Sweet!',
                        text: response.sukses,
                        imageUrl: '/images/' + response.sampul,
                        imageWidth: 300,
                        imageHeight: 300,
                        imageAlt: 'Custom image',
                    })
                }

            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });


    });
</script>
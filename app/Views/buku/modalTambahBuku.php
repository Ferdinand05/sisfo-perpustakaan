<!-- Modal -->
<div class="modal fade" id="modalTambahBuku" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Buku</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= form_open('/buku/tambahBuku', ['class' => 'formBuku', 'enctype' => 'multipart/form-data']) ?>

                <div class="form-group">
                    <label for="kode_buku">Kode Buku</label>
                    <div class="input-group mb-2">
                        <input type="text" name="kode_buku" id="kode_buku" class="form-control" placeholder="BKS01">
                        <div class="invalid-feedback errorKode">

                        </div>
                    </div>
                    <label for="judul_buku">Judul</label>
                    <div class="input-group mb-2">
                        <input type="text" name="judul_buku" id="judul_buku" class="form-control">
                        <div class="invalid-feedback errorJudul">

                        </div>
                    </div>
                    <label for="penulis">Penulis</label>
                    <div class="input-group mb-2">
                        <input type="text" name="penulis_buku" id="penulis_buku" class="form-control">
                        <div class="invalid-feedback errorPenulis">

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md">
                            <label for="penerbit">Penerbit & Kategori Buku</label </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md">
                            <div class="input-group mb-2">
                                <input type="text" name="penerbit" id="penerbit" class="form-control">
                                <div class="invalid-feedback errorPenerbit">
                                </div>
                            </div>
                        </div>
                        <div class="col-md">
                            <select name="kategori_buku" id="kategori_buku" class="form-control">
                                <option value="" selected disabled>Pilih Kategori</option>
                                <?php foreach ($kategori as $k) : ?>
                                    <option value="<?= $k['id_kategori']; ?>"><?= $k['nama_kategori']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback errorKategori">

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="tahun_terbit">Tahun Penerbit & Stok</label>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="tahun_terbit" name="tahun_terbit" placeholder="2004">
                            <div class="invalid-feedback errorTahun">

                            </div>
                        </div>
                        <div class="col-md-6">
                            <input type="number" name="stok_buku" id="stok_buku" class="form-control" placeholder="Stok Buku">
                            <div class="invalid-feedback errorStok">

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md">
                            <div class="input-group">
                                <button type="submit" class="btn btn-warning btn-block">Submit</button>
                            </div>
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

<script>
    $('.formBuku').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "post",
            url: "/buku/tambahBuku",
            data: {
                kode_buku: $('#kode_buku').val(),
                judul_buku: $('#judul_buku').val(),
                penulis_buku: $('#penulis_buku').val(),
                penerbit: $('#penerbit').val(),
                tahun_terbit: $('#tahun_terbit').val(),
                stok_buku: $('#stok_buku').val(),
                kategori_buku: $('#kategori_buku').val()
            },
            dataType: "json",
            success: function(response) {

                if (response.error) {
                    let e = response.error;

                    if (e.errorKode) {
                        $('#kode_buku').addClass('is-invalid');
                        $('.errorKode').html(e.errorKode);
                    }
                    if (e.errorJudul) {
                        $('#judul_buku').addClass('is-invalid');
                        $('.errorJudul').html(e.errorJudul);
                    }
                    if (e.errorPenulis) {
                        $('#penulis_buku').addClass('is-invalid');
                        $('.errorPenulis').html(e.errorPenulis);
                    }
                    if (e.errorPenerbit) {
                        $('#penerbit').addClass('is-invalid');
                        $('.errorPenerbit').html(e.errorPenerbit);
                    }
                    if (e.errorTahun) {
                        $('#tahun_terbit').addClass('is-invalid');
                        $('.errorTahun').html(e.errorTahun);
                    }
                    if (e.errorStok) {
                        $('#stok_buku').addClass('is-invalid');
                        $('.errorStok').html(e.errorStok);
                    }
                    if (e.errorKategori) {
                        $('#kategori_buku').addClass('is-invalid');
                        $('.errorKategori').html(e.errorKategori);
                    }

                }

                if (response.sukses) {
                    Swal.fire(
                        'Good job!',
                        response.sukses,
                        'success'
                    );

                    $('#modalTambahBuku').modal('hide');
                    listDataBuku();
                }


            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    });
</script>
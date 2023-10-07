<!-- Modal -->
<div class="modal fade" id="modalTambahPeminjam" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Peminjam Buku</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <?= form_open('/peminjaman/addPeminjam', ['class' => 'formPeminjam']); ?>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tgl-pinjam">Tanggal Peminjaman</label>
                                <div class="input-group">
                                    <input type="date" name="tgl-peminjam" id="tgl-peminjam" value="<?= date('Y-m-d'); ?>" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="durasi-pinjam">Durasi Peminjaman</label>
                                <div class="input-group">
                                    <select name="durasi-pinjam" id="durasi-pinjam" class="form-control">
                                        <option value="2 day">2 Hari</option>
                                        <option value="3 day">3 Hari</option>
                                        <option value="5 day">5 Hari</option>
                                        <option value="7 day">1 Minggu</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="buku-pinjam">List Buku Tersedia</label>
                                <div class="input-group">
                                    <button type="button" class="btn btn-primary btn-block" id="btnListBuku" data-toggle="tooltip" data-placement="bottom" title="Click untuk melihat List Buku"><i class="fas fa-book-open"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Nama Buku</label>
                                <div class="input-group">
                                    <input type="text" name="nama-buku" id="nama-buku" value="" disabled class="form-control">
                                    <input type="hidden" name="id-buku" id="id-buku">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Penulis</label>
                                <div class="input-group">
                                    <input type="text" name="nama-penulis" id="nama-penulis" disabled class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Tahun</label>
                                <div class="input-group">
                                    <input type="text" name="tahun-buku" id="tahun-buku" class="form-control" disabled>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nama-member">List Member</label>
                                <div class="input-group">
                                    <button type="button" class="btn btn-primary btn-block" id="btnListMember" data-toggle="tooltip" data-placement="bottom" title="Click untuk melihat List Member"><i class="fas fa-user-check"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Nama Member</label>
                                <div class="input-group">
                                    <input type="text" name="member-pinjam" id="member-pinjam" disabled class="form-control">
                                    <input type="hidden" name="id-member" id="id-member">
                                </div>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-group">
                                <label for="">Nama Petugas</label>
                                <div class="input-group">
                                    <select name="petugas-pinjam" id="petugas-pinjam" class="form-control">
                                        <?php foreach ($petugas as $p) : ?>
                                            <option value="<?= $p['id_petugas']; ?>"><?= $p['nama_petugas']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md">
                            <div class="form-group">
                                <div class="input-group">
                                    <button type="submit" class="btn btn-warning btn-block" id="btnAddPeminjam">Submit</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-group">
                                <div class="input-group">
                                    <button type="reset" class="btn btn-dark"><i class="fa fa-sync"></i></button>
                                </div>
                            </div>
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

<div class="viewModalList"></div>

<script>
    $(document).ready(function() {


        $('.formPeminjam').submit(function(e) {
            e.preventDefault();

            if ($('#nama-buku').val() == "" || $('#member-pinjam').val() == "") {
                Swal.fire(
                    'Data Tidak Lengkap',
                    'Nama & Buku tidak boleh kosong!',
                    'question'
                )
            } else {

                Swal.fire({
                    title: 'Confirm!',
                    text: "Apakah anda yakin?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Submit'
                }).then((result) => {
                    if (result.isConfirmed) {

                        // ajax
                        $.ajax({
                            type: "post",
                            url: "/peminjaman/addPeminjam",
                            data: {
                                tgl_pinjam: $('#tgl-peminjam').val(),
                                durasi_pinjam: $('#durasi-pinjam').val(),
                                id_buku: $('#id-buku').val(),
                                id_member: $('#id-member').val(),
                                id_petugas: $('#petugas-pinjam').val()
                            },
                            dataType: "json",
                            beforeSend: function() {
                                $('#btnAddPeminjam').prop('disabled', true);
                                $('#btnAddPeminjam').html('<i class="fa fa-spinner fa-spin"></i>');
                            },
                            complete: function() {
                                $('#btnAddPeminjam').prop('disabled', false);
                                $('#btnAddPeminjam').html('Submit');
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        position: 'center',
                                        icon: 'success',
                                        title: 'Your work has been saved',
                                        showConfirmButton: false,
                                        timer: 1500
                                    })
                                    $('#modalTambahPeminjam').modal('hide');
                                    listDataPeminjaman();
                                }

                                if (response.error) {
                                    Swal.fire(
                                        'Oopss',
                                        response.error,
                                        'error'
                                    )
                                }

                            }
                        });

                    }
                })

            }

        });




        $('#btnListBuku').tooltip();
        $('#btnListMember').tooltip();


        $('#btnListMember').click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: "/peminjaman/modalListMember",
                dataType: "json",
                success: function(response) {
                    $('.viewModalList').html(response.data);
                    $('#modalListMember').modal('show');
                }
            });
        });

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


    });
</script>
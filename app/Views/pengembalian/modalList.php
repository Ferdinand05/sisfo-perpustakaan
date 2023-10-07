<!-- Modal -->
<div class="modal fade" id="modalListPeminjaman" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-sm table-bordered table-hover dataTable dtr-inline collapsed" style="width: 100%;" id="tableListPeminjaman">
                    <thead>
                        <tr>
                            <th style="width: 5%;">No.</th>
                            <th>Nama</th>
                            <th style="width:15%;">Tanggal Peminjaman</th>
                            <th style="width: 15%;">Jatuh Tempo</th>
                            <th>Judul Buku</th>
                            <th>Petugas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    function listCariDataPeminjaman() {

        $('#tableListPeminjaman').DataTable({

            destroy: true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "/pengembalian/listCariDataPeminjaman",
                "type": "POST",
            },
            "columnDefs": [{
                "targets": [4, 5, 6],
                "orderable": false,
            }, ],
        })
    }

    function selectPeminjaman(id_peminjaman) {
        $.ajax({
            type: "post",
            url: "/pengembalian/selectPeminjaman",
            data: {
                id_peminjaman: id_peminjaman
            },
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    let data = response.data;

                    $('#nama').val(data.anggota['nama_anggota']);
                    $('#id_anggota').val(data.anggota['id_anggota']);
                    $('#judul_buku').val(data.buku['judul_buku']);
                    $('#id_buku').val(data.buku['id_buku']);
                    $('#id_peminjaman').val(data.peminjaman['id_peminjaman']);
                    $('#jatuhTempo').val(data.peminjaman['tanggal_kembali']);
                    $('#id_petugas').val(data.petugas['id_petugas']);

                    $('#modalListPeminjaman').modal('hide');
                }
            }
        });
    }

    $(document).ready(function() {
        listCariDataPeminjaman();
    });
</script>
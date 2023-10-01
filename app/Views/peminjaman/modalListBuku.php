<!-- Modal -->
<div class="modal fade" id="modalListBuku" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Daftar Buku Tersedia</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <table class="table table-sm table-bordered table-hover dataTable dtr-inline collapsed" style="width: 100%;" id="tableListBuku">
                        <thead class="bg-dark">
                            <tr>
                                <th>No</th>
                                <th>Kode Buku</th>
                                <th>Judul Buku</th>
                                <th>Kategori</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="viewModalBuku"></div>
<script>
    function listCariDataBuku() {

        $('#tableListBuku').DataTable({

            destroy: true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "/peminjaman/listCariDataBuku",
                "type": "POST",
            },
            "columnDefs": [{
                "targets": [0, 5],
                "orderable": false,
            }, ],
        })
    }

    function selectBuku(id_buku) {
        $.ajax({
            type: "post",
            url: "/peminjaman/getDataBuku",
            data: {
                id_buku: id_buku
            },
            dataType: "json",
            success: function(response) {

                if (response.data) {
                    let data = response.data;

                    $('#nama-buku').val(data.buku['judul_buku']);
                    $('#nama-penulis').val(data.buku['penulis_buku']);
                    $('#tahun-buku').val(data.buku['tahun_penerbit']);
                    $('#id-buku').val(data.buku['id_buku']);


                    $('#modalListBuku').modal('hide');
                }

            }
        });
    }


    function detailBuku(id) {
        $.ajax({
            type: "post",
            url: "/buku/modalDetailBuku",
            data: {
                id_buku: id
            },
            dataType: "json",
            success: function(response) {
                $('.viewModalBuku').html(response.data);
                $('#modalDetailBuku').modal('show');
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    }


    $(document).ready(function() {
        listCariDataBuku();
    });
</script>
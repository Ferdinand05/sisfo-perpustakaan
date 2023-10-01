<!-- Modal -->
<div class="modal fade" id="modalListMember" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">List Member</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-sm table-bordered table-hover dataTable dtr-inline collapsed" style="width: 100%;" id="tableListMember">
                    <thead class="bg-dark">
                        <tr>
                            <th>No.</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Telepon</th>
                            <th>Alamat</th>
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
    function listCariDataAnggota() {

        $('#tableListMember').DataTable({

            destroy: true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "/peminjaman/listCariDataAnggota",
                "type": "POST",
            },
            "columnDefs": [{
                "targets": [0, 3, 4, 5],
                "orderable": false,
            }, ],
        })
    }

    function selectAnggota(id_anggota) {
        $.ajax({
            type: "post",
            url: "/peminjaman/getDataAnggota",
            data: {
                id_anggota: id_anggota
            },
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    let data = response.data;

                    $('#member-pinjam').val(data.anggota['nama_anggota']);
                    $('#id-member').val(data.anggota['id_anggota']);

                    $('#modalListMember').modal('hide');

                }
            }
        });
    }



    $(document).ready(function() {
        listCariDataAnggota();
    });
</script>
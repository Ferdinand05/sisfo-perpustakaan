<!-- Modal -->
<div class="modal fade" id="modalDetailPeminjaman" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Peminjaman</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <ul class="list-group font-weight-bold">
                        <li class="list-group-item active"><?= $peminjaman['tanggal_pinjam'] . ' Sampai ' . $peminjaman['tanggal_kembali'];   ?></li>
                        <li class="list-group-item list-group-item-info">Peminjam : <?= $anggota['nama_anggota'] . ' (' . $anggota['no_telp'] . ')' ?></li>
                        <li class="list-group-item list-group-item-info">Alamat Peminjam : <?= $anggota['alamat_anggota']; ?></li>
                        <li class="list-group-item list-group-item-info">Judul : <?= $buku['judul_buku']; ?></li>
                        <li class="list-group-item list-group-item-info">Penulis & Tahun Terbit : <?= $buku['penulis_buku'] . ' - ' . $buku['tahun_penerbit']; ?></li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
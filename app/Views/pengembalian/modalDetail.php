<!-- Modal -->
<div class="modal fade" id="modalDetailPengembalian" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Informasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item""><strong> Jatuh Tempo &nbsp;&nbsp; : </strong> <?= $pengembalian['jatuhtempo']; ?></li>

                    <?php if ($pengembalian['tanggal_pengembalian'] > $pengembalian['jatuhtempo']) : ?>
                        <li class=" list-group-item" style="border-bottom: 1px solid red;"><strong> Pengembalian &nbsp;&nbsp; : </strong> <?= $pengembalian['tanggal_pengembalian'] . " (Terlambat)" ?></li>
                <?php else : ?>
                    <li class="list-group-item" style="border-bottom: 1px solid red;"><strong> Pengembalian &nbsp;&nbsp; : </strong> <?= $pengembalian['tanggal_pengembalian'] ?></li>
                <?php endif; ?>

                <li class="list-group-item">Nama &nbsp;&nbsp; : <?= $anggota['nama_anggota']; ?></li>
                <li class="list-group-item">Telepon &nbsp;&nbsp; : <?= $anggota['no_telp']; ?></li>
                <li class="list-group-item" style="border-bottom: 1px solid blue;">Alamat &nbsp;&nbsp;: <?= $anggota['alamat_anggota']; ?></li>
                <li class="list-group-item">Buku &nbsp;&nbsp; : <?= $buku['judul_buku']; ?></li>
                <li class="list-group-item">Penulis &nbsp;&nbsp; : <?= $buku['penulis_buku']; ?></li>
                <li class="list-group-item" style="border-bottom:1px solid green">Penerbit &nbsp;&nbsp;: <?= $buku['penerbit_buku'] . " - " . $buku['tahun_penerbit']; ?></li>
                <li class="list-group-item">Petugas &nbsp;&nbsp; : <?= $petugas['nama_petugas']; ?></li>
                <li class="list-group-item">Telepon &nbsp;&nbsp; : <?= $petugas['no_telp_petugas']; ?></li>


                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
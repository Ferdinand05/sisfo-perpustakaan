<!-- Modal -->
<div class="modal fade" id="modalDetailBuku" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card mb-3">
                    <div class="row no-gutters">
                        <div class="col-md-4">
                            <?php if ($buku['sampul'] == null) : ?>
                                <img src="/images/unknown.jpeg" class="img-fluid">
                            <?php else : ?>
                                <img src="/images/<?= $buku['sampul']; ?>" class="img-fluid">
                            <?php endif; ?>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <h5 class="card-title font-weight-bold"><?= $buku['judul_buku']; ?></h5>

                                    </li>
                                    <li class="list-group-item">
                                        <p class="card-text"><strong>Kategori : </strong> <?= $kategori['nama_kategori']; ?></p>
                                    </li>
                                    <li class="list-group-item">
                                        <p class="card-text"><strong>Penulis : </strong> <?= $buku['penulis_buku']; ?></p>
                                    </li>
                                    <li class="list-group-item">
                                        <p><strong>Penerbit : </strong> <?= $buku['penerbit_buku']; ?> - <?= $buku['tahun_penerbit']; ?></p>
                                    </li>
                                    <li class="list-group-item">
                                        <p><strong>Stok : </strong><?= $buku['stok']; ?> </p>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
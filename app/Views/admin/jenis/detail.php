<?= $this->extend('/layout/app') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title"><?= esc($title) ?> - <?= $item->nama_tagihan ?></h4>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#Tambah-data-rekam">
            <i class="fas fa-plus"></i> Tambah Data
        </button>
    </div>
    <div class="card-body">
        <table class="table table-striped" id="table1">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jenis</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $key => $value) : ?>
                <tr>
                    <td><?= $key + 1 ?></td>
                    <td><?= esc($value->nama_penyedia) ?></td>
                    <td align="center">
                        <a href="#" class="btn btn-info"><i class="fa fa-eye"></i>
                            Detail</a>
                        <!-- <a href="/pengguna/ubah/<?= $value->id ?>" class="btn btn-warning"><i class="fa fa-edit"></i> Ubah</a>
                            <a href="/pengguna/delete/<?= $value->id ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                <i class="fa fa-trash"></i> Hapus
                            </a> -->
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>


<div class="modal fade text-left" id="Tambah-data-rekam" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel18">Tambah Data Rekam Medik <?= $item->nama_tagihan ?></h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form action="/jenis/detailsave" method="post">
                <?php csrf_hash() ?>
                <div class="modal-body">
                    <div class="row">

                        <input type="hidden" id="first-name-horizontal" class="form-control" name="jenistagihan_id"
                            value="<?= $item->id ?>">
                        <div class="col-md-3">
                            <label for="first-name-horizontal">Nama Penyedia</label>
                        </div>
                        <div class="col-md-9 form-group">
                            <input type="text" id="first-name-horizontal" class="form-control" name="nama_penyedia"
                                placeholder="nama_penyedia">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="submit" class="btn btn-primary ms-1" data-bs-dismiss="modal">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Accept</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
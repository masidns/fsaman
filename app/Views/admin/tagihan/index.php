<?= $this->extend('/layout/app') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title"><?= esc($title) ?></h4>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#Tambah-data-rekam">
            <i class="fas fa-plus"></i> Tambah Data
        </button>
    </div>
    <div class="card-body">
        <table class="table table-striped" id="table1">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No. Tagihan</th>
                    <th>Nama</th>
                    <th>Jumlah</th>
                    <th>status</th>
                    <th>Penyedia</th>
                    <th>Tempo</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $key => $value) : ?>
                <tr>
                    <td><?= $key + 1 ?></td>
                    <td><?= esc($value->nomor_tagihan) ?></td>
                    <td><?= esc($value->nama) ?></td>
                    <td><?= esc($value->jumlah_tagihan) ?></td>
                    <td><?= esc($value->status_pembayaran) ?></td>
                    <td><?= esc($value->nama_penyedia) ?></td>
                    <td><?= esc($value->tempo) ?></td>
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
                <h4 class="modal-title" id="myModalLabel18">Tagihan</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form action="/tagihan/save" method="post">
                <?php csrf_hash() ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="first-name-horizontal">Nama</label>
                        </div>
                        <div class="col-md-9 form-group">
                            <select class="form-select" id="basicSelect" name="pengguna_id">
                                <option>Pilih Nama Pengguna</option>
                                <?php foreach ($pengguna as $key => $value) : ?>
                                <option value="<?= $value->id ?>"><?= esc($value->nama) ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="first-name-horizontal">Penyedia</label>
                        </div>
                        <div class="col-md-9 form-group">
                        <select class="form-select" id="basicSelect" name="penyedia_id">
                                <option>Pilih Nama Penyedia</option>
                                <?php foreach ($penyedia as $key => $value) : ?>
                                <option value="<?= $value->id ?>"><?= esc($value->nama_penyedia) ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="first-name-horizontal">Jumlah</label>
                        </div>
                        <div class="col-md-9 form-group">
                            <input type="number" id="first-name-horizontal" class="form-control" name="jumlah_tagihan"
                                placeholder="Jumlah Tagihan">
                        </div>
                        <div class="col-md-3">
                            <label for="first-name-horizontal">Tempo</label>
                        </div>
                        <div class="col-md-9 form-group">
                            <input type="date" id="first-name-horizontal" class="form-control" name="tempo"
                                placeholder="Nasma">
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
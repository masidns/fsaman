<?= $this->extend('/layout/app') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title">Tambah Transaksi</h4>
    </div>
    <div class="card-body">
        <form action="/transaksi/save" method="post" class="form form-horizontal">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-3">
                        <label for="jenis-transaksi">Jenis Transaksi</label>
                    </div>
                    <div class="col-md-9 form-group">
                        <select id="jenis-transaksi" class="form-control" name="jenis_transaksi" required>
                            <option value="Pembayaran)">Pembayaran</option>
                            <option value="Transfer">Transfer</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="nominal">Nominal</label>
                    </div>
                    <div class="col-md-9 form-group">
                        <input type="number" id="nominal" class="form-control" name="nominal"
                               placeholder="Nominal Transaksi" required>
                    </div>
                </div>

                <div class="col-sm-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary me-1 mb-1">Simpan</button>
                    <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

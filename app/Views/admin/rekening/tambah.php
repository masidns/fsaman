<?= $this->extend('/layout/app') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title">Tambah Rekening</h4>
    </div>
    <div class="card-body">
        <form action="/rekening/save" method="post" class="form form-horizontal">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-3">
                        <label for="nomor-rekening">Nomor Rekening</label>
                    </div>
                    <div class="col-md-9 form-group">
                        <input type="text" id="nomor-rekening" class="form-control" name="nomor_rekening"
                               placeholder="Nomor Rekening" required>
                    </div>

                    <div class="col-md-3">
                        <label for="bank">Bank</label>
                    </div>
                    <div class="col-md-9 form-group">
                        <select id="bank" class="form-control" name="bank" required>
                            <option value="">Pilih Bank</option>
                            <option value="Mandiri">Mandiri</option>
                            <option value="BCA">BCA</option>
                            <option value="BRI">BRI</option>
                            <option value="BNI">BNI</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="tipe-rekening">Tipe Rekening</label>
                    </div>
                    <div class="col-md-9 form-group">
                        <select id="tipe-rekening" class="form-control" name="tipe" required>
                            <option value="">Pilih Tipe Rekening</option>
                            <option value="Tabungan">Tabungan</option>
                            <option value="Giro">Giro</option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary me-1 mb-1">Lanjutkan</button>
                    <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->extend('/layout/app') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h4 class="card-title"><?= esc($title) ?></h4>
    </div>
    <div class="card-body">
        <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <form action="/pembayaran/cekTagihan" method="post">
            <?= csrf_field(); ?>
            <div class="form-group">
                <label for="jenis_tagihan">Pilih Jenis Tagihan</label>
                <select class="form-control" id="jenis_tagihan" name="penyedia_id" required>
                    <?php foreach ($jenis_tagihan as $penyedia): ?>
                    <option value="<?= esc($penyedia->id) ?>"><?= esc($penyedia->nama_penyedia) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="nomor_tagihan">Nomor Tagihan</label>
                <input type="text" class="form-control" id="nomor_tagihan" name="nomor_tagihan" required>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Cek Tagihan</button>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

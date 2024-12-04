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

        <form action="/transfer/cekRekening" method="post">
            <div class="form-group">
                <label for="nomor_rekening">Masukkan Nomor Rekening Tujuan</label>
                <input type="text" class="form-control" id="nomor_rekening" name="nomor_rekening" required>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Cek Rekening</button>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

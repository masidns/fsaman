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

        <h5>Rekening Tujuan</h5>
        <table class="table">
            <tr>
                <th>Nomor Rekening</th>
                <td><?= esc($rekeningTujuan->nomor_rekening) ?></td>
            </tr>
            <tr>
                <th>Bank</th>
                <td><?= esc($rekeningTujuan->bank) ?></td>
            </tr>
            <tr>
                <th>Nama Pemilik</th>
                <td><?= esc($rekeningTujuan->nama_pemilik) ?></td>
            </tr>
        </table>

        <form action="/transfer/prosesTransfer" method="post">
            <input type="hidden" name="rekening_tujuan" value="<?= esc($rekeningTujuan->nomor_rekening) ?>">
            <div class="form-group">
                <label for="nominal">Masukkan Nominal Transfer</label>
                <input type="number" class="form-control" id="nominal" name="nominal" min="1" required>
            </div>
            <button type="submit" class="btn btn-success mt-3">Lanjutkan Transfer</button>
        </form>

    </div>
</div>

<?= $this->endSection() ?>

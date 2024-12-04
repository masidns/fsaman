<?= $this->extend('/layout/app') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h4 class="card-title">Konfirmasi Pembayaran</h4>
    </div>
    <div class="card-body">
        <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <div class="alert alert-info">
            <h5>Terima kasih! Pembayaran tagihan Anda telah berhasil diproses.</h5>
            <p>Silakan cek riwayat transaksi Anda untuk informasi lebih lanjut.</p>
        </div>

        <a href="<?= site_url('/pembayaran') ?>" class="btn btn-secondary mt-3">Kembali ke Halaman Pembayaran</a>
    </div>
</div>

<?= $this->endSection() ?>

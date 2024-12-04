<?= $this->extend('/layout/app') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title"><?= esc($title) ?></h4>
        <div class="saldo-info">
            <span class="font-weight-bold">Saldo Saat Ini:</span>
            <span class="badge badge-success p-3"
                style="font-size: 1.5rem;"><?= 'Rp. ' . number_format($saldo->saldo_setelah, 0, ',', '.') ?></span>
        </div>
    </div>

    <div class="card-body">
        <table class="table table-striped" id="table1">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal Mutasi</th>
                    <th>Deskripsi</th>
                    <th>Jenis Transaksi</th>
                    <th>Nominal</th>
                    <th>Saldo Akhir</th>
                    <th>Saldo Akhir</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($mutasi as $key => $value) : ?>
                <tr>
                    <td><?= $key + 1 ?></td>
                    <td><?= esc($value->tanggal_mutasi) ?></td>
                    <td><?= esc($value->deskripsi) ?></td>
                    <td><?= esc($value->jenis_transaksi) ?></td>
                    <td><?= esc($value->nominal) ?></td>
                    <td><?= esc(($value->jenis_transaksi)== 'Kredit' ? $value->saldo_setelah : $value->saldo_setelah) ?>
                    </td>
                    <td align="center">
                        aa
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
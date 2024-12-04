<?= $this->extend('/layout/app') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title"><?= esc($title) ?></h4>
        <a href="/jenis/tambah" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Data </a>
    </div>
    <div class="card-body">
        <table class="table table-striped" id="table1">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jenis</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $key => $value) : ?>
                    <tr>
                        <td><?= $key + 1 ?></td>
                        <td><?= esc($value->nama_tagihan) ?></td>
                        <td><?= esc($value->deskripsi) ?></td>
                        <td align="center">
                            <a href="/jenis/detail/<?= $value->id ?>" class="btn btn-info"><i class="fa fa-eye"></i> Detail</a>
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

<?= $this->endSection() ?>

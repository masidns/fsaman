<?= $this->extend('/layout/app') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title">Tambah Data User dan Pengguna</h4>
    </div>
    <div class="card-body">
        <form action="/pengguna/save" method="post" class="form form-horizontal">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-3">
                        <label for="nama">Nama</label>
                    </div>
                    <div class="col-md-9 form-group">
                        <input type="text" id="nama" class="form-control" name="nama" placeholder="Nama" required>
                    </div>

                    <div class="col-md-3">
                        <label for="alamat">Alamat</label>
                    </div>
                    <div class="col-md-9 form-group">
                        <input type="text" id="alamat" class="form-control" name="alamat" placeholder="Alamat" required>
                    </div>

                    <div class="col-md-3">
                        <label for="kontak">Kontak</label>
                    </div>
                    <div class="col-md-9 form-group">
                        <input type="text" id="kontak" class="form-control" name="kontak" placeholder="Kontak" required>
                    </div>

                    <div class="col-md-3">
                        <label for="email">Email</label>
                    </div>
                    <div class="col-md-9 form-group">
                        <input type="email" id="email" class="form-control" name="email" placeholder="Email" required>
                    </div>

                    <div class="col-md-3">
                        <label for="username">Username</label>
                    </div>
                    <div class="col-md-9 form-group">
                        <input type="text" id="username" class="form-control" name="username" placeholder="Username" required>
                    </div>

                    <div class="col-md-3">
                        <label for="password">Password</label>
                    </div>
                    <div class="col-md-9 form-group">
                        <input type="password" id="password" class="form-control" name="password" placeholder="Password" required>
                    </div>

                    <div class="col-md-3">
                        <label for="pin">PIN</label>
                    </div>
                    <div class="col-md-9 form-group">
                        <input type="password" id="pin" class="form-control" name="PIN" placeholder="PIN" required>
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

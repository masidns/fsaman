<?= $this->extend('/layout/app') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title"><?= $title ?></h4>
    </div>
    <div class="card-body">
        <form action="/pengguna/save" method="post" class="form form-horizontal">
            <div class="form-body">

                <div class="row">
                    <div class="col-md-3">
                        <label for="email-horizontal">Nama</label>
                    </div>
                    <div class="col-md-9 form-group">
                        <input type="text" id="email-horizontal" class="form-control" name="nama"
                        placeholder="Nama">
                    </div>
                    <div class="col-md-3">
                        <label for="email-horizontal">Alamat</label>
                    </div>
                    <div class="col-md-9 form-group">
                        <input type="text" id="email-horizontal" class="form-control" name="alamat"
                        placeholder="Alamat">
                    </div>
                    <div class="col-md-3">
                        <label for="email-horizontal">Kontak</label>
                    </div>
                    <div class="col-md-9 form-group">
                        <input type="text" id="email-horizontal" class="form-control" name="kontak"
                        placeholder="Kontak">
                    </div>

                    <div class="col-md-3">
                        <label for="email-horizontal">Email</label>
                    </div>
                    <div class="col-md-9 form-group">
                        <input type="email" id="email-horizontal" class="form-control" name="email"
                        placeholder="Email">
                    </div>
                    <div class="col-md-3">
                        <label for="first-name-horizontal">Username</label>
                    </div>
                    <div class="col-md-9 form-group">
                        <input type="text" id="first-name-horizontal" class="form-control" name="username"
                            placeholder="Username">
                    </div>
                    <div class="col-md-3">
                        <label for="password-horizontal">Password</label>
                    </div>
                    <div class="col-md-9 form-group">
                        <input type="password" id="password-horizontal" class="form-control" name="password"
                            placeholder="Password">
                    </div>
                    <div class="col-md-3">
                        <label for="password-horizontal">PIN</label>
                    </div>
                    <div class="col-md-9 form-group">
                        <input type="password" id="PIN-horizontal" class="form-control" name="PIN"
                            placeholder="PIN">
                    </div>
                    
                </div>
                
                <div class="col-sm-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                    <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
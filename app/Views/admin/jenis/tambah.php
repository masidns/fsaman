<?= $this->extend('/layout/app') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title"><?= $title ?></h4>
    </div>
    <div class="card-body">
        <form action="/jenis/save" method="post" class="form form-horizontal">
            <div class="form-body">

                <div class="row">
                    <div class="col-md-3">
                        <label for="email-horizontal">Nama</label>
                    </div>
                    <div class="col-md-9 form-group">
                        <input type="text" id="email-horizontal" class="form-control" name="nama_tagihan"
                        placeholder="Nama Tagihan">
                    </div>
                    <div class="col-md-3">
                        <label for="email-horizontal">Alamat</label>
                    </div>
                    <div class="col-md-9 form-group">
                        <input type="text" id="email-horizontal" class="form-control" name="deskripsi"
                        placeholder="deskripsi">
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
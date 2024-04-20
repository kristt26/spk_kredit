<?= $this->extend('layout/user/layout') ?>
<?= $this->section('content') ?>
<div class="text-center">
    <img src="<?= base_url("assets/img/bnn.png") ?>" width="8%" alt="">
    <h2>DAFTAR LAPTOP</h2>
    <div class="main-content-inner">
        <div class="card-area">
            <div class="row">
                <?php foreach ($alternatif as $item) : ?>
                    <div class="col-lg-3 col-md-6 mt-5">
                        <div class="card card-bordered">
                            <img class="card-img-top img-fluid" src="/gambar/<?= $item->gambar ?>" style="width:100% ;" alt="image">
                            <div class="card-body">
                                <h6><?= $item->merk . ' ' . $item->type ?></h6>
                                <?php foreach ($item->nilai as $kriteria) : ?>
                                    <?php if ($kriteria['nama'] !== 'Harga') : ?>
                                        <p class="card-text text-left" style="margin-bottom: -3px;"><?= $kriteria['nama']?></p>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                <a href="javascript:void(0);" class="btn btn-primary" style="width: 100%;">Rp. <?= number_format($item->harga, 2, ',', '.')?></a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
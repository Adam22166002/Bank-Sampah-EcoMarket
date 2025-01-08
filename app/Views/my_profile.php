<?= $this->extend('template/index'); ?>

<?= $this->section('page-content'); ?>
<div class="container-fluid py-5">
    <h1 class="h3 mb-4 text-gray-800">My Profile</h1>
    <div class="row g-0">
    <div class="col-md-4">
      <img src="<?= base_url('/Assets/img/' . user()->user_image)?>" class="img-fluid rounded-start" alt="<?= user()->username;?>">
    </div>
        <div class="col-md-8">
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <h4><?= user()->username;?></h4>
                    </li>
                    <?php if( user()->fullname ):?>
                    <li class="list-group-item border-0"><?= user()->fullname;?></li>
                    <?php endif; ?>
                    <li class="list-group-item"><?= user()->email;?></li>
                    <li class="list-group-item">
                        <span class="badge badge-<?= (user()->name == 'admin') ? 'success' : 'warning' ?>"><?= user()->name; ?></span>
                    </li>
                    <li class="list-group-item">
                        <small><a href="<?= base_url('/') ?>">&laquo; back to</a></small>
                    </li>
                </ul>
            </div>
        </div>
  </div>
</div>
<?= $this->endSection(); ?>

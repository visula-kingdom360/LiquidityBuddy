<?= $this->extend("layouts/default") ?>
<?= $this->section("title") ?> Home <?= $this->endSection() ?>
<?= $this->section("content") ?>
    <link rel="stylesheet" href="<?= base_url('assets/css/home.css') ?>">
    <script type="text/javascript" charset="utf8" src="<?= base_url('assets/js/home.js') ?>"></script>
    <div id="demo" class="carousel slide bg-default mb-5" data-bs-ride="carousel">
        <h1>Template Test</h1>
    </div>
    <div class="container mb-5">
    </div>
<?= $this->endSection() ?>

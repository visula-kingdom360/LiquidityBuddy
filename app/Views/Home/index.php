<?= $this->extend("layouts/default") ?>
<?= $this->section("title") ?> Home <?= $this->endSection() ?>
<?= $this->section("content") ?>
    <link rel="stylesheet" href="<?= base_url('assets/css/home.css') ?>">
    <script type="text/javascript" charset="utf8" src="<?= base_url('assets/js/home.js') ?>"></script>
    <div id="demo" class="carousel slide bg-default mb-5" data-bs-ride="carousel">
        <table>
            <tr>
                <td>Username:</td><td><input type="email" name="email" id="email"></td>
            </tr>
            <tr>
                <td>Password:</td><td><input type="password" name="password" id="password"></td>
            </tr>
            <tr>
                <td><a href="" class="btn btn-success"></a></td>
            </tr>
            <!-- <thead>
                <th></th>
            </thead>
            <tbody>
                <tr></tr>
            </tbody> -->
        </table>
    </div>
    <div class="container mb-5">
    </div>
<?= $this->endSection() ?>

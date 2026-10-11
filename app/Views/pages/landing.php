<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="panel">
    <h1>POS Customer and User Accounts</h1>
    <p>Manage customer records and user accounts from one place.</p>
    <div class="cards">
        <a class="card" href="<?= site_url('customers') ?>"><strong>Customer Accounts</strong>View, create, and edit customers.</a>
        <a class="card" href="<?= site_url('users') ?>"><strong>User Accounts</strong>View, create, edit, and update profile avatars.</a>
    </div>
</section>
<?= $this->endSection() ?>

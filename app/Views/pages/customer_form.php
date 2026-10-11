<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="panel">
    <h1><?= esc($heading) ?></h1>
    <?php if ($errors !== []): ?>
        <div class="errors" role="alert">
            <p>Please correct the following:</p>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form action="<?= esc($action) ?>" method="post">
        <?= csrf_field() ?>
        <div class="form-field">
            <label for="full_name">Full name <span aria-hidden="true">*</span></label>
            <input id="full_name" name="full_name" type="text" maxlength="100" required value="<?= esc($customer['full_name'] ?? '') ?>">
        </div>
        <div class="form-field">
            <label for="email">Email <span aria-hidden="true">*</span></label>
            <input id="email" name="email" type="email" maxlength="100" required value="<?= esc($customer['email'] ?? '') ?>">
        </div>
        <div class="form-field">
            <label for="phone">Phone</label>
            <input id="phone" name="phone" type="tel" maxlength="20" value="<?= esc($customer['phone'] ?? '') ?>">
        </div>
        <div class="form-actions">
            <button class="button" type="submit">Save Customer</button>
            <a class="button secondary" href="<?= site_url('customers') ?>">Cancel</a>
        </div>
    </form>
</section>
<?= $this->endSection() ?>

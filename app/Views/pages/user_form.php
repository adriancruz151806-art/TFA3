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
    <form action="<?= esc($action) ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="form-field">
            <label for="username">Username <span aria-hidden="true">*</span></label>
            <input id="username" name="username" type="text" maxlength="50" required value="<?= esc($user['username'] ?? '') ?>">
        </div>
        <div class="form-field">
            <label for="full_name">Full name <span aria-hidden="true">*</span></label>
            <input id="full_name" name="full_name" type="text" maxlength="100" required value="<?= esc($user['full_name'] ?? '') ?>">
        </div>
        <div class="form-field">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" maxlength="100" value="<?= esc($user['email'] ?? '') ?>">
        </div>
        <?php if ($editing): ?>
            <div class="form-field">
                <label for="avatar">Profile picture (JPG or PNG, max 2 MB)</label>
                <?php if (! empty($user['avatar_url'])): ?>
                    <p><img class="avatar" src="<?= esc($user['avatar_url']) ?>" alt="Current profile picture" width="100" height="100"></p>
                <?php endif; ?>
                <input id="avatar" name="avatar" type="file" accept=".jpg,.jpeg,.png,image/jpeg,image/png">
            </div>
        <?php endif; ?>
        <div class="form-actions">
            <button class="button" type="submit">Save User</button>
            <a class="button secondary" href="<?= site_url('users') ?>">Cancel</a>
        </div>
    </form>
</section>
<?= $this->endSection() ?>

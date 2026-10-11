<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="panel">
    <div class="toolbar">
        <div>
            <h1>User Accounts</h1>
            <p>Manage POS users and profile avatars.</p>
        </div>
        <a class="button" href="<?= site_url('users/new') ?>">New User</a>
    </div>
    <?php if (! empty($success)): ?>
        <p class="notice"><?= esc($success) ?></p>
    <?php endif; ?>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th scope="col">Avatar</th>
                    <th scope="col">ID</th>
                    <th scope="col">Username</th>
                    <th scope="col">Full Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><img class="avatar" src="<?= esc($user['avatar_url']) ?>" alt="<?= esc($user['full_name']) ?> avatar" width="56" height="56"></td>
                        <td><?= esc($user['id']) ?></td>
                        <td><?= esc($user['username']) ?></td>
                        <td><?= esc($user['full_name']) ?></td>
                        <td><?= esc($user['email'] ?? 'Not provided') ?></td>
                        <td><?= esc($user['created_at']) ?></td>
                        <td><a href="<?= site_url('users/edit/' . $user['id']) ?>">Edit</a></td>
                    </tr>
                <?php endforeach; ?>
                <?php if ($users === []): ?>
                    <tr><td colspan="7">No user accounts found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
<?= $this->endSection() ?>

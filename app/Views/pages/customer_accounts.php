<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="panel">
    <div class="toolbar">
        <div>
            <h1>Customer Accounts</h1>
            <p>View and manage POS customers.</p>
        </div>
        <a class="button" href="<?= site_url('customers/new') ?>">New Customer</a>
    </div>
    <?php if (! empty($success)): ?>
        <p class="notice"><?= esc($success) ?></p>
    <?php endif; ?>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Full Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($customers as $customer): ?>
                    <tr>
                        <td><?= esc($customer['id']) ?></td>
                        <td><?= esc($customer['full_name']) ?></td>
                        <td><?= esc($customer['email']) ?></td>
                        <td><?= esc($customer['phone'] ?? 'Not provided') ?></td>
                        <td><?= esc($customer['created_at']) ?></td>
                        <td><a href="<?= site_url('customers/edit/' . $customer['id']) ?>">Edit</a></td>
                    </tr>
                <?php endforeach; ?>
                <?php if ($customers === []): ?>
                    <tr><td colspan="6">No customer accounts found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
<?= $this->endSection() ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'POS Customer Accounts') ?></title>
    <style>
        :root { font-family: Arial, Helvetica, sans-serif; color: #1f2937; background: #f3f6fb; }
        * { box-sizing: border-box; }
        body { margin: 0; }
        header { background: #12345a; color: #fff; }
        .nav, main { width: min(1100px, calc(100% - 2rem)); margin: 0 auto; }
        .nav { display: flex; align-items: center; justify-content: space-between; gap: 1rem; min-height: 68px; }
        .brand { color: #fff; font-size: 1.1rem; font-weight: 700; text-decoration: none; }
        nav { display: flex; flex-wrap: wrap; gap: .35rem; }
        nav a { color: #e6efff; padding: .65rem .8rem; border-radius: 6px; text-decoration: none; }
        nav a:hover, nav a:focus { background: #244c78; color: #fff; }
        main { padding: 2.5rem 0; min-height: calc(100vh - 68px); }
        .panel { background: #fff; border-radius: 12px; padding: clamp(1.25rem, 4vw, 2.5rem); box-shadow: 0 8px 24px #12345a12; }
        h1 { margin-top: 0; color: #12345a; }
        p { line-height: 1.65; }
        .cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)); gap: 1rem; margin-top: 1.5rem; }
        .card { display: block; padding: 1.2rem; border: 1px solid #d8e1ec; border-radius: 8px; color: #12345a; text-decoration: none; }
        .card:hover, .card:focus { border-color: #3975b9; background: #f7faff; }
        .toolbar { display: flex; align-items: center; justify-content: space-between; gap: 1rem; flex-wrap: wrap; }
        .button { display: inline-block; padding: .7rem 1rem; border: 0; border-radius: 6px; background: #175c9d; color: #fff; text-decoration: none; cursor: pointer; font: inherit; }
        .button:hover, .button:focus { background: #104879; }
        .button.secondary { background: #526174; }
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 1.25rem; }
        th, td { padding: .85rem 1rem; text-align: left; border-bottom: 1px solid #e5eaf0; }
        th { background: #edf3fa; color: #12345a; }
        tbody tr:hover { background: #f7faff; }
        .avatar { width: 56px; height: 56px; border-radius: 50%; object-fit: cover; vertical-align: middle; }
        .form-field { margin: 1rem 0; }
        .form-field label { display: block; margin-bottom: .4rem; font-weight: 700; }
        .form-field input { width: 100%; max-width: 540px; padding: .7rem; border: 1px solid #bdc9d8; border-radius: 6px; font: inherit; }
        .form-actions { display: flex; gap: .75rem; margin-top: 1.5rem; }
        .errors, .notice { margin: 1rem 0; padding: .9rem 1rem; border-radius: 6px; }
        .errors { background: #fff0f0; color: #8b1f1f; }
        .notice { background: #eaf7ed; color: #205b2a; }
        @media (max-width: 600px) {
            .nav { align-items: flex-start; flex-direction: column; padding: 1rem 0; }
            nav { width: 100%; }
            nav a { padding: .55rem .65rem; }
        }
    </style>
</head>
<body>
    <header>
        <div class="nav">
            <a class="brand" href="<?= site_url('/') ?>">POS Accounts</a>
            <nav aria-label="Main navigation">
                <a href="<?= site_url('/') ?>">Home</a>
                <a href="<?= site_url('customers') ?>">Customers</a>
                <a href="<?= site_url('users') ?>">Users</a>
                <a href="<?= site_url('about') ?>">About</a>
            </nav>
        </div>
    </header>
    <main>
        <?= $this->renderSection('content') ?>
    </main>
</body>
</html>

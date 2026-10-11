<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use RuntimeException;

class Users extends BaseController
{
    public function index(): string
    {
        $users = (new UserModel())->orderBy('id', 'DESC')->findAll();

        foreach ($users as &$user) {
            $user['avatar_url'] = $this->avatarUrl($user['avatar']);
        }
        unset($user);

        return view('pages/user_accounts', [
            'users'  => $users,
            'success' => session()->getFlashdata('success'),
        ]);
    }

    public function new(): string
    {
        return view('pages/user_form', [
            'user'    => [],
            'errors'  => [],
            'action'  => site_url('users/create'),
            'heading' => 'New User',
            'editing' => false,
        ]);
    }

    public function create()
    {
        $data = $this->request->getPost();
        $data['username'] = trim((string) ($data['username'] ?? ''));
        $data['full_name'] = trim((string) ($data['full_name'] ?? ''));
        $data['email'] = trim((string) ($data['email'] ?? ''));

        $rules = [
            'username'  => 'required|max_length[50]|is_unique[users.username]',
            'full_name' => 'required|max_length[100]',
            'email'     => 'permit_empty|valid_email|max_length[100]',
        ];

        if (! $this->validateData($data, $rules)) {
            return view('pages/user_form', [
                'user'    => $data,
                'errors'  => $this->validator->getErrors(),
                'action'  => site_url('users/create'),
                'heading' => 'New User',
                'editing' => false,
            ]);
        }

        (new UserModel())->insert([
            'username'   => $data['username'],
            'full_name'  => $data['full_name'],
            'email'      => $data['email'] ?: null,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to(site_url('users'))->with('success', 'User created.');
    }

    public function edit(int $id): string
    {
        $user = (new UserModel())->find($id);

        if ($user === null) {
            throw PageNotFoundException::forPageNotFound('User not found.');
        }

        return view('pages/user_form', [
            'user'    => array_merge($user, ['avatar_url' => $this->avatarUrl($user['avatar'])]),
            'errors'  => [],
            'action'  => site_url('users/update/' . $id),
            'heading' => 'Edit User',
            'editing' => true,
        ]);
    }

    public function update(int $id)
    {
        $model = new UserModel();
        $user = $model->find($id);

        if ($user === null) {
            throw PageNotFoundException::forPageNotFound('User not found.');
        }

        $rules = [
            'username'  => 'required|max_length[50]|is_unique[users.username,id,' . $id . ']',
            'full_name' => 'required|max_length[100]',
            'email'     => 'permit_empty|valid_email|max_length[100]',
        ];

        $avatar = $this->request->getFile('avatar');
        $hasAvatar = $avatar !== null && $avatar->getError() !== UPLOAD_ERR_NO_FILE;
        $data = $this->request->getPost();
        $data['username'] = trim((string) ($data['username'] ?? ''));
        $data['full_name'] = trim((string) ($data['full_name'] ?? ''));
        $data['email'] = trim((string) ($data['email'] ?? ''));

        if ($hasAvatar) {
            $rules['avatar'] = 'is_image[avatar]|mime_in[avatar,image/jpg,image/jpeg,image/png]|ext_in[avatar,jpg,jpeg,png]|max_size[avatar,2048]';
        }

        if (! $this->validateData($data, $rules)) {
            return view('pages/user_form', [
                'user'    => array_merge($user, $data, ['avatar_url' => $this->avatarUrl($user['avatar'])]),
                'errors'  => $this->validator->getErrors(),
                'action'  => site_url('users/update/' . $id),
                'heading' => 'Edit User',
                'editing' => true,
            ]);
        }

        if ($hasAvatar && ! extension_loaded('gd')) {
            return view('pages/user_form', [
                'user'    => array_merge($user, $data, ['avatar_url' => $this->avatarUrl($user['avatar'])]),
                'errors'  => ['avatar' => 'Avatar processing requires the PHP GD extension. Enable extension=gd in php.ini and restart Apache.'],
                'action'  => site_url('users/update/' . $id),
                'heading' => 'Edit User',
                'editing' => true,
            ]);
        }

        $changes = [
            'username'  => $data['username'],
            'full_name' => $data['full_name'],
            'email'     => $data['email'] ?: null,
        ];

        if ($hasAvatar) {
            $changes['avatar'] = $this->prepareAvatar($avatar);
        }

        $model->update($id, $changes);

        return redirect()->to(site_url('users'))->with('success', 'User updated.');
    }

    private function avatarUrl(?string $avatar): string
    {
        $filename = $avatar === null ? '' : basename($avatar);
        $avatarPath = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'avatars' . DIRECTORY_SEPARATOR . $filename;

        return $filename !== '' && is_file($avatarPath)
            ? site_url('uploads/avatars/' . rawurlencode($filename))
            : site_url('uploads/avatar-placeholder.svg');
    }

    private function prepareAvatar(\CodeIgniter\HTTP\Files\UploadedFile $upload): string
    {
        if (! extension_loaded('gd')) {
            throw new RuntimeException('Avatar processing requires the PHP GD extension. Enable extension=gd in php.ini and restart Apache.');
        }

        $mimeType = $upload->getMimeType();
        $extension = match ($mimeType) {
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            default      => throw new RuntimeException('The uploaded avatar must be a JPEG or PNG image.'),
        };

        $directory = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'avatars';
        if (! is_dir($directory) && ! mkdir($directory, 0755, true) && ! is_dir($directory)) {
            throw new RuntimeException('Could not create the public avatar upload directory.');
        }

        $filename = bin2hex(random_bytes(16)) . '.' . $extension;
        $destination = $directory . DIRECTORY_SEPARATOR . $filename;
        service('image')
            ->withFile($upload->getTempName())
            ->fit(400, 400, 'center')
            ->save($destination);

        return $filename;
    }
}

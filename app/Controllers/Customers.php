<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Customers extends BaseController
{
    public function index(): string
    {
        $customers = (new CustomerModel())->orderBy('id', 'DESC')->findAll();

        return view('pages/customer_accounts', [
            'customers' => $customers,
            'success'   => session()->getFlashdata('success'),
        ]);
    }

    public function new(): string
    {
        return view('pages/customer_form', [
            'customer' => [],
            'errors'   => [],
            'action'   => site_url('customers/create'),
            'heading'  => 'New Customer',
        ]);
    }

    public function create()
    {
        $data = $this->request->getPost();
        $data['full_name'] = trim((string) ($data['full_name'] ?? ''));
        $data['email'] = trim((string) ($data['email'] ?? ''));
        $data['phone'] = trim((string) ($data['phone'] ?? ''));

        $rules = [
            'full_name' => 'required|max_length[100]',
            'email'     => 'required|valid_email|max_length[100]',
            'phone'     => 'permit_empty|max_length[20]',
        ];

        if (! $this->validateData($data, $rules)) {
            return view('pages/customer_form', [
                'customer' => $data,
                'errors'   => $this->validator->getErrors(),
                'action'   => site_url('customers/create'),
                'heading'  => 'New Customer',
            ]);
        }

        (new CustomerModel())->insert([
            'full_name'  => $data['full_name'],
            'email'      => $data['email'],
            'phone'      => $data['phone'] ?: null,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to(site_url('customers'))->with('success', 'Customer created.');
    }

    public function edit(int $id): string
    {
        $customer = (new CustomerModel())->find($id);

        if ($customer === null) {
            throw PageNotFoundException::forPageNotFound('Customer not found.');
        }

        return view('pages/customer_form', [
            'customer' => $customer,
            'errors'   => [],
            'action'   => site_url('customers/update/' . $id),
            'heading'  => 'Edit Customer',
        ]);
    }

    public function update(int $id)
    {
        $model = new CustomerModel();
        $customer = $model->find($id);

        if ($customer === null) {
            throw PageNotFoundException::forPageNotFound('Customer not found.');
        }

        $rules = [
            'full_name' => 'required|max_length[100]',
            'email'     => 'required|valid_email|max_length[100]',
            'phone'     => 'permit_empty|max_length[20]',
        ];

        $data = $this->request->getPost();
        $data['full_name'] = trim((string) ($data['full_name'] ?? ''));
        $data['email'] = trim((string) ($data['email'] ?? ''));
        $data['phone'] = trim((string) ($data['phone'] ?? ''));

        if (! $this->validateData($data, $rules)) {
            return view('pages/customer_form', [
                'customer' => array_merge($customer, $data),
                'errors'   => $this->validator->getErrors(),
                'action'   => site_url('customers/update/' . $id),
                'heading'  => 'Edit Customer',
            ]);
        }

        $model->update($id, [
            'full_name' => $data['full_name'],
            'email'     => $data['email'],
            'phone'     => $data['phone'] ?: null,
        ]);

        return redirect()->to(site_url('customers'))->with('success', 'Customer updated.');
    }
}

<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class UserForm extends Component
{
    public $userId = null;
    public $isEdit = false;

    // Fields
    public $name = '';
    public $email = '';
    public $password = '';
    public $role = 'Operator';

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . ($this->userId ?? 'NULL'),
            'password' => $this->isEdit ? 'nullable|string|min:8' : 'required|string|min:8',
            'role' => 'required|string|in:Administrator,Operator',
        ];
    }

    protected $validationAttributes = [
        'name' => 'Nama Lengkap',
        'email' => 'Email',
        'password' => 'Password',
        'role' => 'Role/Peran',
    ];

    public function mount($id = null)
    {
        if ($id) {
            $this->userId = $id;
            $this->isEdit = true;
            $user = User::findOrFail($id);

            $this->name = $user->name;
            $this->email = $user->email;
            $this->role = $user->role;
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        if ($this->isEdit) {
            $user = User::findOrFail($this->userId);
            $user->update($data);
            session()->flash('message', 'User berhasil diperbarui.');
        } else {
            User::create($data);
            session()->flash('message', 'User berhasil ditambahkan.');
        }

        return $this->redirectRoute('users.index', navigate: true);
    }

    public function render()
    {
        $title = $this->isEdit ? 'Ubah Data User' : 'Tambah User Baru';
        return view('livewire.user.user-form')
            ->layout('layouts.app', ['header' => $title]);
    }
}

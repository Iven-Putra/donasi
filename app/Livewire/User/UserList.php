<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserList extends Component
{
    use WithPagination;

    public $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        // Prevent deleting yourself
        if ($id === auth()->id()) {
            session()->flash('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang digunakan.');
            return;
        }

        $user = User::findOrFail($id);
        
        // Prevent deleting if user has input donations
        if ($user->donations()->count() > 0) {
            session()->flash('error', 'User tidak dapat dihapus karena telah mencatat transaksi donasi.');
            return;
        }

        $user->delete();
        session()->flash('message', 'User berhasil dihapus.');
    }

    public function render()
    {
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->orderBy('role', 'asc')
            ->orderBy('name', 'asc')
            ->paginate(10);

        return view('livewire.user.user-list', [
            'users' => $users
        ])->layout('layouts.app', ['header' => 'Manajemen User']);
    }
}

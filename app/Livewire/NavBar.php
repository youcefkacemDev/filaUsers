<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Attributes\Rule;
use Livewire\Component;

class NavBar extends Component
{
    #[Rule('required|min:3|max:100')]
    public $name = "";
    #[Rule('required|min:3|max:100|email|unique:users')]
    public $email = "";
    #[Rule('required|confirmed|min:8')]
    public $password = "";
    #[Rule('required|min:8')]
    public $password_confirmation = "";
    public function create()
    {
        $validated = $this->validate();
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);
        $this->reset();
        $this->dispatch('close_modal', name: 'register');
    }

    public function login()
    {
        $validated = $this->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);
        if (auth()->attempt($validated)) {
            session()->regenerate();
        }
        $this->reset();
        $this->dispatch('close_modal');
    }

    public function try(){
        dd();
    }

    public function logout()
    {
        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();
    }

    public function render()
    {
        return view('livewire.nav-bar', [
            'user' => auth(),
        ]);
    }
}

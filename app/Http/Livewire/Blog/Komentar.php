<?php

namespace App\Http\Livewire\Blog;

use Livewire\Component;

class Komentar extends Component
{
    public function render()
    {
        return view('livewire.blog.komentar')
        ->extends('layouts.apps', ['title' => 'Komentar']);
    }
}

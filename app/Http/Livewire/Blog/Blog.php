<?php

namespace App\Http\Livewire\Blog;

use App\Models\KategoriPost;
use App\Models\Post;
use App\Models\SubKategori;
use Livewire\Component;

class Blog extends Component
{
    public $slug;

    public function render()
    {
        $data = Post::select('post.*', 'users.name')->where('slug', $this->slug)
                        ->join('users', 'users.id', 'post.id_user')
                        ->first();

        $kategori = KategoriPost::select('sub_kategori.nama_subkategori')
                        ->join('sub_kategori', 'sub_kategori.id', 'kategori_post.id_subkategori')
                        ->where('id_post', $data->id)
                        ->get();

        $navigations = SubKategori::select('sub_kategori.*', 'kategori.nama_kategori')
                    ->join('kategori', 'kategori.id', 'sub_kategori.id_kategori')
                    ->get();

        $artikel_terbaru = Post::orderBy('id', 'DESC')->take('5')->get();

        return view('livewire.blog.blog', compact('data', 'kategori', 'navigations', 'artikel_terbaru'))
        ->extends('layouts.apps-blog', ['title' => $data->judul]);
    }

    public function mount($slug)
    {
        $this->slug = $slug;
    }
}

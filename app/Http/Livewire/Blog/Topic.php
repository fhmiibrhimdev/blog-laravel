<?php

namespace App\Http\Livewire\Blog;

use App\Models\KategoriPost;
use App\Models\Post;
use App\Models\SubKategori;
use Livewire\Component;

class Topic extends Component
{
    public $topic;

    public function render()
    {
        $id_topic = SubKategori::where('nama_subkategori', $this->topic)->first()->id;

        $data = KategoriPost::select('post.judul', 'post.deskripsi', 'slug')->where('id_subkategori', $id_topic)
                    ->join('post', 'post.id', 'kategori_post.id_post')
                    ->get();

        $navigations = SubKategori::select('sub_kategori.*', 'kategori.nama_kategori')
                    ->join('kategori', 'kategori.id', 'sub_kategori.id_kategori')
                    ->get();

        return view('livewire.blog.topic', compact('data', 'navigations'))
        ->extends('layouts.apps-blog', ['title' => 'Topic: '.$this->topic]);
    }

    public function mount($topic)
    {
        $this->topic = $topic;
    }
}

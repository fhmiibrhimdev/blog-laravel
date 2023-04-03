<?php

namespace App\Http\Livewire\Blog;

use App\Models\User;
use Livewire\Component;
use App\Models\Kategori;
use Illuminate\Support\Str;
use App\Models\KategoriPost;
use Livewire\WithPagination;
use App\Models\Post as ModelsPost;
use App\Models\SubKategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Post extends Component
{
    use LivewireAlert;
    use WithPagination;


    protected $listeners = [
        'delete'
    ];
    protected $paginationTheme = 'bootstrap';
    protected $rules = [
        'tanggal'       => 'required',
        'judul'         => 'required',
        'status_publish'=> 'required',
    ];

    public $search;
    public $lengthData  = 10;
    public $updateMode  = false;
    public $idRemoved   = NULL;
    public $dataId      = NULL;
    public $id_user, $tanggal, $judul, $slug, $deskripsi, $isi_konten, $status_publish;
    public $id_subkategori = [];

    public function render()
    {
        $search     = '%'.$this->search.'%';
        $lengthData = $this->lengthData;

        $kategori   = SubKategori::select('id', 'nama_subkategori')->get();
        
        $data       = ModelsPost::select('post.*', 'users.name')
                        ->join('users', 'users.id', 'post.id_user')
                        ->orderBy('post.id')
                        ->paginate($lengthData);

        return view('livewire.blog.post', compact('data', 'kategori'))
        ->extends('layouts.apps', ['title' => 'Posts']);
    }

    public function uploadImage(Request $request)
    {
        if( $request->hasFile('upload') )
        {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;
        
            $request->file('upload')->move(public_path('images'), $fileName);
   
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('images/'.$fileName); 
            $msg = 'Image uploaded successfully URL: '.$url; 
            $response = "<script>alert('$url')window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
            @header('Content-type: text/html; charset=utf-8'); 
            echo $response;
        }
    }

    public function mount()
    {
        $this->tanggal          = date('Y-m-d');
        $this->judul            = '';
        $this->slug             = '';
        $this->deskripsi        = '';
        $this->isi_konten       = '';
        $this->status_publish   = 'Draft';
    }

    private function resetInputFields()
    {
        $this->tanggal          = date('Y-m-d');
        $this->judul            = '';
        $this->slug             = '';
        $this->deskripsi        = '';
        $this->isi_konten       = '';
        $this->status_publish   = 'Draft';
    }

    public function cancel()
    {
        $this->updateMode       = false;
        $this->resetInputFields();
    }

    private function alertShow($type, $title, $text, $onConfirmed, $showCancelButton)
    {
        $this->alert($type, $title, [
            'position'          => 'center',
            'timer'             => '3000',
            'toast'             => false,
            'text'              => $text,
            'showConfirmButton' => true,
            'onConfirmed'       => $onConfirmed,
            'showCancelButton'  => $showCancelButton,
            'onDismissed'       => '',
        ]);
        $this->resetInputFields();
        $this->emit('dataStore');
    }

    public function store()
    {
        $this->validate();

        switch ($this->slug) {
            case '':
                $slug = Str::slug($this->judul, '-');
                break;
            
            default:
                $slug = Str::slug($this->slug, '-');
                break;
        }

        $create = ModelsPost::create([
            'id_user'           => Auth::user()->id,
            'tanggal'           => $this->tanggal,
            'judul'             => $this->judul,
            'slug'              => $slug,
            'deskripsi'         => $this->deskripsi,
            'isi_konten'        => $this->isi_konten,
            'status_publish'    => $this->status_publish,
        ]);
        
        $len = count($this->id_subkategori);
        $data = [];
        for ($i=0; $i < $len; $i++) { 
            $data[] = [
                'id_post' => $create->id,
                'id_subkategori' => $this->id_subkategori[$i]
            ];
        }
        DB::table('kategori_post')->insert($data);

        $this->alertShow(
            'success', 
            'Berhasil', 
            'Data berhasil diubah', 
            '', 
            false
        );
    }

    public function edit($id)
    {
        $this->updateMode       = true;
        $data = ModelsPost::where('id', $id)->first();
        $this->dataId           = $id;
        $this->id_user          = $data->id_user;
        $this->tanggal          = $data->tanggal;
        $this->judul            = $data->judul;
        $this->slug             = $data->slug;
        $this->deskripsi        = $data->deskripsi;
        $this->isi_konten       = $data->isi_konten;
        $this->status_publish   = $data->status_publish;
    }

    public function update()
    {
        $this->validate();

        if( $this->dataId )
        {
            ModelsPost::findOrFail($this->dataId)
            ->update([
                'id_user'           => Auth::user()->id,
                'tanggal'           => $this->tanggal,
                'judul'             => $this->judul,
                'slug'              => $this->slug,
                'deskripsi'         => $this->deskripsi,
                'isi_konten'        => $this->isi_konten,
                'status_publish'    => $this->status_publish,
            ]);
            $this->alertShow(
                'success', 
                'Berhasil', 
                'Data berhasil diubah', 
                '', 
                false
            );
        }
    }

    public function deleteConfirm($id)
    {
        $this->idRemoved = $id;
        $this->alertShow(
            'warning', 
            'Apa anda yakin?', 
            'Jika anda menghapus data tersebut, data tidak bisa dikembalikan!', 
            'delete', 
            true
        );
    }

    public function delete()
    {
        ModelsPost::findOrFail($this->idRemoved)->delete();
        $this->alertShow(
            'success', 
            'Berhasil', 
            'Data berhasil dihapus', 
            '', 
            false
        );
    }

    public function check()
    {
        

    }
}

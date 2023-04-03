<?php

namespace App\Http\Livewire\Blog;

use App\Models\Kategori;
use App\Models\SubKategori as ModelsSubKategori;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class SubKategori extends Component
{
    use LivewireAlert;
    use WithPagination;


    protected $listeners = [
        'delete'
    ];
    protected $paginationTheme = 'bootstrap';
    protected $rules = [
        'nama_subkategori'     => 'required',
    ];

    public $search;
    public $lengthData  = 10;
    public $updateMode  = false;
    public $idRemoved   = NULL;
    public $dataId      = NULL;
    public $id_kategori, $nama_subkategori, $deskripsi, $gambar;

    public function render()
    {
        $search     = '%'.$this->search.'%';
        $lengthData = $this->lengthData;

        $kategoris = Kategori::select('id', 'nama_kategori')->get();

        $data = ModelsSubKategori::select('sub_kategori.*', 'kategori.nama_kategori')
                    ->join('kategori', 'kategori.id', 'sub_kategori.id_kategori')
                    ->where('nama_kategori', 'LIKE', $search)
                    ->orWhere('nama_subkategori', 'LIKE', $search)
                    ->orWhere('deskripsi', 'LIKE', $search)
                    ->orderBy('sub_kategori.id', 'ASC')
                    ->paginate($lengthData);

        return view('livewire.blog.sub-kategori', compact('data', 'kategoris'))
        ->extends('layouts.apps', ['title' => 'Sub Kategori']);
    }

    public function mount()
    {
        $this->nama_subkategori = '';
        $this->deskripsi        = '-';
        $this->gambar           = '';
        $this->id_kategori      = Kategori::min('id');
    }
    
    private function resetInputFields()
    {
        $this->nama_subkategori = '';
        $this->deskripsi        = '-';
        $this->gambar           = '';
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

        ModelsSubKategori::create([
            'id_kategori'      => $this->id_kategori,
            'nama_subkategori'      => $this->nama_subkategori,
            'deskripsi'             => $this->deskripsi,
            'gambar'                => '',
        ]);

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
        $data = ModelsSubKategori::where('id', $id)->first();
        $this->dataId           = $id;
        $this->id_kategori      = $data->id_kategori;
        $this->nama_subkategori = $data->nama_subkategori;
        $this->deskripsi        = $data->deskripsi;
        $this->gambar           = $data->gambar;
    }

    public function update()
    {
        $this->validate();

        if( $this->dataId )
        {
            ModelsSubKategori::findOrFail($this->dataId)->update([
                'id_kategori'      => $this->id_kategori,
                'nama_subkategori'      => $this->nama_subkategori,
                'deskripsi'             => $this->deskripsi,
                'gambar'                => $this->gambar,
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
        // dd($this->idRemoved);
    }

    public function delete()
    {
        ModelsSubKategori::findOrFail($this->idRemoved)->delete();
        $this->alertShow(
            'success', 
            'Berhasil', 
            'Data berhasil dihapus', 
            '', 
            false
        );
    }
}

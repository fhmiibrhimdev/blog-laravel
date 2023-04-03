<div>
    <section class="section">
        <div class="section-header tw-rounded-none lg:tw-rounded-lg tw-shadow-md tw-shadow-gray-300 px-4">
            <h1 class="tw-text-lg mb-1">Post</h1>
        </div>

        @if ($errors->any())
        <script>
            Swal.fire(
                'error',
                'Ada yang error',
                'error'
            )
        </script>
        @endif

        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body px-0">
                            <h3>Tabel Post</h3>
                            <div class="show-entries">
                                <p class="show-entries-show">Show</p>
                                <select wire:model='lengthData' id="length-data">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                    <option value="250">250</option>
                                    <option value="500">500</option>
                                    <option value="1000">1000</option>
                                </select>
                                <p class="show-entries-entries">Entries</p>
                            </div>
                            <div class="search-column">
                                <p>Search: </p>
                                <input type="search" wire:model='search' id="search-data" placeholder="Search here...">
                            </div>
                            <div class="table-responsive tw-max-h-[740px]">
                                <table>
                                    <thead class="tw-sticky tw-top-0">
                                        <tr class="tw-text-gray-700 text-center">
                                            <th width="10%">No</th>
                                            <th width="15%">Judul</th>
                                            <th width="35%">Deskripsi</th>
                                            <th>Author</th>
                                            <th>Status Publish</th>
                                            <th>
                                                <i class="fas fa-cog"></i>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($data as $row)
                                        <tr class="text-center">
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td><a href="{{ url('blog/'.$row->slug) }}" class="tw-no-underline" target="_BLANK">{{ $row->judul }}</a></td>
                                            <td>{{ substr($row->deskripsi, 0, 80) }}...</td>
                                            <td>{{ $row->name }}</td>
                                            <td>
                                                @if ($row->status_publish == "Draft")
                                                <span class="tw-bg-red-100 tw-py-1 tw-px-2 tw-rounded-md tw-text-red-800 tw-font-semibold">Draft</span>
                                                @elseif ( $row->status_publish == "Privated" )
                                                <span class="tw-bg-yellow-100 tw-py-1 tw-px-2 tw-rounded-md tw-text-yellow-800 tw-font-semibold">Privated</span>
                                                @elseif ( $row->status_publish == "Published" )
                                                <span class="tw-bg-green-100 tw-py-1 tw-px-2 tw-rounded-md tw-text-green-800 tw-font-semibold ">Published</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-warning" id="editDataModal" wire:click='edit({{ $row->id }})' data-toggle="modal" data-target="#ubahDataModal">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-danger" wire:click.prevent='deleteConfirm({{ $row->id }})'>
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td class="text-center" colspan="6">No data available in the table</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="p-3">
                                {{ $data->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button class="btn-modal" data-toggle="modal" data-target="#tambahDataModal">
            <i class="far fa-plus"></i>
        </button>
    </section>

    <div class="modal fade" wire:ignore.self id="tambahDataModal" aria-labelledby="tambahDataModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahDataModalLabel">Tambah Data</h5>
                    <button type="button" wire:click.prevent='cancel()' class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="judul">Judul</label>
                                    <input type="text" wire:model="judul" id="judul" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="slug">Slug</label>
                                    <input type="text" wire:model="slug" id="slug" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="tanggal">Tanggal</label>
                                    <input type="date" wire:model="tanggal" id="tanggal" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="id_kategori">Tags</label>
                                    <div wire:ignore>
                                        <select wire:model="id_subkategori" id="id_kategori" multiple class="form-control focus:tw-border focus:tw-border-gray-200 tw-text-black">
                                            @foreach ($kategori as $kategoris)
                                            <option value="{{ $kategoris->id }}">{{ $kategoris->nama_subkategori }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea wire:model="deskripsi" id="deskripsi" class="form-control tw-h-24"></textarea>
                        </div>
                        <div class="form-group" wire:ignore>
                            <label for="isi_konten">Isi Konten</label>
                            <textarea wire:model="isi_konten" id="isi_konten" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="status_publish">Status Publish</label>
                            <select wire:model="status_publish" id="status_publish" class="form-control">
                                <option value="Draft">Draft</option>
                                <option value="Published">Published</option>
                                <option value="Privated">Privated</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary tw-bg-gray-300" data-dismiss="modal">Close</button>
                        <button type="submit" wire:click.prevent="store()" wire:loading.attr="disabled" class="btn btn-primary tw-bg-blue-500">Save Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" wire:ignore.self id="ubahDataModal" aria-labelledby="ubahDataModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ubahDataModalLabel">Edit Data</h5>
                    <button type="button" wire:click.prevent='cancel()' class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form>
                    <div class="modal-body">
                        <input type="hidden" wire:model='dataId'>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="judul">Judul</label>
                                    <input type="text" wire:model="judul" id="judul" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="slug">Slug</label>
                                    <input type="text" wire:model="slug" id="slug" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="tanggal">Tanggal</label>
                                    <input type="date" wire:model="tanggal" id="tanggal" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="edit_id_kategori">Tags</label>
                                    <div wire:ignore>
                                        <select wire:model="id_subkategori" id="edit_id_kategori" multiple class="form-control focus:tw-border focus:tw-border-gray-200 tw-text-black">
                                            @foreach ($kategori as $kategoris)
                                            <option value="{{ $kategoris->id }}">{{ $kategoris->nama_subkategori }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea wire:model="deskripsi" id="deskripsi" class="form-control tw-h-24"></textarea>
                        </div>
                        <div class="form-group" wire:ignore>
                            <label for="edit_isi_konten">Isi Konten</label>
                            <textarea wire:model="isi_konten" id="edit_isi_konten" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="status_publish">Status Publish</label>
                            <select wire:model="status_publish" id="status_publish" class="form-control">
                                <option value="Draft">Draft</option>
                                <option value="Published">Published</option>
                                <option value="Privated">Privated</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary tw-bg-gray-300" data-dismiss="modal">Close</button>
                        <button type="submit" wire:click.prevent="update()" wire:loading.attr="disabled" class="btn btn-primary tw-bg-blue-500">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    var isi_konten;
    var konten = document.getElementById("isi_konten");
    var edit_konten = document.getElementById("edit_isi_konten");
    var ckeditor_edit = CKEDITOR.replace(edit_konten, {
        language: 'en-gb',
        filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });
    $(document).ready(function() {
        $('#id_kategori').select2();
        $('#edit_id_kategori').select2();
        $('#id_kategori').on('change', function(e) {
            var data = $('#id_kategori').select2("val");
            @this.set('id_subkategori', data);
        });
        $('#edit_id_kategori').on('change', function(e) {
            var data = $('#edit_id_kategori').select2("val");
            @this.set('id_subkategori', data);
        });

        $('#editDataModal').click(function(e) {
            setTimeout(() => {
                isi_konten = @this.isi_konten;
                ckeditor_edit.setData(isi_konten);
            }, 3000);
        });

    });


    CKEDITOR.replace(konten, {
        language: 'en-gb',
        filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    }).on('change', function(evt) {
        var data_konten = evt.editor.getData()
        @this.set('isi_konten', data_konten);
    })

    ckeditor_edit.on('change', function(evt) {
        var edit_data_konten = evt.editor.getData()
        @this.set('isi_konten', edit_data_konten);
    })


    CKEDITOR.config.allowedContent = true;
</script>
@endpush
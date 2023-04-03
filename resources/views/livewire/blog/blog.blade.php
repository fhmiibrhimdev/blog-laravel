<div>
    <nav class="navbar navbar-secondary navbar-expand-lg">
        <div class="container">
            <ul class="navbar-nav">
                @foreach ($navigations->groupBy('nama_kategori') as $navigation)
                <li class="nav-item dropdown">
                    <a href="#" data-toggle="dropdown" class="nav-link has-dropdown"><span>{{ $navigation[0]['nama_kategori'] }}</span></a>
                    <ul class="dropdown-menu">
                        @foreach ($navigation as $nav)
                        <li class="nav-item">
                            <a href="{{ url('topic/'.$nav['nama_subkategori']) }}" class="nav-link">{{ $nav['nama_subkategori'] }}</a>
                        </li>
                        @endforeach
                    </ul>
                </li>
                @endforeach
            </ul>
        </div>
    </nav>

    <div class="main-content tw-text-black tw-text-base">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="tw-flex tw-justify-between">
                                    <div class="tw-flex tw-mt-3">
                                        <img src="{{ asset('assets/img/avatar/avatar-1.png') }}" class="tw-rounded-full tw-h-7 tw-w-7">
                                        <div class="tw-ml-3 tw-text-sm">
                                            <p>{{ $data->name }} · <span class="tw-text-gray-400">{{ \Carbon\Carbon::parse($data->tanggal)->isoFormat('D MMMM Y') }}</span></p>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="mt-3 mb-3 tw-text-slate-700 tw-text-2xl tw-font-bold">{{ $data->judul }}</h3><hr>
                                        <ul class="tw-list-none tw-flex tw-mt-4 tw-text-sm">
                                            @foreach ($kategori as $kategoris)
                                            <a href="{{ url('/topic/'.$kategoris->nama_subkategori) }}" class="tw-no-underline">
                                                <li class="tw-bg-gray-200 tw-px-2 tw-py-1 tw-rounded-sm tw-mr-2 tw-font-medium">#{{ $kategoris->nama_subkategori }}</li>
                                            </a>
                                            @endforeach
                                        </ul>
                                    <div class="tw-mt-5">
                                        {!! $data->isi_konten !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h4>Artikel Terbaru</p>
                            </div>
                            <div class="card-body py-0">
                                <ul>
                                    @foreach ($artikel_terbaru as $artikel)
                                    <li>
                                        <div class="tw-mt-5 tw-mb-5">
                                            <a href="{{ url('/blog/'.$artikel->slug) }}" class="tw-no-underline">
                                                <p>{{ $artikel->judul }}</p>
                                                <p class="tw-text-gray-400">{{ \Carbon\Carbon::parse($artikel->tanggal)->isoFormat('D MMMM Y') }}</p>
                                            </a>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

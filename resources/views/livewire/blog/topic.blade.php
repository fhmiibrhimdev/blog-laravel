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
                    @foreach ($data as $row)
                    <div class="col-lg-4 d-flex">
                        <a href="{{ url('/blog/'.$row->slug) }}" class="card tw-no-underline">
                            <div class="card-body">
                                <img src="https://www.petanikode.com/img/cover/tailwind-image-zoom.png" class="tw-rounded-lg">
                                <p class="mt-3 tw-font-semibold">
                                    @if (strlen($row->judul) <= 35)
                                    {{ $row->judul }} <br /><br />
                                    @else
                                    {{ $row->judul }}
                                    @endif
                                </p>
                                <p class="tw-text-gray-400 tw-text-sm mt-2">{{ substr($row->deskripsi, 0, 122) }}...</p>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
</div>

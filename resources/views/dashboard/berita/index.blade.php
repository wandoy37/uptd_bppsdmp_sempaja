@extends('dashboard.layouts.app')

@section('title', 'Berita')

@section('content')

    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Berita</h4>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('dashboard.index') }}">
                            <i class="fas fa-newspaper"></i>
                        </a>
                    </li>
                </ul>
            </div>
            {{-- <div class="page-category">Inner page content goes here</div> --}}

            {{-- Notify --}}
            <div id="flash" data-flash="{{ session('success') }}"></div>

            {{-- Fails --}}
            <div id="fails" data-flash="{{ session('fails') }}"></div>

            <div class="row">
                <div class="col-lg-12 mb-4">
                    <a href="{{ route('dashboard.berita.create') }}" class="btn btn-success btn-round mr-2">
                        <i class="fas fa-plus"></i>
                        Berita
                    </a>
                    <a href="{{ route('dashboard.berita.create') }}" class="btn btn-outline-success btn-round">
                        <i class="fas fa-plus"></i>
                        Kategori
                    </a>
                </div>
                <div class="col-lg-12 mb-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-icon">
                                    <input type="text" class="form-control" name="search ..." placeholder="search ...">
                                    <span class="input-icon-addon">
                                        <i class="fa fa-search"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="category" class="form-control">
                                    <option value="">-select category-</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="status" class="form-control">
                                    <option value="">-select status-</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-hover">
                                <thead>
                                    <tr class="text-center">
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Berita</th>
                                        <th scope="col">Kategori</th>
                                        <th scope="col">Penulis</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($beritas as $berita)
                                        <tr>
                                            <td class="text-center">{{ $berita->created_at->format('d, M Y') }}</td>
                                            <td>{{ $berita->title }}</td>
                                            <td class="text-center">{{ $berita->category->title }}</td>
                                            <td class="text-center">{{ $berita->author->name }}</td>
                                            <td class="text-center">
                                                @if ($berita->status == 'publish')
                                                    <span class="badge badge-success">{{ $berita->status }}</span>
                                                @else
                                                    <span class="badge badge-warning">{{ $berita->status }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <form id="form-delete-{{ $berita->id }}"
                                                    action="{{ route('dashboard.berita.delete', $berita->slug) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <div class="form-inline d-flex justify-content-center">
                                                    <a href="{{ route('dashboard.berita.edit', $berita->slug) }}"
                                                        class="btn btn-outline-info btn-round mr-2">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-danger btn-round"
                                                        onclick="btnDelete( {{ $berita->id }} )">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="my-2 d-flex justify-content-center">
                        {!! $beritas->links('pagination::bootstrap-4') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        var flash = $('#flash').data('flash');
        if (flash) {
            $.notify({
                // options
                icon: 'fas fa-check',
                title: 'Success',
                message: '{{ session('success') }}',
            }, {
                // settings
                type: 'success'
            });
        }
    </script>

    <script>
        var flash = $('#fails').data('flash');
        if (flash) {
            swal("Error", "{{ session('fails') }}", {
                icon: "error",
                buttons: {
                    confirm: {
                        className: 'btn btn-danger'
                    }
                },
            });
        }
    </script>

    {{-- SweetAlert Confirmation --}}
    <script>
        function btnDelete(id) {
            swal({
                title: 'Apa anda yakin?',
                text: "Berita yang di hapus tidak dapat di kembalikan !",
                type: 'warning',
                buttons: {
                    confirm: {
                        text: 'Ya, hapus sekarang',
                        className: 'btn btn-success'
                    },
                    cancel: {
                        visible: true,
                        className: 'btn btn-danger'
                    }
                }
            }).then((Delete) => {
                if (Delete) {
                    $('#form-delete-' + id).submit();
                } else {
                    swal.close();
                }
            });
        }
    </script>
@endpush

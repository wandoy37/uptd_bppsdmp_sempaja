@extends('dashboard.layouts.app')

@section('title', 'Dashboard')

@section('content')

    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Tentang Kami</h4>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('dashboard.tentang_kami.index') }}">
                            <i class="fas fa-info-circle"></i>
                        </a>
                    </li>
                </ul>
            </div>
            {{-- <div class="page-category">Inner page content goes here</div> --}}

            {{-- Notify --}}
            <div id="flash" data-flash="{{ session('success') }}"></div>

            {{-- Fails --}}
            <div id="fails" data-flash="{{ session('fails') }}"></div>

            {{-- Button actions --}}
            <div class="row">
                <div class="col-lg-12">
                    <a href="{{ route('dashboard.tentang_kami.create') }}" class="btn btn-outline-success btn-round">
                        <i class="fas fa-plus"></i>
                        Tambah
                    </a>
                </div>
            </div>

            {{-- Tables --}}
            <div class="row pt-4">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr class="text-center">
                                        <th scope="col">Title</th>
                                        <th scope="col" width="10%">Thumbnail</th>
                                        <th scope="col" width="10%">Status</th>
                                        <th scope="col" width="20%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($aboutUs as $about)
                                        <tr class="text-center">
                                            <td>{{ $about->title }}</td>
                                            <td>
                                                @if ($about->thumbnail == 'no-image.png')
                                                    <img class="img-fluid" width="100px"
                                                        src="{{ asset('uploads/' . $about->thumbnail) }}" alt="">
                                                @else
                                                    <img class="img-fluid" width="100px"
                                                        src="{{ asset('uploads/image/' . $about->thumbnail) }}"
                                                        alt="">
                                                @endif
                                            </td>
                                            <td>
                                                @if ($about->status == 'publish')
                                                    <span class="badge badge-success">{{ $about->status }}</span>
                                                @else
                                                    <span class="badge badge-warning">{{ $about->status }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <form id="form-delete-{{ $about->id }}"
                                                    action="{{ route('dashboard.tentang_kami.delete', $about->slug) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <div class="form-inline d-flex justify-content-center">
                                                    <a href="{{ route('dashboard.tentang_kami.edit', $about->slug) }}"
                                                        class="btn btn-outline-info btn-round mr-2">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-danger btn-round"
                                                        onclick="btnDelete( {{ $about->id }} )">
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
                text: "Data tidak dapat di kembalikan setelah ini !!!",
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

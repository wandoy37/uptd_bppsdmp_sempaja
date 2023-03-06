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
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('dashboard.tentang_kami.create') }}">Tambah</a>
                    </li>
                </ul>
            </div>
            {{-- <div class="page-category">Inner page content goes here</div> --}}

            {{-- Button actions --}}
            <div class="row">
                <div class="col-lg-12">
                    <a href="{{ route('dashboard.tentang_kami.index') }}" class="btn btn-outline-dark btn-round">
                        <i class="fas fa-undo"></i>
                        Kembali
                    </a>
                </div>
            </div>

            {{-- Tables --}}
            <div class="row pt-4">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('dashboard.tentang_kami.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Judul</label>
                                            <input type="text" name="title" class="form-control"
                                                placeholder="Title ..." required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Thumbnail</label>
                                            @error('thumbnail')
                                                <br>
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                            <input type="file" name="thumbnail" class="form-control"
                                                placeholder="thumbnail ...">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Content</label>
                                            <textarea name="content" id="summernote" required></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group float-right">
                                            <input type="submit" name="status" value="publish"
                                                class="btn btn-outline-warning btn-round text-capitalize mr-2">
                                            <input type="submit" name="status" value="draft"
                                                class="btn btn-outline-success btn-round text-capitalize">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $('#summernote').summernote({
            placeholder: 'Content...',
            fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New'],
            tabsize: 2,
            height: 500
        });
    </script>
@endpush

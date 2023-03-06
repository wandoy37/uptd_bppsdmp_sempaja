@extends('dashboard.layouts.app')

@section('title', 'Create Berita')

@section('content')

    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Berita</h4>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('dashboard.berita.index') }}">
                            <i class="fas fa-newspaper"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('dashboard.berita.create') }}">Create</a>
                    </li>
                </ul>
            </div>
            {{-- <div class="page-category">Inner page content goes here</div> --}}

            <div class="row">
                <div class="col-lg-12 my-4">
                    <a href="{{ route('dashboard.berita.index') }}" class="btn btn-outline-dark btn-round">
                        <i class="fas fa-undo"></i>
                        Kembali
                    </a>
                </div>

                <div class="col-lg-12">
                    <form action="{{ route('dashboard.berita.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <label>Judul Berita</label>
                                            <input type="text" class="form-control" name="title" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Content</label>
                                            <textarea name="content" id="summernote" required></textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Pilih Category</label>
                                            <select name="category" class="form-control" required>
                                                <option value="">-select category-</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group" style="margin-top: 55px;">
                                            <label>Thumbnail</label>
                                            @error('thumbnail')
                                                <br>
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                            <input type="file" name="thumbnail" class="form-control"
                                                placeholder="thumbnail ...">
                                        </div>
                                        <div class="form-group float-right">
                                            <input type="submit" name="status" value="publish"
                                                class="btn btn-outline-warning btn-round text-capitalize mr-2">
                                            <input type="submit" name="status" value="draft"
                                                class="btn btn-outline-success btn-round text-capitalize">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
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
            height: 300
        });
    </script>
@endpush

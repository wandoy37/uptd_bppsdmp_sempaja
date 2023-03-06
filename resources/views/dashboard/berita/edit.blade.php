@extends('dashboard.layouts.app')

@section('title', 'Edit Berita')

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
                        <a href="{{ route('dashboard.berita.edit', $berita->slug) }}">Edit
                        </a>
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
                    <form action="{{ route('dashboard.berita.update', $berita->slug) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <label>Judul Berita</label>
                                            <input type="text" class="form-control" name="title" required
                                                value="{{ old('title', $berita->title) }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Content</label>
                                            <textarea name="content" id="summernote" required>
                                                {{ old('content', $berita->content) }}
                                            </textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Pilih Category</label>
                                            <select name="category" class="form-control" required>
                                                <option value="">-select category-</option>
                                                @foreach ($categories as $category)
                                                    @if (old($category->id, $berita->category_id) == $category->id)
                                                        <option value="{{ $category->id }}" selected>{{ $category->title }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                                                    @endif
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
                                        <div class="form-group">
                                            <label>Preview</label>
                                            <br>
                                            <div class="border border-dark text-center">
                                                @if ($berita->thumbnail == 'no-image.png')
                                                    <img src="{{ asset('uploads/' . $berita->thumbnail) }}"
                                                        class="img-fluid my-3" width="170px" alt="">
                                                @else
                                                    <img src="{{ asset('uploads/berita/' . $berita->thumbnail) }}"
                                                        class="img-fluid my-3" width="170px" alt="">
                                                @endif

                                            </div>
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

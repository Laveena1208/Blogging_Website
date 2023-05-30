@extends('admin.layout.app')

@section('styles')
    {{-- TRIK STYLES CDN LINK --}}
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
    {{-- SELECT2 STYLES CDN LINK --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    {{-- FLATPICKR STYLES CDN LINK --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endsection


@section('scripts')
    {{-- TRIK SCRIPT CDN LINK --}}
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>
    {{-- SELECT2 SCRIPT CDN LINK --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    {{-- FLATPICKR SCRIPT CDN LINK --}}
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        $('.select2').select2({
            placeholder: "Select a value",
            allowClear: true
        });

        flatpickr('#published_at', {
            enableTime: true,
            altInput: true,
            altFormat: "F j, Y H:i",
            dateFormat: "Y-m-d H:i",
        });
    </script>
@endsection

@section('main-content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Add new Blog</h1>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.blogs.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{-- TITLE INPUT STARTS HERE --}}
                        <div class="form-group">
                            <label for="title" class="form-label">Title</label>
                            <input
                                type="text"
                                value="{{old('title')}}"
                                class="form-control @error('title') border-danger text-danger @enderror"
                                id="title"
                                placeholder="Enter Title"
                                name="title">
                            @error('title')
                                <span class="text-danger">
                                    {{$message}}
                                </span>
                            @enderror
                        </div>
                        {{-- TITLE INPUT ENDS HERE --}}

                        {{-- EXCERPT INPUT STARTS HERE --}}
                        <div class="form-group">
                            <label for="excerpt" class="form-label">Excerpt</label>
                            <input
                                type="text"
                                value="{{old('excerpt')}}"
                                class="form-control @error('excerpt') border-danger text-danger @enderror"
                                id="excerpt"
                                placeholder="Enter excerpt"
                                name="excerpt">
                            @error('excerpt')
                                <span class="text-danger">
                                    {{$message}}
                                </span>
                            @enderror
                        </div>
                        {{-- EXCERPT INPUT ENDS HERE --}}

                        {{-- BODY INPUT STARTS HERE --}}
                        <div class="form-group">
                            <label for="body" class="form-label">Body</label>
                            <input
                                type="hidden"
                                value="{{old('body')}}"
                                class="form-control @error('body') border-danger text-danger @enderror"
                                id="body"
                                placeholder="Enter Body"
                                name="body">
                                <trix-editor input="body"></trix-editor>
                            @error('body')
                                <span class="text-danger">
                                    {{$message}}
                                </span>
                            @enderror
                        </div>
                        {{-- BODY INPUT ENDS HERE --}}

                        {{-- CATEGORY ID INPUT STARTS HERE --}}
                        <div class="form-group">
                            <label for="category_id" class="form-label">Category</label>
                            <select name="category_id" id="category_id" class="form-control select2">
                                <option></option>
                                @foreach ($categories as $category)
                                    @if ($category->id == old('category_id'))
                                        <option value="{{$category->id}}" selected>{{$category->name}}</option>
                                    @else
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="text-danger">
                                    {{$message}}
                                </span>
                            @enderror
                        </div>
                        {{-- CATEGORY ID INPUT ENDS HERE --}}


                        {{-- TAGS INPUT STARTS HERE --}}
                        <div class="form-group">
                            <label for="tags" class="form-label">Tags</label>
                            <select name="tags[]" id="tags" class="form-control select2" multiple>
                                <option></option>
                                @foreach ($tags as $tag)
                                        <option value="{{$tag->id}}
                                            {{old('tags') && in_array($tag->id, old('tags')) ? 'selected': ''}}">
                                            {{$tag->name}}
                                        </option>
                                @endforeach
                            </select>
                            @error('tags')
                                <span class="text-danger">
                                    {{$message}}
                                </span>
                            @enderror
                        </div>
                        {{-- TAGS INPUT ENDS HERE --}}

                        {{-- PUBLISHED AT INPUT STARTS HERE --}}
                        <div class="form-group">
                            <label for="published_at" class="form-label">Published At</label>
                            <input
                                type="date"
                                value="{{old('published_at')}}"
                                class="form-control @error('published_at') border-danger text-danger @enderror"
                                id="published_at"
                                placeholder="Enter Published Date"
                                name="published_at">
                            @error('published_at')
                                <span class="text-danger">
                                    {{$message}}
                                </span>
                            @enderror
                        </div>
                        {{-- PUBLISHED AT INPUT ENDS HERE --}}

                        {{-- IMAGE INPUT STARTS HERE --}}
                        <div class="form-group">
                            <label for="image" class="form-label">Image</label>
                            <input
                                type="file"
                                class="form-control @error('image') border-danger text-danger @enderror"
                                id="image"
                                placeholder="Select Image File"
                                name="image">
                            @error('image')
                                <span class="text-danger">
                                    {{$message}}
                                </span>
                            @enderror
                        </div>
                        {{-- IMAGE INPUT ENDS HERE --}}

                        <div class="form-group">
                            <button class="btn btn-primary" name="addBlog">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

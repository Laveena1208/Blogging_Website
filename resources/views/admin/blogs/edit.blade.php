@extends('admin.layout.app')

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>
    <script>
        $('.select2').select2({
            placeholder: "Select a Value",
            allowClear: true
        });

        flatpickr("#published_at", {
            enabledTime: true,
            altInput: true,
            altFormat: "F j, Y H:i",
            dateFormat: "Y-m-d H:i"
        });
    </script>
@endsection

@section('main-content')
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.blogs.update', $blog->id)}}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <!-- Title -->
                        <div class="form-group">
                            <label for="title" class="form-label">Title</label>

                            <input
                            type="text"
                            value="{{ old('title', $blog->title)}}"
                            name="title"
                            id="title"
                            class="form-control @error('title') border-danger text-danger @enderror"
                            placeholder="Enter Title">

                            @error('title')
                                <span class="text-danger">
                                    {{-- {{ $errors->has('name') ? 'ERROR' : 'NO ERROR'}}
                                    {{ $errors->first('title') }} --}}

                                    {{ $message }}
                                    {{-- If you are inside error, you get to access $message variable which will print the errors --}}
                                </span>
                            @enderror
                        </div>
                        <!-- end of title -->

                        <!-- excerpt -->
                        <div class="form-group">
                            <label for="excerpt" class="form-label">Excerpt</label>

                            <input
                            type="text"
                            value="{{ old('excerpt', $blog->excerpt)}}"
                            name="excerpt"
                            id="excerpt"
                            class="form-control @error('excerpt') border-danger text-danger @enderror"
                            placeholder="Enter Excerpt">

                            @error('excerpt')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <!-- end of excerpt -->

                        <!-- body -->
                        <div class="form-group">
                            <label for="body" class="form-label">Body</label>

                            <input
                            type="hidden"
                            value="{{ old('body', $blog->body)}}"
                            name="body"
                            id="body"
                            class="form-control @error('body') border-danger text-danger @enderror" >
                            <trix-editor input="body"></trix-editor>
                            @error('body')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <!-- end of body -->

                        <!-- category_id -->
                        <div class="form-group">
                            <label for="category_id" class="form-label">Category</label>
                            <select name="category_id" id="category_id" class="form-control select2">
                                <option></option>
                                @foreach ($categories as $category)
                                    @if($category->id == old('category_id', $blog->category_id))
                                        <option value="{{ $category->id}}" selected>{{ $category->name }}</option>
                                    @else
                                        <option value="{{ $category->id}}">{{ $category->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <!-- end of category_id -->

                        <!-- tags -->
                        <div class="form-group">
                            <label for="tags" class="form-label">Tags</label>
                            <select name="tags[]" id="tags" class="form-control select2" multiple>
                                <option></option>
                                @foreach ($tags as $tag)
                                    <option value="{{ $tag->id}}"
                                        {{ in_array($tag->id, old('tags', $blog->tags()->pluck('tags.id')->toArray())) ? 'selected' : ''}}
                                        >{{$tag->name}}</option>
                                @endforeach
                            </select>
                            @error('tags')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <!-- end of tags -->

                        <!-- published_at -->
                        <div class="form-group">
                            <label for="tag" class="form-label">Publised At</label>

                            <input
                                type="date"
                                value="{{ old('published_at', $blog->published_at)}}"
                                class="form-control  @error('published_at') text-danger border-danger @enderror"
                                id="published_at"
                                name="published_at"
                            >

                            @error('published_at')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <!-- end of tags -->

                        <!-- image file -->
                        <div class="row">
                            <div class="col-md-4">
                                <img src="{{asset($blog->image_path)}}" alt="" width="100%">
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="image" class="form-label">Image</label>

                                    <input
                                        type="file"
                                        class="form-control @error('image_path') text-danger border-danger @enderror"
                                        id="image_path"
                                        name="image"
                                    >

                                    @error('image')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- end of tags -->



                        <div class="from-group">
                            <button type="submit" name="addCategory" class="btn btn-primary">Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

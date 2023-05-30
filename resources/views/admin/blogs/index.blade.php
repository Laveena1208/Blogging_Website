@extends('admin.layout.app')
@section('main-content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Blogs</h1>
            <a href="{{ route('admin.blogs.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-plus fa-sm text-white-50"></i> Create Blog</a>
        </div>
        <!-- END OF Page Heading -->

        <div class="row">
            <div class="col-md-12">
                @include('admin.layout._alert-messages')
                <table class="table table-bordered">
                    <thead>
                        <th> Id</th>
                        <th> Image</th>
                        <th> Title</th>
                        <th> Excerpt</th>
                        <th> Category</th>
                        <th> Actions</th>
                    </thead>
                    <tbody>
                        @foreach ($blogs as $blog)
                            <tr>
                                <td> {{ $blog->id }}</td>
                                <td>
                                    <img src="{{ asset($blog->image_path) }}" alt="{{ $blog->title }}" width="80px">
                                </td>
                                <td> {{ $blog->title }}</td>
                                <td> {{ $blog->excerpt }}</td>
                                <td> {{ $blog->category->name }}</td>
                                <td>
                                    <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="btn btn-primary"><i
                                            class="fas fa-pen"></i>
                                    </a>

                                    <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal"
                                        onclick="deleteModalHelper('{{ route('admin.blogs.trash', $blog->id) }}')">
                                        <i class="fa fa-trash"></i>
                                    </button>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if($blogs->count() == 0)
                <p>No blogs found!</p>
                @endif
                {{ $blogs->links('vendor.pagination.bootstrap-5') }}

            </div>
            <!-- DELETE Modal-->
            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form method="POST" action="" id="deleteForm">
                        @csrf
                        @method('DELETE')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel">Delete Category?</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">Are you sure you want to delete Category?</div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                <button class="btn btn-danger" type="submit">Delete</a>
                            </div>
                        </div>
                </div>
            </div>
            </form>

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function deleteModalHelper(url) {
            document.getElementById("deleteForm").setAttribute('action', url);
        }
    </script>
@endsection

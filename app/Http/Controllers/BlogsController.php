<?php

namespace App\Http\Controllers;

use App\Http\Requests\Blogs\CreateBlogsRequest;
use App\Http\Requests\Blogs\UpdateBlogsRequest;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class BlogsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['validateAuthor'])->only(['edit', 'update', 'destroy','trash']);
    }

    public function index() {
        $authUser = auth()->user();
        if($authUser->isAdmin()) {
        $blogs = Blog::with('category')->latest()->paginate(10);
        } else {
            $blogs = Blog::with('category')
            ->where('user_id', $authUser->id)
            ->latest()
            ->paginate(10);
        }

        return view('admin.blogs.index', compact('blogs'));
    }

    public function create() {
        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.blogs.create', compact([
            'categories',
            'tags'
        ]));
    }

    public function store(CreateBlogsRequest $request) {
        //Image Upload and return the name of the file which will be created
        $image_path = $request->file('image')->store('blogs');
        $data = $request->only(['title', 'excerpt', 'body', 'category_id', 'published_at']);

        $data = array_merge($data, [
            'image_path' => $image_path,
            'user_id' => auth()->user()->id
        ]);

        $blog = Blog::create($data);
        $blog->tags()->attach($request->tags);

        session()->flash('success', 'Blog created successfully...');
        return redirect(route('admin.blogs.index'));
    }

    public function edit(Blog $blog) {
        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.blogs.edit', compact([
            'categories',
            'tags',
            'blog'
        ]));
    }

    public function update(UpdateBlogsRequest $request, Blog $blog) {
        $data = $request->only(['title', 'excerpt', 'body', 'category_id', 'published_at']);

        if($request->hasFile('image')) {
            $image_path = $request->file('image')->store('blogs');
            $blog->deleteImage();
            $data = array_merge($data, ['image_path' => $image_path]);
        }

        $blog -> update($data);
        $blog->tags()->sync($request->tags);

        session()->flash('success', 'Blog Updated successfully...');
        return redirect(route('admin.blogs.index'));
    }

    public function trash(Blog $blog) {
        $blog->delete();

        session()->flash('success', 'Blog Deleted successfully...');
        return redirect(route('admin.blogs.index'));
    }

    public function destroy(int $blogId) {
        $blog = Blog::onlyTrashed()->find($blogId);
        $blog->deleteImage();
        $blog->forceDelete();

        session()->flash('success', 'Blog Destroyed successfully...');
        return redirect(route('admin.blogs.index'));
    }

    public function trashed() {
        $blogs = Blog::with('category')
                ->where('user_id', auth()->id())
                ->onlyTrashed()
                ->latest()
                ->paginate(10);

        return view('admin.blogs.trashed', compact(('blogs')));
    }

    public function restore(int $blogId) {
        $blog = Blog::withTrashed()->find($blogId);
        $blog->restore();

        session()->flash('success', 'Blog Restore successfully...');
        return redirect(route('admin.blogs.index'));
    }
}


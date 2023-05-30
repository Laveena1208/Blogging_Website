<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Http\Requests\Tags\CreateTagsRequest;
use App\Http\Requests\Tags\UpdateTagsRequest;

class TagsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['validateAdmin'])->only(['edit', 'update', 'destroy','trash', 'create']);
    }

    public function index()
    {
        $tags = Tag::latest()->paginate(2);
        return view('admin.tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateTagsRequest $request)
    {
        // dd($request);
        $userId = auth()->user()->id;
        Tag ::create([
            'name' => $request->name,
            'created_by' => $userId,
            'last_updated_by' => $userId
        ]);
        session()->flash('success', 'Tag created succesfully...');
        return redirect(route('admin.tags.index'));
    }
    public function update(UpdateTagsRequest $request, Tag $tag)
    {
        $tag->name = $request->name;
        $tag->save();

        session()->flash('success', 'Tag updated succesfully...');
        return redirect(route('admin.tags.index'));

    }
    public function edit(Tag $tag)
    {
        //route model binding
        return view('admin.tags.edit', compact(['tag']));
    }
    public function destroy(Request $request, Tag $tag)
    {
        //TODO validate whether the category has post associated with it. if not then only proceed!
        if($tag->blogs->count()>0){
            session()->flash('error', 'Tag cannot be deleted as it has posts associated');
        return redirect(route('admin.tags.index'));
        }
        $tag->delete();
        session()->flash('success', 'Tag deleted succesfully...');
        return redirect(route('admin.tags.index'));

    }
}

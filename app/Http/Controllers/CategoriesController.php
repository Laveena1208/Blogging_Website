<?php

namespace App\Http\Controllers;

use App\Http\Requests\Categories\CreateCategoriesRequest;
use App\Http\Requests\Categories\UpdateCategoryRequest;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware(['validateAdmin'])->only(['edit', 'update', 'destroy','trash', 'create']);
    }

    public function index()
    {
        $categories = Category::withCount('blogs')->latest('updated_at')->paginate(20);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCategoriesRequest $request)
    {
        // dd($request);
        $userId = auth()->user()->id;
        Category ::create([
            'name' => $request->name,
            'created_by' => $userId,
            'last_updated_by' => $userId
        ]);
        // session()->put('sucess', 'Category created succesfully...');
        session()->flash('success', 'Category created succesfully...');
        return redirect(route('admin.categories.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //route model binding
        return view('admin.categories.edit', compact(['category']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->name = $request->name;
        $category->last_updated_by = auth()->user()->id;
        $category->save();

        session()->flash('success', 'Category updated succesfully...');
        return redirect(route('admin.categories.index'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Category $category)
    {
        //TODO validate whether the category has post associated with it. if not then only proceed!

        if($category->blogs->count()>0){
            session()->flash('error', 'Category cannot be deleted as it has posts associated');
        return redirect(route('admin.categories.index'));
        }
        $category->delete();
        session()->flash('success', 'Category deleted succesfully...');
        return redirect(route('admin.categories.index'));

    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\Category\StoreRequest;
use App\Http\Requests\Category\UpdateRequest;
use App\Models\Yacht;
use App\Models\Yachts;


class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('created_at', 'DESC')->get();
        return view('admin.modules.category.index', [
            'categories' => $categories,
        ]);
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.modules.category.create', [
            'categories' => $categories,
        ]);
    }

    public function store(StoreRequest $request)
    {
        $data = [
            'name' => $request->name,
            'status' => $request->status,
        ];
        $category = Category::create($data);
        $category->save();
        return redirect()->route('admin.category.index')->with('success', "Create Category $category->name success!");
    }

    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.modules.category.edit', [
            'category' => $category,
        ]);
    }

    public function update(UpdateRequest $request, string $id)
    {
        $category = Category::findOrFail($id);
        $update_category = [
            'name' => $request->name,
            'status' => $request->status,
        ];
        $category->update($update_category);
        return redirect()->route('admin.category.index')->with('success', "Update Category $category->name successfully!");
    }

    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);

        $check_yacht = Yacht::where('category_id', $id)->count();
        if ($check_yacht > 0) {
            return redirect()->route('admin.category.index')
                ->with('error', "Sorry, This Category has products. Can not remove!");
        }

        $category->delete();
        return redirect()->route('admin.category.index')->with('success', "Remove Category $category->name success!");
    }
}

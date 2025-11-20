<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function create()
    {
        return view('categories.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|string|max:255|unique:categories,name',
        ]);

        Category::create([
            'name'=>$request->name,
            'slug'=>Str::slug($request->name),
        ]);

        return redirect()->route('events.index')->with('success','Kategori oluşturuldu.');
    }
    public function edit(Category $category)
    {
        return view('categories.edit',compact('category'));
    }
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name'=>'required|string|max:255|unique:categories,name,'.$category->id,
        ]);

        $category->update([
            'name'=>$request->name,
            'slug'=>Str::slug($request->name),
        ]);

        return redirect()->route('events.index')->with('success','Kategori güncellendi.');
    }
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('events.index')->with('success','Kategori silindi.');
    }
}

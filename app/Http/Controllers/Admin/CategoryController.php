<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index() {
        $categories = Category::with(['parentCategory:id,name','user'])->orderBy('order', 'DESC')->paginate(5);

        return view('admin.categories.list', ['list' => $categories]);
    }

    public function create() {
        return view('admin.categories.create-update');
    }

    public function changeStatus(Request $request) {
        $request->validate([
            'id' => ['required', 'integer', 'exists:categories']
        ]);
        $categoryID = $request->id;

        $category = Category::where('id', $categoryID)->first();
        $oldStatus = $category->status;
        $category->status = !$category->status;
        $category->save();

        $statusText = ($oldStatus == 1 ? "Active" : 'Passive') . " to " . ($category->status == 1 ? 'Active' : 'Passive');

        alert()
            ->success("Successful", "Status of " . $category->name. " was changed from " . $statusText . " status")
            ->showConfirmButton('OK', '#3085d6')
            ->autoClose(5000);
        
        return redirect()->route('category.index');
    }

    public function changeFeatureStatus(Request $request) {
        $request->validate([
            'id' => ['required', 'integer', 'exists:categories']
        ]);
        $categoryID = $request->id;
        $category = Category::where('id', $categoryID)->first();
        $oldStatus = $category->feature_status;
        $category->feature_status = !$category->feature_status;
        $category->save();

        $statusText = ($oldStatus == 1 ? "Active" : 'Passive') . " to " . ($category->feature_status == 1 ? 'Active' : 'Passive');

        alert()
            ->success("Successful", "Feature Status of " . $category->name. " was changed from " . $statusText . " status")
            ->showConfirmButton('OK', '#3085d6')
            ->autoClose(5000);
        
        return redirect()->route('category.index');
    }

    public function delete(Request $request) {
        $request->validate([
            'id' => ['required', 'integer', 'exists:categories']
        ]);

        $categoryID = $request->id;

        Category::where('id', $categoryID)->delete();

        $statusText = 'Category was deleted';

        alert()
            ->success("Successful", $statusText)
            ->showConfirmButton('OK', '#3085d6')
            ->autoClose(5000);
        
        return redirect()->route('category.index');
    }

    public function edit(Request $request) {

        $categoryID = $request->id;

        $category = Category::where('id', $categoryID)->first();
        
        if(is_null($category)) {

            $statusText = 'Category not found';

            alert()
                ->error("Error", $statusText)
                ->showConfirmButton('OK', '#3085d6')
                ->autoClose(5000);
        
            return redirect()->route('category.index');
        
        }

        return view('admin.categories.create-update', compact($category));

    }
}

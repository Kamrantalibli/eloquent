<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\User;
use App\Http\Requests\CategoryStorerequest;

class CategoryController extends Controller
{
    public function index(Request $request) {

        $parentCategories = Category::all();
        $users = User::all();

        $parentID = $request->parent_id;
        $userID = $request->user_id;

        $categories = Category::with(['parentCategory:id,name','user'])
            // ->where(function($query) use($parentID, $userID) {
            //     if(!is_null($parentID)) {
            //         $query->where('parent_id', $parentID)
            //     }
            //     if(!is_null($userID)) {
            //         $query->where('user_id', $userID)
            //     }
            // })
            ->name($request->name)
            ->description($request->description)
            ->slug($request->slug)
            ->order($request->order)
            ->status($request->status)
            ->featureStatus($request->feature_status)
            ->parentCategory($request->parent_id)
            ->user($request->user_id)
            ->orderBy('order', 'DESC')
            ->paginate(5);

        return view('admin.categories.list', ['list' => $categories, 'users' => $users, 'parentCategories' => $parentCategories]);
    }

    public function create() {
        $categories = Category::all();
        return view('admin.categories.create-update', compact('categories'));
    }

    public function store(CategoryStoreRequest $request) {
        $slug = Str::slug($request->slug);
        $slugCheck = Category::where('slug', $slug)->first();

        try {
            //code...
            $category = new Category();
            $category->name = $request->name;
            $category->slug = is_null($slugCheck) ? $slug : Str::slug($request->slug . time());
            $category->description = $request->description;
            $category->order = $request->order;
            $category->parent_id = $request->parent_id;
            $category->status = $request->status ? 1 : 0;
            $category->feature_status = $request->feature_status ? 1 : 0;
            $category->seo_keywords = $request->seo_keywords;
            $category->seo_description = $request->seo_description;
            $category->user_id = random_int(1,10);
            
            $category->save();
        } catch (\Exception $exception) {
            abort(404, $exception->getMessage());
        }
            
        alert()
            ->success("Successful", "Category Saved")
            ->showConfirmButton('OK', '#3085d6')
            ->autoClose(5000);

        return redirect()->back();
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

    public function delete(Request $request, Category $category) {
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

        $categories = Category::all();

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

        return view('admin.categories.create-update', compact('category', 'categories'));

    }

    public function update(CategoryStoreRequest $request) {
        $slug = Str::slug($request->slug);
        $slugCheck = Category::where('slug', $slug)->first();

        try {
            //code...
            $category = Category::find($request->id);
            $category->name = $request->name;
            if ((!is_null($slugCheck) && $slugCheck->id == $category->id) || is_null($slugCheck)) {
                $category->slug = $slug;
            } else if(!is_null($slugCheck) && $slugCheck->id != $category->id) {
                $category->slug = Str::slug($slug .time());
            } else {
                $category->slug = Str::slug($slug .time());
            }
            $category->description = $request->description;
            $category->order = $request->order;
            $category->parent_id = $request->parent_id;
            $category->status = $request->status ? 1 : 0;
            $category->feature_status = $request->feature_status ? 1 : 0;
            $category->seo_keywords = $request->seo_keywords;
            $category->seo_description = $request->seo_description;
            // $category->user_id = random_int(1,10);
            
            $category->save();
        } catch(\Exception $exception) {
            abort(404, $exception->getMessage());
        }

        alert()
            ->success("Successful", "Category Updated")
            ->showConfirmButton('OK', '#3085d6')
            ->autoClose(5000);

        return redirect()->route('category.index');
    }
    
}

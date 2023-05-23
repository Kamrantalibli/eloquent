<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index() {
        $categories = Category::with(['parentCategory:id,name','user'])->orderBy('order', 'DESC')->get();

        return view('admin.categories.list', ['list' => $categories]);
    }

    public function create() {
        return view('admin.categories.create-update');
    }
}

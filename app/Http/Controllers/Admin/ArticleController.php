<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class ArticleController extends Controller
{

    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->middleware('language');
    }

    public function index() {
        return view('admin.articles.list');
    }

    public function create() {

        $categories = Category::all();

        return view('admin.articles.create-update', compact('categories'));
    }
}

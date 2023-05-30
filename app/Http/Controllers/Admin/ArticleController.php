<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Article;
use App\Http\Requests\ArticleCreateRequest;

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

    public function store(ArticleCreateRequest $request) {

        $imageFile = $request->file('image');
        $originalName = $imageFile->getClientOriginalName();
        $originalExtension = $imageFile->getClientOriginalExtension();
        // $originalExtension = $imageFile->extension();
        $explodeName = explode('.', $originalName)[0];
        $fileName = Str::slug($explodeName) . '.' . $originalExtension;

        $folder = 'articles';
        $publicPath = 'storage/'. $folder;

        if(file_exists(public_path($publicPath . $fileName))) {
            
            return redirect()->back()->withErrors([
                'image' => 'Same image already uploaded.'
            ]);

        }

        $data = $request->except('_token');
        $slug = $data['slug'] ?? $data['title'];
        $slug = Str::slug($slug);
        $slugTitle = Str::slug($data['title']);   


        $checkSlug = $this->slugCheck($slug);

        if(!is_null($checkSlug)) {
            $checkTitleSlug = $this->slugCheck($slugTitle);
            if(!is_null($checkTitleSlug)) {
                // If title Slug is not empty
                $slug = Str::slug($slug . time());
            }
            else {
                $slug = $slugTitle;
            }
        }

        $data['slug'] = $slug;
        $data['image'] = $publicPath . '/' . $fileName;
        $data['user_id'] = auth()->id();
        // $data['user_id'] = auth()->user()->id;
        // $data['user_id'] = \Auth::id();
        // $data['user_id'] = \Auth::user()->id;

        Article::create($data);
        $imageFile->storeAs($folder, $fileName, 'public'); /** storage/app/public/articles/$fileName  create */

        alert()
            ->success("Successful", "Category Saved")
            ->showConfirmButton('OK', '#3085d6')
            ->autoClose(5000);

        return redirect()->back();



        dd($fileName);
        dd($request->all());
    }
    
    public function slugCheck(string $text) {
        return Article::where('slug',$text)->first();
    }
}

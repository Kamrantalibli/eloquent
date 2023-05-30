@extends('layouts.admin')

@section('title')
    Article {{ isset($article) ? 'Update' : 'Create' }}
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/summernote/summernote-lite.min.css') }}">
@endsection

@section('content')
<x-bootstrap.card>
    <x-slot name='header'>
        <h2 class="card-title">Article {{ isset($article) ? 'Update' : 'Create' }}</h2>
    </x-slot>

    <x-slot name='body'>
        <p class="card-description"></p>
        <div class="example-container">
            <div class="example-content">
                {{-- @if($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">{{ $error }}</div>
                    @endforeach
                @endif --}}
                <form action="{{ isset($article) ? route('article.edit', ['id' => $article->id]) : route('article.create') }}" method="POST">
                    @csrf
                    @if ($errors->has('title'))
                        <small class="text-danger">* {{ $errors->first('title') }}</small>
                    @endif
                    <label for="title" class="form-label">Article Title</label>
                    <input type="text" 
                        class="form-control form-control-solid-bordered m-b-sm" 
                        placeholder="Article Title"
                        name="title"
                        id="title"
                        value="{{ isset($article) ? $article->title : '' }}"
                        required
                    >

                    @if ($errors->has('slug'))
                        <small class="text-danger">* {{ $errors->first('slug') }}</small>
                    @endif
                    <label for="slug" class="form-label">Article Slug</label>
                    <input type="text" 
                        class="form-control form-control-solid-bordered m-b-sm" 
                        placeholder="Article Slug"
                        name="slug"
                        id="slug"
                        value="{{ isset($article) ? $article->slug : '' }}"
                    >

                    <label for="tags" class="form-label">Tags</label>
                    <input type="text" 
                        class="form-control form-control-solid-bordered" 
                        placeholder="Tags"
                        name="tags"
                        value="{{ isset($article) ? $article->tags : '' }}"
                        id="tags"
                    >
                    <div class="form-text m-b-sm">Write each tags separated by commas</div>

                    <label for="category_id" class="form-label">Category</label>
                    <select 
                        class="form-control form-select form-control-solid-bordered m-b-sm" 
                        name="category_id"
                        id="category_id"
                        >
                        <option value="{{ null }}" selected>Category Selection</option>
                        @foreach ($categories as $item)
                            <option value="{{ $item->id }}" {{ isset($article) && $article->category_id == $item->id ? "selected" : "" }}>
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select>


                    <label for="summernote" class="form-label">Content</label>
                    <div id="summernote" class="m-b-sm">Hello Summernote</div>

                    @if ($errors->has('seo_keywords'))
                        <small class="text-danger">* {{ $errors->first('seo_keywords') }}</small>
                    @endif
                    <label for="seo_keywords" class="form-label m-t-sm">Seo Keywords</label>
                    <textarea 
                        class="form-control form-control-solid-bordered m-b-sm" 
                        name="seo_keywords" 
                        id="seo_keywords" 
                        cols="30" rows="5" 
                        placeholder="Seo Keywords" 
                        style="resize: none">{{ isset($article) ? $article->seo_keywords : '' }}</textarea>

                    @if ($errors->has('seo_description'))
                    <small class="text-danger">* {{ $errors->first('seo_description') }}</small>
                    @endif
                    <label for="seo_description" class="form-label">Seo Description</label>
                    <textarea 
                        class="form-control form-control-solid-bordered m-b-sm" 
                        name="seo_description" 
                        id="seo_description" 
                        cols="30" rows="5" 
                        placeholder="Seo Description" 
                        style="resize: none">{{ isset($article) ? $article->seo_description : '' }}</textarea>

                    <label for="publish_date" class="form-label">Publish Date</label>
                    <input class="form-control flatpickr2 m-b-sm" id="publish_date" name="publish_date" type="text" placeholder="When to share..">

                    <label for="image" class="form-label">Article Image</label>
                    <input type="file" name="image" id="image" class="form-control" accept="image/png, image/jpeg, image/jpg">
                    <div class="form-text m-b-sm">Article Image should be maximum 2MB</div>

                    <div class="form-check m-b-sm">
                        <input class="form-check-input" type="checkbox" name="status" value="1" id="status" {{ isset($article) && $article->status ? "checked" : "" }} >
                        <label class="form-check-label" for="status">
                            Do You Want Article Visible In Site
                        </label>
                    </div>
                    
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-success btn-rounded">
                            {{ isset($article) ? 'Update' : 'Save' }}   
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </x-slot>
</x-bootstrap.card>
  
@endsection

@section('js')
    <script src="{{ asset('assets/admin/plugins/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/admin/js/pages/datepickers.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/summernote/summernote-lite.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/pages/text-editor.js') }}"></script>
    <script>
        $('#publish_date').flatpickr({
            enableTime: true,
            dateFormat: 'Y-m-d H:i',
        });
    </script>
@endsection
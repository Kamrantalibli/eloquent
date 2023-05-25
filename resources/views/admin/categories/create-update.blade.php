@extends('layouts.admin')

@section('title')
    Category {{ isset($category) ? 'Update' : 'Create' }}
@endsection

@section('css')
@endsection

@section('content')
<x-bootstrap.card>
    <x-slot name='header'>
        <h2 class="card-title">Category {{ isset($category) ? 'Update' : 'Create' }}</h2>
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
                <form action="{{ isset($category) ? route('categories.edit', ['id' => $category->id]) : route('category.create') }}" method="POST">
                    @csrf
                    @if ($errors->has('name'))
                        <small class="text-danger">* {{ $errors->first('name') }}</small>
                    @endif
                    <input type="text" 
                        class="form-control form-control-solid-bordered m-b-sm" 
                        aria-describedby="solidBoderedInputExample" 
                        placeholder="Category Name"
                        name="name"
                        value="{{ isset($category) ? $category->name : '' }}"
                        required
                    >
                    @if ($errors->has('slug'))
                        <small class="text-danger">* {{ $errors->first('slug') }}</small>
                    @endif
                    <input type="text" 
                        class="form-control form-control-solid-bordered m-b-sm" 
                        aria-describedby="solidBoderedInputExample" 
                        placeholder="Category Slug"
                        name="slug"
                        value="{{ isset($category) ? $category->slug : '' }}"
                    >

                    @if ($errors->has('description'))
                        <small class="text-danger">* {{ $errors->first('description') }}</small>
                    @endif
                    <textarea 
                        class="form-control form-control-solid-bordered m-b-sm" 
                        name="description" 
                        id="" 
                        cols="30" rows="5" 
                        placeholder="Category Description" 
                        style="resize: none">{{ isset($category) ? $category->description : '' }}</textarea>

                    <input 
                        type="number" 
                        class="form-control form-control-solid-bordered m-b-sm" 
                        aria-describedby="solidBoderedInputExample" 
                        placeholder="Category Order"
                        name="order"
                        value="{{ isset($category) ? $category->order : '' }}"
                    >

                    <select 
                        class="form-control form-select form-control-solid-bordered m-b-sm" 
                        aria-label="Top Category Selection" 
                        name="parent_id"
                        >
                        <option value="{{ null }}" selected>Top Category Selection</option>
                        @foreach ($categories as $item)
                            <option value="{{ $item->id }}" {{ isset($category) && $category->id == $item->id ? "selected" : "" }}>
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select>

                    @if ($errors->has('seo_keywords'))
                        <small class="text-danger">* {{ $errors->first('seo_keywords') }}</small>
                    @endif
                    <textarea 
                        class="form-control form-control-solid-bordered m-b-sm" 
                        name="seo_keywords" 
                        id="seo_keywords" 
                        cols="30" rows="5" 
                        placeholder="Seo Keywords" 
                        style="resize: none">{{ isset($category) ? $category->seo_keywords : '' }}</textarea>

                    @if ($errors->has('seo_description'))
                    <small class="text-danger">* {{ $errors->first('seo_description') }}</small>
                    @endif
                    <textarea 
                        class="form-control form-control-solid-bordered m-b-sm" 
                        name="seo_description" 
                        id="seo_description" 
                        cols="30" rows="5" 
                        placeholder="Seo Description" 
                        style="resize: none">{{ isset($category) ? $category->seo_description : '' }}</textarea>

                    <div class="form-check m-b-sm">
                        <input class="form-check-input" type="checkbox" name="status" value="1" id="status" {{ isset($category) && $category->status ? "checked" : "" }} >
                        <label class="form-check-label" for="status">
                            Do You Want Category Visible In Site
                        </label>
                    </div>

                    <div class="form-check m-b-sm">
                        <input class="form-check-input" type="checkbox" name="feature_status" value="1" id="feature_status" {{ isset($category) && $category->feature_status ? "checked" : "" }} >
                        <label class="form-check-label" for="feature_status">
                            Do You Want Category Featured on homepage?
                        </label>
                    </div>
                    
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-success btn-rounded">
                            {{ isset($category) ? 'Update' : 'Save' }}   
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </x-slot>
</x-bootstrap.card>
  
@endsection

@section('js')
@endsection
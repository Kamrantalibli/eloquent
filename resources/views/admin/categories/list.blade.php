@extends('layouts.admin')

@section('title')
    Category List
@endsection

@section('css')
    <style>
        .table-hover > tbody >tr:hover {
            --bs-table-hover-bg: transparent;
            background: #363638;
            color: #fff
        }
    </style>
@endsection

@section('content')
    <x-bootstrap.card>
        <x-slot name="header">
            <h2>Category List</h2>
        </x-slot>

        <x-slot name="body">
            <x-bootstrap.table 
            :class="'table-striped table-hover'"
            :isResponsive='true'>
                <x-slot:columns>
                    <th scope="col">Name</th>
                    <th scope="col">Slug</th>
                    <th scope="col">Status</th>    
                    <th scope="col">Feature Status</th>    
                    <th scope="col">Description</th>    
                    <th scope="col">Order</th>    
                    <th scope="col">Parent Category</th>    
                    <th scope="col">User</th>    
                    <th scope="col">Actions</th>    
                </x-slot:columns>
                <x-slot:rows>
                    @foreach ($list as $category)
                        <tr>
                            <th scope="row">{{ $category->name }}</th>
                            <td>{{ $category->slug }}</td>
                            <td>
                                @if ($category->status)
                                    Active
                                @else
                                    Passive                                    
                                @endif
                            </td>
                            <td>
                                @if ($category->feature_status)
                                    Active
                                @else
                                    Passive                                    
                                @endif
                            </td>
                            <td>{{ substr($category->description, 0, 20) }}</td>
                            <td>{{ $category->order }}</td>
                            <td>{{ $category->parentCategory?->name }}</td>
                            <td>{{ $category->user?->name }}</td>
                            <td>
                                <div class="d-flex">
                                    <a href="" class="btn btn-success btn-sm"><i class="material-icons ms-0">edit</i></a>
                                    <a href="" class="btn btn-danger btn-sm"><i class="material-icons ms-0">delete</i></a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </x-slot:rows>
            </x-bootstrap.table>   
        </x-slot>
    </x-bootstrap.card>
@endsection

@section('js')
@endsection
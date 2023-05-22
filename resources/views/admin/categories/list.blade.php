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
                    <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                        <td>Mark</td>
                        <td>Otto</td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                        <td>Jacob</td>
                        <td>Thornton</td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td>Larry</td>
                        <td>Bird</td>
                        <td>@twitter</td>
                        <td>Larry</td>
                        <td>Bird</td>
                        <td>@twitter</td>
                        <td>Larry</td>
                        <td>Bird</td>
                    </tr>
                    
                </x-slot:rows>
            </x-bootstrap.table>   
        </x-slot>
    </x-bootstrap.card>
@endsection

@section('js')
@endsection
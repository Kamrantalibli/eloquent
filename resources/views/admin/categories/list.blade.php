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
            <x-bootstrap.table :class="'table-striped table-hover'">
                <x-slot:columns>
                    <th scope="col">#</th>
                    <th scope="col">First</th>
                    <th scope="col">Last</th>
                    <th scope="col">Handle</th>    
                </x-slot:columns>
                <x-slot:rows>
                    <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td colspan="2">Larry the Bird</td>
                        <td>@twitter</td>
                    </tr>
                </x-slot:rows>
            </x-bootstrap.table>   
        </x-slot>
    </x-bootstrap.card>
@endsection

@section('js')
@endsection
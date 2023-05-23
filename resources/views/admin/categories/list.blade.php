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
                                    <a href="javascript:void(0)" data-id="{{ $category->id  }}" class="btn btn-sm btn-success btnChangeStatus">Active</a>
                                @else
                                    <a href="javascript:void(0)" data-id="{{ $category->id  }}" class="btn btn-sm btn-danger btnChangeStatus">Passive</a>                                   
                                @endif
                            </td>
                            <td>
                                @if ($category->feature_status)
                                    <a href="javascript:void(0)" data-id="{{ $category->id  }}" class="btn btn-sm btn-success btnChangeFeatureStatus">Active</a>
                                @else
                                    <a href="javascript:void(0)" data-id="{{ $category->id  }}" class="btn btn-sm btn-danger btnChangeFeatureStatus">Passive</a>                                   
                                @endif
                            </td>
                            <td>{{ substr($category->description, 0, 20) }}</td>
                            <td>{{ $category->order }}</td>
                            <td>{{ $category->parentCategory?->name }}</td>
                            <td>{{ $category->user?->name }}</td>
                            <td>
                                <div class="d-flex">
                                    <a href="javascript:void(0)" class="btn btn-warning btn-sm"><i class="material-icons ms-0">edit</i></a>
                                    <a href="javascript:void(0)" class="btn btn-danger btn-sm"><i class="material-icons ms-0">delete</i></a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </x-slot:rows>
            </x-bootstrap.table>   
        </x-slot>
    </x-bootstrap.card>
    <form action="" method="POST" id="statusChangeForm">
        @csrf
        <input type="hidden" name="id" id="inputStatus" value="">
    </form>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('.btnChangeStatus').click(function () {
                let categoryID = $(this).data('id');
                console.log(categoryID);
                $('#inputStatus').val(categoryID);

                Swal.fire({
                title: 'Are you sure you want to change Status?',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: 'Yes',
                denyButtonText: `No`,
                }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $('#statusChangeForm').attr('action', "{{ route('categories.changeStatus') }}");
                    $('#statusChangeForm').submit();
                } 
                else if (result.isDenied) {
                    // Swal.fire('Nothing action taken.', '', 'info')
                    Swal.fire({
                        title: 'Info',
                        text: 'Nothing action taken.',
                        confirmButtonText: 'OK',
                        icon: 'info'
                    });
                }
                })

                });  
        
            $('.btnChangeFeatureStatus').click(function () {
                let categoryID = $(this).data('id');
                console.log(categoryID);
                $('#inputStatus').val(categoryID);

                Swal.fire({
                title: 'Are you sure you want to change Feature Status?',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: 'Yes',
                denyButtonText: `No`,
                }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $('#statusChangeForm').attr('action', "{{ route('categories.changeFeatureStatus') }}");
                    $('#statusChangeForm').submit();
                } 
                else if (result.isDenied) {
                    // Swal.fire('Nothing action taken.', '', 'info')
                    Swal.fire({
                        title: 'Info',
                        text: 'Nothing action taken.',
                        confirmButtonText: 'OK',
                        icon: 'info'
                    });
                }
                })

                })
            })
    </script>
@endsection
@extends('layouts.admin')

@section('title')
    Category List
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}">
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
            <form action="">
                <div class="row">
                    <div class="col-3 my-2">
                        <input type="text" class="form-control" placeholder="Name" name="name" value="{{ request()->get('name') }}">
                    </div>
                    <div class="col-3 my-2">
                        <input type="text" class="form-control" placeholder="Slug" name="slug" value="{{ request()->get('slug') }}">
                    </div>
                    <div class="col-3 my-2">
                        <input type="text" class="form-control" placeholder="Description" name="description" value="{{ request()->get('description') }}">
                    </div>
                    <div class="col-3 my-2">
                        <input type="text" class="form-control" placeholder="Order" name="order" value="{{ request()->get('order') }}">
                    </div>
                    <div class="col-3 my-2">
                        <select class="js-states form-control" tabindex="-1" id="selectParentCategory" style="display:none; width:100%" name="parent_id">
                            <option value="{{ null }}" >Select Parent Category</option>
                            @foreach ($parentCategories as $parent)
                                <option value="{{ $parent->id }}" {{ request()->get('parent_id') == $parent->id ? 'selected' : '' }} >{{ $parent->name }}</option>    
                            @endforeach
                        </select>
                    </div>
                    <div class="col-3 my-2">
                        <select class="form-select" name="user_id" aria-label="Select Parent Category">
                            <option value="{{ null }}" >Select User</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ request()->get('user_id') == $user->id ? 'selected' : '' }} >{{ $user->name }}</option>    
                            @endforeach
                        </select>
                    </div>
                    <div class="col-3 my-2">
                        <select class="form-select" name="status" aria-label="Status">
                            <option value="{{ null }}" >Status</option>
                            <option value="0" {{ request()->get('status') === '0' ? 'selected' : '' }} >Passive</option>
                            <option value="1" {{ request()->get('status') === '1' ? 'selected' : '' }} >Active</option>
                        </select>
                    </div>
                    <div class="col-3 my-2">
                        <select class="form-select" name="feature_status" aria-label="Feature Status">
                            <option value="{{ null }}" >Feature Status</option>
                            <option value="0" {{ request()->get('feature_status') === '0' ? 'selected' : '' }} >Passive</option>
                            <option value="1" {{ request()->get('feature_status') === '1' ? 'selected' : '' }} >Active</option>
                        </select>
                    </div>
                    <div class="col-12 d-flex justify-content-end my-2 gap-3">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <button type="submit" class="btn btn-warning">Reset Filter</button>
                    </div>
                </div>
                <hr>
            </form>
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
                                    <a href="{{ route('categories.edit', ['id' => $category->id]) }}" class="btn btn-warning btn-sm"><i class="material-icons ms-0">edit</i></a>
                                    <a href="javascript:void(0)" 
                                        class="btn btn-danger btn-sm btnDelete"
                                        data-name="{{ $category->name }}" 
                                        data-id="{{ $category->id }}" >
                                            <i class="material-icons ms-0">delete</i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </x-slot:rows>
            </x-bootstrap.table>
            <div class="d-flex justify-content-center">
                {{-- {{ $list->links('vendor.pagination.bootstrap-5') }}    --}}
                {{-- {{ $list->onEachside(1)->links() }}    --}}
                {{-- {{ $list->appends($_GET)->onEachside(1)->links() }}    --}}
                {{ $list->appends(request()->all())->onEachside(1)->links() }}   
            </div>
        </x-slot>
    </x-bootstrap.card>
    <form action="" method="POST" id="statusChangeForm">
        @csrf
        <input type="hidden" name="id" id="inputStatus" value="">
    </form>
@endsection

@section('js')
    <script src="{{ asset('assets/admin/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/pages/select2.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.btnChangeStatus').click(function () {
                let categoryID = $(this).data('id');
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

            });

            $('.btnDelete').click(function () {
                let categoryID = $(this).data('id');
                let categoryName = $(this).data('name');
                $('#inputStatus').val(categoryID);
                
                Swal.fire({
                title: 'Are you sure you want to delete ' + categoryName + ' ?',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: 'Yes',
                denyButtonText: `No`,
                }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $('#statusChangeForm').attr('action', "{{ route('categories.delete') }}");
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

            $('#selectParentCategory').select2();
            })
    </script>
@endsection
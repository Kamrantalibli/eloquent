@extends('layouts.admin')

@section('title')
    Article List
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/flatpickr/flatpickr.min.css') }}">
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
            <h2>Article List</h2>
        </x-slot>

        <x-slot name="body">
            <form action="">
                <div class="row">
                    <div class="col-3 my-2">
                        <select class="js-states form-control" tabindex="-1" id="selectParentCategory" style="display:none; width:100%" name="category_id">
                            <option value="{{ null }}" >Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ request()->get('parent_id') == $category->id ? 'selected' : '' }} >{{ $category->name }}</option>    
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
                        <input class="form-control flatpickr2 m-b-sm" 
                           type="text" 
                           id="publish_date" 
                           name="publish_date" 
                           value="{{ request()->get('publish_date') }}" 
                           placeholder="When to share..">
                    </div>
                    <div class="col-3 my-2">
                        <input type="text" class="form-control" placeholder="Title, Slug, Body, Tags" name="search_text" value="{{ request()->get('search_text') }}">
                    </div>
                    <div class="col-9 my-2">
                        <div class="row">
                            <div class="col-6">
                                <div class="row">
                                    <div class="col-6">
                                        <input type="number" class="form-control" placeholder="Min View Count" name="min_view_count" value="{{ request()->get('min_view_count') }}">
                                    </div>
                                    <div class="col-6">
                                        <input type="number" class="form-control" placeholder="Max View Count" name="max_view_count" value="{{ request()->get('max_view_count') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="row">
                                    <div class="col-6">
                                        <input type="number" class="form-control" placeholder="Min Like Count" name="min_like_count" value="{{ request()->get('min_like_count') }}">
                                    </div>
                                    <div class="col-6">
                                        <input type="number" class="form-control" placeholder="Max Like Count" name="max_like_count" value="{{ request()->get('max_like_count') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
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
                    <th scope="col">Image</th>
                    <th scope="col">Title</th>
                    <th scope="col">Slug</th>
                    <th scope="col">Status</th>    
                    <th scope="col">Body</th>    
                    <th scope="col">Tags</th>    
                    <th scope="col">View Count</th>    
                    <th scope="col">Like Count</th>    
                    <th scope="col">Category</th>    
                    <th scope="col">Publish Date</th>    
                    <th scope="col">User</th>    
                    <th scope="col">Actions</th>    
                </x-slot:columns>
                <x-slot:rows>
                    @foreach ($list as $article)
                        <tr>
                            <td>
                                @if (!empty($article->image))
                                    <img src="{{ asset($article->image) }}" alt="" height="100" class="img-fluid">
                                @endif
                            </td>

                            <td>{{ $article->title }}</td>
                            <td>{{ $article->slug }}</td>
                            <td>
                                @if ($article->status)
                                    <a href="javascript:void(0)" class="btn btn-sm btn-success btnChangeStatus" data-id="{{ $article->id }}">Active</a>
                                @else
                                    <a href="javascript:void(0)" class="btn btn-sm btn-danger btnChangeStatus" data-id="{{ $article->id }}">Passive</a>
                                @endif
                            </td>
                            
                            <td data-bs-container="body" data-bs-toggle="tooltip" data-bs-placement="top"  data-bs-title="{{ substr($article->body, 0, 200) }}">
                                {{ substr($article->body, 0, 20) }}
                            </td>
                            <td>{{ $article->tags }}</td>
                            <td>{{ $article->view_count }}</td>
                            <td>{{ $article->like_count }}</td>
                            <td>{{ $article->category->name }}</td>
                            <td>{{ $article->publish_date }}</td>
                            <td>{{ $article->user->name }}</td>
                            <td>
                                <div class="d-flex">
                                    <a href="javascript:void(0)" class="btn btn-warning btn-sm"><i class="material-icons ms-0">edit</i></a>
                                    <a href="javascript:void(0)" 
                                        class="btn btn-danger btn-sm btnDelete"
                                        data-name="{{ $article->title }}" 
                                        data-id="{{ $article->id }}" >
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
    <script src="{{ asset('assets/admin/plugins/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/admin/js/pages/datepickers.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/bootstrap/js/popper.min.js') }}"></script>
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
    <script>
        $('#publish_date').flatpickr({
            enableTime: true,
            dateFormat: 'Y-m-d H:i',
        });

        const popover = new bootstrap.Popover('.example-popover', {
            container: 'body'
        })
    </script>
@endsection
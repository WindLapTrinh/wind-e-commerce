@extends('layouts.admin')

@section('content')
    <div id="content" class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                        <span>Danh sách danh mục con của "{{ $parentCategory->name }}"</span>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tên danh mục</th>
                                    <th scope="col">Slug</th>
                                    <th scope="col">Mô tả</th>
                                    <th scope="col">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subcategories as $subcategory)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td><a class="text-setting"
                                                href="{{ $subcategory->children->count() > 0 ? route('category.post.subcategories', $subcategory->id) : '#' }}">{{ $subcategory->name }}</a>
                                        </td>
                                        <td>{{ $subcategory->slug }}</td>
                                        <td>{!! $subcategory->desc !!}</td>
                                        <td>
                                            <a href="#" class="btn btn-success btn-sm rounded-0 text-white btn-submit"
                                                type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                    class="fa fa-edit"></i></a>
                                            <a href="#"
                                                onclick="return confirm('Bạn có chắc xóa thành viên này không')"
                                                class="btn btn-danger btn-sm rounded-0 text-white btn-submit" type="button"
                                                data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                    class="fa fa-trash"></i></a>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

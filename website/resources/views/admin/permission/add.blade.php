@extends('layouts.admin')

@section('content')
<div id="content" class="container-fluid">
    @if(session('status'))
        <div class="alert alert-success" role="alert">
            {{session('status')}}
        </div>
    @endif
    <div class="row">
        <div class="col-4">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Thêm quyền
                </div>
                <div class="card-body">
                        {!! Form::open(['route' => 'permission.store']) !!}
                            <div class="form-group">
                                {!! Form::label("name", "Tên quyền")!!}
                                {!! Form::text("name", old("name"), ["class" => "form-control", "id" => "name"])!!}
                                @error('name')
                                    <small class="text-danger">{{$message}}</small>
                                @enderror
                            
                            </div>
                            <div class="form-group">
                                {!! Form::label("slug", "Slug")!!}
                                {!! Form::text("slug", old("slug"), ["class" => "form-control", "id" => "slug"])!!}
                                @error('slug')
                                    <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                {!! Form::label("description", "Mô tả")!!}
                                {!! Form::textarea("description", old("description"), ["class" => "form-control",
                                "id" => "description",
                                "rows" => 3]) !!}
                                @error('description')
                                    <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Thêm mới</button>
                        {!! Form::close() !!}
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Danh sách quyền
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tên quyền</th>
                                <th scope="col">Slug</th>
                                <!-- <th scope="col">Mô tả</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td scope="row"></td>
                                <td><strong>Post</strong></td>
                                <td></td>
                                <!-- <td></td> -->
                            </tr>
                            <tr>
                                <td scope="row">1</td>
                                <td>|---Add Post</td>
                                <td>post.add</td>
                                <!-- <td></td> -->
                            </tr>
                            <tr>
                                <td scope="row">2</td>
                                <td>|---Edit Post</td>
                                <td>post.edit</td>
                                <!-- <td></td> -->
                            </tr>
                            <tr>
                                <td scope="row">3</td>
                                <td>|---Delete Post</td>
                                <td>post.delete</td>
                                <!-- <td></td> -->
                            </tr>
                            <tr>
                                <td scope="row"></td>
                                <td><strong>Product</strong></td>
                                <td></td>
                                <!-- <td></td> -->
                            </tr>
                            <tr>
                                <td scope="row">4</td>
                                <td>|---Add Product</td>
                                <td>product.add</td>
                                <!-- <td></td> -->
                            </tr>
                            <tr>
                                <td scope="row">5</td>
                                <td>|---Edit Product</td>
                                <td>product.edit</td>
                                <!-- <td></td> -->
                            </tr>
                            <tr>
                                <td scope="row">6</td>
                                <td>|---Delete Product</td>
                                <td>product.delete</td>
                                <!-- <td></td> -->
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
@extends('layouts.admin')

@section('content')
<div id="content" class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                    <span>Danh sách danh mục</span>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCategoryModal">
                        Thêm mới
                    </button>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tên danh mục</th>
                                <th scope="col">Danh mục cha</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Danh mục cha giả định -->
                            <tr>
                                <th scope="row">1</th>
                                <td>Danh mục cha 1</td>
                                <td>Không có</td>
                                <td>Công khai</td>
                                <td>
                                    <button class="btn btn-sm btn-warning">Sửa</button>
                                    <button class="btn btn-sm btn-danger">Xóa</button>
                                </td>
                            </tr>
                            <!-- Danh mục con giả định -->
                            <tr>
                                <th scope="row"></th>
                                <td>-- Danh mục con 1</td>
                                <td>Danh mục cha 1</td>
                                <td>Chờ duyệt</td>
                                <td>
                                    <button class="btn btn-sm btn-warning">Sửa</button>
                                    <button class="btn btn-sm btn-danger">Xóa</button>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Danh mục cha 2</td>
                                <td>Không có</td>
                                <td>Công khai</td>
                                <td>
                                    <button class="btn btn-sm btn-warning">Sửa</button>
                                    <button class="btn btn-sm btn-danger">Xóa</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Thêm mới danh mục -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">Thêm mới danh mục</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="category-name">Tên danh mục</label>
                        <input type="text" class="form-control" id="category-name" placeholder="Nhập tên danh mục">
                    </div>
                    <div class="form-group">
                        <label for="parent-category">Danh mục cha</label>
                        <select class="form-control" id="parent-category">
                            <option value="">Không có</option>
                            <option>Danh mục cha 1</option>
                            <option>Danh mục cha 2</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Trạng thái</label>
                        <select class="form-control" id="status">
                            <option>Chờ duyệt</option>
                            <option>Công khai</option>
                        </select>
                    </div>
                    <button type="button" class="btn btn-primary">Thêm mới</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

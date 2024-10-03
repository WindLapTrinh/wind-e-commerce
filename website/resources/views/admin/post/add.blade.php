@extends('layouts.admin')

@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Thêm bài viết
            </div>
            <div class="card-body">
                <!-- Form method POST -->
                <form action="{{ route('upload.image') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Tiêu đề bài viết -->
                    <div class="form-group">
                        <label for="name">Tiêu đề bài viết</label>
                        <input class="form-control" type="text" name="title" id="name" required>
                    </div>

                    <!-- Nội dung bài viết -->
                    <div class="form-group">
                        <label for="content">Nội dung bài viết</label>
                        <textarea class="form-control" name="content" id="content" rows="5" required></textarea>
                    </div>

                    <!-- Danh mục bài viết từ bảng CategoriesPost -->
                    <div class="form-group">
                        <label for="category">Danh mục</label>
                        <select class="form-control" name="category" id="category" required>
                            <option value="">Chọn danh mục</option>
                            @foreach ($categories as $category)
                                @include('admin.partials.category-option', ['category' => $category, 'prefix' => ''])
                            @endforeach
                        </select>
                    </div>

                    <!-- Trạng thái bài viết -->
                    <div class="form-group">
                        <label for="">Trạng thái</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="exampleRadios1"
                                value="pending" checked>
                            <label class="form-check-label" for="exampleRadios1">
                                Chờ duyệt
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="exampleRadios2"
                                value="public">
                            <label class="form-check-label" for="exampleRadios2">
                                Công khai
                            </label>
                        </div>
                    </div>

                    <!-- Upload hình ảnh bài viết -->
                    <div class="form-group">
                        <label for="image">Ảnh thumbnail</label>
                        <input type="file" name="image" id="image" class="form-control-file" required>
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                </form>
            </div>
        </div>
    </div>
@endsection

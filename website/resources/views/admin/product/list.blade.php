@extends('layouts.admin')

@section('content')
    <div id="content" class="container-fluid">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0">Danh sách sản phẩm</h5>
                <div>
                    <!-- Nút để mở modal thêm mới sản phẩm -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addProductModal">
                        Thêm sản phẩm mới
                    </button>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped table-checkall">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tên sản phẩm</th>
                            <th scope="col">Danh mục</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($products->count() > 0)
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->category->name ?? 'Không có' }}</td>
                                    <td>{{ number_format($product->price, 0, ',', '.') }} VND</td>
                                    <td>{{ $product->stock_quantity }}</td>
                                    <td>{{ $product->product_status }}</td>
                                    <td>
                                        <button class="btn btn-success btn-sm" data-toggle="modal"
                                            data-target="#editProductModal" data-id="{{ $product->id }}">
                                            Sửa
                                        </button>
                                        <a href="{{ route('product.delete', $product->id) }}" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Bạn có chắc chắn xóa sản phẩm này không?')">
                                            Xóa
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7">Hiện tại chưa có thông tin sản phẩm nào!</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <!-- Phân trang -->
                <div class="d-flex justify-content-center">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Thêm Sản phẩm --}}
    <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProductModalLabel">Thêm sản phẩm mới</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Các trường thông tin sản phẩm -->
                        <div class="form-group">
                            <label for="name">Tên sản phẩm</label>
                            <input type="text" name="name" class="form-control" id="name" required>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        {{-- <div class="form-group">
                            <label for="slug">Slug</label>
                            <input type="text" name="slug" class="form-control" id="slug" required>
                        </div> --}}
                        <div class="form-group">
                            <label for="desc">Mô tả ngắn</label>
                            <input type="text" name="desc" class="form-control" id="desc">
                            @error('desc')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="details">Chi tiết sản phẩm</label>
                            <input type="text" name="details" class="form-control" id="details">
                            @error('details')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="price">Giá</label>
                            <input type="number" name="price" class="form-control" id="price" required>
                            @error('price')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="stock_quantity">Số lượng kho</label>
                            <input type="number" name="stock_quantity" class="form-control" id="stock_quantity" required>
                            @error('stock_quantity')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="is_featured">Nổi bật</label>
                            <select name="is_featured" class="form-control" id="is_featured">
                                <option value="0">Không</option>
                                <option value="1">Có</option>
                            </select>
                            @error('is_featured')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="product_status">Trạng thái</label>
                            <select name="product_status" class="form-control" id="product_status">
                                <option value="active">Hoạt động</option>
                                <option value="inactive">Vô hiệu hóa</option>
                                <option value="out_of_stock">Hết hàng</option>
                            </select>
                            @error('product_status')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="category_id">Danh mục</label>
                            <select name="category_id" class="form-control" id="category_id">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="image">Ảnh sản phẩm</label>
                            <input type="file" name="image" id="image" class="form-control-file">
                            @error('image')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

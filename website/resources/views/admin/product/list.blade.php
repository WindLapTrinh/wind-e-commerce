@extends('layouts.admin')

@section('content')
    <div id="content" class="container-fluid">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0">Danh sách sản phẩm</h5>
                <div>
                    <!-- Nút để mở modal thêm mới sản phẩm -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addProductModal">
                        Thêm mới
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
                                    <td class="text-setting">{{ $product->name }}</td>
                                    <td>{{ $product->category->name ?? 'Không có' }}</td>
                                    <td>{{ number_format($product->price, 0, ',', '.') }} VND</td>
                                    <td>{{ $product->stock_quantity }}</td>
                                    <td>{{ $product->product_status }}</td>
                                    <td>
                                        <button class="btn btn-success btn-sm btn-edit-product" data-toggle="modal"
                                            data-target="#editProductModal" data-id="{{ $product->id }}">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <a href="{{ route('product.delete', $product->id) }}" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Bạn có chắc chắn xóa sản phẩm này không?')">
                                            <i class="fa fa-trash"></i>
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

    {{-- Modal add  --}}
    <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProductModalLabel">Thêm sản phẩm</h5>
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
                            <textarea type="text" name="details" class="form-control" id="details"placeholder="Nhập chi tiết sản phẩm"></textarea>
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
                                    @include('admin.partials.category-option', [
                                        'category' => $category,
                                        'prefix' => '',
                                    ])
                                @endforeach
                            </select>
                            @error('category_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="images">Ảnh sản phẩm</label>
                            <input type="file" name="images[]" id="images" class="form-control-file" multiple>
                            <div id="image-preview" class="mt-3"></div>
                            @error('image')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Thêm mới</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal edit product --}}
    <div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="editPostForm" action="{{ route('post.update') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="post_id" id="post_id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Chỉnh sửa sản phẩm</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Tên sản phẩm</label>
                            <input type="text" name="name" class="form-control" id="name" required>
                        </div>
                        <div class="form-group">
                            <label for="desc">Mô tả</label>
                            <input type="text" name="desc" class="form-control" id="desc" required>
                        </div>
                        <div class="form-group">
                            <label for="details">Chi tiết sản phẩm </label>
                            <textarea class="form-control" name="details" id="details"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="price">Giá</label>
                            <input type="text" name="price" class="form-control" id="price" required>
                        </div>
                        <div class="form-group">
                            <label for="post_category">Danh mục</label>
                            <select name="category_id" class="form-control" id="post_category">
                                <option value="0">Không có</option>
                                @foreach ($categories as $category)
                                    @include('admin.partials.category-option', [
                                        'category' => $category,
                                        'prefix' => '',
                                    ])
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <!-- Hiển thị ảnh hiện tại nếu có -->
                            <div class="mt-2">
                                <label class="col-12">Ảnh hiện tại:</label>
                                <img src="" alt="Ảnh hiện tại" class="img-thumbnail" id="current_image"
                                    width="150" style="display: none;">
                            </div>
                            <label for="image">Chọn ảnh mới (tùy chọn)</label>
                            <input type="file" name="image" id="image" class="form-control-file">

                        </div>

                        <div class="form-group">
                            <label for="status">Trạng thái</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status_pending"
                                    value="pending">
                                <label class="form-check-label" for="status_pending">
                                    Chờ duyệt
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status_published"
                                    value="published">
                                <label class="form-check-label" for="status_published">
                                    Công khai
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

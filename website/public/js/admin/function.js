//sử lý show danh mục
function showSubcategories(parentId) {
    // Gửi AJAX request để lấy danh mục con
    $.ajax({
        url: `/category/subcategories/${parentId}`,
        method: "GET",
        success: function (data) {
            let tbody = $("#subcategoriesTable tbody");
            tbody.empty();
            if (data.length > 0) {
                data.forEach(function (subcategory, index) {
                    tbody.append(`
                            <tr>
                                <th scope="row">${index + 1}</th>
                                <td>${subcategory.name}</td>
                                <td>${subcategory.slug}</td>
                                <td>${subcategory.desc ?? ""}</td>
                            </tr>
                        `);
                });
            } else {
                tbody.append(
                    `<tr><td colspan="4">Không có danh mục con nào</td></tr>`
                );
            }
        },
    });
}

// Update this part of the JavaScript code
$(document).ready(function () {
    // Bắt sự kiện click vào nút Edit
    $(".btn-edit-category").on("click", function () {
        var categoryId = $(this).data("id");
        var categoryName = $(this).data("name");
        var categoryDesc = $(this).data("desc");
        var categoryParentId = $(this).data("parent_id");

        // Điền dữ liệu vào modal
        $("#editCategoryModal #edit_name").val(categoryName);
        $("#editCategoryModal #edit_desc").val(categoryDesc);
        $("#editCategoryModal #edit_parent_id").val(categoryParentId);

        // Dynamically build the form action with the base URL and category ID
        var formAction = baseUrl + "/category/update/" + categoryId;
        $("#editCategoryForm").attr("action", formAction);

        // Hiển thị modal
        $("#editCategoryModal").modal("show");
    });

    // Bắt sự kiện click vào nút Edit cho bài viết
    $(".btn-edit-post").on("click", function () {
        var postId = $(this).data("id");
        var postTitle = $(this).data("title");
        var postContent = $(this).data("content");
        var postCategory = $(this).data("category");
        var postStatus = $(this).data("status");
        let imageUrl = $(this).data("image");
        // Điền dữ liệu vào modal bài viết
        $("#post_id").val(postId);
        $("#post_title").val(postTitle);
        $("#post_content").val(postContent);
        $("#post_category").val(postCategory);

        // Hiển thị ảnh hiện tại nếu có
        if (imageUrl) {
            $("#current_image").attr("src", imageUrl).show();
        } else {
            $("#current_image").hide();
        }

        //Set status radio button
        if (postStatus === "published") {
            $("#status_published").prop("checked", true);
        } else {
            $("#status_pending").prop("checked", true);
        }

        // Hiển thị modal bài viết
        $("#editModal").modal("show");
    });
});

// Khi người dùng nhấn vào nút upload
$("#upload-btn").on("click", function () {
    $("#fileManagerModal").modal("show");
});

// Cấu hình TinyMCE (nếu bạn cần dùng thêm các tính năng khác)
tinymce.init({
    selector: "textarea", // hoặc textarea của bạn
    plugins: "image",
    toolbar: "image",
    file_picker_callback: function (callback, value, meta) {
        let cmsURL =
            "/laravel-filemanager?editor=" + meta.fieldname + "&type=Images";

        tinymce.activeEditor.windowManager.openUrl({
            url: cmsURL,
            title: "Quản lý hình ảnh",
            width: 800,
            height: 600,
            onMessage: (api, message) => {
                callback(message.content);
            },
        });
    },
});

// save images
// Giả sử bạn đã có một sự kiện click cho hình ảnh
document.querySelectorAll(".file-item").forEach((item) => {
    item.addEventListener("click", function () {
        const imageUrl = this.getAttribute("data-image-url"); // Thay thế bằng thuộc tính thực tế chứa URL
        const fileName = this.getAttribute("data-file-name"); // Tương tự
        const fileSize = this.getAttribute("data-file-size"); // Tương tự

        // Gọi hàm selectImage khi hình ảnh được chọn
        selectImage(imageUrl, fileName, fileSize);
    });
});

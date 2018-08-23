<?php

return [
    "titles" => [
        "topic" => [
            "manage" => "Quản lý topic",
            "create" => "Thêm topic",
            "update" => "Cập nhật topic",
            "add_member" => "Thêm người dùng vào topic",
        ]
    ],
    "table" => [
        "id" => "#",
        "created_at" => "Ngày tạo",
        "updated_at" => "Ngày sửa",
        "action" => "Thao tác",
        "name" => "Tên",
        "status" => "Trạng thái",
        "delete" => "Xóa",
        "add_member" => [
            "email" => "Email",
            "name" => "Tên"
        ]
    ],
    "form"=>[
        "name_placeholder"=>"Nhập tag...",
        "text"=>[
            "name" => "Tên",
            "topic_hot" => "Topic Hot",
            "hot" => "Hot",
            "normal" => "Thường",
            "desc" => "Mô tả",
            "select_image" => "Chọn ảnh đại diện"
        ],
    ],
    "buttons" => [
        "create" => "Thêm",
        "discard" => "Hủy",
        "update" => "Cập nhật",
    ],
    "placeholder" => [
        "topic" => [
            "name_here" => "Nhập tên...",
            "desc_here" => "Nhập mô tả..."
        ]
    ],
    "labels" => [
        "home" => "Home"
    ],
    "messages" => [
        "success" => [
            "create" => "Thêm thành công",
            "update" => "Cập nhật thành công",
            "delete" => "Xóa thành công",
            "status" => "Sửa trạng thái thành công"
        ],
        "error" => [
            "permission" => "Permission lock",
            "create" => "Thêm thất bại",
            "update" => "Câp nhật thất bại",
            "delete" => "Xóa thất bại",
            "status" => "Sửa trạng thái thất bại",
        ]
    ]
];
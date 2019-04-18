<?php

return [
    "titles" => [
        "contest" => [
            "manage" => "Danh sách cuộc thi",
            "update" => "Sửa cuộc thi",
            "create" => "Thêm cuộc thi"
        ],

        "user_field" => [
            "manage" => "Danh sách trường thông tin",
            "update" => "Sửa trường thông tin",
            "create" => "Thêm trường thông tin"
        ]
    ],
    "table" => [
        "id" => "#",
        "created_at" => "Created at",
        "updated_at" => "Updated at",
        "action" => "Actions",
        "contest" => [
            "name" => "Tên cuộc thi",
            "logo" => "Logo cuộc thi",
            "alias" => "Alias",
            "domain" => "Tên miền",
            "mysql" => "Thông tin db mysql",
            "mongo" => "Thông tin db mongo",
        ],
        "user_field" => [
            "label" => "Nhãn",
            "varible" => "Tên param",
            "type_name" => "Loại",
            "hint_text" => "Hint text",
            "data_view" => "Data",
            "require" => "Tùy chọn",
            "description" => "Mô tả",
        ]
    ],
    "buttons" => [
        "create" => "Tạo",
        "discard" => "Hủy"
    ],
    "placeholder" => [
        "contest" => [
            "name_here" => "Name here...",
            "type" => "Chọn loại view"
        ]
    ],
    "messages" => [
        "success" => [
            "create" => "Create successfully",
            "update" => "Update successfully",
            "delete" => "Delete successfully"
        ],
        "error" => [
            "permission" => "Permission lock",
            "create" => "Create failed",
            "update" => "Update failed",
            "delete" => "Delete failed"
        ]
    ]
];
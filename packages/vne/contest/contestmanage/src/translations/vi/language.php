<?php

return [
    "titles" => [
        "contest_season" => [
            "manage" => "Danh sách mùa thi",
            "create" => "Tạo mùa thi",
            "update" => "Sửa mùa thi"
        ],
        "contest_config" => [
            "manage" => "Danh sách cấu hình",
            "create" => "Tạo cấu hình",
            "update" => "Sửa cấu hình"
        ],
        "contest_round" => [
            "manage" => "Danh sách vòng thi",
            "create" => "Tạo vòng thi",
            "update" => "Sửa vòng thi"
        ],
        "contest_topic" => [
            "manage" => "Danh sách màn thi",
            "create" => "Tạo màn thi",
            "update" => "Sửa màn thi"
        ],
        "topic_round" => [
            "manage" => "Danh sách vòng trong màn thi",
            "create" => "Tạo vòng trong màn thi",
            "update" => "Sửa vòng trong màn thi"
        ],
        "contest_client" => [
            "manage" => "Danh sách client",
            "create" => "Tạo client",
            "update" => "Sửa client"
        ],
        "group_exam" => [
            "manage" => "Danh sách bảng thi",
            "create" => "Tạo bảng thi",
            "update" => "Sửa bảng thi",
            "list_candidate" => "Danh sách thí sinh trong bảng"
        ],
        "candidate" => [
            "manage" => "Danh sách thí sinh",
            "create" => "Thêm thí sinh",
            "update" => "Sửa thí sinh"
        ],
        "contest_target" => [
            "manage" => "Danh sách đối tượng",
            "create" => "Thêm đối tượng",
            "update" => "Quản lý đối tượng thi"
        ],

    ],
    "table" => [
        "id" => "#",
        "created_at" => "Created at",
        "updated_at" => "Updated at",
        "action" => "Actions",
        "status" => "Trạng thái",
        "contest" => [
            "name" => "Tên bộ đề"
        ],
        "contest_season" => [
            "name" => "Tên mùa",
            "alias" => "Alias",
            "description" => "Mô tả",
            "config" => "Cấu hình",
            "time" => "Thời gian diễn ra"
        ],
        "contest_config" => [
            "name" => "Tên cấu hình",
            "alias" => "Alias",
            "description" => "Mô tả",
            "environment" => "Môi trường",
            "option" => "Loại",
            "config_type" => "Loại cấu hình",
            "view" => "Chi tiết cấu hình",
            "config" => "Cấu hình"
        ],
        "contest_round" => [
            "name" => "Tên vòng thi",
            "alias" => "Alias",
            "type" => "Loại thi",
            "round_type" => "Loại vòng",
            "description" => "Mô tả",
            "config" => "Cấu hình",
            "time" => "Thời gian mở"
        ],
        "contest_topic" => [
            "name" => "Tên màn thi",
            "alias" => "Alias",
            "description" => "Mô tả",
            "round" => "vòng thi",
            "type" => "Loại",
            "config" => "Cấu hình"
        ],
        "topic_round" => [
            "name" => "Tên vòng trong màn thi",
            "alias" => "Alias",
            "description" => "Mô tả",
            "order" => "Thứ tự",
            "total_question" => "Tổng số câu hỏi",
            "total_point" => "Tổng điểm tối đa",
            "total_time_limit" => "Tổng thời gian giới hạn",
            "topic_id" => "Màn thi",
            "config" => "Cấu hình"
        ],
        "contest_client" => [
            "name" => "Tên client",
            "environment" => "Môi trường",
            "description" => "Mô tả",
            "resource_path" => "Đường dẫn client",
            "width" => "Chiều rộng",
            "height" => "Chiều cao",
        ],
        "group_exam" => [
            "name" => "Tên bảng thi",
            "description" => "Mô tả",
            "round" => "Vòng thi",
        ],
        "candidate" => [
            "name" => "Họ tên",
            "username" => "Tài khoản",
            "city" => "Tỉnh/ TP",
            "district" => "Quận/ Huyện",
            "school" => "Trường",
            "class" => "Lớp",
            "gender" => "Giới tính"
        ]
    ],
    "buttons" => [
        "create" => "Tạo",
        "discard" => "Hủy",
        "add" => "Thêm",
        "group_exam" => [
            'add' => "Thêm thí sinh"
        ]
    ],
    "placeholder" => [
        "contest_season" => [
            "name_here" => "Nhập tên...",
            "group_name" => "Tên nhóm",
            "group_varible" => "Tên biến",
            "description" => "Mô tả",
            "number" => "Nhập số",
            "before_start_notify" => "Thông báo trước ngày bắt đầu",
            "rules" => "Thể lệ",
            "after_end_notify" => "Thông báo sau ngày kết thúc",
            "config" => "Click chọn cấu hình",
        ],
        "contest_round" => [
            "name_here" => "Nhập tên...",
            "group_name" => "Tên nhóm",
            "group_varible" => "Tên biến",
            "description" => "Mô tả",
            "number" => "Nhập số",
            "before_start_notify" => "Thông báo trước ngày bắt đầu",
            "rules" => "Thể lệ",
            "after_end_notify" => "Thông báo sau ngày kết thúc",
            "config" => "Click chọn cấu hình",
        ],
        "contest_config" => [
            "name_here" => "Nhập tên...",
            "group_name" => "Tên nhóm",
            "environment" => "Môi trường",
            "option" => "Loại",
            "group_varible" => "Tên biến",
            "description" => "Mô tả",
            "number" => "Nhập số",
            "before_start_notify" => "Thông báo trước ngày bắt đầu",
            "rules" => "Thể lệ",
            "after_end_notify" => "Thông báo sau ngày kết thúc",
        ],
        "contest_topic" => [
            "name_here" => "Nhập tên...",
            "group_name" => "Tên nhóm",
            "group_varible" => "Tên biến",
            "description" => "Mô tả",
            "number" => "Nhập số",
            "before_start_notify" => "Thông báo trước ngày bắt đầu",
            "rules" => "Thể lệ",
            "after_end_notify" => "Thông báo sau ngày kết thúc",
            "config" => "Click chọn cấu hình",
            "round" => "Click chọn vòng",
        ],
        "topic_round" => [
            "name_here" => "Nhập tên...",
            "group_name" => "Tên nhóm",
            "group_varible" => "Tên biến",
            "description" => "Mô tả",
            "number" => "Nhập số",
            "before_start_notify" => "Thông báo trước ngày bắt đầu",
            "rules" => "Thể lệ",
            "after_end_notify" => "Thông báo sau ngày kết thúc",
            "config" => "Click chọn cấu hình",
            "topic" => "Click chọn màn"
        ],
        "contest_client" => [
            "name_here" => "Nhập tên...",
            "description" => "Mô tả",
            "width" => "Nhập width",
            "height" => "Nhập height",
            "config_name" => "Nhập tên",
            "config_id" => "Nhập id",
            "config_value" => "Nhập value",
        ],
        "contest_target" => [
            "all" => "Tất cả",
            "city" => "Tất cả",
            "district" => "Chọn Tỉnh/TP trước",
            "school" => "Chọn Quận/ huyện trước",
            "gender" => "Nhập height",
            "ages" => "Nhập tên",
            "gclass" => "Chọn Trường trước",
            "config_value" => "Nhập value",
        ],
        "group_exam" => [
            "name_here" => "Nhập tên...",
            "description" => "Mô tả",
        ],
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
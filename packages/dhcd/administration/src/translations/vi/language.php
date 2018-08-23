<?php

return [
    "titles" => [
        "provine_city" => [
            "manage" => "Quản lý tỉnh thành",
            "create" => "Thêm tỉnh thành",
            "edit" => "Cập nhật tỉnh thành",
        ],
        "country_district" => [
            "manage" => "Quản lý quận huyện",
            "create" => "Thêm quận huyện",
            "edit" => "Cập nhật quận huyện",
        ],
        "commune_guild" => [
            "manage" => "Quản lý phường xã",
            "create" => "Thêm phường xã",
            "edit" => "Cập nhật phường xã",
        ],
    ],
    "table" => [
        "id" => "#",
        "created_at" => "Ngày tạo",
        "updated_at" => "Ngày sửa",
        "action" => "Thao tác",
        "provine_city"=>[
            "name" => "Tên",
            "type" => "Kiểu",
            "name_with_type" => "Tên theo kiểu",
            "code" =>"Code"
        ],
        "country_district"=>[
            "name" => "Tên",
            "provine_city" => "Tỉnh thành",
            "type" => "Kiểu",
            "name_with_type" => "Tên theo kiểu",
            "path"=> "Đường dẫn",
            "path_with_type"=> "Tên theo đường dẫn",
            "code" =>"Code"
        ],
         "commune_guild"=>[
            "name" => "Tên",
            "country_district" => "Quận huyện",
            "type" => "Kiểu",
            "name_with_type" => "Tên theo kiểu",
            "path"=> "Đường dẫn",
            "path_with_type"=>"Tên theo đường dẫn",
            "code" =>"Code"
        ]
    ],
    "buttons" => [
        "create" => "Thêm",
        "discard" => "Hủy",
        "update" => "Cập nhật"
    ],
    "placeholder" => [
        "name" => "Nhập tên",
        "type" => "Nhập kiểu",
        "code" =>" Nhập code"
    ],
    "label" => [
        "name" => "Tên",
        "type" => "Kiểu",
        "code" =>" Code",
        "provine_city" => "Thuộc thành phố",
        "country_district" => "Thuộc quận huyện"
    ],
    "messages" => [
        "success" => [
            "create" => "Thêm thành công",
            "update" => "Cập nhật thành công",
            "delete" => "Xóa thành công"
        ],
        "error" => [
            "permission" => "Permission lock",
            "create" => "Thêm thất bại",
            "update" => "Cập nhật thất bại",
            "delete" => "Xóa thất bại"
        ]
    ]
];
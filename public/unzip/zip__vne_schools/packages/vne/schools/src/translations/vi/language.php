<?php

return [
    "label"=>[
        "name"=>"Tên trường",
        "unitname"=>"Tên đơn vị",
        "parent"=>"Đơn vị cha",
        "catunit"=>"Nhóm đơn vị",
        "nation"=>"Quốc gia",
        "type"=>"Loại",
        "level"=>"Kiểu trường",
        "address"=>"Địa chỉ",
        "phone"=>"Số điện thoại",
        "province"=>"Tỉnh",
        "region"=>"Miền",
        "district"=>"Quận ,Huyện",
        "wards"=>"Xã ,Phường",
        "pclass"=>"Khối lớp",
        "mem"=>"Người phụ trách",
        "action"=>"Hành Động"
    ],
    "placeholder" =>[
        "name"=>"Tên trường",
        "nation"=>"Quốc gia",
        "unitname"=>"Tên đơn vị",
        "level"=>"Kiểu trường",
        "address"=>"Địa chỉ",
        "phone"=>"Số điện thoại",
        "province"=>"Tỉnh",
        "district"=>"Quận ,Huyện",
        "wards"=>"Xã ,Phường",
    ],
    "mem"=>[
        "name"=>"Tên",
        "phone"=>"Số điện thoại",
        "email"=>"Email",
        "pos"=>"Chức vụ",
    ],
    "titles" => [
            "create"=>"Thêm trường",
            "unit"=>"Đơn vị",
            "nation"=>"Quốc gia",
            "catunit"=>"Loại đơn vị",
            "manage" => "Quản lý trường",
            "province" => "Quản lý tỉnh thành",
            "district" => "Quản lý quận huyện",
    ],
    "table" => [
        "id" => "#",
        "catunit" => "Cấp, loại đơn vị",
        "nation"=>"Quốc gia",
        "created_at" => "Created at",
        "updated_at" => "Updated at",
        "action" => "Actions",
        "province" =>"Tỉnh thành",
        "district" =>"Quận huyện",
    ],
    "buttons" => [
        "addschools"=>"Thêm trường",
        "createcatunit"=>"Thêm",
        "addmem" => "Thêm người phụ trách",
        "addprovince" => "Thêm ",
        "adddistrict" => "Thêm ",
        "addpclass" =>"Thêm lớp",
        "discard" => "Discard",
        "update" => "Lưu",
    ],
    "pclass"=>[
        "khoi" => "Khối",
        "lop" =>  "Lớp"
    ],
    "messages" => [
        "success" => [
            "addsuccess"=>"Thêm mới thành công",
            "create" => "Create successfully",
            "update" => "Update successfully",
            "delete" => "Delete successfully",
            "missingprovince" => "Chưa có tỉnh thành nào trong danh sách"
        ],
        "error" => [
            "permission" => "Permission lock",
            "create" => "Create failed",
            "update" => "Update failed",
            "delete" => "Delete failed"
        ]
    ]
];
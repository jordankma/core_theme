<?php

return [
    "titles" => [
        "demo" => [
            "manage" => "Manage demo"
        ],
        'document_type' => [
            "manage" => "Quản lý kiểu tài liệu",
            "create" => "Thêm kiểu tài liệu",
            "edit" => "Cấu hình kiểu tài liệu",
        ],
        'doucment_cate' => [
            "manage" => "Quản lý danh mục tài liệu",
            "create" => "Thêm danh mục tài liệu",
            "edit" => "Sửa danh mục tài liệu",
            "add_member" => "Thêm thành viên"
        ],
        'document' => [
            "manage" => "Quản lý tài liệu",
            "create" => "Thêm tài liệu mới",
            "edit" => "Sửa tài liệu",
        ],
        "tag" => [
            "manage" => "Quản lý tag",
            'create' => 'Thêm tag',
            'edit' => 'Sửa tag',
            'manage' => 'Danh sách tag'
        ],
    ],
    "table" => [
        "id" => "#",
        "created_at" => "Created at",
        "updated_at" => "Updated at",
        "action" => "Actions",
        'name' => 'Tên nhóm tag',
        'alias' => 'Nhãn hiển thị',
        "delete" => "Xóa",
        "add_member" => [
            "name" => "Name"
        ]
    ],
    "buttons" => [
        "create" => "Thêm mới",
        "save" => "Cập nhật",
        "discard" => "Discard"
    ],
    "placeholder" => [
        "demo" => [
            "name_here" => "Name here..."
        ],
        'document_cate' => [
            'name' => 'Nhập tên danh mục...',            
        ],
        'document_type' => [
            'name' => 'Nhập tên kiểu file...',            
        ],
        'document' => [
            'name' => 'Nhập tên tài liệu...',
            'type' => '-- Chọn kiểu --',
            'cate' => '-- Chọn danh mục --', 
            'sort_desc' => 'Mới nhất',
            'sort_asc' => 'Cũ nhất',
        ],
        "tag" => [
            "name_tag" => "Nhập tên tag"
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
    ],
    'document_cate' => [
        'table' => [
            'title' => 'Danh sách danh mục',
            'name' => 'Tên danh mục',
            'parent_id' => 'Danh mục cha',
            'icon' => 'Icon',
            "action" => "Hành động",
            "delete" => 'Xóa danh mục',
            "edit" => 'Sửa danh mục',
        ],
        'form' => [
           'name' => 'Tên danh mục',
           'parent_id' => 'Chọn danh mục cha',
           'icon' => 'Icon',
            'icon_current' => 'Icon hiện tại',
           'icon_new' => 'Icon mới',
           'icon_empty' => 'Chưa có icon',
        ]        
    ],
    'document_type' => [
        'table' => [
            'title' => 'Danh sách kiểu tài liệu',
            'name' => 'Tên kiểu',            
            'icon' => 'Icon',
            "action" => "Hành động",
            "delete" => 'Xóa kiểu tài liệu',
            "edit" => 'Sửa kiểu tài liệu',
        ],
        'form' => [
           'name' => 'Tên kiểu tài liệu',           
           'icon' => 'Icon',
           'icon_current' => 'Icon hiện tại',
           'icon_new' => 'Icon mới',
           'icon_empty' => 'Chưa có icon',
           'type' => 'Định dạng file'
        ]        
    ],
    'document' => [
        'table' => [
            'title' => 'Danh sách tài liệu',
            'name' => 'Tên tài liệu',
            'document_type_id' => 'Kiểu',
            'document_cate_id' => 'Danh mục',
            'file' => 'File',
            'desc' => 'Mô tả',
            "action" => "Hành động",
            "delete" => 'Xóa kiểu tài liệu',
            "edit" => 'Sửa kiểu tài liệu',
            "down" => 'Tải về'
        ],
        'form' => [                      
            'name' => 'Tên tài liệu',
            'document_type_id' => 'Kiểu',
            'document_cate_id' => 'Danh mục',
            'file' => 'File đính kèm',
            'list_file' => 'Danh sách file',
            'desc' => 'Mô tả',
            'icon_current' => 'Icon hiện tại',
            'icon_new' => 'Icon mới',
            'icon_empty' => 'Chưa có icon',
            'type' => 'Đại biểu'
        ]        
    ]
];
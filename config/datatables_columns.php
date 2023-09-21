<?php

return [
    'product_categories' => [
        'name' => [
            'title' => 'Tên danh mục',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'feature_image' => [
            'title' => 'Hình ảnh',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'status' => [
            'title' => 'Trạng thái',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'created_at' => [
            'title' => 'Ngày tạo',
            'orderable' => false,
            'addClass' => 'align-middle',
            'visible' => false
        ],
        'action' => [
            'title' => 'Thao tác',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'order' => [
        'id' => [
            'title' => 'Mã đơn hàng',
            'orderable' => false,
        ],
        'user' => [
            'title' => 'Thành viên',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'status' => [
            'title' => 'Trạng thái',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'total' => [
            'title' => 'Tổng tiền',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'created_at' => [
            'title' => 'Ngày đặt',
            'orderable' => false,
            'visible' => false,
            'addClass' => 'align-middle'
        ],
        'action' => [
            'title' => 'Thao tác',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'product' => [
        'checkbox' => [
            'title' => 'Chọn',
            'orderable' => false,
            'addClass' => 'text-center',
            'width' => '10px',
            'footer' => '<input type="checkbox" class="check-all" />'
        ],
        'feature_image' => [
            'title' => 'Ảnh',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'name' => [
            'title' => 'Tên',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'in_stock' => [
            'title' => 'Kho',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'status' => [
            'title' => 'Trạng thái',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'price' => [
            'title' => 'Giá',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'categories' => [
            'title' => 'Danh mục',
            'orderable' => false,
            'visible' => false,
            'addClass' => 'align-middle'
        ],
        'viewed' => [
            'title' => 'Lượt xem',
            'orderable' => false,
            'visible' => false,
            'addClass' => 'align-middle'
        ],
        'created_at' => [
            'title' => 'Ngày tạo',
            'orderable' => false,
            'visible' => false,
            'addClass' => 'align-middle'
        ],
        'action' => [
            'title' => 'Thao tác',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'category' => [
        'name' => [
            'title' => 'Tên danh mục',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'status' => [
            'title' => 'Trạng thái',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'action' => [
            'title' => 'Thao tác',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'post' => [
        'feature_image' => [
            'title' => 'Ảnh',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'title' => [
            'title' => 'Tiêu đề',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'status' => [
            'title' => 'Trạng thái',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'created_at' => [
            'title' => 'Ngày tạo',
            'orderable' => false,
            'addClass' => 'align-middle',
            'visible' => false
        ],
        'action' => [
            'title' => 'Thao tác',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'admin' => [
        'DT_RowIndex' => [
            'title' => 'STT',
            'width' => '20px',
            'orderable' => false
        ],
        'fullname' => [
            'title' => 'Họ tên',
            'orderable' => false
        ],
        'phone' => [
            'title' => 'Số điện thoại',
            'orderable' => false
        ],
        'email' => [
            'title' => 'Email',
            'orderable' => false,
        ],
        'roles' => [
            'title' => 'Roles',
            'orderable' => false,
        ],
        'created_at' => [
            'title' => 'Ngày tạo',
            'orderable' => false,
            'visible' => false
        ],
        'action' => [
            'title' => 'Thao tác',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center'
        ],
    ],
    'user' => [
        'username' => [
            'title' => 'Tên đăng nhập',
            'orderable' => false,
            'visible' => false
        ],
        'fullname' => [
            'title' => 'Họ tên',
            'orderable' => false
        ],
        'email' => [
            'title' => 'Email',
            'orderable' => false,
        ],
        'phone' => [
            'title' => 'Số điện thoại',
            'orderable' => false
        ],
        'gender' => [
            'title' => 'Giới tính',
            'orderable' => false,
            'visible' => false
        ],
        'created_at' => [
            'title' => 'Ngày tạo',
            'orderable' => false,
            'visible' => false
        ],
        'action' => [
            'title' => 'Thao tác',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center'
        ],
    ],
];
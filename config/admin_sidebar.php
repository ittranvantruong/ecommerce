<?php

return [
    [
        'title' => 'Dashboard',
        'routeName' => 'admin.dashboard',
        'icon' => '<i class="ti ti-home"></i>',
        'roles' => [
            App\Enums\Admin\AdminRoles::SuperAdmin,
            App\Enums\Admin\AdminRoles::Admin
        ],
        'sub' => []
    ],
    [
        'title' => 'Bài viết',
        'routeName' => null,
        'icon' => '<i class="ti ti-article"></i>',
        'roles' => [],
        'sub' => [
            [
                'title' => 'Thêm bài viết',
                'routeName' => 'admin.post.create',
                'icon' => '<i class="ti ti-plus"></i>',
                'roles' => [
                    App\Enums\Admin\AdminRoles::SuperAdmin,
                    App\Enums\Admin\AdminRoles::Admin
                ],
            ],
            [
                'title' => 'DS bài viết',
                'routeName' => 'admin.post.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
            ],
            [
                'title' => 'Chuyên mục',
                'routeName' => 'admin.category.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [
                    App\Enums\Admin\AdminRoles::SuperAdmin,
                    App\Enums\Admin\AdminRoles::Admin
                ],
            ]
        ]
    ],
    [
        'title' => 'Đơn hàng',
        'routeName' => null,
        'icon' => '<i class="ti ti-box"></i>',
        'roles' => [],
        'sub' => [
            [
                'title' => 'Thêm đơn hàng',
                'routeName' => 'admin.order.create',
                'icon' => '<i class="ti ti-plus"></i>',
                'roles' => [],
            ],
            [
                'title' => 'DS đơn hàng',
                'routeName' => 'admin.order.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
            ]
        ]
    ],
    [
        'title' => 'Sản phẩm',
        'routeName' => null,
        'icon' => '<i class="ti ti-brand-producthunt"></i>',
        'roles' => [],
        'sub' => [
            [
                'title' => 'Thêm sản phẩm',
                'routeName' => 'admin.product.create',
                'icon' => '<i class="ti ti-plus"></i>',
                'roles' => [
                    App\Enums\Admin\AdminRoles::SuperAdmin,
                    App\Enums\Admin\AdminRoles::Admin
                ],
            ],
            [
                'title' => 'DS sản phẩm',
                'routeName' => 'admin.product.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
            ],
            [
                'title' => 'Danh mục',
                'routeName' => 'admin.product_category.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [
                    App\Enums\Admin\AdminRoles::SuperAdmin,
                    App\Enums\Admin\AdminRoles::Admin
                ],
            ],
        ]
    ],
    [
        'title' => 'QL Thành viên',
        'routeName' => null,
        'icon' => '<i class="ti ti-users"></i>',
        'roles' => [
            App\Enums\Admin\AdminRoles::SuperAdmin,
            App\Enums\Admin\AdminRoles::Admin
        ],
        'sub' => [
            [
                'title' => 'Thêm thành viên',
                'routeName' => 'admin.user.create',
                'icon' => '<i class="ti ti-plus"></i>',
                'roles' => [],
            ],
            [
                'title' => 'DS thành viên',
                'routeName' => 'admin.user.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
            ],
        ]
    ],
    [
        'title' => 'QL Admin',
        'routeName' => null,
        'icon' => '<i class="ti ti-user-cog"></i>',
        'roles' => [
            App\Enums\Admin\AdminRoles::SuperAdmin,
            App\Enums\Admin\AdminRoles::Admin
        ],
        'sub' => [
            [
                'title' => 'Thêm admin',
                'routeName' => 'admin.admin.create',
                'icon' => '<i class="ti ti-plus"></i>',
                'roles' => [],
            ],
            [
                'title' => 'DS admin',
                'routeName' => 'admin.admin.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
            ],
        ]
    ],
    [
        'title' => 'Cài đặt',
        'routeName' => null,
        'icon' => '<i class="ti ti-settings"></i>',
        'roles' => [
            App\Enums\Admin\AdminRoles::SuperAdmin,
            App\Enums\Admin\AdminRoles::Admin
        ],
        'sub' => [
            [
                'title' => 'Chung',
                'routeName' => 'admin.setting.general',
                'icon' => '<i class="ti ti-tool"></i>',
                'roles' => [],
            ],
        ]
    ],
];
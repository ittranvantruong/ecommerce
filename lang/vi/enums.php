<?php

use App\Enums\Admin\AdminRoles;
use App\Enums\Order\OrderStatus;
use App\Enums\Product\ProductInstock;
use App\Enums\Product\ProductPurchaseQtyType;
use App\Enums\Product\ProductStatus;
use App\Enums\User\UserLevelTypeDiscount;
use App\Enums\ProductCategory\ProductCategoryStatus;
use App\Enums\User\{UserGender, UserVip, UserRoles};

return [
    AdminRoles::class => [
        AdminRoles::SuperAdmin->value => 'Dev',
        AdminRoles::Admin->value => 'Admin',
    ],
    UserGender::class => [
        UserGender::Male->value => 'Nam',
        UserGender::Female->value => 'Nữ',
        UserGender::Other->value => 'Khác',
    ],
    ProductCategoryStatus::class => [
        ProductCategoryStatus::Published->value => 'Đã xuất bản',
        ProductCategoryStatus::Draft->value => 'Bản nháp'
    ],
    ProductStatus::class => [
        ProductStatus::Published->value => 'Đã xuất bản',
        ProductStatus::Draft->value => 'Bản nháp'
    ],
    ProductInstock::class => [
        ProductInstock::Yes->value => 'Còn hàng',
        ProductInstock::No->value => 'Hết hàng'
    ],
    ProductPurchaseQtyType::class => [
        ProductPurchaseQtyType::Amount->value => 'Số tiền',
        ProductPurchaseQtyType::Percent->value => 'Phần trăm'
    ],
    OrderStatus::class => [
        OrderStatus::Processing->value => 'Đang xử lý',
        OrderStatus::Processed->value => 'Đã xử lý',
        OrderStatus::Completed->value => 'Đã hoàn thành',
        OrderStatus::Cancelled->value => 'Đã hủy'
    ],
];
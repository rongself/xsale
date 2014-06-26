<?php
return array(
    'root'=>array(
        'account'=>array(
            'account/change-password',
            'account/create-account',
            'account/edit-account',
            'account/index',
            'account/login',
            'account/logout',
            'account/delete',
            'account/delete-multiple',
        ),
        'customer'=>array(
            'customer/create-customer',
            'customer/edit-customer',
            'customer/index',
            'customer/delete',
            'customer/delete-multiple',
            'customer/get-customers-json',
        ),
        'index'=>array(
            'index/index',
        ),
        'product'=>array(
            'product/edit-product',
            'product/index',
            'product/delete',
            'product/delete-multiple',
            'product/get-products-json',
        ),
        'sale-record'=>array(
            'sale-record/create-record',
            'sale-record/edit-record',
            'sale-record/history',
            'sale-record/index',
            'sale-record/delete-multiple',
            'sale-record/ajax-get-record',
            'sale-record/delete',
        ),
        'setting'=>array(
            'setting/index',
            'setting/others',
            'setting/system',
        ),
        'statistics'=>array(
            'statistics/hot-sell',
            'statistics/index',
            'statistics/profit',
            'statistics/sold',
            'statistics/ajax-get-total-profit-weekly',
        ),
        'stock-record'=>array(
            'stock-record/create-record',
            'stock-record/edit-record',
            'stock-record/index',
            'stock-record/record-detail',
            'stock-record/delete-multiple',
            'stock-record/delete',
            'stock-record/ajax-get-record',
        ),
    )
);
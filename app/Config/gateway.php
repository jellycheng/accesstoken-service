<?php
/**
 * 网关配置
 */
return [
    '/user/<version>/'=> ['App\\Controllers\\V1\\Gateway\\UserController',
                            'indexAction'], //用户服务网关
    '/coupon/<version>/'=> ['App\\Controllers\\V1\\Gateway\\CouponController',
                            'indexAction'], //优惠券服务网关
    '/cart/<version>/'=> ['App\\Controllers\\V1\\Gateway\\CartController',
                            'indexAction'], //购物车服务网关
    '/order/<version>/'=> ['App\\Controllers\\V1\\Gateway\\OrderController',
                            'indexAction'], //订单服务网关
    '/goods/<version>/'=> ['App\\Controllers\\V1\\Gateway\\GoodsController',
                            'indexAction'], //商品服务地址
    '/common/<version>/'=> ['App\\Controllers\\V1\\Gateway\\CommonController',
                            'indexAction'], //公共服务地址，存站内信、地址库、发短信等
];

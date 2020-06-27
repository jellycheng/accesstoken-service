<?php
/**
 * 网关配置
 * Date: 2019-07-08
 * Time: 12:08
 */
return [
    '/api/<version>/<service>/'=> ['App\\Mobile\\Controllers\\V1\\Gateway\\ApiController',
                                    'indexAction'],//提供汉德接口网关
    '/v1_xxxuser_<controllername>/<action>'=> ['App\\Mobile\\Controllers\\V1\\Gateway\\XxxController',
                                    'indexAction'],//hv app和小程序使用xxx网关,透传用户服务
    '/user/<version>/'=> ['App\\Mobile\\Controllers\\V1\\Gateway\\UserController',
                            'indexAction'], //用户服务网关
    '/coupon/<version>/'=> ['App\\Mobile\\Controllers\\V1\\Gateway\\CouponController',
                                'indexAction'], //优惠券服务网关
];
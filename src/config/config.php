<?php
/**
 * Created by Sublime.
 * User: 豁达于心
 * Date: 2017/8/25
 */

return [
    //应用ID,您的APPID。
    'app_id' => "",

    //商户私钥 不能用pkcs8.pem中的密钥！！！！！
    'merchant_private_key' => "",

    //异步通知地址
    'notify_url' => "http://外网可访问网关地址/alipay.trade.page.pay-PHP-UTF-8/notify_url.php",

    //手机异步通知地址
    'notify_url_wap' => "http://外网可访问网关地址/alipay.trade.page.pay-PHP-UTF-8/notify_url.php",

    //同步跳转
    'return_url' => "http://外网可访问网关地址/alipay.trade.page.pay-PHP-UTF-8/return_url.php",

    //手机同步跳转
    'return_url_wap' => "http://外网可访问网关地址/alipay.trade.page.pay-PHP-UTF-8/return_url.php",

    //编码格式
    'charset' => "UTF-8",

    //签名方式
    'sign_type' => "RSA2",

    //支付宝网关
    'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

    //支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
    'alipay_public_key' => "",
    
    // email: 394786996@qq.com
];
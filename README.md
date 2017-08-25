# laravel-alipay包 ING。。。。

# 根据支付宝最新版 支付接口SDK 整合laravel5包

## 安装
在 composer.json 文件中添加:"
w394786996/alipay": "1.0.*"
执行：composer update

在app.php中加上
Yi210\Alipay\AlipayServiceProvider::class,

添加配置文件到config: 
php artisan vendor:publish --provider="Yi210\Alipay\AlipayServiceProvider"

## 支持 手机、电脑
支持交易查询操作
支持退款操作
支持退款查询操作
支持交易关闭操作

## 用法
先将config/alipay.php 中各项配置好

// 具体方法可查看 AlipaySdk.php

namespace App\Http\Controllers;
use Yi210\Alipay\Facades\Alipay;

// ------------------------------------- 电脑版 -------------------

/**
 * 支付
 * @param Request $request
 * @return mixed
 */
public function pagePay(Request $request)
{
    //商户订单号，商户网站订单系统中唯一订单号，必填
    $out_trade_no = date('YmdHis') . '00045623';
    //订单名称，必填
    $subject = '这是一个好东东啊';
    //付款金额，必填
    $total_amount = 0.01;
    //商品描述，可空
    $body = '啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊';
    $response = Alipay::pagePay($subject, $body, $out_trade_no, $total_amount);
    //输出表单
    return $response['redirect_url'];
}


// ------------------------------------- 手机版 -------------------

public function wapPay(Request $request)
{
    //商户订单号，商户网站订单系统中唯一订单号，必填
    $out_trade_no = date('YmdHis') . '00045623';
    //订单名称，必填
    $subject = '这是一个好东东啊';
    //付款金额，必填
    $total_amount = 0.01;
    //商品描述，可空
    $body = '啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊';
    $response = Alipay::wapPay($subject, $body, $out_trade_no, $total_amount);
    //输出表单
    return $response['redirect_url'];
}



// ....... 其它退款 关闭等请看 AlipaySdk.php

// 不足之处请加Q394786996提出
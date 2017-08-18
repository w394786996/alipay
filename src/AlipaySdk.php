<?php
namespace Yi210\Alipay;

use Yi210\Alipay\BuilderModel\AlipayTradeCloseContentBuilder;
use Yi210\Alipay\BuilderModel\AlipayTradeFastpayRefundQueryContentBuilder;
use Yi210\Alipay\BuilderModel\AlipayTradeQueryContentBuilder;
use Yi210\Alipay\BuilderModel\AlipayTradeRefundContentBuilder;

// 电脑版
use Yi210\Alipay\BuilderModel\AlipayTradePagePayContentBuilder;
use Yi210\Alipay\Service\AlipayPageTradeService;

// 手机版
use Yi210\Alipay\BuilderModel\AlipayTradeWapPayContentBuilder;
use Yi210\Alipay\Service\AlipayWapTradeService;

class AlipaySdk
{
    public $pageAop;
    public $wapAop;
    public $config;

    /**
     * AlipaySdk constructor.
     */
    public function __construct($config)
    {
        $this->config = $config;
        $this->wapAop = new AlipayWapTradeService($config);
        $this->pageAop = new AlipayPageTradeService($config);
        // dd($config);
    }

    /**
     * 手机支付接口 支持自定义数据传输
     * @param $subject
     * @param $body
     * @param $out_trade_no
     * @param $total_amount
     * @param $timeout_express 超时时间
     * @return bool|提交表单HTML文本|mixed|\SimpleXMLElement|string
     */
    public function tradeWapPay($subject, $body, $out_trade_no, $total_amount, $timeout_express = '1m')
    {
        $payRequestBuilder = new AlipayTradeWapPayContentBuilder();
        $payRequestBuilder->setBody($body);
        $payRequestBuilder->setSubject($subject);
        $payRequestBuilder->setOutTradeNo($out_trade_no);
        $payRequestBuilder->setTotalAmount($total_amount);
        $payRequestBuilder->setTimeExpress($timeout_express);
        $response = $this->wapAop->wapPay($payRequestBuilder, $this->config['return_url_wap'], $this->config['notify_url_wap']);
        // return $response;
        return ;
    }
}
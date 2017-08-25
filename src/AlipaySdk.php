<?php
namespace Yi210\Alipay;

// 统一收单交易关闭接口
use Yi210\Alipay\BuilderModel\AlipayTradeCloseContentBuilder;

// 统一收单交易退款查询
use Yi210\Alipay\BuilderModel\AlipayTradeFastpayRefundQueryContentBuilder;

// 支付宝手机网站查询对账单下载地址
use Yi210\Alipay\BuilderModel\AlipayDataDataserviceBillDownloadurlQueryContentBuilder;

// 支付交易查询接口
use Yi210\Alipay\BuilderModel\AlipayTradeQueryContentBuilder;

// 支付宝电脑网站支付退款接口
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

    /* --------------------------手机网站2.0支付 ----------------- */

    /**
     * 手机支付接口 支持自定义数据传输
     * @param $subject
     * @param $body
     * @param $out_trade_no
     * @param $total_amount
     * @param $timeout_express 超时时间
     * @return bool|提交表单HTML文本|mixed|\SimpleXMLElement|string
     */
    public function wapPay($subject, $body, $out_trade_no, $total_amount, $timeout_express = '1m')
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

    /**
     * 手机支付交易查询接口，用于查询交易是否交易成功
     * @param $out_trade_no 商户订单号
     * @return bool|提交表单HTML文本|mixed|\SimpleXMLElement|\SimpleXMLElement[]|string
     */
    public function wapQuery($out_trade_no, $trade_no)
    {
        // 商户订单号和支付宝交易号不能同时为空。 trade_no、  out_trade_no如果同时存在优先取trade_no
        // 商户订单号，和支付宝交易号二选一
        $RequestBuilder = new AlipayTradeQueryContentBuilder();
        $RequestBuilder->setOutTradeNo($out_trade_no);
        $RequestBuilder->setTradeNo($trade_no);

        $response = $this->wapAop->Query($RequestBuilder);
        // return $response;
        return ;
    }


    /**
     * 手机网站2.0订单退款
     * @param  [type] $out_trade_no   [商户订单号]
     * @param  [type] $trade_no   [支付宝交易号]
     * @param  [type] $refund_amount  [退款金额，不能大于订单总金额]
     * @param  [type] $refund_reason  [退款的原因说明]
     * @param  [type] $out_request_no [标识一次退款请求]
     * @return [type]                 bool
     */
    public function wapRefund($out_trade_no, $trade_no, $refund_amount, $refund_reason, $out_request_no)
    {
        // 商户订单号和支付宝交易号不能同时为空。 trade_no、  out_trade_no如果同时存在优先取trade_no
        // 商户订单号，和支付宝交易号二选一
        $RequestBuilder = new AlipayTradeRefundContentBuilder();
        $RequestBuilder->setTradeNo($trade_no);
        $RequestBuilder->setOutTradeNo($out_trade_no);
        $RequestBuilder->setRefundAmount($refund_amount);
        $RequestBuilder->setRefundReason($refund_reason);
        $RequestBuilder->setOutRequestNo($out_request_no);

        $response = $this->wapAop->Refund($RequestBuilder);
        return ;
    }

    /**
     * [支付宝手机网站交易退款查询]
     * 商户订单号和支付宝交易号不能同时为空。 trade_no、  out_trade_no如果同时存在优先取trade_no
     * 商户订单号，和支付宝交易号二选一
     * @param  [type] $out_trade_no   [商户订单号]
     * @param  [type] $trade_no       [支付宝交易号]
     * @param  [type] $out_request_no [请求退款接口时，传入的退款请求号，如果在退款请求时未传入，则该值为创建交易时的外部交易号]
     * @return [type]                 [description]
     */
    public function wapRefundQuery($out_trade_no, $trade_no, $out_request_no)
    {
        $RequestBuilder = new AlipayTradeFastpayRefundQueryContentBuilder();
        $RequestBuilder->setTradeNo($trade_no);
        $RequestBuilder->setOutTradeNo($out_trade_no);
        $RequestBuilder->setOutRequestNo($out_request_no);

        $response = $this->wapAop->refundQuery($RequestBuilder);
        return ;
    }

    /**
     * [wapClose 支付宝手机网站交易关闭接口]
     * @param  [type] $out_trade_no   [商户订单号]
     * @param  [type] $trade_no       [支付宝交易号]
     * @return [type]               [description]
     */
    public function wapClose($out_trade_no, $trade_no)
    {
        $RequestBuilder = new AlipayTradeCloseContentBuilder();
        $RequestBuilder->setTradeNo($trade_no);
        $RequestBuilder->setOutTradeNo($out_trade_no);

        $response = $this->wapAop->Close($RequestBuilder);
        return ;
    }

    /**
     * [wapDataDownioad 支付宝手机网站查询对账单下载地址]
     * 账单类型，商户通过接口或商户经开放平台授权后其所属服务商通过接口可以获取以下账单类型：trade、signcustomer；
     * trade指商户基于支付宝交易收单的业务账单；signcustomer是指基于商户支付宝余额收入及支出等资金变动的帐务账单；
     * @param  [type] $bill_type [trade or signcustomer]
     * @param  [type] $bill_date [账单时间：日账单格式为yyyy-MM-dd，月账单格式为yyyy-MM]
     * @return [type]            [description]
     */
    public function wapDataDownioad($bill_type, $bill_date)
    {
        $RequestBuilder = new AlipayDataDataserviceBillDownloadurlQueryContentBuilder();
        $RequestBuilder->setBillType($bill_type);
        $RequestBuilder->setBillDate($bill_date);

        $response = $this->wapAop->downloadurlQuery($RequestBuilder);
        return ;
    }

    /**
     * 手机异步通知验证
     * @param $requestData
     * @return bool
     */
    public function wapNotify($requestData)
    {
        $this->wapAop->writeLog(var_export($requestData,true));
        return $this->wapAop->check($requestData);
    }




    /* --------------------------------- 以下是电脑版 --------------------------------- */




    /**
     * 电脑支付接口 支持自定义数据传输
     * @param $subject
     * @param $body
     * @param $out_trade_no
     * @param $total_amount
     * @return bool|提交表单HTML文本|mixed|\SimpleXMLElement|string
     */
    public function pagePay($subject, $body, $out_trade_no, $total_amount)
    {
        $payRequestBuilder = new AlipayTradePagePayContentBuilder();
        $payRequestBuilder->setBody($body);
        $payRequestBuilder->setSubject($subject);
        $payRequestBuilder->setTotalAmount($total_amount);
        $payRequestBuilder->setOutTradeNo($out_trade_no);
        $response = $this->pageAop->pagePay($payRequestBuilder, $this->config['return_url'], $this->config['notify_url']);

        return $response;
    }

    /**
     * 支付交易查询接口，用于查询交易是否交易成功
     * @param $out_trade_no 商户订单号
     * @return bool|提交表单HTML文本|mixed|\SimpleXMLElement|\SimpleXMLElement[]|string
     */
    public function pageQuery($out_trade_no, $trade_no)
    {
        // 商户订单号和支付宝交易号不能同时为空。 trade_no、  out_trade_no如果同时存在优先取trade_no
        // 商户订单号，和支付宝交易号二选一
        $RequestBuilder = new AlipayTradeQueryContentBuilder();
        $RequestBuilder->setOutTradeNo($out_trade_no);
        $RequestBuilder->setTradeNo($trade_no);

        $response = $this->pageAop->Query($RequestBuilder);
        // return $response;
        return ;
    }


    /**
     * 电脑订单退款
     * @param  [type] $out_trade_no   [商户订单号]
     * @param  [type] $trade_no   [支付宝交易号]
     * @param  [type] $refund_amount  [退款金额，不能大于订单总金额]
     * @param  [type] $refund_reason  [退款的原因说明]
     * @param  [type] $out_request_no [标识一次退款请求]
     * @return [type]                 bool
     */
    public function pageRefund($out_trade_no, $trade_no, $refund_amount, $refund_reason, $out_request_no)
    {
        // 商户订单号和支付宝交易号不能同时为空。 trade_no、  out_trade_no如果同时存在优先取trade_no
        // 商户订单号，和支付宝交易号二选一
        $RequestBuilder = new AlipayTradeRefundContentBuilder();
        $RequestBuilder->setTradeNo($trade_no);
        $RequestBuilder->setOutTradeNo($out_trade_no);
        $RequestBuilder->setRefundAmount($refund_amount);
        $RequestBuilder->setRefundReason($refund_reason);
        $RequestBuilder->setOutRequestNo($out_request_no);

        $response = $this->pageAop->Refund($RequestBuilder);
        return ;
    }

    /**
     * [支付宝电脑网站交易退款查询]
     * 商户订单号和支付宝交易号不能同时为空。 trade_no、  out_trade_no如果同时存在优先取trade_no
     * 商户订单号，和支付宝交易号二选一
     * @param  [type] $out_trade_no   [商户订单号]
     * @param  [type] $trade_no       [支付宝交易号]
     * @param  [type] $out_request_no [请求退款接口时，传入的退款请求号，如果在退款请求时未传入，则该值为创建交易时的外部交易号]
     * @return [type]                 [description]
     */
    public function pageRefundQuery($out_trade_no, $trade_no, $out_request_no)
    {
        $RequestBuilder = new AlipayTradeFastpayRefundQueryContentBuilder();
        $RequestBuilder->setTradeNo($trade_no);
        $RequestBuilder->setOutTradeNo($out_trade_no);
        $RequestBuilder->setOutRequestNo($out_request_no);

        $response = $this->pageAop->refundQuery($RequestBuilder);
        return ;
    }

    /**
     * [pageClose 支付宝电脑网站交易关闭接口]
     * @param  [type] $out_trade_no   [商户订单号]
     * @param  [type] $trade_no       [支付宝交易号]
     * @return [type]               [description]
     */
    public function pageClose($out_trade_no, $trade_no)
    {
        $RequestBuilder = new AlipayTradeCloseContentBuilder();
        $RequestBuilder->setTradeNo($trade_no);
        $RequestBuilder->setOutTradeNo($out_trade_no);

        $response = $this->pageAop->Close($RequestBuilder);
        return ;
    }

    /**
     * [pageDataDownioad 支付宝电脑网站查询对账单下载地址]
     * 账单类型，商户通过接口或商户经开放平台授权后其所属服务商通过接口可以获取以下账单类型：trade、signcustomer；
     * trade指商户基于支付宝交易收单的业务账单；signcustomer是指基于商户支付宝余额收入及支出等资金变动的帐务账单；
     * @param  [type] $bill_type [trade or signcustomer]
     * @param  [type] $bill_date [账单时间：日账单格式为yyyy-MM-dd，月账单格式为yyyy-MM]
     * @return [type]            [description]
     */
    public function pageDataDownioad($bill_type, $bill_date)
    {
        $RequestBuilder = new AlipayDataDataserviceBillDownloadurlQueryContentBuilder();
        $RequestBuilder->setBillType($bill_type);
        $RequestBuilder->setBillDate($bill_date);

        $response = $this->pageAop->downloadurlQuery($RequestBuilder);
        return ;
    }

    /**
     * 电脑异步通知验证
     * @param $requestData
     * @return bool
     */
    public function pageNotify($requestData)
    {
        $this->pageAop->writeLog(var_export($requestData,true));
        return $this->pageAop->check($requestData);
    }
}
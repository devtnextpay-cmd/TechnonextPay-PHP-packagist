<?php

namespace TechnonextPlugin;

class TechnonextpayConfig
{
    /** merchant store username assigned by Technonextpay system */
    public $username;

    /** merchant store password assigned by Technonextpay system */
    public $password;

    /** Merchant signature used to generate order id */
    public $signature;

    public $merchant_code;

    /** Technonextpay payment gateway API endpoint; e.g. https://sandbox.Technonextpayment.com */
    public $api_endpoint;

    /** URL to redirect after completion of a payment. e.g. https://sandbox.Technonextpayment.com/success */
    public $success_url;

    /** URL to redirect after completion of a payment. e.g. https://sandbox.Technonextpayment.com/failure */
    public $failure_url;

    /** URL to redirect after completion of a payment. e.g. https://sandbox.Technonextpayment.com/cancel */
    public $cancel_url;

    /** IPN URL */
    public $ipn_url;

    /** Log path or directory to store PHP plugin logs */
    public $log_path;


    /** Merchant prefix used to generate order id */
    public $ssl_verifypeer;

    public $order_prefix;
}
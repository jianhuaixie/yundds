<?php

/**
 * ECTouch Open Source Project
 * ============================================================================
 * Copyright (c) 2012-2014 http://ectouch.cn All rights reserved.
 * ----------------------------------------------------------------------------
 * 文件名称：paypal.php
 * ----------------------------------------------------------------------------
 * 功能描述：paypal支付插件语言包
 * ----------------------------------------------------------------------------
 * Licensed ( http://www.ectouch.cn/docs/license.txt )
 * ----------------------------------------------------------------------------
 */

/* 访问控制 */
if (! defined('IN_ECTOUCH')) {
    die('Deny Access');
}

$_LANG['paypal']                       = 'paypal';
$_LANG['paypal_desc']                  = 'PayPal（www.paypal.com） 是在綫付款解決方案的全球領導者，PayPal 可在 56 個市場以 7 種貨幣（加元、歐元、英鎊、美元、日元、澳元、港元）使用。';
$_LANG['paypal_account']               = '商戶帳號';
$_LANG['paypal_currency']              = '支付貨幣';
$_LANG['paypal_currency_range']['AUD'] = '澳元';
$_LANG['paypal_currency_range']['CAD'] = '加元';
$_LANG['paypal_currency_range']['EUR'] = '歐元';
$_LANG['paypal_currency_range']['GBP'] = '英镑';
$_LANG['paypal_currency_range']['JPY'] = '日元';
$_LANG['paypal_currency_range']['USD'] = '美元';
$_LANG['paypal_currency_range']['HKD'] = '港元';
$_LANG['paypal_button']                = '使用Paypal支付';
$_LANG['paypal_txn_id']                = 'Paypal交易號';
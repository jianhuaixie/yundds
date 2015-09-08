<?php

/**
 * ECTouch Open Source Project
 * ============================================================================
 * Copyright (c) 2012-2014 http://ectouch.cn All rights reserved.
 * ----------------------------------------------------------------------------
 * 文件名称：wxpay.php
 * ----------------------------------------------------------------------------
 * 功能描述：微信支付语言包
 * ----------------------------------------------------------------------------
 * Licensed ( http://www.ectouch.cn/docs/license.txt )
 * ----------------------------------------------------------------------------
 */

/* 访问控制 */
if (! defined('IN_ECTOUCH')) {
    die('Deny Access');
}

$_LANG['wxpay'] = '微信支付';
$_LANG['wxpay_desc'] = '微信支付，是基於客戶端提供的服務功能。同時向商戶提供銷售經營分析、帳戶和資金管理的功能支持。用戶通過掃描二維碼、微信內打開頁面購買等多種方式調用微信支付模塊完成支付。';
$_LANG['wxpay_appid'] = '微信公眾號AppId';
$_LANG['wxpay_appsecret'] = '微信公眾號AppSecret';
$_LANG['wxpay_key'] = '商戶支付密鑰Key';
$_LANG['wxpay_mchid'] = '受理商ID';
$_LANG['wxpay_signtype'] = '簽名方式';
$_LANG['wxpay_button'] = '立即使用微信支付';
<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/13
 * Time: 21:26
 */
return [
    //  +---------------------------------
    //  微信相关配置
    //  +---------------------------------
    // 小程序app_id
    'app_id' => 'wxe82771f4021e1e28',
    // 小程序app_secret
    'app_secret' => 'b33fbb95cf60897be73cadbd616bc075',

    // 微信使用code换取用户openid及session_key的url地址
    'login_url' => "https://api.weixin.qq.com/sns/jscode2session?" .
        "appid=%s&secret=%s&js_code=%s&grant_type=authorization_code",

    // 微信获取access_token的url地址
    'access_token_url' => "https://api.weixin.qq.com/cgi-bin/token?" .
        "grant_type=client_credential&appid=%s&secret=%s",
];
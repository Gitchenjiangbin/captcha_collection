<?php

namespace Chenjiangbin\CaptchaPuzzle\Common;


/**
 * 全局常量配置
 */
class Constants
{
    // 缓存时间 10 分钟有效期
    const CACHE_TIME = 600;
    // 缓存类型
    const CACHE_TYPE_SESSION = 'SESSION';
    const CACHE_TYPE_REDIS   = 'REDIS';

    // 验证码类型 en-英文验证码，zh-中文验证码
    const CHARS_TYPE_EN = 'en';
    const CHARS_TYPE_ZH = 'zh';

    const VOICE_TEMP = '您的验证码是 %s';
    const VOICE_LANG_ARRAY = ['en', 'en-us', 'en-uk', 'zh', 'fr', 'de', 'es'];
}

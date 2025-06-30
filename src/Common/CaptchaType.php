<?php


namespace Chenjiangbin\CaptchaPuzzle\Common;

/**
 * php < 8.1 不支持枚举，使用常量替代
 * Class CaptchaType
 * @package Chenjiangbin\CaptchaPuzzle\Common
 */
class CaptchaType
{
    const IMAGE      = 'image';       // 图形验证码
    const PUZZLE     = 'puzzle';      // 拼图验证码
    const VOICE      = 'voice';       // 语音验证码
    const ARITHMETIC = 'arithmetic';  // 算术验证码
}
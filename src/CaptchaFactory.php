<?php


namespace Chenjiangbin\CaptchaPuzzle;


use Chenjiangbin\CaptchaPuzzle\Captcha\ArithmeticCaptcha;
use Chenjiangbin\CaptchaPuzzle\Captcha\ImageCaptcha;
use Chenjiangbin\CaptchaPuzzle\Captcha\PuzzleCaptcha;
use Chenjiangbin\CaptchaPuzzle\Captcha\VoiceCaptcha;
use Chenjiangbin\CaptchaPuzzle\Common\CaptchaType;

/**
 * 验证码工厂
 * Class CaptchaFactory
 * @package Chenjiangbin\CaptchaPuzzle
 */
class CaptchaFactory
{
    public static function make(array $config = []): CaptchaInterface
    {
        if (empty($config['type'])) {
            throw new CaptchaException("请输入类型");
        }
        switch ($config['type']) {
            case CaptchaType::PUZZLE:
                return new PuzzleCaptcha($config);
            case CaptchaType::IMAGE:
                return new ImageCaptcha($config);
            case CaptchaType::VOICE:
                return new VoiceCaptcha($config);
            case CaptchaType::ARITHMETIC:
                return new ArithmeticCaptcha($config);
            default:
                throw new CaptchaException("类型 {$config['type']} 不存在");
        }
    }
}
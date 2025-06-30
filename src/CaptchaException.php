<?php

namespace Chenjiangbin\CaptchaPuzzle;

/**
 * Class CaptchaException
 * 自定义异常，用于验证码生成与验证中的错误处理
 */
class CaptchaException extends \RuntimeException
{
    /**
     * CaptchaException constructor.
     * CaptchaException constructor.
     * @param string $message
     * @param int $code
     * @param null $previous
     */
    public function __construct($message = "", $code = 0, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

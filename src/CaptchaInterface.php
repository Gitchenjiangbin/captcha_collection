<?php


namespace Chenjiangbin\CaptchaPuzzle;


interface CaptchaInterface
{
    // 生成验证码
    public function generate(): array;

    // 验证验证码
    public function validate($params): bool;
}
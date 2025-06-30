<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Chenjiangbin\CaptchaPuzzle\CaptchaFactory;
use Chenjiangbin\CaptchaPuzzle\Common\CaptchaType;
use Chenjiangbin\CaptchaPuzzle\Common\Constants;

header('Content-Type: application/json');


// 初始化验证码生成器
$captcha = CaptchaFactory::make([
    'type'      => CaptchaType::ARITHMETIC,    // 验证码类型，可查看CaptchaType类
    'id'        => 'login',                    // 验证码key标识
    'width'     => 120,                        // 验证码图片宽度
    'height'    => 40,                         // 验证码图片高度
    'cacheType' => Constants::CACHE_TYPE_REDIS // 验证码存储方式
]);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $raw   = file_get_contents('php://input');
        $input = json_decode($raw, true);

        if (empty($input['cache_id'])) {
            throw new \Exception('无效的cache_id');
        }
        if (empty($input['code'])) {
            throw new \Exception('code不能为空');
        }

        $check = $captcha->validate($input);

        $code = $check == true ? 1 : 0;
        echo json_encode(['code' => $code, 'error' => $check ? '' : "验证失败"]);
    } catch (\Exception $e) {
        echo json_encode([
            'code'    => 0,
            'error'   => $e->getMessage(),
            'message' => $e->getMessage(),
        ]);
    }
} else {
    // 生成验证码
    try {
        $data = $captcha->generate();
        echo json_encode($data);
    } catch (Exception $e) {
        echo json_encode([
            'error'   => '生成验证码失败',
            'message' => $e->getMessage(),
        ]);
    }
}


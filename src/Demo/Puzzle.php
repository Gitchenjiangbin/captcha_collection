<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Chenjiangbin\CaptchaPuzzle\CaptchaFactory;
use Chenjiangbin\CaptchaPuzzle\CaptchaGenerator;
use Chenjiangbin\CaptchaPuzzle\Common\CaptchaType;
use Chenjiangbin\CaptchaPuzzle\Common\Constants;

header('Content-Type: application/json');

$action = $_GET['action'] ?? '';
// 初始化验证码生成器
$captcha = CaptchaFactory::make([
    'type'         => CaptchaType::PUZZLE,          // 验证码类型
    'id'           => 'login',                      // 验证码key标识
    'images'       => '../../assets/bgs/yzm_04.png',// 自定义背景图片地址，传数组为随机选取
    'imgWidth'     => 40,                           // 拼图宽度
    'imgHeight'    => 40,                           // 拼图高度
    'targetWidth'  => 300,                          // 返回的背景图宽度
    'targetHeight' => 200,                          // 背景图高度
    'bgRgb'        => [230, 255, 32, 0],            // 抠图部位的背景色
    'bgBorderRgb'  => [230, 255, 32, 0],            // 抠图部位的边框色
    'cacheType'    => Constants::CACHE_TYPE_REDIS,  // 缓存方式
    'redisConfig'     => [
        'host'     => '127.0.0.1',
        'port'     => 6379,
        'password' => '',
        'db'       => 0
    ],
]);
if ($action === 'index') {
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

} else if ($action === 'verify') {

    $raw   = file_get_contents('php://input');
    $input = json_decode($raw, true);

    if (empty($input['cache_id'])) {
        throw new \Exception('无效的cache_id');
    }
    if (empty($input['offset'])) {
        throw new \Exception('offset不能为空');
    }

    $captcha = $captcha->validate($input);
    try {
        echo json_encode(['is_check' => $captcha]);
    } catch (Exception $e) {
        echo json_encode([
            'error'   => $e->getMessage(),
            'message' => $e->getMessage(),
        ]);
    }
}

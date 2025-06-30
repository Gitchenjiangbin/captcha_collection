<?php


require_once __DIR__ . '/../../vendor/autoload.php';

use Chenjiangbin\CaptchaPuzzle\CaptchaFactory;
use Chenjiangbin\CaptchaPuzzle\CaptchaGenerator;
use Chenjiangbin\CaptchaPuzzle\Common\CaptchaType;
use Chenjiangbin\CaptchaPuzzle\Common\VoiceLangType;

header('Content-Type: application/json');


// 初始化验证码生成器
$captcha = CaptchaFactory::make([
    'type'      => CaptchaType::VOICE,
    'id'        => 'login',
    'length'    => 4,     // 验证码长度默认是5
    'voiceDir'  => '../../assets/voice/', // wav文件存储文件夹
    'voiceLang' => VoiceLangType::ZH,  // 验证码语言，默认zh 支持 en、en-us、en-uk、zh、fr、de、es
    'voiceTemp' => '您的验证码是 %s',    // 如果是中文的话有默认模板
    'voiceS'    => 190,      // 语数 190词/每分钟  范围 80 ~ 450
    'voiceP'    => 50,       // 音调 默认 0 ~ 99
    'voiceA'    => 100,      // 音量 0~200
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
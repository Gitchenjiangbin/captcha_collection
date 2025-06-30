<?php


namespace Chenjiangbin\CaptchaPuzzle\Captcha;


use Chenjiangbin\CaptchaPuzzle\CaptchaException;
use Chenjiangbin\CaptchaPuzzle\CaptchaInterface;
use Chenjiangbin\CaptchaPuzzle\Common\Constants;

/**
 * 语音验证码
 * Class VoiceCaptcha
 * @package Chenjiangbin\CaptchaPuzzle\Captcha
 */
class VoiceCaptcha extends CaptchaBase implements CaptchaInterface
{

    public function __construct($config = [])
    {
        parent::__construct($config);
        // 清理过期wav文件
        $this->unLinkWav();
    }

    /**
     * 生成验证码和.wav文件
     * @return array
     * @throws \Exception
     */
    public function generate(): array
    {
        // 验证验证码类型
        if (!in_array($this->voiceLang, Constants::VOICE_LANG_ARRAY)) {
            throw new CaptchaException("验证码不支持`$this->voiceLang`");
        }

        // 根据长度生成相应的验证码位数
        $code = str_pad((string)random_int(0, pow(10, $this->length) - 1), $this->length, '0', STR_PAD_LEFT);

        // 缓存id
        $cache_id = $this->setCaptchaCache(['code' => $code]);

        // 语音缓存路径
        $filepath = $this->voiceDir . $cache_id . ".wav";

        // 判断模板，如果有自定义模板用自定义，没有的话用默认模板
        $temp = empty($this->voiceTemp) ? Constants::VOICE_TEMP : $this->voiceTemp;
        $text = sprintf($temp, implode(' ', preg_split('//u', $code, -1, PREG_SPLIT_NO_EMPTY)));


        $cmd = sprintf("espeak-ng -v %s -s %s -p %s -a %s %s --stdout > %s",
            $this->voiceLang, $this->voiceS, $this->voiceP, $this->voiceA, escapeshellarg($text), $filepath);

        exec($cmd, $output, $returnCode);

        if ($returnCode !== 0) {
            throw new \RuntimeException("语音验证码生成失败，命令返回码：$returnCode");
        }

        return ['src' => $filepath, 'cache_id' => $cache_id];
    }

    /**
     * 验证验证码
     * @param $params
     * @return bool
     */
    public function validate($params): bool
    {
        $cacheId      = $params['cache_id'] ?? '';
        $captchaCache = $this->getCaptchaCache($cacheId);
        $isValid      = $captchaCache['code'] === $params['code'];

        if ($isValid) {
            $this->delCache($captchaCache['cache_id']);
            unlink($this->voiceDir . $cacheId . ".wav");
        }

        return $isValid;
    }


    /**
     * 清理过期文件
     */
    private function unLinkWav()
    {
        $timestamp = time();
        foreach (glob($this->voiceDir . '*.wav') as $file) {
            if (is_file($file) && $timestamp - filemtime($file) > Constants::CACHE_TIME) {
                unlink($file);
            }
        }
    }
}
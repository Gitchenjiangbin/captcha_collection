<?php


namespace Chenjiangbin\CaptchaPuzzle\Captcha;


use Chenjiangbin\CaptchaPuzzle\CaptchaInterface;
use Chenjiangbin\CaptchaPuzzle\Common\Constants;

/**
 * 图形验证码
 * Class ImageCaptcha
 * @package Chenjiangbin\CaptchaPuzzle\Captcha
 */
class ImageCaptcha extends CaptchaBase implements CaptchaInterface
{

    /**
     * @return array
     * @throws \Exception
     */
    public function generate(): array
    {
        $image = imagecreatetruecolor($this->width, $this->height);
        // 背景白色
        $this->fillBackground($image);

        // 字体文件路径
        $fontFile = $this->resolvePath('../../assets/fonts/1.ttf');

        // 生成验证码
        $code = $this->generateCode();

        // 添加干扰字符
        $this->drawNoiseCharacters($image, $fontFile, $count = 40);

        // 写入验证码文本（中文支持）
        $this->drawText($image, $code, $fontFile);

        // 设置缓存
        $cacheId = $this->setCaptchaCache(['code' => $code]);

        // 输出图像
        return ['src' => $this->imageToBase64($image), 'code' => $code, 'cache_id' => $cacheId];
    }

    /**
     * 验证
     * @param $params
     * @return bool
     */
    public function validate($params): bool
    {
        $cacheId      = $params['cache_id'] ?? '';
        $captchaCache = $this->getCaptchaCache($cacheId);

        // 是否区分大小写
        if ($this->isCaseSensitive) {
            $isValid = $captchaCache['code'] === $params['code'];
        } else {
            $isValid = strtolower($captchaCache['code']) === strtolower($params['code']);
        }

        if ($isValid) $this->delCache($captchaCache['cache_id']);

        return $isValid;
    }


    /**
     * 绘制验证码字符，自动计算间距与位置
     */
    private function drawText($image, string $text, string $fontFile): void
    {
        $length   = mb_strlen($text, 'utf-8');
        $fontSize = 20;
        $padding  = 10;
        $spacing  = ($this->width - 2 * $padding) / max($length, 1);

        for ($i = 0; $i < $length; $i++) {
            $char  = mb_substr($text, $i, 1, 'utf-8');
            $angle = rand(-30, 30);
            $x     = $padding + $i * $spacing;
            $y     = rand($fontSize + 8, $this->height - 5);
            $color = imagecolorallocate($image, rand(0, 120), rand(0, 120), rand(0, 120));
            imagettftext($image, $fontSize, $angle, $x, $y, $color, $fontFile, $char);
        }
    }

    /**
     * 生成验证码
     * @return string
     */
    private function generateCode(): string
    {
        $code = '';
        if ($this->charsType === Constants::CHARS_TYPE_ZH) {
            for ($i = 0; $i < $this->length; $i++) {
                $code .= mb_substr($this->zhChars, rand(0, mb_strlen($this->zhChars, 'utf-8') - 1), 1, 'utf-8');
            }
        } else {
            for ($i = 0; $i < $this->length; $i++) {
                $code .= $this->chars[rand(0, strlen($this->chars) - 1)];
            }
        }
        return $code;
    }

    /**
     * 添加干扰字符
     * @param $image
     * @param string $fontFile
     * @param int $count
     */
    private function drawNoiseCharacters($image, string $fontFile, int $count = 40): void
    {
        for ($i = 0; $i < $count; $i++) {
            $char = $this->charsType === Constants::CHARS_TYPE_ZH
                ? mb_substr($this->zhChars, rand(0, mb_strlen($this->zhChars, 'utf-8') - 1), 1, 'utf-8')
                : $this->chars[rand(0, strlen($this->chars) - 1)];

            $fontSize = rand(8, 12);
            $angle    = rand(-45, 45);
            $x        = rand(0, $this->width);
            $y        = rand($fontSize, $this->height - 2);
            $color    = imagecolorallocate($image, rand(180, 220), rand(180, 220), rand(180, 220));

            imagettftext($image, $fontSize, $angle, $x, $y, $color, $fontFile, $char);
        }
    }
}
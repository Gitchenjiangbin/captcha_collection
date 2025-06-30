<?php


namespace Chenjiangbin\CaptchaPuzzle\Captcha;


use Chenjiangbin\CaptchaPuzzle\CaptchaInterface;

/**
 * 算术验证码
 * Class ArithmeticCaptcha
 * @package Chenjiangbin\CaptchaPuzzle\Captcha
 */
class ArithmeticCaptcha extends CaptchaBase implements CaptchaInterface
{
    /**
     * 生成验证码
     * @return array
     * @throws \Exception
     */
    public function generate(): array
    {
        // 构造算式文本
        [$question, $result] = $this->operator();

        $image = imagecreatetruecolor($this->width, $this->height);
        // 背景白色
        $this->fillBackground($image);
        $textColor = imagecolorallocate($image, 0, 0, 0);
        // 字体文件路径
        $fontFile = $this->resolvePath('../../assets/fonts/1.ttf');

        // 加干扰点
        for ($i = 0; $i < 200; $i++) {
            $noiseColor = imagecolorallocate($image, rand(150, 255), rand(150, 255), rand(150, 255));
            imagesetpixel($image, rand(0, $this->width), rand(0, $this->height), $noiseColor);
        }

        // 添加干扰曲线
        for ($i = 0; $i < 2; $i++) {
            $curveColor = imagecolorallocate($image, rand(100, 180), rand(100, 180), rand(100, 180));
            $amplitude  = rand(5, 15);                  // 振幅
            $frequency  = rand(10, 20);                 // 频率
            $phase      = rand(0, 10);                  // 相位偏移
            $yOffset    = rand(10, $this->height - 10); // 垂直偏移

            for ($x = 0; $x < $this->width; $x++) {
                $y = (int)($amplitude * sin($x / $frequency + $phase)) + $yOffset;
                if ($y >= 0 && $y < $this->height) {
                    imagesetpixel($image, $x, $y, $curveColor);
                }
            }
        }

        $angle    = 0;
        $fontSize = 16;
        $bbox     = imagettfbbox($fontSize, $angle, $fontFile, $question);
        // 计算文字宽高
        $textWidth  = $bbox[2] - $bbox[0];
        $textHeight = $bbox[1] - $bbox[7];

        // 计算居中位置
        $x = ($this->width - $textWidth) / 2;
        $y = ($this->height + $textHeight) / 2;

        imagettftext($image, $fontSize, $angle, (int)$x, (int)$y, $textColor, $fontFile, $question);

        // 设置缓存
        $cacheId = $this->setCaptchaCache(['code' => $result]);
        // 输出图像
        return ['src' => $this->imageToBase64($image), 'result' => $result, 'cache_id' => $cacheId];

    }

    /**
     * 验证算数
     * @param $params
     * @return bool
     */
    public function validate($params): bool
    {
        $cacheId      = $params['cache_id'] ?? '';
        $captchaCache = $this->getCaptchaCache($cacheId);

        $isValid = $captchaCache['code'] == $params['code'];

        if ($isValid) $this->delCache($captchaCache['cache_id']);

        return $isValid;
    }

    private function operator()
    {

        // 随机生成两个数字和运算符
        $operators = ['+', '-', '*', '÷'];
        $operator  = $operators[rand(0, count($operators) - 1)];

        // 计算结果保存到 session
        switch ($operator) {
            case '+':
                $num1   = rand(1, 100);
                $num2   = rand(1, 100);
                $result = $num1 + $num2;
                break;
            case '-':
                $num1   = rand(1, 100);
                $num2   = rand(1, $num1);
                $result = $num1 - $num2;
                break;
            case '*':
                $num1   = rand(1, 20);
                $num2   = rand(1, 10);
                $result = $num1 * $num2;
            case '÷':
                $num2   = rand(1, 10);
                $result = rand(1, 10);     // 先生成结果
                $num1   = $num2 * $result; // 保证能整除
                $result = $num1 / $num2;
                break;
        }
        // 构造算式文本
        $question = "$num1 $operator $num2 = ?";

        return [$question, $result];
    }
}
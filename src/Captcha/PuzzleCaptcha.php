<?php


namespace Chenjiangbin\CaptchaPuzzle\Captcha;


use Chenjiangbin\CaptchaPuzzle\CaptchaException;
use Chenjiangbin\CaptchaPuzzle\CaptchaInterface;


/**
 * 图形拼图验证码
 * Class PuzzleCaptcha
 */
class PuzzleCaptcha extends CaptchaBase implements CaptchaInterface
{

    /**
     * 生成图形验证码
     *
     * @return array 返回包含背景图、拼图块、偏移量等信息的数组
     * @throws CaptchaException|\Exception 如果图像加载失败
     */
    public function generate(): array
    {
        // 拼接图片路径
        $bgPath = $this->resolvePath($this->getSrc());
        if (!$bgPath || !file_exists($bgPath)) {
            throw new CaptchaException("背景图像路径无效: {$bgPath}");
        }

        $src    = $this->loadImage($bgPath);
        if (!$src) {
            throw new CaptchaException('读取不到图片');
        }

        // 创建目标图像，返回背景图、宽高
        [$bg, $bgWidth, $bgHeight] = $this->createBaseImage($src);

        // 随机生成拼图块位置（避免贴边）
        [$x, $y] = [
            rand($this->imgWidth, $bgWidth - $this->imgWidth - 20),
            rand(0, $bgHeight - $this->imgHeight - 20)
        ];

        // 创建拼图块图像
        $puzzle = $this->createPuzzlePiece($bg, $x, $y);

        // 应用遮罩和边框
        $this->applyMask($bg, $x, $y);
        $this->drawBorder($bg, $x, $y);

        // 保存验证码信息到 Session
        $cacheId = $this->setCaptchaCache(['offset' => $x]);

        // 返回数据
        return [
            'bg'         => $this->imageToBase64($bg),
            'puzzle'     => $this->imageToBase64($puzzle),
            'offset'     => $x,
            'cache_id' => $cacheId,
            'width'      => $this->imgWidth,
            'height'     => $this->imgHeight,
            'top'        => $y
        ];
    }

    /**
     * 校验验证码偏移值
     * @param $params
     * @return bool
     */
    public function validate($params): bool
    {
        $cacheId      = $params['cache_id'] ?? '';

        $captchaCache = $this->getCaptchaCache($cacheId);

        $isValid = abs($captchaCache['offset'] - $params['offset']) <= 5;

        if ($isValid) $this->delCache($captchaCache['cache_id']);

        return $isValid;
    }


    /**
     * 创建基础图像资源
     *
     * @param resource $src 原始图像
     * @return array [目标图像resource, 宽, 高]
     */
    private function createBaseImage($src): array
    {
        $width  = $this->targetWidth;
        $height = $this->targetHeight;

        $bg = imagecreatetruecolor($width, $height);
        imagesavealpha($bg, true);
        imagefill($bg, 0, 0, imagecolorallocatealpha($bg, 0, 0, 0, 127));
        imagecopyresampled($bg, $src, 0, 0, 0, 0, $width, $height, imagesx($src), imagesy($src));
        imagedestroy($src);

        return [$bg, $width, $height];
    }

    /**
     * 创建拼图块图像
     *
     * @param resource $bg 背景图像
     * @param int $x 起始X坐标
     * @param int $y 起始Y坐标
     * @return resource 拼图图像
     */
    private function createPuzzlePiece($bg, int $x, int $y)
    {
        $piece = imagecreatetruecolor($this->imgWidth, $this->imgHeight);

        imagesavealpha($piece, true);
        imagefill($piece, 0, 0, imagecolorallocatealpha($piece, 0, 0, 0, 127));
        imagecopy($piece, $bg, 0, 0, $x, $y, $this->imgWidth, $this->imgHeight);

        return $piece;
    }

    /**
     * 在背景图上应用遮罩颜色（如白色透明）
     *
     * @param resource $bg 背景图像
     * @param int $x 起始X坐标
     * @param int $y 起始Y坐标
     */
    private function applyMask(&$bg, int $x, int $y): void
    {
        [$r, $g, $b, $opacity] = $this->bgRgb;
        $maskColor = imagecolorallocatealpha($bg, $r, $g, $b, $opacity);
        for ($i = 0; $i < $this->imgWidth; $i++) {
            for ($j = 0; $j < $this->imgHeight; $j++) {
                imagesetpixel($bg, $x + $i, $y + $j, $maskColor);
            }
        }
    }

    /**
     * 绘制拼图边框
     *
     * @param resource $bg 背景图像
     * @param int $x 起始X坐标
     * @param int $y 起始Y坐标
     */
    private function drawBorder(&$bg, int $x, int $y): void
    {
        [$r, $g, $b, $opacity] = $this->bgBorderRgb;
        $borderColor = imagecolorallocatealpha($bg, $r, $g, $b, $opacity);
        imagerectangle($bg, $x, $y, $x + $this->imgWidth - 1, $y + $this->imgHeight - 1, $borderColor);
    }
}
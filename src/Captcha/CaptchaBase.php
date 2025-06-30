<?php


namespace Chenjiangbin\CaptchaPuzzle\Captcha;


use Chenjiangbin\CaptchaPuzzle\CaptchaException;
use Chenjiangbin\CaptchaPuzzle\Common\Constants;

/**
 * Class CaptchaBase
 * @package Chenjiangbin\CaptchaPuzzle\Captchas
 * @property mixed $id
 * @property string $seKey
 * @property string $src
 * @property array $images
 * @property int $targetWidth
 * @property int $targetHeight
 * @property int $imgWidth
 * @property int $imgHeight
 * @property array $bgRgb
 * @property array $bgBorderRgb
 * @property string $charsType
 * @property string $chars
 * @property string $zhChars
 * @property bool $isCaseSensitive
 * @property int $length
 * @property int $width
 * @property int $height
 * @property string $cacheType
 * @property array $redisConfig
 * @property string $voiceLang
 * @property string $voiceDir
 * @property string $voiceTemp
 * @property string $voiceS
 * @property string $voiceP
 * @property string $voiceA
 */
class CaptchaBase
{
    protected \Redis $redis;
    protected        $config
        = [
            'id'              => '',
            'seKey'           => 'CAPTCHA_TOKEN',
            // 拼图验证码设置
            'src'             => '',
            'images'          => [
                '../../assets/bgs/yzm_01.png',
                '../../assets/bgs/yzm_02.png',
                '../../assets/bgs/yzm_03.png',
                '../../assets/bgs/yzm_04.png',
                '../../assets/bgs/yzm_05.png',
                '../../assets/bgs/yzm_06.png',
                '../../assets/bgs/yzm_07.png'
            ],
            'targetWidth'     => 300,
            'targetHeight'    => 200,
            'imgWidth'        => 50,
            'imgHeight'       => 50,
            'bgRgb'           => [255, 255, 255, 90],
            'bgBorderRgb'     => [255, 255, 255, 0],
            // 图形验证码配置
            'charsType'       => Constants::CHARS_TYPE_EN,
            'chars'           => 'abcdefghjklmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ123456789',
            'zhChars'         => '们以我到他会作时要动国产的一是工就年阶义发成部民可出能方进在了不和有大这主中人上为来分生对于学下级地个用同行面说种过命度革而多子后自社加小机也经力线本电高量长党得实家定深法表着水理化争现所二起政三好十战无农使性前等反体合斗路图把结第里正新开论之物从当两些还天资事队批点育重其思与间内去因件日利相由压员气业代全组数果期导平各基或月毛然如应形想制心样干都向变关问比展那它最及外没看治提五解系林者米群头意只明四道马认次文通但条较克又公孔领军流入接席位情运器并飞原油放立题质指建区验活众很教决特此常石强极土少已根共直团统式转别造切九你取西持总料连任志观调七么山程百报更见必真保热委手改管处己将修支识病象几先老光专什六型具示复安带每东增则完风回南广劳轮科北打积车计给节做务被整联步类集号列温装即毫知轴研单色坚据速防史拉世设达尔场织历花受求传口断况采精金界品判参层止边清至万确究书术状厂须离再目海交权且儿青才证低越际八试规斯近注办布门铁需走议县兵固除般引齿千胜细影济白格效置推空配刀叶率述今选养德话查差半敌始片施响收华觉备名红续均药标记难存测士身紧液派准斤角降维板许破述技消底床田势端感往神便贺村构照容非搞亚磨族火段算适讲按值美态黄易彪服早班麦削信排台声该击素张密害侯草何树肥继右属市严径螺检左页抗苏显苦英快称坏移约巴材省黑武培著河帝仅针怎植京助升王眼她抓含苗副杂普谈围食射源例致酸旧却充足短划剂宣环落首尺波承粉践府鱼随考刻靠够满夫失包住促枝局菌杆周护岩师举曲春元超负砂封换太模贫减阳扬江析亩木言球朝医校古呢稻宋听唯输滑站另卫字鼓刚写刘微略范供阿块某功套友限项余倒卷创律雨让骨远帮初皮播优占死毒圈伟季训控激找叫云互跟裂粮粒母练塞钢顶策双留误础吸阻故寸盾晚丝女散焊功株亲院冷彻弹错散商视艺灭版烈零室轻血倍缺厘泵察绝富城冲喷壤简否柱李望盘磁雄似困巩益洲脱投送奴侧润盖挥距触星松送获兴独官混纪依未突架宽冬章湿偏纹吃执阀矿寨责熟稳夺硬价努翻奇甲预职评读背协损棉侵灰虽矛厚罗泥辟告卵箱掌氧恩爱停曾溶营终纲孟钱待尽俄缩沙退陈讨奋械载胞幼哪剥迫旋征槽倒握担仍呀鲜吧卡粗介钻逐弱脚怕盐末阴丰雾冠丙街莱贝辐肠付吉渗瑞惊顿挤秒悬姆烂森糖圣凹陶词迟蚕亿矩康遵牧遭幅园腔订香肉弟屋敏恢忘编印蜂急拿扩伤飞露核缘游振操央伍域甚迅辉异序免纸夜乡久隶缸夹念兰映沟乙吗儒杀汽磷艰晶插埃燃欢铁补咱芽永瓦倾阵碳演威附牙芽永瓦斜灌欧献顺猪洋腐请透司危括脉宜笑若尾束壮暴企菜穗楚汉愈绿拖牛份染既秋遍锻玉夏疗尖殖井费州访吹荣铜沿替滚客召旱悟刺脑措贯藏敢令隙炉壳硫煤迎铸粘探临薄旬善福纵择礼愿伏残雷延烟句纯渐耕跑泽慢栽鲁赤繁境潮横掉锥希池败船假亮谓托伙哲怀割摆贡呈劲财仪沉炼麻罪祖息车穿货销齐鼠抽画饲龙库守筑房歌寒喜哥洗蚀废纳腹乎录镜妇恶脂庄擦险赞钟摇典柄辩竹谷卖乱虚桥奥伯赶垂途额壁网截野遗静谋弄挂课镇妄盛耐援扎虑键归符庆聚绕摩忙舞遇索顾胶羊湖钉仁音迹碎伸灯避泛亡答勇频皇柳哈揭甘诺概宪浓岛袭谁洪谢炮浇斑讯懂灵蛋闭孩释乳巨徒私银伊景坦累匀霉杜乐勒隔弯绩招绍胡呼痛峰零柴簧午跳居尚丁秦稍追梁折耗碱殊岗挖氏刃剧堆赫荷胸衡勤膜篇登驻案刊秧缓凸役剪川雪链渔啦脸户洛孢勃盟买杨宗焦赛旗滤硅炭股坐蒸凝竟陷枪黎救冒暗洞犯筒您宋弧爆谬涂味津臂障褐陆啊健尊豆拔莫抵桑坡缝警挑污冰柬嘴啥饭塑寄赵喊垫丹渡耳刨虎笔稀昆浪萨茶滴浅拥穴覆伦娘吨浸袖珠雌妈紫戏塔锤震岁貌洁剖牢锋疑霸闪埔猛诉刷狠忽灾闹乔唐漏闻沈熔氯荒茎男凡抢像浆旁玻亦忠唱蒙予纷捕锁尤乘乌智淡允叛畜俘摸锈扫毕璃宝芯爷鉴秘净蒋钙肩腾枯抛轨堂拌爸循诱祝励肯酒绳穷塘燥泡袋朗喂铝软渠颗惯贸粪综墙趋彼届墨碍启逆卸航衣孙龄岭骗休借',
            'length'          => 5,
            'width'           => 120,
            'height'          => 50,
            'isCaseSensitive' => false,
            // cacheType 存储类型，
            'cacheType'       => Constants::CACHE_TYPE_SESSION,
            'redisConfig'     => [
                'host'     => '127.0.0.1',
                'port'     => 6379,
                'password' => '',
                'db'       => 0
            ],
            'voiceLang'       => Constants::CHARS_TYPE_ZH,
            'voiceDir'        => '../../assets/voice/',
            'voiceTemp'       => '',
            // 语音配置
            'voiceS'          => 190, // 语数 175词/每分钟  范围 80 ~ 450
            'voiceP'          => 50,  // 音调 默认 0 ~ 99
            'voiceA'          => 100, // 音量 0~200
        ];

    /**
     * 架构方法 设置参数
     * @access public
     * @param array $config 配置参数
     */
    public function __construct($config = [])
    {
        $this->config = array_merge($this->config, $config);
        if ($this->cacheType === Constants::CACHE_TYPE_SESSION) {
            $this->sessionStart();
        } else {
            $this->redis = new \Redis();
            $this->redis->connect($this->redisConfig['host'], $this->redisConfig['port']);
            if (!empty($this->redisConfig['password'])) {
                $this->redis->auth($this->redisConfig['password']);
            }
            $this->redis->select($this->redisConfig['db']);
        }

    }

    /**
     * 使用 $this->name 获取配置
     * @access public
     * @param string $name 配置名称
     * @return mixed    配置值
     */
    public function __get($name)
    {
        return $this->config[$name];
    }

    /**
     * 设置验证码配置
     * @access public
     * @param string $name 配置名称
     * @param mixed $value 配置值
     * @return void
     */
    public function __set($name, $value)
    {
        if (in_array($name, ['bgRgb', 'bgBorderRgb'])) {
            if (is_array($value) && count($value) >= 2) {
                $value = $this->validateRgba(...$value);
            } else {
                throw new CaptchaException("RGBA 数组格式不正确，至少包含 r,g,b 值");
            }
        }

        if (isset($this->config[$name])) {
            $this->config[$name] = $value;
        }
    }

    /**
     * 检查配置
     * @access public
     * @param string $name 配置名称
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->config[$name]);
    }

    /**
     * 路径解析
     * @param string $path
     * @return false|string|null
     */
    public function resolvePath(string $path)
    {
        if (file_exists($path)) {
            return realpath($path);
        }

        $relativePath = __DIR__ . DIRECTORY_SEPARATOR . $path;
        if (file_exists($relativePath)) {
            return realpath($relativePath);
        }

        return null;
    }

    /**
     * 获取当前背景图片路径
     * @return string
     */
    public function getSrc(): string
    {

        if (is_string($this->images)) {
            $this->src = $this->images;
        } else {
            $this->src = $this->images[array_rand($this->images)];
        }

        return $this->src;
    }

    /**
     * 加载图像资源
     * @param string $path
     * @return bool|false|resource
     */
    public function loadImage(string $path)
    {
        if (!file_exists($path)) {
            return false;
        }
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        switch ($ext) {
            case 'png':
                return @imagecreatefrompng($path);
            case 'jpg':
            case 'jpeg':
                return @imagecreatefromjpeg($path);
            case 'gif':
                return @imagecreatefromgif($path);
            case 'webp':
                return function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($path) : false;
            default:
                return false;
        }
    }

    /**
     * 防止开启session报错
     */
    public function sessionStart()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * 将 GD 图像资源转换为 base64 PNG 图像
     * @param resource $img GD 图像资源
     * @return string base64 格式的 PNG 图片数据 URI
     */
    public function imageToBase64($img): string
    {
        ob_start();
        imagepng($img);         // 输出 PNG 到输出缓冲区
        $data = ob_get_clean(); // 获取并清空缓冲区内容
        imagedestroy($img);     // 释放图像资源
        return 'data:image/png;base64,' . base64_encode($data);
    }

    /**
     * 校验并格式化 RGBA 值
     *
     * @param int $r
     * @param int $g
     * @param int $b
     * @param int $opacity
     * @return array
     * @throws CaptchaException
     */
    protected function validateRgba(int $r, int $g, int $b, int $opacity = 0): array
    {
        foreach ([$r, $g, $b] as $value) {
            if ($value < 0 || $value > 255) {
                throw new CaptchaException("RGB 颜色值必须在 0-255 之间");
            }
        }

        if ($opacity < 0 || $opacity > 127) {
            throw new CaptchaException("透明度必须在 0-127 之间");
        }

        return [$r, $g, $b, $opacity];
    }

    /**
     * session Key
     * @return string
     */
    public function getSessionId()
    {
        $setKeyHash = md5($this->seKey . '_' . $this->id);
        $a          = substr($setKeyHash, 0, 16);
        $b          = substr($setKeyHash, 16, 32);
        $key        = md5($b . $a);
        return implode('-', str_split($key, 4));
    }

    /**
     * 缓存验证码
     * @param array $params
     * @return string
     * @throws \Exception
     */
    public function setCaptchaCache(array $params): string
    {
        $data = $params + ['expires_at' => time() + Constants::CACHE_TIME];
        if ($this->cacheType === Constants::CACHE_TYPE_SESSION) {
            $cacheId            = $this->getSessionId();
            $_SESSION[$cacheId] = $data;
            return $cacheId;
        } else {
            $cacheId = bin2hex(random_bytes(16));
            $success = $this->redis->setex($cacheId, Constants::CACHE_TIME, json_encode($data));
            if (!$success) {
                throw new CaptchaException('验证码缓存失败');
            }
            return $cacheId;
        }
    }

    /**
     * 获取缓存
     * @param string $cacheId
     * @return array
     */
    public function getCaptchaCache($cacheId = '')
    {
        if ($this->cacheType == Constants::CACHE_TYPE_SESSION) {
            $cacheId = $this->getSessionId();
            if (!isset($_SESSION[$cacheId])) {
                throw new CaptchaException('验证码不存在');
            }
            $data = $_SESSION[$cacheId];
            if ($data['expires_at'] < time()) {
                unset($_SESSION[$cacheId]);
                throw new CaptchaException('验证码已失效');
            }

        } else {
            if (empty($cacheId)) {
                throw new CaptchaException('缓存标识不能为空');
            }
            $data = $this->redis->get($cacheId);
            if (!$data) {
                throw new CaptchaException('缓存不存在');
            }
            $data = json_decode($data, true);
        }

        return $data + ['cache_id' => $cacheId];
    }

    /**
     * 删除缓存
     * @param $cacheId
     */
    public function delCache($cacheId)
    {
        if ($this->cacheType === Constants::CACHE_TYPE_SESSION) {
            unset($_SESSION[$cacheId]);
        } else {
            $this->redis->del($cacheId);
        }
    }

    /**
     * 设置背景
     * @param $image
     */
    protected function fillBackground($image)
    {
        // 设置背景
        $bgColor = imagecolorallocate($image, 255, 255, 255);
        imagefill($image, 0, 0, $bgColor);
    }
}
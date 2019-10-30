<?php
/**
 * Created by PhpStorm.
 * User: XueSiLf
 * Date: 2019/10/26
 * Time: 17:52
 */

namespace app\index\services;

use PHPMailer\PHPMailer\PHPMailer;
use think\Exception;

class Mail
{
    // 配置数组
    protected $config = [
        // smtp 服务器
        'Host' => 'smtp.qq.com',
        // 发送者的邮箱地址
        'From' => '1592328848@qq.com',
        // 发送邮件的用户昵称
        'FromName' => 'XueSiLf',
        // 登录到邮箱的用户名
        'Username' => '1592328848@qq.com',
        // 第三方登录的授权码，在邮箱里面设置
        'Password' => 'abcdefg'
    ];

    /**
     * 构造函数
     * Mail constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->config = array_merge($this->config, $config);
    }

    /**
     * 发送邮件处理
     * @param string $title 邮件标题
     * @param string $message 邮件内容
     * @param string $emailAddress 收件人
     */
    public function send($title = '测试内容', $message = '你好，最近在干嘛呢？', $emailAddress = '891157073@qq.com')
    {
        $mail = new PHPMailer();

        // 告诉服务器使用 smtp 协议发送
        $mail->isSMTP();
        // 开启 SMTP 授权验证
        $mail->SMTPAuth = true;
        // 使用 ssl 协议方式
        $mail->SMTPSecure = 'ssl';
        // 设置端口
        $mail->Port = 465;
        // 告诉我们的服务使用 qq 的 smtp 服务器发送
        $mail->Host = $this->Host;
        // 发送者的邮件地址
        $mail->From = $this->From;
        // 发件人的用户昵称
        $mail->FromName = $this->FromName;
        // 发件人的用户名
        $mail->Username = $this->Username;
        // 第三方登录的授权码，在邮箱里面设置
        $mail->Password = $this->Password;

        //$mail->setFrom($this->Username);

        //---编辑发送的邮件内容
        // 发送的内容使用 HTML 编写
        $mail->isHTML(true);
        // 设置发送内容的编码
        $mail->CharSet = 'utf-8';
        // 设置邮件的标题
        $mail->Subject = $title;
        // 发送的邮件内容主体
        $mail->msgHTML($message);
        // 收件人的邮件地址
        $mail->addAddress($emailAddress);

        // 调用方法，执行发送
        return $mail->send();
        // halt($mail->ErrorInf);
    }

    /**
     * 魔术方法 使用 $this->name 获取配置
     * @param $name 配置名称
     * @return mixed 配置值
     */
    public function __get($name)
    {
        return isset($this->config[$name]) ? $this->config[$name] : '';
    }

    /**
     * 魔术方法 检查配置
     * @param $name 配置名称
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->config[$name]);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: XueSiLf
 * Date: 2019/10/26
 * Time: 16:08
 */

namespace app\index\job;


use app\index\services\Mail;
use think\Exception;
use think\queue\Job;
use think\Log;

class sendActivationMail
{
    /**
     * fire 方法是消息队列默认调用的方法
     * @param Job $job 当前的任务对象
     * @param $data 发布任务时自定义的数据
     */
    public function fire(Job $job, $data)
    {
        // 执行发送邮件
        $isJobDone = $this->sendMail($data);

        // 如果发送成功 就删除队列
        if ($isJobDone) {
            print(date('Y-m-d H:i:s') . ": <warn>任务执行成功，已经删除!</warn>\n");
            $job->delete();
        } else {
            // 如果执行到这里的话，说明队列执行失败。
            // 如果失败三次就删除任务，否则重新执行
            print(date('Y-m-d H:i:s') . ": <warn>任务执行失败!</warn>\n");
            if ($job->attempts() > 3) {
                print("<warn>删除任务!</warn>\n");
            } else {
                $job->release(); // 重发任务
                print(date('Y-m-d H:i:s') . ": <info>重新执行! 第{$job->attempts()}次重新执行</info>\n");
            }
        }
    }

    /**
     * 发送邮件
     * @param  $data
     * @return boolean
     */
    public function sendMail($data)
    {
        # 调用自定义邮箱服务类
        $mail = new Mail();

        $title = '账号激活邮件';
        $msg = '欢迎您注册xxx网站，请您点击一个链接激活您的账号!......';
        try {
            return $mail->send($title, $msg, $data['email']);
        } catch (Exception $e) {
            return false;
        }
    }
}
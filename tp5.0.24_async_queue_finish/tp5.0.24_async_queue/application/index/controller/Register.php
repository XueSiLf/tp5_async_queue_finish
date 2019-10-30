<?php
/**
 * Created by PhpStorm.
 * User: XueSiLf
 * Date: 2019/10/26
 * Time: 16:23
 */
namespace app\index\controller;

use app\index\model\Member;
use app\index\services\Mail;
use think\Controller;
use app\index\validate\Register as RegisterValidate;
use think\Queue;
use think\Log;
use think\Config;

class Register extends Controller
{
    // 保存当前类对应的模型实例
    private $model = '';

    // 控制器初始化
    public function _initialize()
    {
        // 实例化用户模型
        $this->model = new Member();
    }

    /**
     * 渲染模板 展示注册页面
     * @return mixed
     */
    public function index()
    {
        /*$obj = new Mail();
        var_dump($obj->send());
        die;*/
        return $this->fetch();
    }

    /**
     * 注册逻辑处理
     */
    public function doRegister()
    {
        // 判断是 POST 提交
        if ($this->request->isPost()) {
            # 调用验证器实例化验证器类，执行验证，如果验证失败则跳转并且提示
            $validate = new RegisterValidate();
            # 获取 post 提交数据
            $data = input('post.');
            # 验证数据不合法
            if (!$validate->check($data)) {
                return $this->error($validate->getError());
            }

            // 此处应该加密码 md5 sha1 hash 都可以
            // 写入注册的用户
            //$result = $this->model->allowField(['email', 'password'])->save($data);
            $data = [
                'email' => trim($data['email']),
                'password' => trim($data['email']),
                'create_time' => time(),
            ];
            $result = $this->model->save($data);

            // 注册成功
            if ($result) {
                // 注册完毕后获取到邮件账号然后加入到队列
                $this->sendActionMail($this->model->email);
                return $this->success('注册成功，请前往邮箱激活您的账号!');
            } else {
                return $this->error('注册失败');
            }
        }
    }

    /**
     * @param string $email 邮箱账号
     * @return mixed
     */
    private function sendActionMail($email = '')
    {
        if (empty($email)) {
            return false;
        }

        // 负责处理队列任务的类
        $jobName = 'app\index\job\sendActivationMail';
        // 当前任务所需的业务数据
        $data = ['email' => $email];
        // 当前任务归属的队列名称，如果为新队列，会自动创建
        $jobQueueName = 'sendActivationMail';

        $result = Queue::push($jobName, $data, $jobQueueName);

        if ($result) {
            Log::write(date('Y-m-d H:i:s') . '一个新的队列任务');
        } else {
            Log::write(date('Y-m-d H:i:s') . '添加队列出错!!!');
        }

        // php think queue:work --queue sendActivationMail --daemon

    }
}

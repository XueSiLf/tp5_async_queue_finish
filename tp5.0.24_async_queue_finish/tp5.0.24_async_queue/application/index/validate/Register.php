<?php
/**
 * Created by PhpStorm.
 * User: XueSiLf
 * Date: 2019/10/26
 * Time: 16:08
 */

namespace app\index\validate;


use think\Validate;

class Register extends Validate
{
    protected $rule = [
        'email' => 'require|email|unique:member,email',
        'password' => 'require',
        'repassword' => 'require|confirm:password'
    ];
}
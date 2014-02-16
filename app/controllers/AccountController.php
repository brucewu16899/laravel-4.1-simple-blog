<?php

class AccountController extends BaseController
{
    /**
     * 页面：用户中心首页
     * @return Response
     */
    public function getIndex()
    {
        return View::make('account.index');
    }
    
    /**
     * 页面：修改当前账号密码
     * @return Response
     */
    public function getChangePassword()
    {
        return View::make('account.changePassword');
    }

    /**
     * 动作：修改当前账号密码
     * @return Response
     */
    public function putChangePassword()
    {
        // 获取所有表单数据.
        $data = Input::all();
        // 验证旧密码
        if (! Hash::check($data['password_old'], Auth::user()->password) )
            return Redirect::back()->withErrors($this->messages->add('password_old', '原始密码错误'));
        // 创建验证规则
        $rules = array(
            'password' => 'alpha_dash|between:6,16|confirmed',
        );
        // 自定义验证消息
        $messages = array(
            'password.alpha_dash' => '密码格式不正确。',
            'password.between'    => '密码长度请保持在:min到:max位之间。',
            'password.confirmed'  => '两次输入的密码不一致。',
        );
        // 开始验证
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->passes()) {
            // 验证成功
            // 更新用户
            $user = Auth::user();
            $user->password = Input::get('password');
            if ($user->save()) {
                // 更新成功
                return Redirect::back()
                    ->with('success', '<strong>密码修改成功。</strong>');
            } else {
                // 更新失败
                return Redirect::back()
                    ->withInput()
                    ->with('error', '<strong>密码修改失败。</strong>');
            }
        } else {
            // 验证失败，跳回
            return Redirect::back()->withInput()->withErrors($validator);
        }
    }

    /**
     * 页面：更改头像
     * @return Response
     */
    public function getChangePortrait()
    {
        return View::make('account.changePortrait');
    }

    /**
     * 动作：更改头像
     * @return Response
     */
    public function putChangePortrait()
    {
        // 
    }


}
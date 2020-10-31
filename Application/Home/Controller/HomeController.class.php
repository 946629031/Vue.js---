<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Controller;
use Think\Controller;
header('content-type: text/html; charset=utf-8');
/**
 * 前台公共控制器
 * 为防止多分组Controller名称冲突，公共Controller名称统一使用分组名称
 */
class HomeController extends Controller {

	/* 空操作，用于输出404页面 */
	public function _empty(){
		$this->redirect('Index/index');
	}

    protected function _initialize(){
        if(isMobile()){
            // header("location:http://m.gdtata.com".$_SERVER['REQUEST_URI']);
        }
        /* 读取站点配置 */
        $config = api('Config/lists');
        C($config); //添加配置

        if(!C('WEB_SITE_CLOSE')){
            $this->error('站点已经关闭，请稍后访问~');
        }
        $this->_init();
    }

    private function _init()
    {
        //如果已经登陆，则跳转到登陆页面
        // $isLogin = $this->isLogin();
        // if (!$isLogin) {
        //     $this->redirect('login/index');
        // }
    }
    /*
        获取用户信息
        @return array
    */
    public function getLoginUser()
    {
        return session("adminUser");
    }
    /*
        判定是否登陆
    */
    public function isLogin()
    {
        $user = $this->getLoginUser();
        if ($user && is_array($user)) {
            return true;
        }
        return false;
    }







	

}

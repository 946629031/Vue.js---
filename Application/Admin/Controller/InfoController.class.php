<?php

namespace Admin\Controller;
use User\Api\UserApi;
header('content-type: text/html; charset=utf-8');

class InfoController extends AdminController{
    public function index(){
        $notice = D('notice');
        if(IS_POST){
            $data = I('post.');
            
            // 先全部删除
            $old = $notice->select();
            foreach($old as $v) $curr_id[] = $v['id'];
            $id = array('id'=>array('IN',$curr_id));
            $notice->where($id)->delete();

            // 然后在新增  提交的内容
            foreach($data['content'] as $val){
                $info['content'] = $val;
                $notice->add($info);
            }
            $this->success('修改成功');
            return;
        }

        $notice = $notice->select();
        $this->assign('notice',$notice);
        $this->display();
    }

    public function copyright (){
        $copyright = D('copyright');
        if(IS_POST){
            $data = I();
            // var_dump($data);exit;
            if($copyright->create($data)){
                if($copyright->where('id=1')->save()){
                    $this->success('修改成功');
                }else{
                    $this->error('修改失败');
                }
            }else{
                $this->error($copyright->getError());
            }
            return;
        }
        $data = $copyright->select();
        $this->assign('copyright',$data);
        
            // var_dump($data);exit;
        $this->display();
    }






}
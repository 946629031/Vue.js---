<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Admin\Controller;
use User\Api\UserApi;

class CateController extends AdminController {

    public function index()
    {
        $cate = M('Cate');
        $cres = $cate->order('id desc')->select();
        // print_r($cres);die;

        $advertisement = M('advertisement');
        $ad_result = $advertisement->select();
        $this->assign('ad_result',$ad_result);

        $this->assign('cres',$cres);
        $this->display();
    }
    public function add()
    {
        $gcate = D('Cate');
        if (IS_POST) {

            $advertisement = D('advertisement');
            $data['ad_name'] = I('ad_name');
            $data['img_address'] = I('img_address');
            $data['ad_href'] = I('ad_href');
            $data['type'] = I('type');

            if($advertisement->create()){
                if($advertisement->add()){
                    $this->success('添加成功','./index');
                }else{
                    $this->error('添加失败');
                }
            }else{
                $this->error($advertisement->getError());
            }



            // if ($gcate->create()) {
            //     if ($gcate->add()) {
            //         $this->success('添加成功');
            //     }else{
            //         $this->error('添加失败');
            //     }
            // }else{
            //     $this->error($gcate->getError());
            // }
        }
        $rcate = $gcate->getCate();
        $this->assign('rcate',$rcate);
        $this->display();
    }
    public function edit()
    {
        $advertisement = D('advertisement');
        if (IS_POST) {
            $data['id']          = $_POST['id'];
            $data['ad_name']     = $_POST['ad_name'];
            $data['img_address'] = $_POST['img_address'];
            $data['ad_href']     = $_POST['ad_href'];
            $data['type']        = $_POST['type'];
            if ($advertisement->create($data)) {
                if ($advertisement->save()) {
                    $this->success('修改成功');
                }else{
                    $this->error('修改失败 或 未作任何修改');
                }
            }else{
                $this->error($advertisement->getError());
            }
        }
        $ad = $advertisement->find($_GET['id']);
        $this->assign('ad',$ad);
        // $rcate = $advertisement->getCate();
        // $this->assign('editres',$editres);
        // $this->assign('rcate',$rcate);
        $this->display();

        // $gcate = D('Cate');
        // if (IS_POST) {
        //     if ($gcate->create()) {
        //         if ($gcate->save()) {
        //             $this->success('修改成功');
        //         }else{
        //             $this->error('修改失败');
        //         }
        //     }else{
        //         $this->error($gcate->getError());
        //     }
        // }
        // $editres = $gcate->find($_GET['id']);
        // $rcate = $gcate->getCate();
        // $this->assign('editres',$editres);
        // $this->assign('rcate',$rcate);
        // $this->display();
    }
    public function del()
    {
        $ids = I('id');
        // var_dump(I('id'));exit;
        if(is_array($ids)) $ids = implode(',',$ids);
        $advertisement = D("advertisement")->delete($ids);
        if ($advertisement) {
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }














}

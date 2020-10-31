<?php
namespace Home\Controller;
use OT\DataDictionary;
header('Content-Type: text/html; charset=utf-8');

class TicketController extends HomeController {
    public function index(){

        // $tic = M("ticket");
        // $tlist = $tic->select();
        // $adminUser = session("adminUser");
        // // print_r($adminUser);die;
        // foreach ($tlist as $k => $v) {
        //     if ($adminUser['group'] =="") {
        //         // echo 1;die;
        //         $dailiprice = M("dailiprice")->where(['xiaji_id'=>$adminUser['id'],'p_id'=>$v['t_id']])->find();
        //         if ($dailiprice) {
        //             if ($adminUser['level'] == 2) {
        //                 $tlist[$k]['erji_price'] = $dailiprice['erji_price']; 
        //             }elseif ($adminUser['level'] == 3) {
        //                 $tlist[$k]['sanji_price'] = $dailiprice['sanji_price'];
        //             }elseif ($adminUser['level'] == 1) {
        //                 $tlist[$k]['yiji_price'] = $dailiprice['yiji_price']; 
                        
        //             }
        //         }
        //     }else{
        //         // echo 2;die;
        //         $dailiprice = M("groupprice")->where(['g_id'=>$adminUser['group'],'tic_id'=>$v['t_id']])->find();
        //         if ($dailiprice) {
        //             if ($adminUser['level'] == 2) {
        //                 $tlist[$k]['erji_price'] = $dailiprice['erji_price']; 
        //             }elseif ($adminUser['level'] == 3) {
        //                 $tlist[$k]['sanji_price'] = $dailiprice['sanji_price']; 
        //             }elseif ($adminUser['level'] ==1) {
        //                 $tlist[$k]['yiji_price'] = $dailiprice['yiji_price']; 
        //             }
        //         }
        //     }
        // }

        
        // 站点分类
        $type = M('type');
        $type = $type->select();
        $this->assign('type',$type);
        
        // 系统公告
        $notice = M('notice');
        $notice = $notice->select();
        $this->assign('notice',$notice);

        // 备案
        $copyright = M('copyright');
        $copyright = $copyright->select();
        $this->assign('copyright',$copyright);

        // seo内容
        $seo = M('ticket');
        $seo = $seo->select();
        $this->assign('seo',$seo);

        //內容引流項目添加項目
        $flow = M('flow');
        $flow = $flow->where('status=1')->select();
        $this->assign('flow',$flow);

        //自定义JS代码
        $add_js = M('add_js');
        $add_js = $add_js->select();
        $this->assign('add_js',$add_js);

        // =====================网站导航 start=====================

        $scenic = M('scenic');
        $result = $scenic->select();
        // var_dump($result);exit;
        foreach($result as $key => $val){
            $web_list[$key]['web_name'] = $val['scenic_name'];
            $web_list[$key]['web_img'] = $val['spic'];
            $web_list[$key]['web_address'] = $val['supplier_address'];
            $web_list[$key]['web_more_address'] = $val['more_address'];
        }
        $this->assign('web_list',$web_list);


        $advertisement = M('advertisement');
        $ad_left   = $advertisement->where('type="left"')->select();
        $ad_middle = $advertisement->where('type="middle"')->select();
        $ad_right  = $advertisement->where('type="right"')->select();
        $ad_middle_big  = $advertisement->where('type="middle_big"')->select();
        $ad_middle_top  = $advertisement->where('type="middle_top"')->select();
        $this->assign('ad_left',$ad_left);
        $this->assign('ad_middle',$ad_middle);
        $this->assign('ad_right',$ad_right);
        $this->assign('ad_middle_big',$ad_middle_big);
        $this->assign('ad_middle_top',$ad_middle_top);
        // =====================网站导航 end=====================


        // $this->assign('adminuser',$adminUser);
        // $this->assign("tic",$tlist);
        $this->display();
    }
    public function showtype(){
        $url = $_SERVER['QUERY_STRING'];
        $type_id = explode('=',$url)[0];    // 获取分类id
        $type_id = intval($type_id);


        $type = I('first_char');    // 首字母
        $keyword = I('keyword');    // 搜索关键词
        $scenic = M('scenic');

        // 如果 $type_id 是整数  则是请求type类型，否则就是请求其他类型
        if($type_id){
            $result = $scenic->where('type='.$type_id)->select();
            $this->assign('web_list',$result);
            // echo 'type_id';exit;
        }else{

            $term = array();
            if(!empty($type)){
                if($type=='全部'){
                }else if($type=='数字'){
                    $term['first_char'] = array('IN',array(1,2,3,4,5,6,7,8,9,10));
                }else{
                    $term['first_char'] = $type;
                }
            }
            if(!empty($keyword)){
                $term['scenic_name'] = array('like','%'.$keyword.'%');
            }
    
            if(!empty($term)) $scenic = $scenic->where($term);
            $result = $scenic->select();
            // echo 'other_type';exit;
        }
        // var_dump($type_id);exit;


        
        
        foreach($result as $key => $val){
            $web_list[$key]['web_name'] = $val['scenic_name'];
            $web_list[$key]['web_img'] = $val['spic'];
            $web_list[$key]['web_address'] = $val['supplier_address'];
            $web_list[$key]['web_more_address'] = $val['more_address'];
        }
        $this->assign('web_list',$web_list);


        // =====================广告图 end=====================
        $advertisement = M('advertisement');
        $ad_left   = $advertisement->where('type="left"')->select();
        $ad_middle = $advertisement->where('type="middle"')->select();
        $ad_right  = $advertisement->where('type="right"')->select();
        $ad_middle_big  = $advertisement->where('type="middle_big"')->select();
        $this->assign('ad_left',$ad_left);
        $this->assign('ad_middle',$ad_middle);
        $this->assign('ad_right',$ad_right);
        $this->assign('ad_middle_big',$ad_middle_big);
        // =====================广告图 end=====================
                
        // 站点分类
        $type = M('type');
        $type = $type->select();
        $this->assign('type',$type);

        // 系统公告
        $notice = M('notice');
        $notice = $notice->select();
        $this->assign('notice',$notice);

        // 备案
        $copyright = M('copyright');
        $copyright = $copyright->select();
        $this->assign('copyright',$copyright);

        // seo内容
        $seo = M('ticket');
        $seo = $seo->select();
        $this->assign('seo',$seo);

        //內容引流項目添加項目
        $flow = M('flow');
        $flow = $flow->where('status=1')->select();
        $this->assign('flow',$flow);

        //自定义JS代码
        $add_js = M('add_js');
        $add_js = $add_js->select();
        $this->assign('add_js',$add_js);


        $this->display('index');
    }













}
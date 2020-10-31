<?php
namespace Admin\Controller;
use User\Api\UserApi;
header('content-type: text/html; charset=utf-8');

class TicketController extends AdminController {

    public function index(){
        if ($_POST) {
            // var_dump($_POST);exit;
            $ticket = D('flow');
            if ($ticket->create()) {
                if ($ticket->add()) {
                    $this->success('添加成功');
                }else{
                    $this->error('添加失败');
                }
            }else{
                $this->error($ticket->getError());
            }
            return;
        }
        $flow = M('flow'); // 实例化User对象
        $flow = $flow->select();
        // $count      = $ticket->count();// 查询满足要求的总记录数
        // $Page       = new \Think\Page($count,3);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        // $show       = $Page->show();// 分页显示输出
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        // $list = $ticket->join('onethink_scenic on onethink_scenic.id=onethink_ticket.scenic_id')->order('t_id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('flow',$flow);// 赋值数据集
        // $this->assign('page',$show);// 赋值分页输出
        $this->display(); // 输出模板
    }
    /*
        SEO内容
    */
    public function add(){
        if ($_POST) {
            // var_dump($_POST);exit;
            $ticket = D('flow');
            if ($ticket->create()) {
                if ($ticket->add()) {
                    $this->success('修改成功','../../index');
                }else{
                    $this->error('修改失败');
                }
            }else{
                $this->error($ticket->getError());
            }
            return;
        }
        $this->display();
    }
    /*
        门票删除
    */
    public function tdel(){
        if(!$_GET['id']){
            return '';
        }
        $ticket = D("flow")->where('id='.$_GET['id'])->delete();
        if ($ticket) {
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }
    /*
        门票修改
    */
    public function edit(){
        $flow = D('flow');
        if ($_POST) {
            if ($flow->create()) {
                if ($flow->where('id='.$_POST['id'])->save()) {
                    $this->success('修改成功');
                }else{
                    $this->error('未作任何修改 或 修改失败');
                }
            }else{
                $this->error($flow->getError());
            }
            return;
        }
        $flow = D('flow');
        $flow = $flow->where('id='.$_GET['id'])->find();
        $this->assign('flow',$flow);
        $this->display();
    }




    // 站点分类
    public function type(){
        // var_dump($data);exit;
        $type = D('type');
        $type = $type->select();
        $this->assign('type',$type);
        $this->display();
    }

    // 新增站点分类
    public function type_add(){
        if(IS_POST){
            $data = I('post.name');
            $type = D('type');
            if($type->create()){
                if($type->add()){
                    $this->success('添加成功','./type');
                }else{
                    $this->error('添加失败');
                }
            }else{
                $this->error($type->getError());
            }
            return;
        }
        $this->display();
    }
    // 删除站点分类
    public function type_del(){
        $id = I('get.id');
        if(!$id) return '';
        if(IS_GET){
            $data = 'id='.$id;
            $type = D('type');

            if($type->where($data)->delete()){
                $this->success('删除成功','./type');
            }else{
                $this->error('删除失败');
            }
            return;
        }
    }
    // 修改站点分类
    public function type_edit(){
        $id = I('get.id');
        $type = D('type');

        if(IS_POST){
            $data = I('post.');
            if($type->create()){
                if($type->save()){
                    $this->success('修改成功');
                }else{
                    $this->error('修改失败');
                }
            }else{
                $this->error($type->getError());
            }
        }

        $result = $type->where('id='.$id)->select();
        $this->assign('result',$result);
        // var_dump($result);exit;
        $this->display();
    }






    /*
        SEO内容
    */
    public function seo(){
        if ($_POST) {
            $ticket = D('Ticket');
            // $_POST['t_id'] = 31;
            if ($ticket->create()) {
                if ($ticket->where('t_id=31')->save()) {
                    $this->success('修改成功');
                }else{
                    $this->error('未做任何修改 或 修改失败');
                }
            }else{
                $this->error($ticket->getError());
            }
            return;
        }
        $seo = D('Ticket');
        $seo = $seo->select();
        $this->assign('seo',$seo);
        $this->display();
    }
    /* 
        自定义js代码 
    */
    public function add_js(){
        $add_js = M('add_js');
        if($_POST){
            // var_dump($_POST);exit;
            if($add_js->create()){
                if($add_js->where('id='.$_POST['id'])->save()){
                    $this->success('修改成功');
                }else{
                    $this->error('未做任何修改 或 修改失败');
                }
            }else{
                $this->error($add_js->getError());
            }
            return;
        }
        $add_js = $add_js->select();
        $this->assign('add_js',$add_js);
        $this->display();
    }
    /*
        门票详情
    */
    public function detail()
    {
        $ticket = M("ticket");
        $tinfo = $ticket->join('onethink_scenic on onethink_scenic.id=onethink_ticket.scenic_id')->find($_GET['id']);
        // print_r($tinfo);die;
        $this->assign('tinfo',$tinfo);
        $this->display();
    }

    /*
        图片上传
    */
    public function imageUpload()
    {
        // var_dump($_FILES);exit;
        if (isset($_POST['session'])){ 
            session_id($_POST['session']); 
            session_start();//注意此函数要在session_id之后 
        } 
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
        $upload->subName   =     date(Y) . '/' . date(m) .'/' . date(d);
        // 上传文件 
        $info   =   $upload->upload();
        // var_dump($info);exit;
        if(!$info) {// 上传错误提示错误信息
            // $this->ajaxReturn($msg=$info);
            $this->error($upload->getError());
        }else{// 上传成功
            $data = '/Uploads/'.$info['file']['savepath'] . $info['file']['savename'];
            $this->success('上传成功！',$data);
            // $this->ajaxReturn($data);
        }
    }
    /*
        景区添加
    */
    public function sadd()
    {
        if (IS_POST) {
            $data['sheng'] = M('region')->where(['id'=>$_POST['sheng']])->getField('name');
            $data['shi'] = M('region')->where(['id'=>$_POST['shi']])->getField('name');
            $data['scenic_name']      = $_POST['scenic_name'];
            $data['s_level']          = $_POST['s_level'];
            $data['spic']             = $_POST['spic'];
            $data['intro']            = $_POST['intro'];
            $data['reservation_note'] = $_POST['reservation_note'];
            $data['traffic_info']     = $_POST['traffic_info'];
            $data['supplier']         = $_POST['supplier'];
            $data['supplier_address'] = $_POST['supplier_address'];
            $data['more_address']     = implode(',',$_POST['more_address']);
            $data['first_char'] = $this->getFirstChar($data['scenic_name']);
            $data['s_area']           = $data['sheng'].'-'.$data['shi'];
            $data['type']             = $_POST['type'];
            $scenic = D('Scenic');
            if ($scenic->create($data)) {
                if ($scenic->add()) {
                    $this->success('添加成功',U('/Admin/ticket/sindex'));
                }else{
                    $this->error('添加失败');
                }
            }else{
                $this->error($scenic->getError());
            }
        }
        $model_region = M('region');
        $area_info = $model_region -> where(array('pid' => 1)) -> select();
        $this -> assign('area_info',$area_info);

        $type = D('type')->select();
        $this->assign('type',$type);
        $this->display();
    }
    /*
        景区列表
    */
    public function sindex()
    {
        $ticket = D('Scenic'); 
        $count      = $ticket->count();
        $Page       = new \Think\Page($count,10);
        $show       = $Page->show();
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $list = $ticket->relation('type')->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
        // print_r($list);exit;
        $this->assign('list',$list);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出

        $type = D('type')->select();
        $this->assign('type',$type);
        // var_dump($type);exit;

        $this->display(); // 输出模板
    }
    /*
        景区编辑
    */
    public function sedit()
    {
        if (IS_POST) {
            $data['id']               = $_POST['id'];
            $data['scenic_name']      = $_POST['scenic_name'];
            $data['s_level']          = $_POST['s_level'];
            $data['spic']             = $_POST['spic'];
            $data['intro']            = $_POST['intro'];
            $data['reservation_note'] = $_POST['reservation_note'];
            $data['traffic_info']     = $_POST['traffic_info'];
            $data['supplier']         = $_POST['supplier'];
            $data['supplier_address'] = $_POST['supplier_address'];
            $data['s_area']           = $_POST['s_area'];
            $data['first_char'] = $this->getFirstChar($data['scenic_name']);
            $data['type']             = $_POST['type'];
            $scenic = D('Scenic');
            if ($scenic->create($data)) {
                if ($scenic->save()) {
                    $this->success('修改成功',U('/Admin/ticket/sindex'));
                }else{
                    $this->error('修改失败');
                }
            }else{
                $this->error($ticket->getError());
            }
        }
        $scenic = D('Scenic')->getEditInfo($_GET['id']);
        $this->assign('scenic',$scenic);

        $type = D('type')->select();
        $this->assign('type',$type);

        $this->display();
    }
    public function del()
    {
        $ids = I('id');
        if(is_array($ids)) $ids = implode(',',$ids);
        $scenic = D("Scenic")->delete($ids);
        if ($scenic) {
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }
    //网站归类
    public function set_type_into(){
        $ids = I('POST.ids');
        if(is_string($ids)) $ids = explode(',',$ids);   // 拿到选中的 id , array
        $scenic = D('Scenic');

        $select = I('POST.select'); // 要归类到 xx分类的 id
        $data_id = array('id'=>array('IN',$ids));
        $set_type['type'] = $select;

        $sql = $scenic->where($data_id)->save($set_type);
        if($sql){
            $this->success('归类成功', U('/Admin/ticket/sindex'));
        }else{
            $this->error('归类失败');
        }
        // return;
    }
    /*
        省、市--选择
    */
    public function find_address(){
        $pid = $_POST['pid'];
        $model_region = M('region');
        $area_info = $model_region -> where(array('pid' => $pid)) -> select();
        $this -> ajaxReturn($area_info);
    }

    public function menpiao()
    {
        $arr = piaofutong("Get_Ticket_List",array("ac"=>"100019","pw"=>"jjl4yk11f82ce6c0f33a5c003f2fec56","n"=>$_POST['scenicp_id'],'m'=>""));
        $cup = array();
        foreach ($arr as $k => $v) {
            $cup= $v;
        }
        $this -> ajaxReturn($cup);
    }
    public function menpiao_info(){
        $arr = piaofutong("Get_Ticket_List",array("ac"=>"100019","pw"=>"jjl4yk11f82ce6c0f33a5c003f2fec56","n"=>'','m'=>$_POST['menpiao']));
        
        $this -> ajaxReturn($arr['Rec']);
    }

    /**
     * 取字符串，包括汉字的第一个字的首字母
     */
    function getFirstChar($str){
        if(empty($str)){return '';}
        $fchar=ord($str{0});
        if($fchar==ord('0')) return 10;
        if($fchar>=ord('1')&&$fchar<=ord('9')) return $str{0};
        if($fchar>=ord('A')&&$fchar<=ord('z')) return strtoupper($str{0});
        $s1=iconv('UTF-8','gb2312',$str);
        $s2=iconv('gb2312','UTF-8',$s1);
        $s=$s2==$str?$s1:$str;
        $asc=ord($s{0})*256+ord($s{1})-65536;
        if($asc>=-20319&&$asc<=-20284) return 'A';
        if($asc>=-20283&&$asc<=-19776) return 'B';
        if($asc>=-19775&&$asc<=-19219) return 'C';
        if($asc>=-19218&&$asc<=-18711) return 'D';
        if($asc>=-18710&&$asc<=-18527) return 'E';
        if($asc>=-18526&&$asc<=-18240) return 'F';
        if($asc>=-18239&&$asc<=-17923) return 'G';
        if($asc>=-17922&&$asc<=-17418) return 'H';
        if($asc>=-17417&&$asc<=-16475) return 'J';
        if($asc>=-16474&&$asc<=-16213) return 'K';
        if($asc>=-16212&&$asc<=-15641) return 'L';
        if($asc>=-15640&&$asc<=-15166) return 'M';
        if($asc>=-15165&&$asc<=-14923) return 'N';
        if($asc>=-14922&&$asc<=-14915) return 'O';
        if($asc>=-14914&&$asc<=-14631) return 'P';
        if($asc>=-14630&&$asc<=-14150) return 'Q';
        if($asc>=-14149&&$asc<=-14091) return 'R';
        if($asc>=-14090&&$asc<=-13319) return 'S';
        if($asc>=-13318&&$asc<=-12839) return 'T';
        if($asc>=-12838&&$asc<=-12557) return 'W';
        if($asc>=-12556&&$asc<=-11848) return 'X';
        if($asc>=-11847&&$asc<=-11056) return 'Y';
        if($asc>=-11055&&$asc<=-10247) return 'Z';
        return null;
    }


















}

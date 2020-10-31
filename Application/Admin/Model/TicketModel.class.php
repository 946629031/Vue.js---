<?php
namespace Admin\Model;
use Think\Model;

class TicketModel extends Model {

    // protected $_validate = array(
    //     array('scenic_id','require','景区必须选择'), 
    //     array('ticket_name','require','门票必须填写！'), 
    //     array('pay_type','require','支付方式必须填写！'), 
    //     array('ticket_number','require','票号必须填写！'), 
    //     array('menshi_price','require','门市价必须填写！'), 
    //     array('jiesuan_price','require','结算价必须填写！'), 
    // );

    /*
        删除景区信息
    */
    public function delTicket($value)
    {
        if (!$value) {
            return '';
        }
        return $this->delete($value);
    }

}

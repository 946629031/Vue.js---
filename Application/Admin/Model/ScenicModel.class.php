<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com>
// +----------------------------------------------------------------------

namespace Admin\Model;
use Think\Model\RelationModel;

class ScenicModel extends RelationModel {
    
	protected $_validate = array(
        array('scenic_name','require','站点名称必须填写！'), 
        array('s_area','require','地点必须填写！'), 
        array('s_level','require','等级必须填写！'),
        // array('spic','require','图片必须上传'), 
        array('supplier','require','供应商必须填写！'), 
        array('supplier_address','require','网站地址必须填写！'), //默认情况下用正则进行验证
        array('intro','require','介绍必须填写'), 
	);
	protected $_link = array(
        'type' => array(
            'mapping_type' => self::BELONGS_TO,
            'class_name'   => 'type',
            'foreign_key' => 'type'
        )
    );
	/*
		修改景区信息
	*/
	public function getEditInfo($id="")
	{
		if (!$id) {
			return '';
		}
		return $this->find($id);
	}
	/*
		删除景区信息
	*/
	public function delScenic($value)
	{
		if (!$value) {
			return '';
		}
		return $this->delete($value);
	}
	/*
		查找景区信息
	*/
	public function findScenic()
	{
		return $this->select();
	}





















}

<?php

namespace Home\Model;
use Think\Model\RelationModel;

class ScenicModel extends RelationModel{
    
    protected $_link = array(
        'type' => array(
            'mapping_type' => self::BELONGS_TO,
            'class_name'   => 'type',
            'foreign_keys' => 'id',
        )
    );


















}
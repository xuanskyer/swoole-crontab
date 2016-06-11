<?php
/**
 * Created by PhpStorm.
 * User: xuanskyer <furthestworld@icloud.com>
 * Time: 2016-06-09 14:23
 */

class SwooleTable
{
    public static $Instance;
    public static $column_config = array(
        'taskname' => array('type' => swoole_table::TYPE_STRING, 'len' => 64),
        'rule' => array('type' => swoole_table::TYPE_STRING, 'len' => 64),
        'unique' => array('type' => swoole_table::TYPE_INT, 'len' => 64),
        'execute' => array('type' => swoole_table::TYPE_STRING, 'len' => 64),
        'status' => array('type' => swoole_table::TYPE_INT, 'len' => 4)
    );

    public static function getInstance(){
        if(!self::$Instance){
            self::$Instance = new swoole_table(1024 * 8);
            foreach(self::$column_config as $field_name => $field_setting){
                self::getInstance()->column($field_name, $field_setting['type'], $field_setting['len']);
            }
            self::$Instance->create();
        }
        return self::$Instance;
    }

    public static function set($key = '', $data = ''){
        $res = false;
        if(!empty($key) && is_array($data) && !empty($data)){
            foreach($data as $k => $v){
                $serialize_data[$k] = serialize($v);
            }
            $res = self::getInstance()->set($key, $serialize_data);
        }
        return $res;
    }

    public static function get($key = ''){
        $unserialize_res = false;
        if(!empty($key)){
            $res = self::getInstance()->get($key);
            if(!empty($res)){
                foreach($res as $key => $val){
                    $unserialize_res[$key] = is_string($val) ? unserialize($val) : $val;
                }
            }
        }
        return $unserialize_res;
    }
}


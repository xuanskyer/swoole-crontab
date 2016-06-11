<?php
/**
 * Created by PhpStorm.
 * User: xuanskyer <furthestworld@icloud.com>
 * Time: 2016-06-09 14:23
 */

class SwooleTable
{
    public static $Instance;
    /**
     * 任务属性结构
     * {
     *   "unique_name": "唯一任务名",
     *   "basic" : {
     *     "name"  : "名字",
     *     "desc"  : "描述",
     *     "created_time" :  "创建时间",
     *     "updated_time"  : "更新时间",
     *     "owner" : "脚本所属人"
     *   },
     *
     *   "system" : {
     *     "cmd" : "脚本命令",
     *     "args": "脚本参数",
     *     "rule": "执行规则",
     *     "node"  : {
     *          "node1" : {
     *          "pid" : "进程ID",
     *          "pname" : "进程名称",
     *          "ip" : "要运行的机器"
     *       },
     *
     *       "node2" : {
     *          "pid" : "进程ID",
     *          "pname" : "进程名称",
     *          "ip" : "要运行的机器"
     *       }
     *     }
     *   },
     *
     *   "status": {
     *     "0" : "出生",
     *     "1" : "运行成功",
     *     "2" : "运行失败",
     *     "3" : "运行超时",
     *     "4" : "等待运行",
     *     "99" : "死亡"
     *   },
     *
     *   "action": {
     *     "0-4" : "修改状态：从 出生 到 等待运行",
     *     "0-5" : "修改状态：从 出生 到 死亡",
     *     "1-4" : "修改状态：从 成功 到 等待运行",
     *     "1-99": "修改状态：从 成功 到 死亡",
     *     "2-4" : "修改状态：从 失败 到 等待运行",
     *     "2-99": "修改状态：从 失败 到 死亡",
     *     "3-4" : "修改状态：从 超时 到 等待运行",
     *     "3-99" : "修改状态：从 超时 到 死亡",
     *     "4-1" : "修改状态：从 等待运行 到 成功",
     *     "4-2" : "修改状态：从 等待运行 到 失败",
     *     "4-3" : "修改状态：从 等待运行 到 超时",
     *     "4-99" : "修改状态：从 等待运行 到 死亡",
     *     "自定义" : ""
     *   } ,
     *
     *   "statistic":  {
     *     "total" : "总运行次数",
     *     "success" : "成功运行次数",
     *     "error" : "失败运行次数",
     *     "timeout" : "运行超时次数"
     *   }
     * }
     * @var array
     */
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


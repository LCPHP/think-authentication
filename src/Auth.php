<?php
namespace niklaslu;

use think\Db;
use think\Config;
class Auth {
    
    protected $open = 1;
    
    protected $type = 1;
    
    protected $tableUser = 'user';
    
    protected $tableGroup = 'auth_group';
    
    protected $tableUserGroup = 'auth_user_group';
    
    protected $tableAuthRule = 'auth_rule';
    
    protected $dbTablePrefix = 'think_';
    
    protected $errorCode = 0;
    
    protected $errorMsg = '';
    
    public function __construct($config = null){
        
        $this->open = isset($config['is_open']) ? $config['is_open'] : $this->open;
        $this->type = isset($config['type']) ? $config['type'] : $this->type;
        $this->tableUser = isset($config['table_user']) ? $config['table_user'] : $this->tableUser;
        $this->tableGroup = isset($config['table_group']) ? $config['table_group'] : $this->tableGroup;
        $this->tableAuthRule = isset($config['table_auth_rule']) ? $config['table_auth_rule'] : $this->tableAuthRule;
        $this->tableUserGroup = isset($config['table_user_group']) ? $config['table_user_group'] : $this->tableUserGroup;
        $this->dbTablePrefix = Config::get('database.prefix') ? Config::get('database.prefix') : $this->dbTablePrefix;
        
    }
    
    /**
     * 获取用户组ids
     * @param int $uid 用户id
     * @return array 用户组id数组
     */
    public function getGroupIds($uid){
        
        $groupIds = Db::table($this->dbTablePrefix . $this->tableUserGroup)
                    ->where('user_id',$uid)
                    ->column('group_id');
        
        return $groupIds;
    }
    
    /**
     * 获取用户组信息
     * @param int $uid 用户id
     */
    public function getGroup($uid){
        
        $groupIds = $this->getGroupIds($uid);
        
        $groups = DB::table($this->dbTablePrefix . $this->tableGroup)
                    ->where('id' , 'in' , $groupIds)
                    ->where('status' , '1')
                    ->order('sort asc')
                    ->select();
        
        return $groups;
        
    }
    
    /**
     * 获取用户权限
     * @param unknown $uid
     */
    public function getRuleIds($uid){
        
        $groups = $this->getGroup($uid);
        
        $rules = [];
        foreach ($groups as $g){
            $rule = $g['rules'] ? explode(',', $g['rules']) : '';
            if ($rule){
                $rules = array_merge($rules , $rule);
            } 
        }
        
        return $rules;
    }
    
    /**
     * 获取用户权限信息
     * @param int $uid
     * @return array
     */
    public function getRules($uid){
        
        $ruleIds = $this->getRuleIds($uid);
        
        $rules = DB::table($this->dbTablePrefix . $this->tableAuthRule)
                ->where('id' , 'in' , $ruleIds)
                ->where('status' , '1')
                ->order('sort asc')
                ->select();
        
        return $rules;
    }
    
    /**
     * 通过名称标识获取规则信息
     * @param string $name
     * @return array
     */
    public function getRule($name){
        
        $rule = DB::table($this->dbTablePrefix . $this->tableAuthRule)->where('name' , $name)->where('status' , '1')->find();
        
        return $rule;
    }
    
    /**
     * 验证规则
     * @param string $name 规则名称
     * @param int $uid 用户id
     */
    protected function checkRule($name , $uid){
        
        $rule = $this->getRule($name);
        
        if (!$rule){
            $this->errorCode = '100001';
            $this->errorMsg = '验证规则不存在';
            
            return false;
        }else{
            $ruleIds = $this->getRuleIds($uid);
            $ruleId = $rule['id'];
            
            $check = in_array($ruleId , $ruleIds);
            if ($check){
                
                return true;
            }else{

                $this->errorCode = '100002';
                $this->errorMsg = '验证规则无权限';
                return false;
            }
            
        }
    }
    
    /**
     * 
     * @param string $name 规则名称,多个用，隔开
     * @param int $uid 用户id
     * @param string $tpye and:且关系 or: 或关系
     */
    public function check($name , $uid , $relation = 'and'){
        
        if ($this->open == 0){
            return true;    
        }
        
        if ($name === ''){
            
            $this->errorCode = '100003';
            $this->errorMsg = '验证规则名称不符合要求';
            return false;
        }
        
        $names = explode(',', $name);
        $check = [];
        foreach ($names as $v){
            $check[$v] = $this->checkRule($v, $uid);
        }
        
        if ($relation == 'and'){
            $result = true;
            foreach ($check as $c){
                if ($c == false){
                    $result = false;
                }
            }
            
            return $result;
        }elseif ($relation == 'or'){
            
            $result = false;
            foreach ($check as $c){
                if ($c == true){
                    $result = true;
                }
            }
            
            return $result;
        }else{
            
            $this->errorCode = '100004';
            $this->errorMsg = '验证规则关系不符合要求';
            return false;
        }
    }
    
    /**
     * 获取错误信息
     * @return number[]|string[]
     */
    public function getErrorInfo(){
        
        return ['error_code' => $this->errorCode , 'error_msg' => $this->errorMsg ];
    }
    
    
}
<?php
namespace app\cms\controller;
use think\Controller;

class Login extends Controller
{
    public function _initialize () {
        //ipè¿‡æ»¤
        $ipAddr = get_client_ip();
        $ipArray = array();
        $tmp = explode('.', $ipAddr);
        $ipArray[] = $tmp[0].'.';
        $ipArray[] = $tmp[0].'.'.$tmp[1].'.';
        $ipArray[] = $tmp[0].'.'.$tmp[1].'.'.$tmp[2].'.';
        $ipArray[] = $ipAddr;
        $availableIp = M('cms_ip_filter')->where("replace(ip,'*','') in('','".$ipArray[0]."','" .$ipArray[1]."','" .$ipArray[2]."','" .$ipArray[3]."') " )->select();
        if (!$availableIp) {
            return $this->error();die();
        }        
    }
    public function login(){

        return $this->fetch('login');
    }

    public function dologin() {
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        $user = M('cms_users')->where(array('username'=>$username, 'password'=>$password))->find();

        if ($user) {
            session('cmsuid', $user['id']);

            //Ä£¿é·ÖÅä
            $moduleArr = M('cms_module')->where(['status'=>0])->select();
            $mask =true;
            foreach($moduleArr as $k=>&$v){
                $models= M('cms_models')->alias('m')->distinct(true)->field('m.*,e.name ename')
                ->join('inner join '.C('DB_PREFIX').'cms_role_model rm on m.id = rm.modelid')
                ->join('inner join '.C('DB_PREFIX').'cms_roles r on r.id = rm.roleid')
                ->join('inner join '.C('DB_PREFIX').'cms_role_user ru on ru.roleid = r.id')
                ->join('inner join '.C('DB_PREFIX').'cms_users u on u.id = ru.userid')
                ->join('left join '.C('DB_PREFIX').'cms_module e on e.id = m.module_id')
                ->where(array('u.id'=>$user['id'],'module_id'=>$v['id']))->order('m.id')->select();
                foreach($models as &$vv){
                    $vv['url'] = '<a class="cms_left_list_bg1 change_style" href="'.U('cms/'.$vv['modelname'].'/index').'">'.$vv['menuname'].'</a>';
                }
                $v['models'] = $models;
                if(empty($models)){
                    unset($moduleArr[$k]);
                }
                if(!empty($models) && $mask){
                    $mask=false;
                    $firstModelName = $models[0]['modelname'];
                }             
            }
            session('moduleArr',$moduleArr);
            if($firstModelName){
                $this->redirect(U($firstModelName.'/index'));
            }else{
                return $this->error('该用户没有管理模块');
            }
            
        } else {
            $this->redirect(U('login'));
        }
    }
    public function loginout(){
        session('cmsuid',null);
        $this->redirect(U('login'));
    }
}

<?php
namespace app\cms\controller;
use think\Controller;

class CmsController extends Controller
{
	protected $uid ;
    public function _initialize () {
        //登录验证
    	$this->uid = session('cmsuid');
        if(empty($this->uid)){
            $this->redirect('cms/Login/login');die();
        }     	


        //权限判断
        $models = [];

        $models = M('cms_models')->alias('m')->distinct(true)->field('m.*')
        ->join('inner join '.C('DB_PREFIX').'cms_role_model rm on m.id = rm.modelid')
        ->join('inner join '.C('DB_PREFIX').'cms_roles r on r.id = rm.roleid')
        ->join('inner join '.C('DB_PREFIX').'cms_role_user ru on ru.roleid = r.id')
        ->join('inner join '.C('DB_PREFIX').'cms_users u on u.id = ru.userid')
        ->where(array('u.id'=>$this->uid,'m.modelname'=>CONTROLLER_NAME))->select();
        if(empty($models)){
            $this->redirect('cms/Login/login');die();
        }
        //模块，登录的时候设置
    	$this->assign('moduleArr',session('moduleArr')); 
        $userInfo = M('cms_users')->where(['id'=>$this->uid])->find();
        $this->assign('userInfo',$userInfo);
    }

}
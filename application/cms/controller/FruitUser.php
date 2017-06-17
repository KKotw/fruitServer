<?php
//由HuaiGod自动生成,请根据需要修改
namespace app\cms\controller;
use app\cms\controller\CmsController;

use app\cms\model\Pager;

use think\Db;

class FruitUser extends CmsController {
public function _initialize(){
		
	parent::_initialize();
		
	$this->assign('titleName','用户管理');
}
public function index(){        
        
        $pageSize = 25;
        if (isset($_GET['pageSize'])) {
            $pageSize = $_GET['pageSize'];
        }
        $this->assign("pageSize", $pageSize);

        $currentPage = 1;
        if (isset($_GET['page'])) {
            $currentPage = $_GET['page'];
        }
        $where = [];
        $searchCnd = [];
if(isset($_GET["id"]) && $_GET["id"]!==""){
			$where["a.`id`"] = array("like","%".$_GET["id"]."%");
			$searchCnd["id"] = $_GET["id"];
		}
        

        $totalCount = M('fruit_user')->alias('a')->where($where)->count();
        $pager = new Pager($pageSize, $currentPage, $totalCount, U('index'), $_GET);
        $this->assign("pager", $pager->show());
        $fruit_user = M('fruit_user')->alias('a')->where($where)->limit($pager->offset,$pager->pageSize)->order('id desc')->select();
        $this->assign('arr',$fruit_user);
        $this->assign('searchCnd',$searchCnd);
        return $this->fetch();
}







public function excel(){        
        
        $pageSize = 25;
        if (isset($_GET['pageSize'])) {
            $pageSize = $_GET['pageSize'];
        }
        $this->assign("pageSize", $pageSize);

        $currentPage = 1;
        if (isset($_GET['page'])) {
            $currentPage = $_GET['page'];
        }
        $where = [];
        $searchCnd = [];
if(isset($_GET["id"]) && $_GET["id"]!==""){
			$where["a.`id`"] = array("like","%".$_GET["id"]."%");
			$searchCnd["id"] = $_GET["id"];
		}
        
        $fruit_user = M('fruit_user')->alias('a')->order('id desc')->where($where)->select();
        foreach ($fruit_user as &$v) {
            if ($v['sex']==1){
                $v['sex'] = '男';
            }else if($v['sex']==2){
                $v['sex'] = '女';
            }else{
                $v['sex'] = '未知';
            }
        }
        $date = date('Y-m-d H:i:s', time());
        $filename = '用户' . $date;
        $arr = array(
            'id' => 'ID',
            'openid' => '微信用户openid',                
            'nickname' => '微信用户昵称',                
            'sex' => '微信用户性别',
            'headimgurl' => '微信用户头像地址',                
            'province' => '微信用户填写的省份',                
            'city' => '微信用户填写的城市',                
            'country' => '微信用户填写的国家',                
            'createtime' => '创建时间',                
        );
        toexcel($filename, $arr, $fruit_user);
}







public function add(){
	if(IS_POST){
		foreach($_POST as $k=>$p){
			if(empty($k)){
				unset($_POST[$k]);
			}
		}
if(isset($_POST["createtime"]) && empty($_POST["createtime"])){unset($_POST["createtime"]);}
			$id = M('fruit_user')->add($_POST);	
			if($id){
				$this->redirect('index');
			}else{
				return $this->error('操作失败');
			}
	}else{
		return $this->fetch();
	}
	
}

public function edit(){
	if(IS_POST){
		//把空值写成null.
		foreach($_POST as $k=>$p){
			if($p===''){
				$_POST[$k] = null;
			}
			if(empty($k)){
				unset($_POST[$k]);
			}
		}
		Db::startTrans();
		try{
if(isset($_POST["createtime"]) && empty($_POST["createtime"])){unset($_POST["createtime"]);}
			M('fruit_user')->where(array('id'=>$_GET['id']))->save($_POST);
			Db::commit();
			$this->redirect('index');
		}catch(\Exception $e){
			Db::rollback();
			return $this->error('操作失败');
		}
	}else{
		$info = M('fruit_user')->alias('a')->field('a.*')->where(array('a.id'=>$_GET['id']))->find();
		
		
		$this->assign('info',$info);
		return $this->fetch();
	}
}


public function delete(){
	$where['id'] = $_GET['id'];
	M('fruit_user')->where($where)->delete();
	$this->redirect('index');
}

public function info(){       
	$info = M('fruit_user')->alias('a')->field('a.*')->where(array('a.id'=>$_GET['id']))->find();
	$this->assign('info',$info);
	return $this->fetch();
}

}
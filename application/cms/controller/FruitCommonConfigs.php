<?php
namespace app\cms\controller;
use app\cms\controller\CmsController;

use app\cms\model\Pager;

use think\Db;

class FruitCommonConfigs extends CmsController {
public function _initialize(){
		
	parent::_initialize();
		
	$this->assign('titleName','公共变量管理');
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
        

        $totalCount = M('fruit_common_configs')->alias('a')->where($where)->count();
        $pager = new Pager($pageSize, $currentPage, $totalCount, U('index'), $_GET);
        $this->assign("pager", $pager->show());
        $fruit_common_configs = M('fruit_common_configs')->alias('a')->where($where)->limit($pager->offset,$pager->pageSize)->order('id desc')->select();
        $this->assign('arr',$fruit_common_configs);
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
        
        $fruit_common_configs = M('fruit_common_configs')->alias('a')->order('id desc')->where($where)->select();
        foreach ($fruit_common_configs as &$v) {
        }
        $date = date('Y-m-d H:i:s', time());
        $filename = '公共变量' . $date;
        $arr = array(
            'id' => 'ID',                
            'name' => '变量名',                
            'description' => '变量描述',                
            'value' => '变量值',                
            'type' => '配置类型 0：string ，1：bannerUrl，2：file，3：files',                
        );
        toexcel($filename, $arr, $fruit_common_configs);
}







public function add(){
	if(IS_POST){
		foreach($_POST as $k=>$p){
			if(empty($k)){
				unset($_POST[$k]);
			}
		}
$_POST["value"] = empty($_POST["valueimgurl"])?"":json_encode($_POST["valueimgurl"]);unset($_POST["valueimgurl"]);
			$id = M('fruit_common_configs')->add($_POST);	
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
        $len = count($_POST['valueimgurl']);
        $a=array();
        $b=array();
        for ($i=0;$i<$len;$i++){
            $b['img'] = $_POST['valueimgurl'][$i];
            $a[] = $b;
        }
        $d['value'] = json_encode($a);
        $d['name'] = $_POST['name'];
        $d['description'] = $_POST['description'];
        $d['type'] = $_POST['type'];
		Db::startTrans();
		try{
			M('fruit_common_configs')->where(array('id'=>$_GET['id']))->save($d);
			Db::commit();
			$this->redirect('index');
		}catch(\Exception $e){
			Db::rollback();
			return $this->error('操作失败');
		}
	}else{
		$info = M('fruit_common_configs')->alias('a')->field('a.*')->where(array('a.id'=>$_GET['id']))->find();
        $info["valueimg"] = json_decode($info["value"],true);unset($info["value"]);
		$this->assign('info',$info);
		return $this->fetch();
	}
}


public function delete(){
	$where['id'] = $_GET['id'];
	M('fruit_common_configs')->where($where)->delete();
	$this->redirect('index');
}

public function info(){       
	$info = M('fruit_common_configs')->alias('a')->field('a.*')->where(array('a.id'=>$_GET['id']))->find();
$info["valueimg"] = json_decode($info["value"],true);unset($info["value"]);
	$this->assign('info',$info);
	return $this->fetch();
}

}
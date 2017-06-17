<?php
//由HuaiGod自动生成,请根据需要修改
namespace app\cms\controller;
use app\cms\controller\CmsController;

use app\cms\model\Pager;

use think\Db;

class FruitMachine extends CmsController {
public function _initialize(){
		
	parent::_initialize();
		
	$this->assign('titleName','货架机器管理');
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
        if(isset($_GET["mac"]) && $_GET["mac"]!==""){
                    $where["a.`mac`"] = array("like","%".$_GET["mac"]."%");
                    $searchCnd["mac"] = $_GET["mac"];
                }
        if(isset($_GET["contact_mobile"]) && $_GET["contact_mobile"]!==""){
                    $where["a.`contact_mobile`"] = array("like","%".$_GET["contact_mobile"]."%");
                    $searchCnd["contact_mobile"] = $_GET["contact_mobile"];
                }
        if(isset($_GET["contact_name"]) && $_GET["contact_name"]!==""){
                    $where["a.`contact_name`"] = array("like","%".$_GET["contact_name"]."%");
                    $searchCnd["contact_name"] = $_GET["contact_name"];
                }
        if(isset($_GET["name"]) && $_GET["name"]!==""){
                    $where["a.`name`"] = array("like","%".$_GET["name"]."%");
                    $searchCnd["name"] = $_GET["name"];
                }
        if(isset($_GET["id"]) && $_GET["id"]!==""){
                    $where["a.`id`"] = array("like","%".$_GET["id"]."%");
                    $searchCnd["id"] = $_GET["id"];
                }

        $totalCount = M('fruit_machine')->alias('a')->where($where)->count();
        $pager = new Pager($pageSize, $currentPage, $totalCount, U('index'), $_GET);
        $this->assign("pager", $pager->show());
        $fruit_machine = M('fruit_machine')->alias('a')->where($where)->limit($pager->offset,$pager->pageSize)->order('id desc')->select();
        $this->assign('arr',$fruit_machine);
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
if(isset($_GET["mac"]) && $_GET["mac"]!==""){
			$where["a.`mac`"] = array("like","%".$_GET["mac"]."%");
			$searchCnd["mac"] = $_GET["mac"];
		}
if(isset($_GET["contact_mobile"]) && $_GET["contact_mobile"]!==""){
			$where["a.`contact_mobile`"] = array("like","%".$_GET["contact_mobile"]."%");
			$searchCnd["contact_mobile"] = $_GET["contact_mobile"];
		}
if(isset($_GET["contact_name"]) && $_GET["contact_name"]!==""){
			$where["a.`contact_name`"] = array("like","%".$_GET["contact_name"]."%");
			$searchCnd["contact_name"] = $_GET["contact_name"];
		}
if(isset($_GET["name"]) && $_GET["name"]!==""){
			$where["a.`name`"] = array("like","%".$_GET["name"]."%");
			$searchCnd["name"] = $_GET["name"];
		}
if(isset($_GET["id"]) && $_GET["id"]!==""){
			$where["a.`id`"] = array("like","%".$_GET["id"]."%");
			$searchCnd["id"] = $_GET["id"];
		}
        
        $fruit_machine = M('fruit_machine')->alias('a')->order('id desc')->where($where)->select();
        foreach ($fruit_machine as &$v) {
            if($v['is_delete'] ==0){
                $v['is_delete']='正常';
            }else{
                $v['is_delete']='删除';
            }
        }
        $date = date('Y-m-d H:i:s', time());
        $filename = '货架机器' . $date;
        $arr = array(
            'id' => '货架机器ID',
            'name' => '货架名称',                
            'contact_name' => '联系人',                
            'contact_mobile' => '联系人手机',                
            'contact_address' => '联系人地址',                
            'mac' => '货架mac地址',                
            'is_delete' => '状态',
        );
        toexcel($filename, $arr, $fruit_machine);
}







public function add(){
	if(IS_POST){
		foreach($_POST as $k=>$p){
			if(empty($k)){
				unset($_POST[$k]);
			}
		}
        $id = M('fruit_machine')->add($_POST);
			if($id){
                $signinUrl = C('__SiteUrl__').'index/index/index?id='.$id;
                $qrCodePath = './static/qrcode/'.$id.'.png';
                Vendor("phpqrcode.phpqrcode");
                \QRcode::png($signinUrl, $qrCodePath, 'L', 8);
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
			M('fruit_machine')->where(array('id'=>$_GET['id']))->save($_POST);
			Db::commit();
			$this->redirect('index');
		}catch(\Exception $e){
			Db::rollback();
			return $this->error('操作失败');
		}
	}else{
		$info = M('fruit_machine')->alias('a')->field('a.*')->where(array('a.id'=>$_GET['id']))->find();
		
		
		$this->assign('info',$info);
		return $this->fetch();
	}
}


public function delete(){
	$where['id'] = $_GET['id'];
    $a['is_delete'] = 1;
	M('fruit_machine')->where($where)->save($a);
	$this->redirect('index');
}

public function info(){       
	$info = M('fruit_machine')->alias('a')->field('a.*')->where(array('a.id'=>$_GET['id']))->find();
	$this->assign('info',$info);
	return $this->fetch();
}

}
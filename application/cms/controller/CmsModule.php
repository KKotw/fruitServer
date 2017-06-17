<?php
//由HuaiGod自动生成,请根据需要修改
namespace app\cms\controller;
use app\cms\controller\CmsController;

use app\cms\model\Pager;

use think\Db;

class CmsModule extends CmsController {
public function _initialize() {
		parent::_initialize();
		$this->assign('titleName','大模块管理');
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
if(isset($_GET["id"]) && $_GET["id"]!==""){
		$where["a.id"] = $_GET["id"];
		$this->assign("id",$_GET["id"]);
	}
if(isset($_GET["name"]) && $_GET["name"]!==""){
		$where["a.name"] = array("like","%".$_GET["name"]."%");
		$this->assign("name",$_GET["name"]);
	}
        

        $totalCount = M('cms_module')->alias('a')->where($where)->count();
        $pager = new Pager($pageSize, $currentPage, $totalCount, U('index'), $_GET);
        $this->assign("pager", $pager->show());
        $cms_module = M('cms_module')->alias('a')->where($where)->limit($pager->offset,$pager->pageSize)->order('id')->select();
        $this->assign('arr',$cms_module);
        
        return $this->fetch();
}







public function add(){
	if(IS_POST){
			$id = M('cms_module')->add($_POST);	
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
		Db::startTrans();
		try{
			M('cms_module')->where(array('id'=>$_GET['id']))->save($_POST);

			Db::commit();
			$this->redirect('index');
		}catch(\Exception $e){
			Db::rollback();
			return $this->error('操作失败');
		}
	}else{
		$res = M('cms_module')->where(array('id'=>$_GET['id']))->find();

		$this->assign('info',$res);
		return $this->fetch();
	}
}


public function delete(){
	$where['id'] = $_GET['id'];
	$data['status'] = 4;
	M('cms_module')->where($where)->save($data);
	Db::commit();
	$this->redirect('index');
}

}
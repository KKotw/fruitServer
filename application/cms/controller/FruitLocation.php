<?php
//由HuaiGod自动生成,请根据需要修改
namespace app\cms\controller;
use app\cms\controller\CmsController;

use app\cms\model\Pager;

use think\Db;

class FruitLocation extends CmsController {
public function _initialize(){
		
	parent::_initialize();
		
	$this->assign('titleName','货架商品位置管理');
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
    if(isset($_GET["machine_id"]) && $_GET["machine_id"]!==""){
        $where["machine_id.`id`"] = $_GET["machine_id"];
        $searchCnd["machine_id"] = $_GET["machine_id"];
    }
    if(isset($_GET["machine_name"]) && $_GET["machine_name"]!==""){
        $where["machine_id.`name`"] = array("like","%".$_GET["machine_name"]."%");
        $searchCnd["machine_name"] = $_GET["machine_name"];
    }
        

        $totalCount = M('fruit_location')->alias('a')->where($where)
            ->join('left join fruit_machine machine_id on machine_id.id=a.machine_id')
            ->join('left join fruit_product product_id on product_id.id=a.product_id')->count();
        $pager = new Pager($pageSize, $currentPage, $totalCount, U('index'), $_GET);
        $this->assign("pager", $pager->show());
        $fruit_location = M('fruit_location')->alias('a')->field('a.*,machine_id.id machine_id,machine_id.name machine_name,product_id.id product_id,product_id.name product_name')->where($where)->join('left join fruit_machine machine_id on machine_id.id=a.machine_id')->join('left join fruit_product product_id on product_id.id=a.product_id')->limit($pager->offset,$pager->pageSize)->order('id desc')->select();
        $this->assign('arr',$fruit_location);
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
        
        $fruit_location = M('fruit_location')->alias('a')->field('a.*,machine_id.id machine_id,machine_id.name machine_name,product_id.id product_id,product_id.name product_name')->order('id desc')->where($where)->join('left join fruit_machine machine_id on machine_id.id=a.machine_id')->join('left join fruit_product product_id on product_id.id=a.product_id')->select();
        foreach ($fruit_location as &$v) {
        }
        $date = date('Y-m-d H:i:s', time());
        $filename = '货架商品位置' . $date;
        $arr = array(
            'id' => 'ID',                
            'machine_id' => '机器ID',
            'machine_name' => '机器名',
            'product_id' => '商品ID',
            'product_name' => '商品名',
            'location_x' => '位置横坐标',                
            'location_y' => '位置纵坐标',                
            'storage' => '库存数量',                
        );
        toexcel($filename, $arr, $fruit_location);
}







public function add(){
	if(IS_POST){
		foreach($_POST as $k=>$p){
			if(empty($k)){
				unset($_POST[$k]);
			}
		}
			$id = M('fruit_location')->add($_POST);	
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
			M('fruit_location')->where(array('id'=>$_GET['id']))->save($_POST);
			Db::commit();
			$this->redirect('index');
		}catch(\Exception $e){
			Db::rollback();
			return $this->error('操作失败');
		}
	}else{
		$info = M('fruit_location')->alias('a')->field('a.*')->where(array('a.id'=>$_GET['id']))->find();
		
		
		$this->assign('info',$info);
		return $this->fetch();
	}
}


public function delete(){
	$where['id'] = $_GET['id'];
	M('fruit_location')->where($where)->delete();
	$this->redirect('index');
}

public function info(){       
	$info = M('fruit_location')->alias('a')->field('a.*,machine_id.id machine_id,machine_id.name machine_name,product_id.id product_id,product_id.name product_name')->where(array('a.id'=>$_GET['id']))->join('left join fruit_machine machine_id on machine_id.id=a.machine_id')->join('left join fruit_product product_id on product_id.id=a.product_id')->find();
	$this->assign('info',$info);
	return $this->fetch();
}

}
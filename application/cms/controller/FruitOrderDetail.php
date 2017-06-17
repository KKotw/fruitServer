<?php
//由HuaiGod自动生成,请根据需要修改
namespace app\cms\controller;
use app\cms\controller\CmsController;

use app\cms\model\Pager;

use think\Db;

class FruitOrderDetail extends CmsController {
public function _initialize(){
		
	parent::_initialize();
		
	$this->assign('titleName','管理');
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

    if(isset($_GET["order_id"]) && $_GET["order_id"]!==""){
        $where["a.`order_id`"] = $_GET["order_id"];
        $searchCnd["order_id"] = $_GET["order_id"];
    }

    $where['c.status'] = array('neq',0);
        $totalCount = M('fruit_order_detail')->alias('a')
            ->join('left join fruit_user as b ON b.id = a.user_id')
            ->join('left join fruit_order as c ON c.id = a.order_id')
            ->field('a.*,b.nickname')
            ->where($where)->count();

        $pager = new Pager($pageSize, $currentPage, $totalCount, U('index'), $_GET);
        $this->assign("pager", $pager->show());

        $fruit_order_detail = M('fruit_order_detail')->alias('a')
            ->join('left join fruit_user as b ON b.id = a.user_id')
            ->join('left join fruit_order as c ON c.id = a.order_id')
            ->field('a.*,b.nickname,c.status')
            ->where($where)->limit($pager->offset,$pager->pageSize)->order('a.id desc')->select();

        $this->assign('arr',$fruit_order_detail);
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
    $where['c.status']=1;
        $fruit_order_detail = M('fruit_order_detail')->alias('a')->order('a.id desc')
            ->join('left join fruit_user as b ON b.id = a.user_id')
            ->join('left join fruit_order as c ON c.id = a.order_id')
            ->field('a.*,b.nickname')
            ->where($where)->select();
        foreach ($fruit_order_detail as &$v) {
        }
        $date = date('Y-m-d H:i:s', time());
        $filename = '' . $date;
        $arr = array(
            'id' => 'ID',
            'order_id' => '订单ID',                
            'user_id' => '用户ID',
            'nickname' => '用户名',
            'product_id' => '产品ID',                
            'product_name' => '产品名',                
            'product_count' => '产品购买数',                
            'price' => '该产品总支付额',                
            'createtime' => '创建时间',                
        );
        toexcel($filename, $arr, $fruit_order_detail);
}







public function add(){
	if(IS_POST){
		foreach($_POST as $k=>$p){
			if(empty($k)){
				unset($_POST[$k]);
			}
		}
if(isset($_POST["createtime"]) && empty($_POST["createtime"])){unset($_POST["createtime"]);}
			$id = M('fruit_order_detail')->add($_POST);	
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
			M('fruit_order_detail')->where(array('id'=>$_GET['id']))->save($_POST);
			Db::commit();
			$this->redirect('index');
		}catch(\Exception $e){
			Db::rollback();
			return $this->error('操作失败');
		}
	}else{
		$info = M('fruit_order_detail')->alias('a')->field('a.*')->where(array('a.id'=>$_GET['id']))->find();
		
		
		$this->assign('info',$info);
		return $this->fetch();
	}
}


public function delete(){
	$where['id'] = $_GET['id'];
	M('fruit_order_detail')->where($where)->delete();
	$this->redirect('index');
}

public function info(){       
	$info = M('fruit_order_detail')->alias('a')
        ->join('left join fruit_user as b ON b.id = a.user_id')
        ->field('a.*,b.nickname')
        ->where(array('a.id'=>$_GET['id']))->find();
	$this->assign('info',$info);
	return $this->fetch();
}

}
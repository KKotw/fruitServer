<?php
//由HuaiGod自动生成,请根据需要修改
namespace app\cms\controller;
use app\cms\controller\CmsController;

use app\cms\model\Pager;

use think\Db;

class FruitOrder extends CmsController {
public function _initialize(){
		
	parent::_initialize();
		
	$this->assign('titleName','订单管理');
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
    if(isset($_GET["order_number"]) && $_GET["order_number"]!==""){
        $where["a.`order_number`"] = array("like","%".$_GET["order_number"]."%");
        $searchCnd["order_number"] = $_GET["order_number"];
    }
    if(isset($_GET["nickname"]) && $_GET["nickname"]!==""){
        $where["b.`nickname`"] = array("like","%".$_GET["nickname"]."%");
        $searchCnd["nickname"] = $_GET["nickname"];
    }

    $searchCnd["status"] = 0;
    if(isset($_GET["status"]) && $_GET["status"]!=0){
        $where["a.`status`"] = $_GET["status"];
        $searchCnd["status"] = $_GET["status"];
    }

        $totalCount = M('fruit_order')->alias('a')->where($where)
            ->join('left join fruit_user as b ON b.id = a.user_id')
            ->field('a.*,b.nickname')
            ->count();
        $pager = new Pager($pageSize, $currentPage, $totalCount, U('index'), $_GET);
        $this->assign("pager", $pager->show());
        $fruit_order = M('fruit_order')->alias('a')
            ->join('left join fruit_user as b ON b.id = a.user_id')
            ->field('a.*,b.nickname')
            ->where($where)->limit($pager->offset,$pager->pageSize)->order('a.id desc')->select();
        $this->assign('arr',$fruit_order);
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
        $where['a.status'] = 1;
        $fruit_order = M('fruit_order')->alias('a')->order('a.id desc')
            ->join('left join fruit_user as b ON b.id = a.user_id')
            ->field('a.*,b.nickname')
            ->where($where)->select();
        foreach ($fruit_order as &$v) {
            if($v['status']==0){
                $v['status']='未支付';
            }else{
                $v['status']='已支付';
            }

        }
        $date = date('Y-m-d H:i:s', time());
        $filename = '订单' . $date;
        $arr = array(
            'id' => '订单ID',
            'user_id' => '用户ID',
            'nickname' =>'用户名',
            'order_number' => '订单号，DD+年月日时分秒+四位随机数',
            'total_price' => '支付总价',
            'products' => '产品名',
            'createtime' => '创建时间',
        );
        toexcel($filename, $arr, $fruit_order);
}







public function add(){
	if(IS_POST){
		foreach($_POST as $k=>$p){
			if(empty($k)){
				unset($_POST[$k]);
			}
		}
			$id = M('fruit_order')->add($_POST);	
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
			M('fruit_order')->where(array('id'=>$_GET['id']))->save($_POST);
			Db::commit();
			$this->redirect('index');
		}catch(\Exception $e){
			Db::rollback();
			return $this->error('操作失败');
		}
	}else{
		$info = M('fruit_order')->alias('a')->field('a.*')->where(array('a.id'=>$_GET['id']))->find();
		
		
		$this->assign('info',$info);
		return $this->fetch();
	}
}


public function delete(){
	$where['id'] = $_GET['id'];
	M('fruit_order')->where($where)->delete();
	$this->redirect('index');
}

public function info(){
	$info = M('fruit_order')->alias('a')
        ->join('left join fruit_user as b ON b.id = a.user_id')
        ->field('a.*,b.nickname')
        ->where(array('a.id'=>$_GET['id']))
        ->find();
	$this->assign('info',$info);
	return $this->fetch();
}

}
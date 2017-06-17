<?php
namespace app\cms\controller;
use app\cms\controller\CmsController;

use app\cms\model\Pager;

use think\Db;

class FruitProduct extends CmsController {
public function _initialize(){
		
	parent::_initialize();
		
	$this->assign('titleName','果汁商品管理');
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
if(isset($_GET["is_sales_promotion"]) && $_GET["is_sales_promotion"]!==""){
			$where["a.`is_sales_promotion`"] = array("like","%".$_GET["is_sales_promotion"]."%");
			$searchCnd["is_sales_promotion"] = $_GET["is_sales_promotion"];
		}
if(isset($_GET["name"]) && $_GET["name"]!==""){
			$where["a.`name`"] = array("like","%".$_GET["name"]."%");
			$searchCnd["name"] = $_GET["name"];
		}
if(isset($_GET["id"]) && $_GET["id"]!==""){
			$where["a.`id`"] = array("like","%".$_GET["id"]."%");
			$searchCnd["id"] = $_GET["id"];
		}
        $totalCount = M('fruit_product')->alias('a')->where($where)->count();
        $pager = new Pager($pageSize, $currentPage, $totalCount, U('index'), $_GET);
        $this->assign("pager", $pager->show());
        $fruit_product = M('fruit_product')->alias('a')
            ->field('a.*')
            ->where($where)->limit($pager->offset,$pager->pageSize)->order('a.id desc')->select();
        $this->assign('arr',$fruit_product);
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
if(isset($_GET["is_sales_promotion"]) && $_GET["is_sales_promotion"]!==""){
			$where["a.`is_sales_promotion`"] = array("like","%".$_GET["is_sales_promotion"]."%");
			$searchCnd["is_sales_promotion"] = $_GET["is_sales_promotion"];
		}
if(isset($_GET["name"]) && $_GET["name"]!==""){
			$where["a.`name`"] = array("like","%".$_GET["name"]."%");
			$searchCnd["name"] = $_GET["name"];
		}
if(isset($_GET["id"]) && $_GET["id"]!==""){
			$where["a.`id`"] = array("like","%".$_GET["id"]."%");
			$searchCnd["id"] = $_GET["id"];
		}
        
        $fruit_product = M('fruit_product')->alias('a')->order('a.id desc')
            ->field('a.*')
            ->where($where)->select();
        foreach ($fruit_product as &$v) {
            if($v['is_sales_promotion']==1){
                $v['is_sales_promotion']='是';
            }else{
                $v['is_sales_promotion']='否';
            }
            if ($v['is_delete']==0){
                $v['is_delete']='正常';
            }else{
                $v['is_delete']='下架';
            }
        }
        $date = date('Y-m-d H:i:s', time());
        $filename = '果汁商品' . $date;
        $arr = array(
            'id' => 'ID',
            'name' => '商品名称',
            'description' =>'口味',
            'price' => '商品价格',
            'img_url' =>'图片路径',
            'is_sales_promotion' => '是否参加促销',
            'promotion_price' => '促销价格',                
            'is_delete' => '状态',
        );
        toexcel($filename, $arr, $fruit_product);
}







public function add(){
	if(IS_POST){
		foreach($_POST as $k=>$p){
			if(empty($k)){
				unset($_POST[$k]);
			}
		}
			$id = M('fruit_product')->add($_POST);
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
			M('fruit_product')->where(array('id'=>$_GET['id']))->save($_POST);
			Db::commit();
			$this->redirect('index');
		}catch(\Exception $e){
			Db::rollback();
			return $this->error('操作失败');
		}
	}else{
		$info = M('fruit_product')->alias('a')
            ->field('a.*')
            ->where(array('a.id'=>$_GET['id']))->find();
		$this->assign('info',$info);
		return $this->fetch();
	}
}


public function delete(){
	$where['id'] = $_GET['id'];
    $a['is_delete'] = 1;
	M('fruit_product')->where($where)->save($a);
	$this->redirect('index');
}

public function info(){       
	$info = M('fruit_product')->alias('a')
        ->field('a.*')
        ->where(array('a.id'=>$_GET['id']))->find();
	$this->assign('info',$info);
	return $this->fetch();
}

}
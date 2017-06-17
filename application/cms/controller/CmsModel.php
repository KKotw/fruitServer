<?php
namespace app\cms\controller;
use app\cms\controller\CmsController;

use app\cms\model\Pager;

use think\Db;
class CmsModel extends CmsController {
	public function _initialize() {
		parent::_initialize();
		$this->assign('titleName','后台模块管理');
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
		
		if (isset($_GET['menuname'])) {
			$where['menuname'] = array('like', '%'.$_GET['menuname'].'%');
			$this->assign('menuname', $_GET['menuname']);
		}
		if (isset($_GET['modelname'])) {
			$where['modelname'] = array('like', '%'.$_GET['modelname'].'%');
			$this->assign('modelname', $_GET['modelname']);
		}

		$totalCount = M('cms_models')->where($where)->count();
        $pager = new Pager($pageSize, $currentPage, $totalCount, U('index'), $_GET);
        $this->assign("pager", $pager->show());
		$modelList  = M('cms_models')->where($where)->field('cms_models.* ,dm.name  dm_name')->join('left join cms_module dm on dm.id=cms_models.module_id')->limit($pager->offset,$pager->pageSize)->select();
		
        $this->assign('arr', $modelList);
		return $this->fetch();
	}
	
	public function update() {
		if (IS_POST) {
			if (isset($_GET['id'])) {			
				if (M('cms_models')->where(array('id'=>intval($_GET['id'])))->save($_POST)!==false) {
					return $this->success('修改成功',U('CmsModel/index'));
				} else {
					return $this->error('操作失败');
				}
			} else {				
				if (M('cms_models')->add($_POST) !== false) {
					return $this->success('添加成功',U('CmsModel/index'));
				} else {
					return $this->error('操作失败');
				}
			}
		} else {
			$model = null;
			if (isset($_GET['id'])) {
				$model = M('cms_models')->field('cms_models.*,dm.id as dm_id')
				->join('left join cms_module dm on dm.id=cms_models.module_id')->where(array('cms_models.id'=>intval($_GET['id'])))->find();
			}
			$module = M('cms_module')->select();
			$this->assign('cms_module',$module);
			$this->assign('info', $model);
			return $this->fetch();
		}
	}
	
	public function delete() {
		if (isset($_GET['id'])) {
			$success = M('cms_models')->where(array('id'=>intval($_GET['id'])))->delete();
			if ($success !== false) {
				M('cms_role_model')->where(array('modelid'=>intval($_GET['id'])))->delete();
			}
			
			if ($success !== false) {
				return $this->success('删除成功',U('CmsModel/index'));
			} else {
				return $this->error('操作失败');
			}
		}
	}
}
?>
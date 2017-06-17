<?php
namespace app\cms\controller;
use app\cms\controller\CmsController;

use app\cms\model\Pager;

use think\Db;
class CmsRole extends CmsController {
	public function _initialize() {
		parent::_initialize();
		$this->assign('titleName','角色管理');
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
		
		if (isset($_GET['rolename'])) {
			$where['rolename'] = array('like', '%'.$_GET['rolename'].'%');
			$this->assign('rolename', $_GET['rolename']);
		}

		$totalCount = M('cms_roles')->where($where)->count();
        $pager = new Pager($pageSize, $currentPage, $totalCount, U('index'), $_GET);
        $this->assign("pager", $pager->show());
		$roleList  = M('cms_roles')->where($where)->limit($pager->offset,$pager->pageSize)->select();
		
        $this->assign('arr', $roleList);
		return $this->fetch();
	}
	
	public function update() {
		if (IS_POST) {
			if (isset($_GET['id'])) {			
				if (M('cms_roles')->where(array('id'=>intval($_GET['id'])))->save($_POST)!==false) {
					return $this->success('修改成功',U('CmsRole/index'));
				} else {
					return $this->error('操作失败');
				}
			} else {				
				if (M('cms_roles')->add($_POST) !== false) {
					return $this->success('添加成功',U('CmsRole/index'));
				} else {
					return $this->error('操作失败');
				}
			}
		} else {
			$role = null;
			if (isset($_GET['id'])) {
				$role = M('cms_roles')->where(array('id'=>intval($_GET['id'])))->find();
			}
			$this->assign('info', $role);
			return $this->fetch();
		}
	}
	
	public function delete() {
		if (isset($_GET['id'])) {
			$success = M('cms_roles')->where(array('id'=>intval($_GET['id'])))->delete();
			if ($success !== false) {
				M('cms_role_user')->where(array('roleid'=>intval($_GET['id'])))->delete();
			}
			if ($success !== false) {
				M('cms_role_model')->where(array('roleid'=>intval($_GET['id'])))->delete();
			}
			
			if ($success !== false) {
				return $this->success('删除成功',U('CmsRole/index'));
			} else {
				return $this->error('操作失败');
			}
		}
	}
	
	public function setmodel() {
		if (IS_POST) {
			$success = M('cms_role_model')->where(array('roleid'=>intval($_GET['id'])))->delete();
			
			if ($success !== false) {
				$modelids = $_POST['modelid'];
				foreach($modelids as $modelid) {
					$data = array();
					$data['roleid'] = intval($_GET['id']);
					$data['modelid'] = $modelid;
					M('cms_role_model')->add($data);
				}
			}
			
			if ($success !== false) {
				return $this->success('修改成功',U('CmsRole/index'));
			} else {
				return $this->error('操作失败');
			}
		} else {
			$role = M('cms_roles')->where(array('id'=>intval($_GET['id'])))->find();
			$models = M('cms_models')->alias('m')->field('m.*, case when (rm.id is not null) then 1 else 0 end as checked')
				->join('left join cms_role_model rm on m.id = rm.modelid and rm.roleid = '.intval($_GET['id']))->select();
			$this->assign('arr', $models);
			$this->assign('role', $role);
			return $this->fetch();
		}
	}
}
?>
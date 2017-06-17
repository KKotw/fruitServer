<?php
namespace app\cms\controller;
use app\cms\controller\CmsController;

use app\cms\model\Pager;

use think\Db;
class CmsUser extends CmsController {
	public function _initialize() {
		parent::_initialize();
		$this->assign('titleName','后台用户管理');
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
		if (isset($_GET['username'])) {
			$where['u.username'] = array('like', '%'.$_GET['username'].'%');
			$this->assign('username', $_GET['username']);
		}
		$totalCount = M('cms_users')->where($where)->alias('u')->count();
        $pager = new Pager($pageSize, $currentPage, $totalCount, U('index'), $_GET);
        $this->assign("pager", $pager->show());
		$userList  = M('cms_users')->where($where)->alias('u')->limit($pager->offset,$pager->pageSize)->select();
					
		foreach($userList as $k=>$v){
			$arr = array();
			$where2['userid'] = $v['id'];
			$roles = M('cms_role_user')->where($where2)->select();

			foreach ($roles as $value) {
				$where1['id'] = $value['roleid'];
				$result = M('cms_roles')->where($where1)->getField('rolename',true);
				$arr[] = $result[0];
			}
			$str = implode($arr,',');
			$userList[$k]['rolename'] = $str;
		}

        $this->assign('arr', $userList);
		return $this->fetch();
	}
	
	public function update() {
		if (IS_POST) {

			if (isset($_POST['id'])) {			
				if (M('cms_users')->where(array('id'=>intval($_POST['id'])))->save($_POST)!==false) {
					return $this->success('修改成功',U('CmsUser/index'));
				} else {
					return $this->success('修改成功',U('CmsUser/index'));
					// return $this->error('操作失败');
				}
			} else {				
				$_POST['password'] = md5($_POST['password']);
				$roleids = isset($_POST['roleid'])?$_POST['roleid']:'';
				unset($_POST['roleid']);
				$id = M('cms_users')->add($_POST);
				if ( $id !== false) {
					if(is_array($roleids)){
						foreach($roleids as $roleid) {
							$data = array();
							$data['userid'] = $id;
							$data['roleid'] = $roleid;
							M('cms_role_user')->add($data);
						}						
					}
					return $this->success('添加成功',U('CmsUser/index'));

				} else {
					return $this->error('操作失败');
				}
			}
		} else {
			$user = null;
			if (isset($_GET['id'])) {
				$user = M('cms_users')->where(array('id'=>intval($_GET['id'])))->select();
				$this->assign('type',1);
			}
			$roles = M('cms_roles')->alias('r')->field('r.*')->select();
			$this->assign('roles',$roles);
			$this->assign('info', $user[0]);
			return $this->fetch();
		}
	}
	
	public function resetpassword() {
		if (IS_POST) {
			if (isset($_GET['id'])) {
				$_POST['password'] = md5($_POST['password']);
				if (M('cms_users')->where(array('id'=>intval($_GET['id'])))->save($_POST)!==false) {
					return $this->success('修改成功',U('CmsUser/index'));
				} else {
					return $this->error('操作失败');
				}
			}
		} else {
			$user = null;
			if (isset($_GET['id'])) {
				$user = M('cms_users')->where(array('id'=>intval($_GET['id'])))->find();
			}
			$this->assign('info', $user);
			return $this->fetch();
		}
	}
	
	public function delete() {
		if (isset($_GET['id'])) {
			$success = M('cms_users')->where(array('id'=>intval($_GET['id'])))->delete();
			if ($success !== false) {
				M('cms_role_user')->where(array('userid'=>intval($_GET['id'])))->delete();
			}
			
			if ($success !== false) {
				return $this->success('删除成功',U('CmsUser/index'));
			} else {
				return $this->error('操作失败');
			}
		}
	}
	
	public function setrole() {
		if (IS_POST) {
			$success = M('cms_role_user')->where(array('userid'=>intval($_GET['id'])))->delete();
			
			if ($success !== false) {
				$roleids = $_POST['roleid'];
				foreach($roleids as $roleid) {
					$data = array();
					$data['userid'] = intval($_GET['id']);
					$data['roleid'] = $roleid;
					M('cms_role_user')->add($data);
				}
			}
			
			if ($success !== false) {
				return $this->success('修改成功',U('CmsUser/index'));
			} else {
				return $this->error('操作失败');
			}
		} else {
			$user = M('cms_users')->where(array('id'=>intval($_GET['id'])))->find();
			$roles = M('cms_roles')->alias('r')->field('r.*, case when (ru.id is not null) then 1 else 0 end as checked')
				->join('left join cms_role_user ru on r.id = ru.roleid and ru.userid = '.intval($_GET['id']))->select();
			$this->assign('arr', $roles);
			$this->assign('info', $user);
			return $this->fetch();
		}
	}
}
?>
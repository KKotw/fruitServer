<?php
namespace app\cms\controller;
use app\cms\controller\CmsController;

use app\cms\model\Pager;

use think\Db;
class CmsIpFilter extends CmsController {
	public function _initialize() {
		parent::_initialize();
		$this->assign('titleName','IP白名单管理');
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
        if (isset($_GET['ip'])) {
            $where['ip'] = array('like', '%' . $_GET['ip'] . '%');
            $this->assign('ip', $_GET['ip']);
        }

		$totalCount = M('cms_ip_filter')->where($where)->count();
        $pager = new Pager($pageSize, $currentPage, $totalCount, U('index'), $_GET);
        $this->assign("pager", $pager->show());
		$res  = M('cms_ip_filter')->where($where)->limit($pager->offset,$pager->pageSize)->select();
		
        $this->assign('arr', $res);
		return $this->fetch();
	}
	
	public function update() {
		if (IS_POST) {
			if (isset($_GET['id'])) {			
				if (M('cms_ip_filter')->where(array('id'=>intval($_GET['id'])))->save($_POST)!==false) {
					$this->redirect('CmsIpFilter/index');
				} else {
					return $this->error('操作失败');
				}
			} else {				
				$_POST['createtime'] = time();
				if (M('cms_ip_filter')->add($_POST) !== false) {
					$this->redirect('CmsIpFilter/index');
				} else {
					return $this->error('操作失败');
				}
			}
		} else {
			$info = null;
			if (isset($_GET['id'])) {
				$info = M('cms_ip_filter')->where(array('id'=>intval($_GET['id'])))->select();
			}
			$info = $info[0];
			$this->assign('info', $info);
			return $this->fetch();
		}
	}
	
	public function delete() {
		if (isset($_GET['id'])) {
			$where['id'] = $_GET['id'];
			$success = M('cms_ip_filter')->where($where)->delete();
			if ($success !== false) {
				$this->redirect('CmsIpFilter/index');
			} else {
				return $this->error('操作失败');
			}
		}
	}
}
?>
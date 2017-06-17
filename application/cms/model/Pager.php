<?php 
namespace app\cms\model;
//use think\Model;

class Pager
{
    public $pageSize;
    public $currentPage;
    public $totalCount;
    public $totalPage;
    public $url;
    public $offset;
    public function __construct($pageSize, $currentPage, $totalCount, $url, $params='') {
		$this->pageSize = $pageSize;
        $this->currentPage = $currentPage;
        $this->totalCount = $totalCount;
        $this->offset = $this->pageSize * ($this->currentPage - 1);

        $totalPage = 0;
        if ($totalCount > 0) {
            $totalPage = ceil($totalCount / $pageSize);
        }
        $this->totalPage = $totalPage;

        $this->url = $url . "?pageSize=" . $this->pageSize;
        if ($params) {
            foreach($params as $k=>$v) {
                if ($k != "page" && $k != "pageSize") {
                    $this->url .= "&".$k."=".$v;
                }
            }
        }
	}

    public function show() {
        $startPageIndex = ceil($this->currentPage/5);
        $endPageIndex = min($this->totalPage, $startPageIndex + 4);

        $pagerModel = array();
        $pagerModel['currentPage'] = $this->currentPage;
        $pagerModel['totalPage'] = $this->totalPage;
        $pagerModel['url'] = $this->url;
        if ($this->currentPage == 1) {
            $pagerModel['prevPage'] = 1;
        } else {
            $pagerModel['prevPage'] = $this->currentPage - 1;
        }

        if ($this->currentPage == $this->totalPage) {
            $pagerModel['nextPage'] = $this->totalPage;
        } else {
            $pagerModel['nextPage'] = $this->currentPage + 1;
        }

        $pagerModel['lists'] = array();
        for($i = $startPageIndex; $i <= $endPageIndex; $i++) {
            $list = array();
            $list['index'] = $i;
            $pagerModel['lists'][] = $list;
        }

        return $pagerModel;
    }
}
?>
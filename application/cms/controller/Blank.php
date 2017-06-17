<?php
namespace app\cms\controller;
use app\cms\controller\CmsController;
use think\Db;

class Blank extends cmsController
{
    public function index(){
        return $this->fetch();
    }
}

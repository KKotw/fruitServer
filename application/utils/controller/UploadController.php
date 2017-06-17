<?php
namespace app\utils\controller;
use think\Controller;
use think\Db;


class UploadController extends Controller
{
    /**
     * 带压缩切图的文件上传
     */
    public function uploadWithCrop() {
        $config = array(
            'maxSize'    =>    8000000,
            'rootPath'   =>    './static/',
            'savePath'   =>    "picture/",
            'saveName'   =>    array('uniqid',''),
            'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),
            'autoSub'    =>    false
        );

        // 实例化上传类
        $upload = new \think\Upload($config);
        $info   =   $upload->upload();
        $val = $info[$_GET['filename']];
        // 文件缩放
        $image = new \think\Image();
        $image->open('./static/'.$val['savepath'].$val['savename']);

        $width = $image->width();
        $height = $image->height();

        if (isset($_GET['width']) && !empty($_GET['width'])) {
            $width = $_GET['width'];
        }
        if (isset($_GET['height']) && !empty($_GET['height'])) {
            $height = $_GET['height'];
        }
        $image->thumb($width, $height,\Think\Image::IMAGE_THUMB_CENTER)->save('./static/'.$val['savepath'].$val['savename']);

        $result['url'] = __STATIC__ . "/" .$val['savepath'].$val['savename'];
        return json_encode($result);
    }

    /**
     * 上传能量站 main 和 index
     */
    public function uploadMainIndexImg() {
        $userId = session('userid');
        if (empty($userId)) {
            $result['errcode'] = 9;
            $result['errmsg'] = '未登录';
            return json_encode($result, JSON_UNESCAPED_UNICODE);
        }
        $config = array(
            'maxSize'    =>    8000000,
            'rootPath'   =>    './static/',
            'savePath'   =>    "picture/",
            'saveName'   =>    array('uniqid',''),
            'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),
            'autoSub'    =>    false
        );

        // 实例化上传类
        $upload = new \think\Upload($config);
        $info   =   $upload->upload();
        $val = $info[$_GET['filename']];

        // 文件缩放
        $image = new \think\Image();
        $image->open('./static/'.$val['savepath'].$val['savename']);
        $width = 750;
        $height = 360;
        $image->thumb($width, $height,\Think\Image::IMAGE_THUMB_CENTER)->save('./static/'.$val['savepath'].$val['savename']);
        $result['main'] =__STATIC__ . "/" .$val['savepath'].$val['savename'];

        $imageindex = new \think\Image();
        $imageindex->open('./static/'.$val['savepath'].$val['savename']);
        $widthindex = 200;
        $heightindex = 150;

        $imageindex->thumb($widthindex, $heightindex,\Think\Image::IMAGE_THUMB_CENTER)->save('./static/'.$val['savepath'].'index'.$val['savename']);

           $result['index'] = __STATIC__ . "/" .$val['savepath'].'index'.$val['savename'];

        return json_encode($result);
    }
}

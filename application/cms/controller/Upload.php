<?php
namespace app\cms\controller;
use think\Controller;
use think\Db;

class Upload extends Controller
{
    /**
     * 文件上传
     */
    public function fileupload(){
        $result = array();
        // 必须指定保存路径
        if (isset($_GET['photodir'])) {
            $extension = pathinfo($_FILES[array_keys($_FILES)[0]]['name'])['extension'];
            $relativePhotoDirPath = __STATIC__ . "/cms_upload/" . $_GET['photodir'];
            // 创建图片路径
            if (!file_exists($_SERVER['DOCUMENT_ROOT'].$relativePhotoDirPath) || !is_dir($_SERVER['DOCUMENT_ROOT'].$relativePhotoDirPath)) {
                mkdir($_SERVER['DOCUMENT_ROOT'].$relativePhotoDirPath, 0777, true);
            }

            $timeStamp = time();
            $randNum = rand(10000, 99999);
            $relativePhotoFilePath = $relativePhotoDirPath . "/" . $timeStamp . $randNum . '.'.$extension;
            move_uploaded_file($_FILES[array_keys($_FILES)[0]]["tmp_name"], $_SERVER['DOCUMENT_ROOT'].$relativePhotoFilePath);

            $result['success'] = 1;
            $result['url'] = $relativePhotoFilePath;

        } else {
            $result['success'] = 0;
        }

        return json_encode($result);
    }

    /**
     * 富文本框文件上传(返回格式与普通上传不一样success->error)
     */
    public function kindEditorUpload() {
        $result = array();
        // 必须指定保存路径
        if (isset($_GET['photodir'])) {
            $extension = pathinfo($_FILES[array_keys($_FILES)[0]]['name'])['extension'];
            $relativePhotoDirPath = __STATIC__ . "/cms_upload/" . $_GET['photodir'];
            // 创建图片路径
            if (!file_exists($_SERVER['DOCUMENT_ROOT'].$relativePhotoDirPath) || !is_dir($_SERVER['DOCUMENT_ROOT'].$relativePhotoDirPath)) {
                mkdir($_SERVER['DOCUMENT_ROOT'].$relativePhotoDirPath, 0777, true);
            }

            $timeStamp = time();
            $randNum = rand(10000, 99999);
            $relativePhotoFilePath = $relativePhotoDirPath . "/" . $timeStamp . $randNum . '.'.$extension;
            move_uploaded_file($_FILES[array_keys($_FILES)[0]]["tmp_name"], $_SERVER['DOCUMENT_ROOT'].$relativePhotoFilePath);

            $result['error'] = 0;
            $result['url'] = $relativePhotoFilePath;

        } else {
            $result['error'] = 1;
        }

        return json_encode($result);
    }

    /**
     * 带压缩切图的文件上传
     */
    public function uploadWithCrop() {
        $config = array(
            'maxSize'    =>    3145728,
            'rootPath'   =>    './static/',
            'savePath'   =>    $_GET['photodir']."/",
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
        $width = $_GET['width'];
        $height = $_GET['height'];

        $image->thumb($width, $height,\Think\Image::IMAGE_THUMB_CENTER)->save('./static/'.$val['savepath'].$val['savename']);

        return json_encode(__STATIC__ . "/" .$val['savepath'].$val['savename']);
    }

    /**
     * 用户相册图上传
     */
    public function uploadUserPicture() {
        $config = array(
            'maxSize'    =>    3145728,
            'rootPath'   =>    './static/',
            'savePath'   =>    $_GET['photodir']."/",
            'saveName'   =>    array('uniqid',''),
            'exts'       =>    array('jpg','png'),
            'autoSub'    =>    false
        );

        // 实例化上传类
        $upload = new \think\Upload($config);
        $info   =   $upload->upload();
        $val = $info[$_GET['filename']];

        // 文件缩放
        $image = new \think\Image();
        $image->open('./static/'.$val['savepath'].$val['savename']);
        $width = $_GET['width'];
        $height = $_GET['height'];

        $image->thumb($width, $height,\Think\Image::IMAGE_THUMB_CENTER)->save('./static/'.$val['savepath'].$val['savename']);

        // 插入用户相册图片
        $imageUrl = __STATIC__ . "/" .$val['savepath'].$val['savename'];
        M('user_picture')->add(array('userid'=>$_GET['userId'], 'picture'=>$imageUrl));
        $pictureId = M()->getLastInsID();

        $result = array();
        $result['url'] = $imageUrl;
        $result['pictureId'] = $pictureId;
        return json_encode($result);
    }

    /**
     * 上传参考资料
     * @return string
     */
    public function uploadReferenceMaterial() {
        $result = array();
        // 必须指定保存路径
        if (isset($_GET['photodir'])) {
            $extension = pathinfo($_FILES[array_keys($_FILES)[0]]['name'])['extension'];
            $relativePhotoDirPath = __STATIC__ . "/" . $_GET['photodir'];
            // 创建图片路径
            if (!file_exists($_SERVER['DOCUMENT_ROOT'].$relativePhotoDirPath) || !is_dir($_SERVER['DOCUMENT_ROOT'].$relativePhotoDirPath)) {
                mkdir($_SERVER['DOCUMENT_ROOT'].$relativePhotoDirPath, 0777, true);
            }

            $timeStamp = time();
            $randNum = rand(10000, 99999);
            $relativePhotoFilePath = $relativePhotoDirPath . "/" . $timeStamp . $randNum . '.'.$extension;
            move_uploaded_file($_FILES[array_keys($_FILES)[0]]["tmp_name"], $_SERVER['DOCUMENT_ROOT'].$relativePhotoFilePath);

            $result['error'] = 0;
            $result['url'] = $relativePhotoFilePath;
        } else {
            $result['error'] = 1;
        }

        return json_encode($result);
    }
}

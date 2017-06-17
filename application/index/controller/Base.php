<?php
namespace app\index\controller;

use app\index\service\UtilService;
use think\Controller;

class Base extends Controller
{
    /**
     * controller基础处理，包括自动登录等
     */
    public function _initialize()
    {
        // 如果用户已经绑定过，并且还没有登录，则自动登录
        $userid = session('userid');
        if (empty($userid)) {
           $currentUrl = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
           $authUrl = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . C('__APPID__') . "&redirect_uri=" . urlencode($currentUrl) . "&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect";
           if (empty($_GET['code'])) {
               $this->redirect($authUrl);
               die;
           }

           $info = getToken($_GET['code']);
           $openid = $info['openid'];
           $token = $info['access_token'];
           $url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$token."&openid=".$openid."&lang=zh_CN";
           $u_info = request_get($url);
           $u['nickname'] = $u_info['nickname'];
           $u['sex'] = $u_info['sex'];
           $u['headimgurl'] = $u_info['headimgurl'];
           $u['city'] = $u_info['city'];
           $u['country'] = $u_info['country'];
           $u['province'] = $u_info['province'];
           $user = M('fruit_user')->where(array('openid'=>$openid))->find();
           // 如果找到了用户，则自动登录
           if ($user) {
               session('userid', $user['id']);
               M('fruit_user')->where(array('openid'=>$openid))->save($u);
           }else{
               $a['openid'] = $u_info['openid'];
               $a['nickname'] = $u_info['nickname'];
               $a['sex'] = $u_info['sex'];
               $a['headimgurl'] = $u_info['headimgurl'];
               $a['city'] = $u_info['city'];
               $a['country'] = $u_info['country'];
               $a['province'] = $u_info['province'];
               $a['createtime'] = date("Y-m-d H:i:s");
               $id = M('fruit_user')->add($a);
               session('userid',$id);
           }
        }


    }
}

?>
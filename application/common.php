<?php
function request_post($url = '', $param = ''){
    if (empty($url) || empty($param)) {
        return false;
    }
    $postUrl = $url;
    $curlPost = $param;
    $ch = curl_init(); //初始化curl
    curl_setopt($ch, CURLOPT_URL, $postUrl); //抓取指定网页
    curl_setopt($ch, CURLOPT_HEADER, 0); //设置header
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //要求结果为字符串且输出到屏幕上
    curl_setopt($ch, CURLOPT_POST, 1); //post提交方式
    curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
    $data = curl_exec($ch); //运行curl
    curl_close($ch);
    return $data;
}

function request_get($url = '' ,$type=1){
    if (empty($url)) {
        return false;
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $data = curl_exec($ch);
    if($type){
        $arr = json_decode($data, true);
        curl_close($ch);
        return $arr;
    } else {
        curl_close($ch);
        return $data;
    }
}

function getToken($code){
        $appid = C('__APPID__');
        $appsecret = C('__APPSECRET__');
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$appsecret."&code=".$code."&grant_type=authorization_code";
        $arr = request_get($url);
        return $arr;
}

function toexcel($filename,$arr,$result,$addstr = ''){
    header('Content-Type: text/html; charset=UTF-8');
    header('Cache-Control: no-cache, must-revalidate');
    header('Content-type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename='.$filename.'.xls');

    $str='<table bgcolor="#fff" border="1" bordercolor="#4BACC6"><tr align="center" height="50" style="color:#fff">';
    foreach($arr as $v){
        $str.= '<th bgcolor="#4BACC6">'.$v.'</th>';
    }
    $str.= '</tr >';
    $i = 1;
    foreach ($result as $v) {
        $i++;
        $color = '';
        if($i%2){
            $color = '#B7DDE8';
        }
        $str.=' <tr align="center" height="40">';
        foreach($arr as $k=>$s){
            $str.=  '<td bgcolor='.$color.'>'.$v[$k].'</td>';
        }
        $str.= '</tr>';
    }
    $str .= $addstr;
    $str.='</table>';
    echo $str;
}
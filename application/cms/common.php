<?php 
	/*  返回对应状态对应中文
		$status 数据库状态数据
		$str    映射字符串
	*/
	function showstatus($status,$str){
		$arr = explode(':', $str);
		$key = explode(',', $arr[1]);
		$name = explode(',', $arr[0]);
		foreach($name as $k=>$v){
			$res[$key[$k]] = $v;
		}
		if($status!=='' && isset($res[$status])){ //一个情况
			return $res[$status];
		}elseif($status!==''){               //多个情况
			foreach($res as $k=>$v){
				if(!($status&$k)){
					unset($res[$k]);
				}
			}
			return implode(',',$res);
		}
	}
	/*  返回数据集合
		$column    关联字段
		$table     关联表
		$prefix    表前缀
		$arr       数据集合
	*/
	function getfkarr($column,$table,$prefix,&$arr,$where='',$isself=''){
		$table = str_replace($prefix,'',$table);
		if($table=='common_locale' && empty($isself)){
			$res = M('common_locale')->where("category <> 0")->field('id,name,category,parent_id')->select();
			foreach($res as $k =>$v){
				switch ($v['category']) {
					case 1:
						$arr['province'][] = $v; 
						break;
					case 2:
						$arr['city'][$v['parent_id']][] = $v; 
						break;
					case 3:
						$arr['county'][$v['parent_id']][] = $v; 
						break;
				}
			}
			$arr = json_encode($arr);
		}else{
			if($where){
				$arr = M("{$table}")->where(['status'=>0])->field("id ,{$column}")->select();
			}else{
				$arr = M("{$table}")->field("id ,{$column}")->select();
			}
		}
		
	}

/**
 * 获取客户端IP地址
 * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
 * @return mixed
 */
function get_client_ip($type = 0) {
	$type       =  $type ? 1 : 0;
    static $ip  =   NULL;
    if ($ip !== NULL) return $ip[$type];
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $pos    =   array_search('unknown',$arr);
        if(false !== $pos) unset($arr[$pos]);
        $ip     =   trim($arr[0]);
    }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ip     =   $_SERVER['HTTP_CLIENT_IP'];
    }elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip     =   $_SERVER['REMOTE_ADDR'];
    }
    // IP地址合法验证
    $long = ip2long($ip);
    $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
    return $ip[$type];
}

// function toexcel($filename,$arr,$result,$addstr = ''){
//     header('Content-Type: text/html; charset=UTF-8');
//     header('Cache-Control: no-cache, must-revalidate');
//     header('Content-type: application/vnd.ms-excel');
//     header('Content-Disposition: attachment; filename='.$filename.'.xls');

//     $str='
//                 <table bgcolor="#fff" border="1" bordercolor="#4BACC6">
//                     <tr align="center" height="50" style="color:#fff">';
//     foreach($arr as $v){
//         $str.= '<th bgcolor="#4BACC6">'.$v.'</th>';
//     }
//     $str.= '</tr >';
//     $i = 1;
//     foreach ($result as $v) {
//         $i++;
//         $color = '';
//         if($i%2){
//             $color = '#B7DDE8';
//         }
//         $str.=' <tr align="center" height="40">';
//         foreach($arr as $k=>$s){
//             $str.=  '<td bgcolor='.$color.'>'.$v[$k].'</td>';
//         }
//         $str.= '</tr>';
//     }
//     $str .= $addstr;
//     $str.='</table>';
//     echo $str;
// }
?>
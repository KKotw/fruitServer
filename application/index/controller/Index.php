<?php
namespace app\index\controller;

use think\Controller;
use think\Db;

class Index extends Base
{
    public function _initialize()
    {
        parent::_initialize();
    }
    public function index()
    {
        $a['id'] = $_GET['id'];
        $m_name = M('fruit_machine')->where($a)->find();
        $ad = M('fruit_common_configs')->where(array('name' => 'AD_BANNER'))->find();
        $ad_img = json_decode($ad["value"], true);
        unset($ad["value"]);
        $end = count($ad_img) - 1;
        $goods = M('fruit_location')->alias('l')->join('inner join fruit_product as p ON l.product_id = p.id')
            ->field('sum(l.storage) as stock,p.*')->where(array('l.machine_id'=>$a['id'],'p.is_delete'=>0))
            ->group('l.product_id')->select();
        $this->assign('name', $m_name['name']);
        $this->assign('endBanner', $ad_img[$end]);
        $this->assign('firstBanner', $ad_img['0']);
        $this->assign('banners', $ad_img);
        $this->assign('m_id',$a['id']);
        $this->assign('goods', $goods);
        return $this->fetch();
    }

    public function order()
    {
        $d = json_decode($_POST['data'], true);
        $m_id = $_POST['m_id'];
        $order['order_number'] = 'DD' . date("YmdHis") . rand(1000, 9999);
        $order['createtime'] = date("Y-m-d H:i:s");
        $order['user_id'] = session('userid');
        $order['status'] = 0;
        $order['total_price'] = 0;
        $order['left_count'] = 0;
        $order['machine_id'] = $m_id;
        $name = '';
        for ($i = 0; $i < count($d); $i++) {
            $a = M('fruit_location')->field('sum(storage) as stock')
                ->where(array('product_id'=>$d[$i]['id'],'machine_id'=>$m_id))->group('product_id')->find();
            $b = M('fruit_product')->where(array('id'=>$d[$i]['id']))->find();
            if ($a['stock'] < $d[$i]['count']) {
                $msg['low_stock'] = 0;
                return json_encode($msg, JSON_UNESCAPED_UNICODE);
            }
            $name = $name . $b['name'] . ',';
            if ($b['is_sales_promotion'] == 0) {
                $order_detail['price'] = $d[$i]['count'] * $b['price'];
            } else {
                $order_detail['price'] = $d[$i]['count'] * $b['promotion_price'];
            }
            $order['total_price'] = $order['total_price'] + $order_detail['price'];
        }
        $order['products'] = rtrim($name, ',');
        Db::startTrans();
        try {
            $order_detail['order_id'] = M('fruit_order')->add($order);
            $order_detail['createtime'] = $order['createtime'];
            $order_detail['user_id'] = session('userid');
            for ($i = 0; $i < count($d); $i++) {
                $a = M('fruit_product')->where("id='" . $d[$i]['id'] . "'")->find();
                if ($a['is_sales_promotion'] == 0) {
                    $order_detail['product_id'] = $d[$i]['id'];
                    $order_detail['product_count'] = $d[$i]['count'];
                    $order_detail['price'] = $d[$i]['count'] * $a['price'];
                    $order_detail['product_name'] = $a['name'];
                    M('fruit_order_detail')->add($order_detail);
                } else {
                    $order_detail['product_id'] = $d[$i]['id'];
                    $order_detail['product_count'] = $d[$i]['count'];
                    $order_detail['price'] = $d[$i]['count'] * $a['promotion_price'];
                    $order_detail['product_name'] = $a['name'];
                    M('fruit_order_detail')->add($order_detail);
                }
            }
            Db::commit();
            $msg['id'] = $order_detail['order_id'];
            return json_encode($msg, JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            Db::rollback();
            return $this->error('操作失败');
        }


    }

    public function help()
    {
        return $this->fetch();
    }
}

?>


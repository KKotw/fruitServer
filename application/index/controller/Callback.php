<?php
namespace app\index\controller;

use think\Controller;
use think\Db;

class Callback extends Controller
{
    /**
     * 出货方法，正常：errcode=0, 异常：errcode!=0
     * @return string
     */
    public function shipment(){
        $macAddress = $_GET['mac_address'];

        $machine = M('fruit_machine')->where(array('mac'=>$macAddress))->find();
        if (!$machine) {
            $data['errcode'] = 1;
            $data['errmsg'] = '机器不存在';
            return json_encode($data, JSON_UNESCAPED_UNICODE);
        }

        Db::startTrans();
        $order = M('fruit_order')->where(array('machine_id'=>$machine['id'], 'status'=>1))->lock(true)->find();
        if (!$order) {
            Db::rollback();
            $data['errcode'] = 2;
            $data['errmsg'] = '无待出货订单';
            return json_encode($data, JSON_UNESCAPED_UNICODE);
        }

        $shipments = M('fruit_order_shipment')->field('location_x as x, location_y as y, shipment_count as count')->where(array('order_id'=>$order['id'], 'machine_id'=>$machine['id']))->select();
        M('fruit_order')->where(array('id'=>$order['id']))->setField(array('status'=>2));
        Db::commit();

        $data['errcode'] = 0;
        $data['order_id'] = $order['id'];
        $data['items'] = $shipments;
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 出货回调，1:失败，3:成功
     * @return string
     */
    public function shipmentCallback() {
        $orderid = $_GET['order_id'];
        $leftCount = $_GET['left_count'];
        $status = $_GET['status'];

        if ($status == 1 || $status == 3) {
            M('fruit_order')->where(array('id'=>$orderid))->setField(array('status'=>$status, 'left_count'=>$leftCount));
            $data['errcode'] = 0;
            return json_encode($data, JSON_UNESCAPED_UNICODE);
        } else {
            $data['errcode'] = 1;
            $data['errmsg'] = '状态值不正确';
            return json_encode($data, JSON_UNESCAPED_UNICODE);
        }
    }
}

?>


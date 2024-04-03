<?php

/**
 * Created by PhpStorm.
 * User: moon
 * Date: 2017-05-26
 * Time: 오후 7:04
 */
class OrderProcess
{
    public $db;
    public $http_type;
    public $mall_ix;

    public function __construct()
    {
        $this->db = getForbiz()->import('db.db');

        if (sess_val('admininfo', 'mall_ix')) {
            $this->mall_ix = $_SESSION ['admininfo']['mall_ix'];
        } else if ($_SESSION ['layout_config']['mall_ix']) {
            $this->mall_ix = $_SESSION ['layout_config']['mall_ix'];
        } else {
            $mobile_check = substr($_SERVER["HTTP_HOST"], 0, 2);
            if ($mobile_check == "m.") {
                $mall_domain = str_replace("".$mobile_check."", "", $_SERVER["HTTP_HOST"]);
            } else {
                $mall_domain = str_replace("www.", "", $_SERVER["HTTP_HOST"]);
            }
            $sql = "select mall_ix from shop_shopinfo  where  mall_domain = '".$mall_domain."' ";
            $this->db->query($sql);
            $this->db->fetch();

            $this->mall_ix = $this->db->dt['mall_ix'];
        }

        if (!empty($_SERVER['HTTPS'])) {
            $this->http_type = 'https://';
        } else {
            $this->http_type = 'http://';
        }
    }

    public function getPginfo($pg_code)
    {
        switch ($pg_code) {
            case 'payco':
            case 'kakaopay':
                $sql = "SELECT * FROM `shop_mall_config` where mall_ix = '".$this->mall_ix."'";
                $this->db->query($sql);
                if ($this->db->total) {
                    for ($i = 0; $i < $this->db->total; $i++) {
                        $this->db->fetch($i);
                        $payment_config[$this->db->dt['config_name']] = $this->db->dt['config_value'];
                    }
                    return $payment_config;
                }
                break;
            default:
                $sql = "select * from shop_payment_config
				where mall_ix = '".$this->mall_ix."' and pg_code = '".$pg_code."' ";

                $this->db->query($sql);

                if ($this->db->total) {
                    for ($i = 0; $i < $this->db->total; $i++) {
                        $this->db->fetch($i);
                        $payment_config[$this->db->dt['config_name']] = $this->db->dt['config_value'];
                    }
                    return $payment_config;
                }
                break;
        }
    }

    public function getFormData($data, $charset = "")
    {
        if (is_array($data)) {
            $pgForm = "<form name='order_info' id='pay_form' method='POST' ".($charset != '' ? "accept-charset='".$charset."'" : "")." >";
            foreach ($data as $key => $val) {
                $pgForm .= "<input type=hidden name='".$key."' id='".$key."' value='".$val."'>";
            }
            $pgForm .= "</form>";
        }
        return $pgForm;
    }

    public function getCancelFormData($data, $charset = "")
    {
        if (is_array($data)) {
            $pgForm = "<form name='cancel_frm' id='cancel_frm' method='POST' ".($charset != '' ? "accept-charset='".$charset."'" : "")." >";
            foreach ($data as $key => $val) {
                $pgForm .= "<input type=hidden name='".$key."' id='".$key."' value='".$val."'>";
            }
            $pgForm .= "</form>";
        }
        return $pgForm;
    }

    public function getPgOrder($oid)
    {

        $sql = "SELECT * FROM shop_order where oid = '".$oid."'  ";
        $this->db->query($sql);
        if ($this->db->total) {
            $order_data = $this->db->fetch();
            return $order_data;
        }
    }

    public function getPgOrderDetail($oid, $od_ix)
    {

        $sql = "SELECT * FROM shop_order_detail where oid = '".$oid."' and od_ix = '".$od_ix."' ";
        return $sql;
        $this->db->query($sql);
        if ($this->db->total) {
            $order_detail_data = $this->db->fetch();
            return $order_detail_data;
        }
    }

    public function getPgOrderDetailDeliveryInfo($oid, $od_ix)
    {

        $sql = "SELECT * FROM shop_order_detail_deliveryinfo where oid = '".$oid."' and order_type = '1' ";
        $this->db->query($sql);
        if ($this->db->total) {
            $order_deliveryinfo_data = $this->db->fetch();
            return $order_deliveryinfo_data;
        }
    }

    public function getPgOrderPayment($oid)
    {

        $sql = "SELECT * FROM shop_order_payment where oid = '".$oid."' and pay_type = 'G' ";
        $this->db->query($sql);
        if ($this->db->total) {
            $order_payment_data = $this->db->fetch();
            return $order_payment_data;
        }
    }

    public function escrow_status($oid, $od_ix, $status, $message)
    {
        $sql = "update shop_order_detail set escrow_delivery_status = '".$status."', escrow_delivery_message = '".$message."'  where oid = '".$oid."' and od_ix = '".$od_ix."' ";
        $this->db->query($sql);
    }

    public function getModule($pay_method)
    {
        switch ($pay_method) {
            case("Card") :
            case('escrow') :
            case("iche") :
            case("virtual") :
                $sattle_module = $_SESSION['layout_config']['sattle_module'];
                break;
            case("payco") :
                $sattle_module = 'payco';
                break;
            case("kakaopay") :
                $sattle_module = 'kakaopay';
                break;
        }
        return $sattle_module;
    }

    function __destruct()
    {

    }
}
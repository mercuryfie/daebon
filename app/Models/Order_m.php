<?php

namespace App\Models;


use CodeIgniter\Model;
use CodeIgniter\Config;
use App\Libraries\Utils;

class Order_m extends Model
{
    protected $db;

    public function __construct()
    {
        parent::__construct();

        $this->db = \Config\Database::connect('default');
    }


    public function Load_dashboardOrder_Info($fields=['ALL']){
        $sql = "SELECT shoptyp,COUNT(*) as Cnt from vw_order_info a WHERE DATE_FORMAT(indate, '%Y-%m-%d') = CURDATE() GROUP BY shoptyp ORDER BY 1 ASC;";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function Load_Packing_All($keyword,$searchType,$fields=['ALL']){
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM tbl_delivery_info a ";
        if($keyword===''){
            $searchword = '';
            $wheresql1 = "WHERE a.is_del=:ISDEL: ";
        }else{
            $searchword = "%{$keyword}%";
            $wheresql1 = "WHERE a.is_del=:ISDEL: AND (a.opcode LIKE :SEARCH: OR a.deli_code LIKE :SEARCH:) ";
        }
        $wheresql2='';
        if($searchType!='') {
            $wheresql2 = 'AND a.p_status=:STATUS: ';
        }
        $wsql = $sql . $wheresql1 . $wheresql2 . 'order by a.seq DESC;';
        $bindparam = [
            'ISDEL'=> 0,
            'SEARCH' => $searchword,
            'STATUS' => $searchType
        ];
        $query = $this->db->query($wsql,$bindparam);
        return $query->getResultArray();
    }

    public function Load_PackingByOpcode($opcode,$fields=['ALL']){
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM tbl_delivery_info  where opcode=:OPCODE: ";
        $bindparam = [
            'OPCODE'=> $opcode
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Load_Order_All($search, $fields=['ALL'])
    {
        $separated_val = fn_Make_Fields($fields);

        $sql = "SELECT {$separated_val} 
            FROM vw_order_info 
            WHERE is_del = :ISDEL:
            AND (
                orcode LIKE :SKEY: 
                OR buy_name LIKE :SKEY:
                OR buy_phone LIKE :SKEY:
                OR receive_name LIKE :SKEY:
                OR receive_phone LIKE :SKEY:
            )
            ORDER BY indate DESC";

        $bindparam = [
            'SKEY' => "%{$search}%",
            'ISDEL' => 0
        ];

        $query = $this->db->query($sql, $bindparam);
        return $query->getResultArray();
    }

    public function Load_Order_Info($code,$fields=['ALL']){
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM vw_order_info where orcode=:ORCODE:";
        $bindparam = [
            'ORCODE'=> $code
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Load_Order_InfoBySpcode($spcode,$fields=['ALL']){
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM vw_order_info where spcode=:SPCODE:";
        $bindparam = [
            'SPCODE'=> $spcode
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Load_Order_InfoByMiss($spcode,$fields=['ALL']){
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM tbl_order_miss where spcode=:SPCODE:";
        $bindparam = [
            'SPCODE'=> $spcode
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Load_Order_InfoByMissProduct($shoptype,$fields=['ALL']){
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM vw_order_info_miss a LEFT JOIN tbl_order_products b ON a.orcode=b.fk_orcode LEFT JOIN tbl_order_buyer_info c ON a.orcode=c.fk_orcode WHERE shoptyp=:SHOPTYP: AND a.is_del=:ISDEL:;";
        $bindparam = [
            'SHOPTYP' => $shoptype,
            'ISDEL'=> 0
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Load_Order_ByOrcode($orcode,$fields=['ALL']){
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM tbl_order_products where fk_orcode=:FKORCODE:";
        $bindparam = [
            'FKORCODE' => $orcode,
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Load_Order_InfoBySgcode($orcode,$sgcode,$fields=['ALL']){
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM tbl_order_products where fk_orcode=:FKORCODE: AND sgcode=:SGCODE:";
        $bindparam = [
            'FKORCODE' => $orcode,
            'SGCODE' => $sgcode
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function procedure_Move_Order_Miss($orcode,$sgcode,$pdcode)
    {
        $sql = "call sp_MoveMissOrderToMain(:ORCODE:,:SGCODE:,:PDCODE:);";
        $bindparam = [
            'ORCODE' => $orcode,
            'SGCODE' => $sgcode,
            'PDCODE' => $pdcode
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }


    public function Load_Order_ProductByMatch($excode,$fields=['ALL']){
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM tbl_product_matching where fk_excode=:FKEXCODE:";
        $bindparam = [
            'FKEXCODE'=> $excode
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Load_Order_In_Info($orcodes,$fields=['ALL']){
        if (empty($orcodes)) return [];

        $builder = $this->db->table('vw_order_info');
        $builder->select(fn_Make_Fields($fields))
            ->whereIn('orcode', $orcodes);

        return $builder->get()->getResultArray();
    }

    public function Load_OrderIn_Delivery_Info($opcodes,$fields=['ALL']){
        if (empty($opcodes)) return [];

        $builder = $this->db->table('tbl_delivery_info a');
        $builder->select(fn_Make_Fields($fields))
            ->select('(SELECT count(*) FROM tbl_delivery_package WHERE fk_opcode=a.opcode) as JoinCnt')
            ->whereIn('opcode', $opcodes);

        return $builder->get()->getResultArray();
    }

    public function Load_Order_Delivery_Info($opcode,$fields=['ALL']){
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val},(SELECT count(*) FROM tbl_delivery_package WHERE fk_opcode=a.opcode) as JoinCnt FROM tbl_delivery_info a where opcode=:OPCODE:";
        $bindparam = [
            'OPCODE'=> $opcode
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Load_Order_Package_Info($orcode,$fields=['ALL']){
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM tbl_delivery_package where fk_orcode=:ORCODE:";
        $bindparam = [
            'ORCODE'=> $orcode
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Load_Order_Package_Info2($orcode,$fields=['ALL']){
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM tbl_delivery_package a join tbl_order b on a.fk_orcode=b.orcode where a.fk_orcode=:ORCODE:";
        $bindparam = [
            'ORCODE'=> $orcode
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }




    public function Cnt_Order_Miss_ShopType($shopType){
        $sql = "SELECT COUNT(*) as cnt FROM tbl_order_miss WHERE shoptyp = :SHOPTYPE: AND is_del=:ISDEL:";
        $bindparam = [
            'SHOPTYPE' => $shopType,
            'ISDEL' => 0
        ];
        $query = $this->db->query($sql, $bindparam);
        $row = $query->getRowArray();
        return (int)$row['cnt'];
    }


    public function Load_Order_Package_Info_opcode($opcode,$fields=['ALL']){
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM tbl_delivery_package where fk_opcode=:OPCODE:";
        $bindparam = [
            'OPCODE'=> $opcode
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Load_Order_Product($orcode,$fields=['ALL']){
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM vw_order_products_info a WHERE a.fk_orcode=:ORCODE: ORDER BY a.seq ASC";
        $bindparam = [
            'ORCODE'=> $orcode,
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Insert_Order_Info($param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_order');
        $builder->insert($param);
        $insertID = $this->db->insertID();
        $this->db->transComplete();

        return $insertID;
    }

    public function Insert_Order_Info_Miss($param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_order_miss');
        $builder->insert($param);
        $insertID = $this->db->insertID();
        $this->db->transComplete();

        return $insertID;
    }

    public function Insert_Order_Buyer($param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_order_buyer_info');
        $builder->insert($param);
        $insertID = $this->db->insertID();
        $this->db->transComplete();

        return $insertID;
    }

    public function Insert_Order_Product($param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_order_products');
        $affected = $builder->insertBatch($param);
        $this->db->transComplete();

        return $affected;
    }


    public function Insert_Order_delivery_Info($param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_delivery_info');
        $affected = $builder->insertBatch($param);
        $this->db->transComplete();

        return $affected;
    }

    public function Insert_Order_delivery_file($opcode,$param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_delivery_file');
        $builder->insert($param);
        $insertID = $this->db->insertID();
        $this->db->transComplete();
        return $insertID;
    }

    public function Insert_Order_delivery_Info2($param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_delivery_info');
        $builder->insert($param);
        $insertID = $this->db->insertID();
        $this->db->transComplete();

        return $insertID;
    }


    public function Insert_Order_Package_Info($param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_delivery_package');
        $affected = $builder->insertBatch($param);
        $this->db->transComplete();

        return $affected;
    }

    public function Insert_Order_Package_Info2($param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_delivery_package');
        $builder->insert($param);
        $insertID = $this->db->insertID();
        $this->db->transComplete();

        return $insertID;
    }

    public function Update_Order_Info($code,$param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_order');
        $builder->whereIn('orcode', $code);
        $builder->update($param);
        $affected_rows = $this->db->affectedRows();
        $this->db->transComplete();

        return $affected_rows;
    }


    public function Load_Order_User_Info($code,$fields=['ALL']){
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM tbl_order_buyer_info where fk_orcode=:ORCODE:";
        $bindparam = [
            'ORCODE'=> $code
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Update_Order_User_Info($orcode,$u_info){
        $this->db->transStart();
        $builder = $this->db->table('tbl_order_buyer_info');
        $builder->where('fk_orcode', $orcode);
        $builder->update($u_info);
        $affected_rows = $this->db->affectedRows();
        $this->db->transComplete();

        return $affected_rows;
    }

    public function Update_Order_Products_Info($codes,$param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_order_products');
        $builder->whereIn('orcode', $codes);
        $builder->update($param);
        $affected_rows = $this->db->affectedRows();
        $this->db->transComplete();

        return $affected_rows;
    }

    public function Update_Order_Delivery_Info($opcode,$param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_delivery_info');
        $builder->where('opcode', $opcode);
        $builder->update($param);
        $affected_rows = $this->db->affectedRows();
        $this->db->transComplete();

        return $affected_rows;
    }
    public function Update_Order_Info2($codes,$param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_order');
        $builder->where('orcode', $codes);
        $builder->update($param);
        $affected_rows = $this->db->affectedRows();
        $this->db->transComplete();

        return $affected_rows;
    }

    public function Insert_Order_API_MallLog($param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_mall_log');
        $builder->insert($param);
        $insertID = $this->db->insertID();
        $this->db->transComplete();

        return $insertID;
    }





}
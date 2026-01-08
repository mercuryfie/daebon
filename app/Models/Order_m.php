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

    public function Load_Packing_All($search,$fields=['ALL']){
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM tbl_order_delivery_info  ORDER BY seq DESC";
        $bindparam = [
            'ISDEL'=> 0
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Load_Order_All($search,$fields=['ALL']){
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM vw_order_info where is_del=:ISDEL: ORDER BY seq ASC";
        $bindparam = [
            'ISDEL'=> 0
        ];
        $query = $this->db->query($sql,$bindparam);
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

    public function Load_Order_In_Info($orcodes,$fields=['ALL']){
        if (empty($orcodes)) return [];

        $builder = $this->db->table('vw_order_info');
        $builder->select(fn_Make_Fields($fields))
            ->whereIn('orcode', $orcodes);

        return $builder->get()->getResultArray();
    }

    public function Load_OrderIn_Delivery_Info($opcodes,$fields=['ALL']){
        if (empty($opcodes)) return [];

        $builder = $this->db->table('tbl_order_delivery_info a');
        $builder->select(fn_Make_Fields($fields))
            ->select('(SELECT count(*) FROM tbl_order_package WHERE fk_opcode=a.opcode) as JoinCnt')
            ->whereIn('opcode', $opcodes);

        return $builder->get()->getResultArray();
    }

    public function Load_Order_Delivery_Info($opcode,$fields=['ALL']){
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val},(SELECT count(*) FROM tbl_order_package WHERE fk_opcode=a.opcode) as JoinCnt FROM tbl_order_delivery_info a where opcode=:OPCODE:";
        $bindparam = [
            'OPCODE'=> $opcode
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Load_Order_Package_Info($orcode,$fields=['ALL']){
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM tbl_order_package where fk_orcode=:ORCODE:";
        $bindparam = [
            'ORCODE'=> $orcode
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Load_Order_Package_Info_opcode($opcode,$fields=['ALL']){
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM tbl_order_package where fk_opcode=:OPCODE:";
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
        $builder = $this->db->table('tbl_order_delivery_info');
        $affected = $builder->insertBatch($param);
        $this->db->transComplete();

        return $affected;
    }

    public function Insert_Order_delivery_Info2($param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_order_delivery_info');
        $builder->insert($param);
        $insertID = $this->db->insertID();
        $this->db->transComplete();

        return $insertID;
    }


    public function Insert_Order_Package_Info($param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_order_package');
        $affected = $builder->insertBatch($param);
        $this->db->transComplete();

        return $affected;
    }

    public function Update_Order_Info($codes,$param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_order');
        $builder->whereIn('orcode', $codes);
        $builder->update($param);
        $affected_rows = $this->db->affectedRows();
        $this->db->transComplete();

        return $affected_rows;
    }
}
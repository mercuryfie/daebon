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

    public function Load_Order_All($search,$fields=['ALL']){
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM tbl_order a,tbl_order_buyer_info b WHERE a.orcode=b.fk_orcode AND a.is_del=:ISDEL: ORDER BY a.seq ASC";
        $bindparam = [
            'ISDEL'=> 0
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Load_Order_Info($orcode,$fields=['ALL']){
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM tbl_order a WHERE a.orcode=:ORCODE: ORDER BY a.seq ASC";
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
}
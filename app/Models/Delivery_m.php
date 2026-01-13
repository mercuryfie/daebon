<?php

namespace App\Models;


use CodeIgniter\Model;
use CodeIgniter\Config;
use App\Libraries\Utils;

class Delivery_m extends Model
{
    protected $db;

    public function __construct()
    {
        parent::__construct();

        $this->db = \Config\Database::connect('default');
    }

    public function get_Delivery_code($fields=['ALL']){
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM tbl_delivery_code WHERE is_use=:ISUSE: AND is_del=:ISDEL: order by seq ASC limit 1";
        $bindparam = [
            'ISUSE' => 0,
            'ISDEL' => 0
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function get_Delivery_confirm_info($confirmseq,$fields=['ALL']){
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM tbl_delivery_confirm WHERE seq=:SEQ:";
        $bindparam = ['SEQ' => $confirmseq];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Insert_Delivery_Confirm($param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_delivery_confirm');
        $builder->insert($param);
        $insertID = $this->db->insertID();
        $this->db->transComplete();

        return $insertID;
    }

    public function Update_Delivery_Info($opcode,$param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_delivery_info');
        $builder->where('opcode', $opcode);
        $builder->update($param);
        $affected_rows = $this->db->affectedRows();
        $this->db->transComplete();

        return $affected_rows;
    }

    public function Update_Delivery_Code($delicode,$param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_delivery_code');
        $builder->where('dcode', $delicode);
        $builder->update($param);
        $affected_rows = $this->db->affectedRows();
        $this->db->transComplete();

        return $affected_rows;
    }

}

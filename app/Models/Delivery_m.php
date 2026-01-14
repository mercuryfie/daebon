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

    public function get_Delivery_List_All($param,$fields=['ALL']){
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM tbl_delivery_info a ";
        $sql .= "JOIN tbl_delivery_confirm b ON a.fk_confirm=b.seq ";
        $sql .= "JOIN tbl_delivery_package c ON c.fk_opcode = a.opcode ";
        $sql .= "JOIN tbl_order d ON d.orcode = c.fk_orcode ";
        $sql .= "WHERE a.p_status > :STATUS: AND b.confirm_date >= :SDATE: AND b.confirm_date <= :EDATE: ";
        if($param['select_typ']=='1'){
            $sql .= "AND a.deli_code=:SEARCHKEY: ";
        }else if($param['select_typ']=='2'){
            $sql .= "AND b.r_name=:SEARCHKEY: ";
        }else if($param['select_typ']=='3'){
            $sql .= "AND b.r_phone=:SEARCHKEY: ";
        }else if($param['select_typ']=='4'){
            $sql .= "AND d.spcode=:SEARCHKEY: ";
        }
        $sql .= " order by a.seq DESC";
        $bindparam = [
            'STATUS'=> 1,
            'SDATE' => $param['sdate'],
            'EDATE' => $param['edate'],
            'SEARCHKEY' => $param['searchkey']
        ];

        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
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

    public function get_Delivery_Image($opcode,$fields=['ALL']){
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM tbl_delivery_file WHERE opcode=:OPCODE: order by seq ASC";
        $bindparam = [
            'OPCODE' => $opcode
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

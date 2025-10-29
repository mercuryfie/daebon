<?php

namespace App\Models;


use CodeIgniter\Model;
use CodeIgniter\Config;
use App\Libraries\Utils;

class Goods_m extends Model
{
    protected $db;

    public function __construct()
    {
        parent::__construct();

        $this->db = \Config\Database::connect('default');
    }

    public function Load_Goods_Material($Code,$fields=['ALL'])
    {
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} from vw_goods_matrial WHERE fk_gcode=:CODE: AND is_del=:ISDEL: order by seq DESC  ";
        $bindparam = [
            'CODE'=> $Code,
            'ISDEL' => 0
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Load_Goods_Process($Code,$fields=['ALL'])
    {
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} from tbl_goods_process WHERE fk_gcode=:CODE: order by stepNum ASC  ";
        $bindparam = [
            'CODE'=> $Code,
            'ISDEL' => 0
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Load_Goods_Step_Material($code,$step,$fields=['ALL'])
    {
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM tbl_goods_step_material a JOIN tbl_material b WHERE a.fk_mcode=b.mcode and fk_gcode=:CODE: AND stepNum=:STEP: ";
        $bindparam = [
            'CODE'=> $code,
            'STEP' => $step
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }


    public function Insert_Goods_Step_Material($param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_goods_step_material');
        $affected = $builder->insertBatch($param);
        $this->db->transComplete();

        return $affected;
    }

    public function Insert_Goods_Process($param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_goods_process');
        $affected = $builder->insertBatch($param);
        $this->db->transComplete();

        return $affected;
    }

    public function Insert_Goods_Material($param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_goods_material');
        $affected = $builder->insertBatch($param);
        $this->db->transComplete();

        return $affected;
    }

    public function Insert_Goods_Info($param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_goods');
        $builder->insert($param);
        $insertID = $this->db->insertID();
        $this->db->transComplete();

        return $insertID;
    }

    public function Insert_Goods_Instructions($param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_goods_instructions');
        $builder->insert($param);
        $insertID = $this->db->insertID();
        $this->db->transComplete();

        return $insertID;
    }


}
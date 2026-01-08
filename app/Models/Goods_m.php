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

    public function Search_Goods_Info($skey,$fields=['ALL'])
    {
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM tbl_goods_info ";
        if($skey!=''){
            $sql .=  'WHERE is_del=0 AND gsname like :SKEY: ';
            $like = "%{$skey}%";
        }else{
            $like = '';
        }
        $bindparam = [
            'SKEY' => $like
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Load_Goods_Default($search, $fields = ['ALL'])
    {
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} ,IFNULL((SELECT gcode from tbl_goods where fk_gscode=a.gscode),'') AS gcode FROM tbl_goods_info a ";
        if($search===''){
            $searchword = '';
            $wheresql = "WHERE is_del=:ISDEL: ";
        }else{
            $searchword = "%{$search}%";
            $wheresql = "WHERE is_del=:ISDEL: AND (gscode LIKE :SEARCH: OR gsname LIKE :SEARCH:) ";
        }
        $wsql = $sql . $wheresql . 'order by seq DESC;';
        $bindparam = [
            'ISDEL' => 0,
            'SEARCH' => $searchword
        ];

        $query = $this->db->query($wsql, $bindparam);
        return $query->getResultArray();
    }


    public function Load_Goods_Each($code, $fields = ['ALL'])
    {
        $separated_val = fn_Make_Fields($fields);
//        $sql = "SELECT {$separated_val} FROM tbl_goods_info ";
        $sql = "SELECT {$separated_val} FROM tbl_goods_info WHERE gscode=:GSCODE: AND is_del=0";

        $bindparam = [
            'GSCODE' => $code,
        ];

        $query = $this->db->query($sql, $bindparam);
        return $query->getResultArray();
    }

//    public function Load_Maker_Each ($code,$fields=['ALL'])
//    {
//
//        $separated_val = fn_Make_Fields($fields);
//        $sql = "SELECT {$separated_val} FROM tbl_maker WHERE code=:CODE: AND is_del=0";
//
//        $bindparam = [
//            'CODE' => $code,
//        ];
//        $query = $this->db->query($sql,$bindparam);
//        return $query->getResultArray();
//    }


    public function Load_Goods_List($search, $fields = ['ALL'])
    {
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM vw_goods ";
        if($search===''){
            $searchword = '';
            $wheresql = "WHERE is_del=:ISDEL: ";
        }else{
            $searchword = "%{$search}%";
            $wheresql = "WHERE is_del=:ISDEL: AND (gcode LIKE :SEARCH: OR gsname LIKE :SEARCH:) ";
        }
        $wsql = $sql . $wheresql . 'order by seq DESC;';
        $bindparam = [
            'ISDEL' => 0,
            'SEARCH' => $searchword
        ];

        $query = $this->db->query($wsql, $bindparam);
        return $query->getResultArray();
    }

    public function Load_Goods_Code($code,$fields=['ALL'])
    {
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM vw_goods WHERE gcode=:CODE:";
        $bindparam = [
            'CODE' => $code
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }


    public function Load_Goods_Material($Code,$fields=['ALL'])
    {
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} from vw_goods_material WHERE fk_gcode=:CODE: AND is_del=:ISDEL: order by seq DESC  ";
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
        $sql = "SELECT {$separated_val} from tbl_goods_process WHERE fk_gcode=:CODE: and is_del=:ISDEL: order by stepNum ASC  ";
        $bindparam = [
            'CODE'=> $Code,
            'ISDEL' => 0
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Load_Goods_Step_Material($code,$prcode,$fields=['ALL'])
    {
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM tbl_goods_step_material a JOIN tbl_material b WHERE a.fk_mtcode=b.mtcode and fk_gcode=:CODE: AND fk_prcode=:PRCODE: and a.is_del=:ISDEL: ";
        $bindparam = [
            'CODE'=> $code,
            'PRCODE' => $prcode,
            'ISDEL' => 0
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Load_Goods_Step_Material_Data($code,$fields=['ALL'])
    {
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM tbl_goods_step_material where fk_gcode=:FKGCODE: and is_del=:ISDEL:";
        $bindparam = [
            'FKGCODE'=> $code,
            'ISDEL' => 0
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

    public function Delete_Goods_Step_Material($gcode){
        $param = ['is_del' => 1];
        $this->db->transStart();
        $builder = $this->db->table('tbl_goods_step_material');
        $builder->where('fk_gcode',$gcode);
        $builder->update($param);
        $affected_rows = $this->db->affectedRows();
        $this->db->transComplete();

        return $affected_rows;
    }

    public function Delete_Goods_Process($gcode){
        $param = ['is_del' => 1];
        $this->db->transStart();
        $builder = $this->db->table('tbl_goods_process');
        $builder->where('fk_gcode',$gcode);
        $builder->update($param);
        $affected_rows = $this->db->affectedRows();
        $this->db->transComplete();

        return $affected_rows;
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

    public function Delete_Goods_Material($gcode){
        $param = ['is_del' => 1];
        $this->db->transStart();
        $builder = $this->db->table('tbl_goods_material');
        $builder->where('fk_gcode',$gcode);
        $builder->update($param);
        $affected_rows = $this->db->affectedRows();
        $this->db->transComplete();

        return $affected_rows;
    }

    public function Insert_Goods_Info($param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_goods');
        $builder->insert($param);
        $insertID = $this->db->insertID();
        $this->db->transComplete();

        return $insertID;
    }

    public function Insert_ProductDefault_Info($param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_goods_info');
        $builder->insert($param);
        $insertID = $this->db->insertID();
        $this->db->transComplete();

        return $insertID;
    }

    public function Delete_Goods_Data($gcode)
    {
        $sql = "call DelGoods(:GCODE:);";
        $bindparam = [
            'GCODE' => $gcode
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Update_Goods_Info($gcode,$param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_goods');
        $builder->where('gcode',$gcode);
        $builder->update($param);
        $affected_rows = $this->db->affectedRows();
        $this->db->transComplete();

        return $affected_rows;
    }

    public function Update_ProductDefault_Info($gscode,$param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_goods_info');
        $builder->where('gscode',$gscode);
        $builder->update($param);
        $affected_rows = $this->db->affectedRows();
        $this->db->transComplete();

        return $affected_rows;
    }

    public function Delete_Goods_Info($gcode){
        $this->db->transStart();
        $builder = $this->db->table('tbl_goods');
        $builder->where('gcode',$gcode);
        $builder->delete();

        $affected_rows = $this->db->affectedRows();
        $this->db->transComplete();

        return $affected_rows;
    }

    public function Delete_ProductDefault_Info($gscode){
        $this->db->transStart();
        $builder = $this->db->table('tbl_goods_info');
        $builder->where('gscode',$gscode);
        $builder->delete();

        $affected_rows = $this->db->affectedRows();
        $this->db->transComplete();

        return $affected_rows;
    }



    public function Insert_Instructions($param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_instructions');
        $builder->insert($param);
        $insertID = $this->db->insertID();
        $this->db->transComplete();

        return $insertID;
    }

    public function Insert_Instructions_Material($param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_instructions_material');
        $affected = $builder->insertBatch($param);
        $this->db->transComplete();

        return $affected;
    }

    public function Insert_Instructions_Process($param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_instructions_process');
        $affected = $builder->insertBatch($param);
        $this->db->transComplete();

        return $affected;
    }

    public function Insert_Instructions_Step_Material($param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_instructions_step_material');
        $affected = $builder->insertBatch($param);
        $this->db->transComplete();

        return $affected;
    }

    public function Insert_Goods_All($param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_goods_info');
        $affected = $builder->insertBatch($param);
        $this->db->transComplete();

        return $affected;
    }




}
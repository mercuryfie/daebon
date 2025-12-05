<?php

namespace App\Models;


use CodeIgniter\Model;
use CodeIgniter\Config;
use App\Libraries\Utils;

class Material_m extends Model
{
    protected $db;

    public function __construct()
    {
        parent::__construct();

        $this->db = \Config\Database::connect('default');
    }





    public function Load_MaterialList_All($fields=['ALL'])
    {
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM tbl_material WHERE is_del=0 order by mtname ASC;";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function Load_MaterialList_Type($typ,$fields=['ALL'])
    {
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM tbl_material WHERE is_del=0 AND typ=:TYP: order by seq ASC;";
        $bindparam = [
            'TYP' => $typ
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Load_Material_Info($code,$fields=['ALL'])
    {
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM vw_material_info WHERE is_del=0 AND mtcode=:CODE:;";
        $bindparam = [
            'CODE' => $code
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Load_Material_MaxCode()
    {
        $sql = "SELECT MAX(mtcode) as MaxCode FROM vw_material_info;";
        $Query = $this->db->query($sql);
        $row = $Query->getRow();
        $MCode = ($row) ? $row->MaxCode : '';
        return $MCode;
    }

    public function Load_Material_Search($search,$fields=['ALL'])
    {
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM vw_material_info WHERE is_del=:ISDEL: ";
        if($search!=''){
            $sql .=  'AND (mtcode LIKE :SKEY: OR mtname LIKE :SKEY:)';
            $like =  "%{$search}%";
        }else{
            $like = '';
        }
        $bindparam = [
            'ISDEL' => 0,
            'SKEY' => $like
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Load_Material_statistics($mcode)
    {
        $sql = "call GetMaterialInout(:MCODE:);";
        $bindparam = [
            'MCODE' => $mcode
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Load_Goods_statistics($gcode,$glocation)
    {
        $sql = "call GetGoodsInout(:MCODE:,:LOCATION:);";
        $bindparam = [
            'MCODE' => $gcode,
            'LOCATION' => $glocation
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Cnt_Goods_InstructionsBygCode($code,$status)
    {
        $sql = "SELECT count(*) as Cnt FROM tbl_instructions where fk_gcode=:FKGCODE: and is_complete=:ISCOMPLETE:;";
        $bindparam = [
            'FKGCODE' => $code,
            'ISCOMPLETE' => $status
        ];
        $Query = $this->db->query($sql,$bindparam);
        $row = $Query->getRow();
        $MCode = ($row) ? $row->Cnt : '';
        return $MCode;
    }



    public function Insert_Material_Info($param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_material');
        $builder->insert($param);
        $insertID = $this->db->insertID();
        $this->db->transComplete();

        return $insertID;
    }
    public function Update_Material_Info($code,$param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_material');
        $builder->where('mtcode', $code);
        $builder->update($param);
        $affected_rows = $this->db->affectedRows();
        $this->db->transComplete();

        return $affected_rows;
    }


    public function Delete_Order($sn){
        $this->db->transStart();
        $builder = $this->db->table('herb_order_goods');
        $builder->set('gd_isdel', 1);
        $builder->where('sn', $sn);
        $builder->update();
        $affected_rows = $this->db->affectedRows();
        $this->db->transComplete();

        return $affected_rows;
    }



}
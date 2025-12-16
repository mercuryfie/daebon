<?php

namespace App\Models;


use CodeIgniter\Model;
use CodeIgniter\Config;
use App\Libraries\Utils;

class Product_m extends Model
{
    protected $db;

    public function __construct()
    {
        parent::__construct();

        $this->db = \Config\Database::connect('default');
    }

    public function Update_Product_Info($pdcode,$param) {
        $this->db->transStart();
        $builder = $this->db->table('tbl_product');
        $builder->where('pdcode',$pdcode);
        $builder->update($param);
        $affected_rows = $this->db->affectedRows();
        $this->db->transComplete();

        return $affected_rows;
    }


    public function Load_Product_File($pdcode,$fields=['ALL']){
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM tbl_product_files WHERE FK_pdcode=:PDCODE: ORDER BY seq ASC";
        $bindparam = [
            'PDCODE'=> $pdcode,
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Delete_Product_Material($pdcode){
        $this->db->transStart();
        $builder = $this->db->table('tbl_product_material');
        $builder->where('fk_pdcode',$pdcode);
        $builder->delete();

        $affected_rows = $this->db->affectedRows();
        $this->db->transComplete();

        return $affected_rows;
    }

    public function Delete_Product_Match($pdcode){
        $this->db->transStart();
        $builder = $this->db->table('tbl_product_matching');
        $builder->where('fk_pdcode',$pdcode);
        $builder->delete();

        $affected_rows = $this->db->affectedRows();
        $this->db->transComplete();

        return $affected_rows;
    }

    public function Delete_Product_File($pdcode){
        $this->db->transStart();
        $builder = $this->db->table('tbl_product_files');
        $builder->where('fk_pdcode',$pdcode);
        $builder->delete();

        $affected_rows = $this->db->affectedRows();
        $this->db->transComplete();

        return $affected_rows;
    }

    public function Delete_Product_Goods($pdcode){
        $this->db->transStart();
        $builder = $this->db->table('tbl_product_goods');
        $builder->where('fk_pdcode',$pdcode);
        $builder->delete();

        $affected_rows = $this->db->affectedRows();
        $this->db->transComplete();

        return $affected_rows;
    }

    public function Load_Product_Match($code,$fields=['ALL']){
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM tbl_product_matching WHERE FK_pdcode=:PDCODE: ORDER BY seq ASC";
        $bindparam = [
            'PDCODE'=> $code,
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Load_Product_Material($code,$fields=['ALL']){
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val}";
        $sql .= ",(select mtname from tbl_material where mtcode=a.fk_mtcode) as mtname ";
        $sql .= " FROM tbl_product_material a WHERE fk_pdcode=:PDCODE: ORDER BY seq ASC";
        $bindparam = [
            'PDCODE'=> $code,
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Load_Product_sub($code,$fields=['ALL']){
        $separated_val = fn_Make_Fields($fields);
        //$sql = "SELECT {$separated_val},(SELECT gsname FROM tbl_goods_info WHERE gscode=a.fk_gcode) AS gname FROM tbl_product_goods a WHERE a.fK_pdcode=:PDCODE: ORDER BY a.seq ASC";
        $sql = "SELECT {$separated_val} FROM tbl_product_goods a,tbl_goods_info b WHERE a.fk_gcode=b.gscode AND a.fK_pdcode=:PDCODE: ORDER BY a.seq ASC";
        $bindparam = [
            'PDCODE'=> $code,
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }


    public function Load_Product_Info($code,$fields=['ALL']){
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM tbl_product WHERE pdcode=:PDCODE: AND is_del=:ISDEL:";
        $bindparam = [
            'ISDEL' => 0,
            'PDCODE'=> $code,
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Load_Product_All($search,$fields = ['ALL'])
    {
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val}";
        $sql .= ",(select count(*) from tbl_product_matching where fk_pdcode=a.pdcode) as mCnt ";
        $sql .= ",(select count(*) from tbl_product_goods where fk_pdcode=a.pdcode) as gCnt ";
        $sql .= " FROM tbl_product a ";
        if($search===''){
            $searchword = '';
            $wheresql = "WHERE a.is_del=:ISDEL: ";
        }else{
            $searchword = "%{$search}%";
            $wheresql = "WHERE a.is_del=:ISDEL: AND (a.pdcode LIKE :SEARCH: OR a.pdname LIKE :SEARCH:) ";
        }
        $wsql = $sql . $wheresql . 'order by a.seq DESC;';
        $bindparam = [
            'ISDEL' => 0,
            'SEARCH' => $searchword
        ];
        $query = $this->db->query($wsql, $bindparam);
        return $query->getResultArray();
    }

    public function Insert_Product_Info($param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_product');
        $builder->insert($param);
        $insertID = $this->db->insertID();
        $this->db->transComplete();

        return $insertID;
    }


    public function Insert_Product_File($param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_product_files');
        $builder->insert($param);
        $insertID = $this->db->insertID();
        $this->db->transComplete();

        return $insertID;
    }

    public function Insert_Product_Match($param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_product_matching');
        $affected = $builder->insertBatch($param);
        $this->db->transComplete();

        return $affected;
    }

    public function Insert_Product_Goods($param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_product_goods');
        $affected = $builder->insertBatch($param);
        $this->db->transComplete();

        return $affected;
    }

    public function Insert_Product_Material($param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_product_material');
        $affected = $builder->insertBatch($param);
        $this->db->transComplete();

        return $affected;
    }

    public function Initialize_Product($gdcode)
    {
        $sql = "call DelProduct(:GDCODE:);";
        $bindparam = [
            'GDCODE' => $gdcode
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

}

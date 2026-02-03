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

    public function Load_Material_stock($mtcode,$fields=['ALL']){
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM tbl_material_inout WHERE fk_mtcode=:MTCODE: ORDER BY seq DESC LIMIT 1;";
        $bindparam = [
            'MTCODE' => $mtcode,
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }



    public function Load_Material_inout($search){
        $sql = "SELECT m1.*, CONCAT(mt.mtname, '||', mt.typ) AS mtstr FROM tbl_material_inout m1 ";
        $sql .="INNER JOIN (SELECT MAX(seq) AS max_seq FROM tbl_material_inout GROUP BY fk_mtcode ) m2 ON m1.seq = m2.max_seq ";
        $sql .="INNER JOIN tbl_material mt ON m1.fk_mtcode = mt.mtcode ";
        if($search!=''){
            $sql .= "WHERE (m1.fk_mtcode LIKE :LIKESTR: OR mt.mtname LIKE :LIKESTR:)";
            $like = "%{$search}%";
            $bindparam = ['LIKESTR' => $like];
        }else{
            $bindparam = [];
        }
        $sql .= ' order by m1.seq DESC';
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }


    public function Cnt_Maker_All()
    {
        $sql = "SELECT count(*) as Cnt FROM tbl_maker where is_del=:ISDEL:;";
        $bindparam = [ 'ISDEL' => 0 ];
        $Query = $this->db->query($sql,$bindparam);
        $row = $Query->getRow();
        $MCode = ($row) ? $row->Cnt : '';
        return $MCode;
    }



    public function Load_Maker_All($param,$fields=['ALL'])
    {
        $skey = $param['skey'];
        $limit = $param['limit'];
        $offset = $param['offset'];

        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM tbl_maker WHERE is_del=0 order by name ASC limit :LIMIT: offset :OFFSET: ";

        $bindparam = [
            'SKEY' => $skey,
            'LIMIT' => $limit,
            'OFFSET' => $offset
        ];

        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Load_Maker_Each ($code,$fields=['ALL'])
    {

        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM tbl_maker WHERE code=:CODE: AND is_del=0";

        $bindparam = [
            'CODE' => $code,
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Load_Maker_Search($param,$fields=['ALL'])
    {
        $skey = $param['skey'];

        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM tbl_maker WHERE is_del=0 order by name ASC";
        if($skey!=''){
            $sql .=  'AND (code LIKE :SKEY: OR name LIKE :SKEY:)';
            $like =  "%{$skey}%";
        }else{
            $like = '';
        }
        $bindparam = [
            'SKEY' => $skey,
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Load_Supplier_All($fields=['ALL'])
    {
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM tbl_supplier WHERE is_del=0 order by name ASC;";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function Load_Supplier_Each ($code,$fields=['ALL'])
    {

        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM tbl_supplier WHERE code=:CODE: AND is_del=0";

        $bindparam = [
            'CODE' => $code,
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Load_Supplier_Search($search,$fields=['ALL'])
    {
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM tbl_supplier WHERE is_del=:ISDEL: ";
        if($search!=''){
            $sql .=  'AND (code LIKE :SKEY: OR name LIKE :SKEY:)';
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

    public function Load_MaterialList_All($fields=['ALL'])
    {
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM vw_material_info WHERE is_del=:ISDEL: order by mtname ASC";
        $bindparam = [
            'ISDEL' => 0
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Load_MaterialList_Type($typ,$fields=['ALL'])
    {
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM vw_material_info WHERE is_del=0 AND typ=:TYP: order by seq ASC;";
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

    public function Load_Material_Filter($fkey,$fields=['ALL'])
    {
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM vw_material_info WHERE typ=:TYP: AND is_del=:ISDEL: ";

        $bindparam = [
            'ISDEL' => 0,
            'TYP' => $fkey,
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

    public function Insert_Maker_Info($param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_maker');
        $builder->insert($param);
        $insertID = $this->db->insertID();
        $this->db->transComplete();

        return $insertID;
    }

    public function Insert_Supplier_Info($param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_supplier');
        $builder->insert($param);
        $insertID = $this->db->insertID();
        $this->db->transComplete();

        return $insertID;
    }

    public function Insert_Supplier_All($param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_supplier');
        $affected = $builder->insertBatch($param);
        $this->db->transComplete();

        return $affected;
    }

    public function Insert_Maker_All($param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_maker');
        $affected = $builder->insertBatch($param);
        $this->db->transComplete();

        return $affected;
    }

    public function Insert_Material_All($param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_material');
        $affected = $builder->insertBatch($param);
        $this->db->transComplete();

        return $affected;
    }


    public function Update_Maker_Info($code,$param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_supplier');
        $builder->where('code', $code);
        $builder->update($param);
        $affected_rows = $this->db->affectedRows();
        $this->db->transComplete();

        return $affected_rows;
    }

    public function Update_Supplier_Info($code,$param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_supplier');
        $builder->where('code', $code);
        $builder->update($param);
        $affected_rows = $this->db->affectedRows();
        $this->db->transComplete();

        return $affected_rows;
    }

    public function Delete_Maker($code){
        $this->db->transStart();
        $builder = $this->db->table('tbl_maker');
        $builder->set('is_del', 1);
        $builder->where('code', $code);
        $builder->update();
        $affected_rows = $this->db->affectedRows();
        $this->db->transComplete();

        return $affected_rows;
    }


    public function Delete_Supplier($code){
        $this->db->transStart();
        $builder = $this->db->table('tbl_supplier');
        $builder->set('is_del', 1);
        $builder->where('code', $code);
        $builder->update();
        $affected_rows = $this->db->affectedRows();
        $this->db->transComplete();

        return $affected_rows;
    }

    public function Insert_Material_Info($param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_material');
        $builder->insert($param);
        $insertID = $this->db->insertID();
        $this->db->transComplete();

        return $insertID;
    }

    public function Insert_Material_Income($param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_material_inout');
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
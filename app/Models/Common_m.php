<?php

namespace App\Models;


use CodeIgniter\Model;
use CodeIgniter\Config;
use App\Libraries\Utils;

class Common_m extends Model
{
    protected $db;

    public function __construct()
    {
        parent::__construct();

        $this->db = \Config\Database::connect('default');
    }

    public function Insert_Log($param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_system_log');
        $builder->insert($param);
        $insertID = $this->db->insertID();
        $this->db->transComplete();

        return $insertID;
    }


    public function Load_Maker($fields=['ALL'])
    {
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM tbl_maker WHERE is_del=:ISDEL: order by name ASC;";
        $bindparam = [
            'ISDEL' => 0
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Load_Supply($fields=['ALL'])
    {
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM tbl_supplier WHERE is_del=:ISDEL: order by name ASC;";
        $bindparam = [
            'ISDEL' => 0
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Load_Material_Info($skey,$fields=['ALL'])
    {
        $separated_val = fn_Make_Fields($fields);
        if($skey=='') {
            $sql = "SELECT {$separated_val} FROM vw_category WHERE is_del=:ISDEL: order by cname ASC;";
            $bindparam = [
                'ISDEL' => 0
            ];
        }else{
            $sql = "SELECT {$separated_val} FROM vw_category WHERE is_del=:ISDEL: ";
            $sql .=  ' AND cname like :SKEY: order by cname ASC;';
            $like = "%{$skey}%";
            $bindparam = [
                'ISDEL' => 0,
                'SKEY' => $like
            ];
        }

        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }


    public function Load_Mall_List($typ,$fields=['ALL'])
    {
        $separated_val = fn_Make_Fields($fields);
        if($typ==''){
            $sql = "SELECT {$separated_val} FROM tbl_mall_info order by seq ASC;";
        }else {
            $sql = "SELECT {$separated_val} FROM tbl_mall_info WHERE method=:METHOD:  order by seq ASC;";
        }
        $bindparam = [
            'METHOD' => $typ
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Load_Mall_Log($code,$typ,$fields=['ALL'])
    {
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM tbl_mall_log where fk_shoptyp=:FKTYP: and typ=:TYP: order by seq DESC limit 1;";
        $bindparam = [
            'FKTYP' => $code,
            'TYP' => $typ
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Load_Mall_Log_All($code,$fields=['ALL'])
    {
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val},(select shop_name from tbl_mall_info where shoptyp=a.fk_shoptyp) as sname FROM tbl_mall_log a where fk_shoptyp=:FKTYP: order by seq DESC;";
        $bindparam = [
            'FKTYP' => $code
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

//    Board_NoticeRegister start

    public function Insert_Notice_Content($param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_board');
        $affected = $builder->insertBatch($param);
        $this->db->transComplete();

        return $affected;
    }

//    public function Load_NoticeList ($bcode, $fields=['ALL'])
//    {
//        $separated_val = fn_Make_Fields($fields);
//        $sql = "SELECT {$separated_val} FROM tbl_board where is_Del=:IS_DEL: order by regidate DESC;";
//        $bindparam = [
//            'IS_DEL' => 0
//        ];
//        $query = $this->db->query($sql,$bindparam);
//        return $query->getResultArray();
//    }

    public function Load_NoticeList($bcode,$fields=['ALL'])
    {
        $separated_val = fn_Make_Fields($fields);
        if($bcode=='') {
            $sql = "SELECT {$separated_val} FROM tbl_board WHERE is_Del=:IS_DEL: order by regidate DESC;";
            $bindparam = [
                'IS_DEL' => 0
            ];
        }else{
            $sql = "SELECT {$separated_val} FROM tbl_board WHERE is_Del=:IS_DEL: ";
            $sql .=  ' AND bcode like :BCODE:';
            $like = "%{$bcode}%";
            $bindparam = [
                'IS_DEL' => 0,
                'BCODE' => $like
            ];
        }

        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Load_NoticeInfo ($bcode,$fields=['ALL'])
    {
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM tbl_board where bcode=:BCODE: and is_Del=:IS_DEL:";
        $bindparam = [
            'BCODE' => $bcode,
            'IS_DEL' => 0
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Update_NoticeInfo($bcode,$param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_board');
        $builder->where('bcode', $bcode);
        $builder->update($param);
        $affected_rows = $this->db->affectedRows();
        $this->db->transComplete();

        return $affected_rows;
    }

    public function IsDel_NoticeInfo($bcode,$param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_board');
        $builder->where('bcode', $bcode);
        $builder->update($param);
        $affected_rows = $this->db->affectedRows();
        $this->db->transComplete();

        return $affected_rows;
    }


//    public function Load_NoticeInfo($bcode,$fields=['ALL'])
//    {
//        $separated_val = fn_Make_Fields($fields);
//        if($bcode=='') {
//            $sql = "SELECT {$separated_val} FROM tbl_board WHERE is_Del=:IS_DEL: order by regidate DESC;";
//            $bindparam = [
//                'IS_DEL' => 0
//            ];
//        }else{
//            $sql = "SELECT {$separated_val} FROM tbl_board WHERE is_Del=:IS_DEL: ";
//            $sql .=  ' AND bcode like :BCODE:';
//            $like = "%{$bcode}%";
//            $bindparam = [
//                'IS_DEL' => 0,
//                'BCODE' => $like
//            ];
//        }
//
//        $query = $this->db->query($sql,$bindparam);
//        return $query->getResultArray();
//    }

//    Board_NoticeRegister end



}
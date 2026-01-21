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


    public function Load_UserList ($fields=['ALL'])
    {
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM tbl_member where is_use=:IS_USE: order by uid DESC;";
        $bindparam = [
            'IS_USE' => 1
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Load_UserInfo ($uid,$fields=['ALL'])
    {
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM tbl_member where uid=:UID: and is_use=:IS_USE:";
        $bindparam = [
            'UID' => $uid,
            'IS_USE' => 1
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Insert_UserInfo ($param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_member');

        if (!empty($param['passwd'])) {
            $builder->set('passwd', "PASSWORD('{$param['passwd']}')", false);
            unset($param['passwd']);
        }

        $builder->insert($param);
        $insertID = $this->db->insertID();
        $this->db->transComplete();

        return $insertID;
    }

    public function Update_UserInfo($uid,$param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_member');
        $builder->where('uid',$uid);
        $builder->update($param);
        $affected_rows = $this->db->affectedRows();
        $this->db->transComplete();

        return $affected_rows;
    }

    public function Update_ResetPw($uid,$param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_member');
        $builder->where('uid',$uid);
        $builder->update($param);
        $affected_rows = $this->db->affectedRows();
        $this->db->transComplete();

        return $affected_rows;
    }

    public function Delete_UserInfo($uid){
        $this->db->transStart();
        $builder = $this->db->table('tbl_member');
        $builder->where('uid',$uid);
        $builder->delete();

        $affected_rows = $this->db->affectedRows();
        $this->db->transComplete();

        return $affected_rows;
    }

    public function Update_User_Passwd($uid,$passwd){
        $this->db->transStart();
        $builder = $this->db->table('tbl_member');
        $builder->set('passwd', "PASSWORD('{$passwd}')", FALSE);
        $builder->where('uid', $uid);
        $builder->update();

        $affected_rows = $this->db->affectedRows();
        $this->db->transComplete();

        return $affected_rows;
    }

    public function Insert_Delivery_Code($param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_delivery_code');
        $affected = $builder->insertBatch($param);
        $this->db->transComplete();

        return $affected;
    }



}
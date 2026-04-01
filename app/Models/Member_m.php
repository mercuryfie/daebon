<?php

namespace App\Models;


use CodeIgniter\Model;
use CodeIgniter\Config;
use App\Libraries\Utils;

class Member_m extends Model
{
    protected $db;

    public function __construct()
    {
        parent::__construct();

        $this->db = \Config\Database::connect('default');
    }

    public function Chk_Member_Userid($userid)
    {
        $sql = "SELECT count(*) AS Cnt from tbl_member WHERE userid=:USERID: and is_use=1";
        $bindparam = [
            'USERID' => $userid
        ];
        $Query = $this->db->query($sql, $bindparam);
        $row = $Query->getRow();
        $Cnt = ($row) ? $row->Cnt : 0;
        return $Cnt;
    }

    public function Cur_Pw_Check($uid,$pw_now)
    {
        $sql = "SELECT COUNT(*) AS Cnt FROM tbl_member WHERE is_use= 1 AND uid = :UID: AND passwd = PASSWORD(:PASSWD:);";
        $bindparam = [
            'UID' => (int)$uid,
            'PASSWD' => $pw_now
        ];
        $Query = $this->db->query($sql, $bindparam);
        $row = $Query->getRow();
        $Cnt = ($row) ? $row->Cnt : 0;
        return $Cnt;
    }

    public function Load_UserIDAPWD_Info($Param,$fields=['ALL'])
    {
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM tbl_member WHERE is_use=:ISUSE: and userid = :USERID: AND passwd = PASSWORD(:PWD:);";

        $bindparam = [
            'USERID' => $Param['userid'],
            'PWD' => $Param['passwd'],
            'ISUSE' => 1
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Load_UserInfo_Uid($uid,$fields=['ALL'])
    {
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM tbl_member WHERE uid=:UID:";
        $bindparam = [
            'UID' => $uid
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Load_Menu_Permission($uid,$fields=['ALL'])
    {
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM tbl_member_permission WHERE uid=:UID:";
        $bindparam = [
            'UID' => $uid
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

    public function Load_UserGrade_Type($gtyp,$fields=['ALL'])
    {
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM tbl_member WHERE is_use=1 AND grade=:GRADE: order by grade ASC;";
        $bindparam = [
            'GRADE' => $gtyp
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


}

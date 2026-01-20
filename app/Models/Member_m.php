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


    public function Load_UserIDAPWD_Info($Param,$fields=['ALL'])
    {
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM tbl_member WHERE is_use=:ISUSE: and userid = :USERID:  AND passwd = PASSWORD(:PWD:);";

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
    

}

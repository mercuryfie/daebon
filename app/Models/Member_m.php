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

    public function Load_Company_micode($micode,$fields=array('ALL')){
        $util = new Utils;
        $separated_val = $util->fnMake_Fields($fields);
        $builder = $this->db->table('herb_company');
        $builder->select($separated_val);
        $builder->where('mi_code',$micode);
        $query = $builder->get();

        return $query->getResultArray();
    }

    public function Load_Company_miType($mitype,$fields=array('ALL')){
        $util = new Utils;
        $separated_val = $util->fnMake_Fields($fields);
        $builder = $this->db->table('herb_company');
        $builder->select($separated_val);
        $builder->where('mi_type',$mitype);
        $builder->where('mi_use','Y');
        $query = $builder->get();

        return $query->getResultArray();
    }

    public function Load_Member_Uid($uid,$fields=array('ALL')){
        $util = new Utils;
        $separated_val = $util->fnMake_Fields($fields);
        $sql = "SELECT {$separated_val} from herb_member WHERE uid=:UID:";
        $param = array(
            'UID' => $uid
        );
        $Query = $this->db->query($sql, $param);
        return $Query->getResultArray();
    }


    public function Load_UserID_Info($Param,$fields=array('ALL')){
        $util = new Utils;
        $separated_val = $util->fnMake_Fields($fields);
        $sql = "SELECT {$separated_val} FROM V_MEMBER_INFO WHERE is_use=:ISUSE: and userid = :USERID:;";
        $state = array(
            'USERID' => $Param['userid'],
            'ISUSE' => 1
        );


        $query = $this->db->query($sql,$state);
        return $query->getResultArray();
    }

    public function Load_UserIDAPWD_Info($Param,$fields=array('ALL')){
        $util = new Utils;
        $separated_val = $util->fnMake_Fields($fields);
        $sql = "SELECT {$separated_val} FROM V_MEMBER_INFO WHERE is_use=:ISUSE: and userid = :USERID:   AND passwd = PASSWORD(:PWD:);";
        $state = array(
            'USERID' => $Param['userid'],
            'PWD' => $Param['passwd'],
            'ISUSE' => 1
        );
        $query = $this->db->query($sql,$state);
        return $query->getResultArray();
    }

    

}

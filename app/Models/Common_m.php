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



}
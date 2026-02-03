<?php

namespace App\Models;


use CodeIgniter\Model;
use CodeIgniter\Config;
use App\Libraries\Utils;

class Market_m extends Model
{
    protected $db;

    public function __construct()
    {
        parent::__construct();

        $this->db = \Config\Database::connect('default');
    }

    public function getMallLog($param, $fields = ['*'])
    {
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM tbl_mall_log WHERE fk_shoptyp=:FKSHOPTYP: AND typ=:TYP: order by seq DESC limit 1;";

        $bindparam = [
            'FKSHOPTYP' => $param['shoptyp'],
            'TYP' => 1
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function getCode($code, $fields = ['*'])
    {
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM tbl_product_matching WHERE fk_excode=:FKEXCODE:;";

        $bindparam = [
            'FKEXCODE' => $code
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Load_Mall_info($stype,$fields=['ALL']){
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM tbl_mall_info  where shoptyp=:SHOPTYP: ";
        $bindparam = [
            'SHOPTYP'=> $stype
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }


}
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
        $sql = "SELECT {$separated_val} FROM tbl_mall_log WHERE fk_shoptyp=:FKSHOPTYP: AND typ=:TYP: AND status=:STATUS:";

        $bindparam = [
            'FKSHOPTYP' => $param['shoptyp'],
            'TYP' => 1,
            'STATUS' => 'ok'
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }


}
<?php

namespace App\Models;


use CodeIgniter\Model;
use CodeIgniter\Config;
use App\Libraries\Utils;

class Produce_m extends Model
{
    protected $db;

    public function __construct()
    {
        parent::__construct();

        $this->db = \Config\Database::connect('default');
    }

    public function Load_Produce_List_All($search,$fields=['ALL'])
    {
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} from vw_produce WHERE is_del=:ISDEL: order by seq DESC  ";
        $bindparam = [
            'ISDEL' => 0
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Load_Produce_List_Code($Code,$fields=['ALL'])
    {
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} from vw_produce WHERE fk_gcode=:CODE: AND is_del=:ISDEL: order by seq DESC  ";
        $bindparam = [
            'CODE'=> $Code,
            'ISDEL' => 0
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }




}
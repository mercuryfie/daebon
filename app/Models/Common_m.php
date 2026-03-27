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

    public function Month_Order_Statistics($sdate,$edate){
        $sql = "SELECT DATE_FORMAT(orderdate,'%Y-%m-%d') AS sDate,COUNT(*) as Cnt FROM tbl_order WHERE orderdate >=:SDATE: ";
        $sql .= "AND orderdate< :EDATE: GROUP BY DATE_FORMAT(orderdate,'%Y-%m-%d')  ORDER BY 1 ASC";
        $bindparam = [
            'SDATE' => $sdate,
            'EDATE' => $edate
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Month_Delivery_Statistics($sdate,$edate){
        $sql = "SELECT DATE_FORMAT(indate,'%Y-%m-%d') AS sDate,COUNT(*) as Cnt FROM tbl_delivery_info WHERE indate >=:SDATE: ";
        $sql .= "AND indate< :EDATE: GROUP BY DATE_FORMAT(indate,'%Y-%m-%d')  ORDER BY 1 ASC";
        $bindparam = [
            'SDATE' => $sdate,
            'EDATE' => $edate
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
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

    public function Load_Mall_List($typ,$fields=['ALL'])
    {
        $separated_val = fn_Make_Fields($fields);
        if($typ==''){
            $sql = "SELECT {$separated_val}";
            $sql .= ",(select count(*) from tbl_order_miss where shoptyp=a.shoptyp) as missCnt ";
            $sql .= ",(select concat(startdate,'||',enddate,'||',indate) from tbl_mall_log where fk_shoptyp=a.shoptyp AND typ=1 order by seq DESC limit 1) as period ";
            $sql .= "FROM tbl_mall_info a order by seq ASC;";
        }else {
            $sql = "SELECT {$separated_val}";
            $sql .= ",(select count(*) from tbl_order_miss where shoptyp=a.shoptyp) as missCnt ";
            $sql .= ",(select concat(startdate,'||',enddate,'||',indate) from tbl_mall_log where fk_shoptyp=a.shoptyp AND typ=1 order by seq DESC limit 1) as period ";
            $sql .= "FROM tbl_mall_info a WHERE method=:METHOD:  order by seq ASC;";
        }
        $bindparam = [
            'METHOD' => $typ
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Load_Mall_List_All($fields=['ALL'])
    {
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM tbl_mall_info Order By seq ASC";
        $query = $this->db->query($sql);
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

    public function Del_Mall_Log($seq,$typ){
        $param = [
            'seq' => $seq,
            'fk_shoptyp' => $typ
        ];
        $this->db->transStart();
        $builder = $this->db->table('tbl_mall_log');
        $builder->where($param)->delete();
        $affected_rows = $this->db->affectedRows();
        $this->db->transComplete();
        return $affected_rows;
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

    public function Load_NoticeType_List($typ,$fields=['ALL']){
        $subsql = '';
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM tbl_board WHERE is_Del=:IS_DEL: ";
        if($typ==1){
            $subsql .= " AND is_Fix=:ISVALUE:";
        }else if($typ==2){
            $subsql .= " AND is_Notice=:ISVALUE:";
        }
        $sql = $sql . $subsql . " order by regidate DESC;";
        $bindparam = [
            'IS_DEL' => 0,
            'ISVALUE' => 1
        ];

        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }


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




}
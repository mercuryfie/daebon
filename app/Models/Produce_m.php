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

    public function Load_SemiProduct_Process($pscode,$fields=['ALL']){
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} from tbl_semiproduct_inout a JOIN tbl_instructions_process b ON a.fk_prcode=b.fk_prcode ";
        $sql .= " WHERE a.pscode=:PSCODE: ;";
        $bindparam = [
            'PSCODE'=> $pscode
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();

    }


    public function Load_SemiProduct_Company($pscode){
        $sql = "SELECT c.* FROM tbl_semiproduct_inout a ";
        $sql .="JOIN tbl_instructions_material b ON a.fk_gicode=b.fk_gicode ";
        $sql .="JOIN vw_material_info c ON b.fk_mtcode=c.mtcode ";
        $sql .="WHERE a.pscode=:PSCODE: AND m_input>0";
        $bindparam = [
            'PSCODE'=> $pscode
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();

    }


    public function Load_dashboardProduce_Info(){
        $sql = "SELECT COUNT(CASE WHEN is_complete = 0 AND step_now=0 THEN 1 END) AS count_ready,COUNT(CASE WHEN is_complete < 2 AND step_now > 0 THEN 1 END) AS count_ing,COUNT(CASE WHEN is_complete = 2 THEN 1 END) AS count_complete ";
        $sql .= "FROM tbl_instructions WHERE is_del = :ISDEL: AND DATE_FORMAT(indate, '%Y-%m-%d') = CURDATE() ";
        $bindparam = [
            'ISDEL'=> 0
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }



    public function Load_SemiProduct_Info($search){

        $sql = "SELECT a.seq,pscode,a.fk_gicode,b.gname,c.step_name,a.indate, ";
        $sql .= "SUM(m_input) AS total_input, SUM(m_output) AS total_output, (SUM(m_input) - SUM(m_output)) AS stock_amount ";
        $sql .= "FROM tbl_semiproduct_inout a JOIN tbl_instructions b ON a.fk_gicode=b.gicode JOIN tbl_instructions_process c ON a.fk_gicode=c.fk_gicode AND  c.fk_prcode=a.fk_prcode ";
        if($search!=''){
            $searchword = "%{$search}%";
            $wheresql = "WHERE (b.gname LIKE :SEARCH: OR c.step_name LIKE :SEARCH: OR a.fk_gicode LIKE :SEARCH: OR a.pscode LIKE :SEARCH:)";
        }else{
            $searchword = '';
            $wheresql = '';
        }

        $sql = $sql . $wheresql . "GROUP BY pscode ORDER BY indate DESC;";

        $bindparam = [
            'SEARCH'=> $searchword
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Load_SemiProduct_Info3($params,$paging){

        $search = array_key_exists('skey', $params) ? $params['skey'] : '';
        $limit =  $paging['limit'];
        $offset = $paging['offset'];

        $sql = "SELECT a.seq,pscode,a.fk_gicode,b.gname,c.step_name,a.indate, ";
        $sql .= "SUM(m_input) AS total_input, SUM(m_output) AS total_output, (SUM(m_input) - SUM(m_output)) AS stock_amount ";
        $sql .= "FROM tbl_semiproduct_inout a JOIN tbl_instructions b ON a.fk_gicode=b.gicode JOIN tbl_instructions_process c ON a.fk_gicode=c.fk_gicode AND  c.fk_prcode=a.fk_prcode ";
        if($search!=''){
            $searchword = "%{$search}%";
            $wheresql = "WHERE (b.gname LIKE :SEARCH: OR c.step_name LIKE :SEARCH: OR a.fk_gicode LIKE :SEARCH: OR a.pscode LIKE :SEARCH:)";
        }else{
            $searchword = '';
            $wheresql = '';
        }

        $sql = $sql . $wheresql . "GROUP BY pscode ORDER BY indate DESC limit :LIMIT: offset :OFFSET: ";

        $bindparam = [
            'SEARCH'=> $searchword,
            'LIMIT' => $limit,
            'OFFSET'=> $offset
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Load_SemiProduct_Info2($gscode,$typ,$fields=['ALL']){
        $separated_val = fn_Make_Fields($fields);
        if($typ==1) {
            $sql = "SELECT {$separated_val} from tbl_semiproduct_inout WHERE pscode=:PSCODE: AND m_input>0 order by seq DESC limit 1";
        }else{
            $sql = "SELECT {$separated_val} from tbl_semiproduct_inout WHERE pscode=:PSCODE: AND m_output>0 order by seq DESC limit 1";
        }
        $bindparam = ['PSCODE' => $gscode];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Cnt_Instructions_Process($typ,$gicode){
        if($typ==1) {
            $sql = "SELECT count(*) AS Cnt from tbl_instructions_process WHERE fk_gicode=:GICODE: and is_del=0";
        }else if($typ==2) {
            $sql = "SELECT count(*) AS Cnt from tbl_instructions_process WHERE fk_gicode=:GICODE: and status in(0,1) and is_del=0";
        }else if($typ==3) {
            $sql = "SELECT count(*) AS Cnt from tbl_instructions_process WHERE fk_gicode=:GICODE: and status=2 and is_del=0";
        }
        $bindparam = [
            'GICODE' => $gicode
        ];
        $Query = $this->db->query($sql, $bindparam);
        $row = $Query->getRow();
        $Cnt = ($row) ? $row->Cnt : 0;
        return $Cnt;
    }

    public function Load_Instructions_List_All2($params,$paging,$fields=['ALL'])
    {
        $sdate = array_key_exists('sdata', $params) ? $params['sdata'].' 00:00:00' : date("Y-m-d").' 00:00:00';
        $edate = array_key_exists('edata', $params) ? $params['edata'].' 23:59:59' : date("Y-m-d").' 23:59:59';
        $word = array_key_exists('skey', $params) ? $params['skey'] : '';
        $filter = array_key_exists('filter', $params) ? $params['filter'] : '';


        $limit =  $paging['limit'];
        $offset = $paging['offset'];

        $searchword = "%{$word}%";
        $wsql = "AND (indate >=:SDATE: AND indate <= :EDATE:) ";
        if($word!='') $wsql .= "AND (gicode LIKE :WORD: OR gname LIKE :WORD:) ";
        if($filter!='') $wsql .= "AND (a.is_complete = :FILTER:)";

        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val},";
        $sql .= "IFNULL((SELECT fk_prcode from tbl_instructions_process WHERE fk_gicode=a.gicode AND stepNum=a.step_now),'') AS nowprcode";
        $sql .= " from vw_produce a";
        $sql .= " WHERE is_del=:ISDEL: {$wsql} order by seq DESC  limit :LIMIT: offset :OFFSET:";
        $bindparam = [
            'SDATE' => $sdate,
            'EDATE' => $edate,
            'WORD' => $searchword,
            'FILTER' => $filter,
            'ISDEL' => 0,
            'LIMIT' => $limit,
            'OFFSET' => $offset
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Load_Instructions_List_All($param,$fields=['ALL'])
    {
        $stype = $param['stype'];
        $limit = $param['limit'];
        $offset = $param['offset'];

        $separated_val = fn_Make_Fields($fields);
        if($stype!=''){
            $wsql = ' AND is_complete='. $stype;
        }else{
            $wsql = '' ;
        }
        $sql = "SELECT {$separated_val},";
        $sql .= "IFNULL((SELECT fk_prcode from tbl_instructions_process WHERE fk_gicode=a.gicode AND stepNum=a.step_now),'') AS nowprcode";
        $sql .=" from vw_produce a WHERE is_del=:ISDEL: {$wsql} order by seq DESC  limit :LIMIT: offset :OFFSET:";
        $bindparam = [
            'ISDEL' => 0,
            'LIMIT' => $limit,
            'OFFSET' => $offset
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Load_Instructions_Info($gicode,$fields=['ALL'])
    {
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} ,";
        $sql .= "IFNULL((SELECT fk_prcode from tbl_instructions_process WHERE fk_gicode=a.gicode AND stepNum=a.step_now),'') AS nowprcode ,";
        $sql .= "IFNULL((SELECT fk_gscode FROM tbl_goods WHERE gcode=a.fk_gcode ),'') AS nowgscode ";
        $sql .= " from vw_produce a WHERE gicode=:GICODE: AND is_del=:ISDEL: order by seq DESC  ";
        $bindparam = [
            'GICODE'=> $gicode,
            'ISDEL' => 0
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Load_Instructions_Material($code,$fields=['ALL']){
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} from vw_instructions_material WHERE fk_gicode=:CODE: AND is_del=:ISDEL: order by seq DESC  ";
        $bindparam = [
            'CODE'=> $code,
            'ISDEL' => 0
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Load_Instructions_Process($code,$fields=['ALL']){
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} ,";
        $sql .= "IFNULL((SELECT name FROM vw_instructions_worker WHERE fk_gicode=a.fk_gicode AND fk_prcode=a.fk_prcode AND a.status=typ LIMIT 1),'') as worker ";
        $sql .= "from tbl_instructions_process a  WHERE fk_gicode=:CODE: AND is_del=:ISDEL: order by stepNum ASC  ";
        $bindparam = [
            'CODE'=> $code,
            'ISDEL' => 0
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Load_Instructions_Process_Info($gicode,$prcode,$fields=['ALL']){
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} ,";
        $sql .= "IFNULL((SELECT name FROM vw_instructions_worker  WHERE a.fk_gicode=fk_gicode AND fk_prcode=a.fk_prcode AND a.status=typ LIMIT 1),'') as worker ";
        $sql .= "from tbl_instructions_process a WHERE fk_gicode=:FKGICODE: AND fk_prcode=:PRCODE: AND is_del=:ISDEL:";
        $bindparam = [
            'FKGICODE'=> $gicode,
            'PRCODE' => $prcode,
            'ISDEL' => 0
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Load_Instructions_NowProcess($gicode,$stepnum,$fields=['ALL']){
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val},";
        $sql .= "IFNULL((SELECT name FROM vw_instructions_worker  WHERE fk_gicode=a.fk_gicode AND fk_prcode=a.fk_prcode AND a.status=typ LIMIT 1),'') as worker ";
        $sql .= "from tbl_instructions_process a WHERE fk_gicode=:GICODE: AND stepNum = :STEPNUM: AND is_del=:ISDEL: ORDER BY seq DESC LIMIT 1;";
        $bindparam = [
            'GICODE'=> $gicode,
            'STEPNUM' => $stepnum,
            'ISDEL' => 0
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Load_Instructions_Worker($gicode,$prcode,$typ,$fields=['ALL']){
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} from tbl_instructions_worker a,tbl_member b WHERE a.uid=b.uid AND fk_gicode=:GICODE: AND fk_prcode=:PRCODE: AND typ=:TYPE: AND is_del=:ISDEL:";
        $bindparam = [
            'GICODE' => $gicode,
            'PRCODE'=> $prcode,
            'TYPE' => $typ,
            'ISDEL' => 0
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Load_Instructions_Step_Material($code,$prcode,$fields=['ALL']){
        $separated_val = fn_Make_Fields($fields);
        $sql = "SELECT {$separated_val} FROM tbl_instructions_step_material a JOIN tbl_material b WHERE a.fk_mtcode=b.mtcode and a.fk_gicode=:CODE: AND a.fk_prcode=:PRCODE: and a.is_del=:ISDEL: ";
        $bindparam = [
            'CODE'=> $code,
            'PRCODE' => $prcode,
            'ISDEL' => 0
        ];
        $query = $this->db->query($sql,$bindparam);
        return $query->getResultArray();
    }

    public function Insert_Instructions_Worker($param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_instructions_worker');
        $builder->insert($param);
        $insertID = $this->db->insertID();
        $this->db->transComplete();

        return $insertID;
    }

    public function Insert_SemiProduct($param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_semiproduct_inout');
        $builder->insert($param);
        $insertID = $this->db->insertID();
        $this->db->transComplete();

        return $insertID;
    }

    public function Insert_FinalProduct($param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_goods_inout');
        $builder->insert($param);
        $insertID = $this->db->insertID();
        $this->db->transComplete();

        return $insertID;
    }

    public function Update_Instructions_Process($gicode,$prcode,$param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_instructions_process');
        $builder->where('fk_gicode',$gicode);
        $builder->where('fk_prcode',$prcode);
        $builder->update($param);
        $affected_rows = $this->db->affectedRows();
        $this->db->transComplete();

        return $affected_rows;
    }

    public function Update_Instructions_Info($gicode,$param){
        $this->db->transStart();
        $builder = $this->db->table('tbl_instructions');
        $builder->where('gicode',$gicode);
        $builder->update($param);
        $affected_rows = $this->db->affectedRows();
        $this->db->transComplete();

        return $affected_rows;
    }




}
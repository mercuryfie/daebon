<?php

namespace App\Controllers;


use App\Libraries\Auth;
use CodeIgniter\API\ResponseTrait;
use Firebase\JWT\JWT;


class ApiProductController extends BaseController
{
    use ResponseTrait;

    public function Load_Goods_List(){

    }


    public function Load_Product_Detail(){
        $sessinarr = $this->GetSessionData();
        $pdcode = ($this->request->getPost('code')=='') ? '' : $this->request->getPost('code');
        if($sessinarr['islogin']==false) {
            $result = 'NoLogin';
            $data = [];
            $message = '로그인이 필요합니다.';
        }else if($pdcode==''){
            $result = 'Error001';
            $data = [];
            $message = '잘못된 접근입니다.';
        }else if(!Check_Token($sessinarr)) {
            $result = 'Error002';
            $data = [];
            $message = '잘못된 토큰입니다.';
        }else{
            $product_m = model('Product_m');
            $mRs = $product_m->Load_Product_Match($pdcode);
            $match_arr = (fn_ArrayCnt($mRs)===0) ? [] : $mRs;
            $sRs = $product_m->Load_Product_sub($pdcode);
            $goods_arr = (fn_ArrayCnt($sRs)===0) ? [] : $sRs;
            $tRs = $product_m->Load_Product_Material($pdcode);
            $material_arr = (fn_ArrayCnt($tRs)===0) ? [] : $tRs;

            $p_arr = [
                'pdcode' => $pdcode,
                'match' => $match_arr,
                'goods' => $goods_arr,
                'material' => $material_arr
            ];


            $i_arr = [
                'info' => $p_arr
            ];

            $result = 'ok';
            $data = $i_arr;
            $message = '';
        }
        $return = [
            'result' => $result,
            'info' => $data,
            'message' => $message
        ];
        return $this->respond($return);
    }


    public function Edit_Product(){
        $sessinarr = $this->GetSessionData();
        $data = $this->request->getPost('data') ?? [];
        if($sessinarr['islogin']==false) {
            $result = 'NoLogin';
            $data = [];
            $message = '로그인이 필요합니다.';
        }else if(fn_ArrayCnt($data)===0){
            $result = 'Error001';
            $data = [];
            $message = '잘못된 접근입니다.';
        }else if(!Check_Token($sessinarr)) {
            $result = 'Error002';
            $data = [];
            $message = '잘못된 토큰입니다.';
        }else{
            $info = $data['info'];
            $file = ($data['file']==='') ? '' : $data['file'];
            $match = $data['macthing'] ?? [];
            $goods = $data['goods'] ?? [];
            $material = $data['material'] ?? [];

            $product_m = model('Product_m');

            $pdcode = $info['pdcode'];
            $info_arr = [
                'pdname' => $info['pTitle'],
                'pdcategory' => $info['category'],
                'pdprice' => $info['pPrice'],
                'pdWeigth' => $info['pWeigth'],
                'content' => $info['str_editor'],
                'is_sale' => $info['sell_type'],
                'is_del' => 0
            ];
            $Cnt = $product_m->Update_Product_Info($pdcode,$info_arr);

            if($file['fname']!=''){
                $Cnt = $product_m->Delete_Product_File($pdcode);
                $file_arr = [
                    'fk_pdcode' => $pdcode,
                    'fname' => $file['fname']
                ];
                $Cnt = $product_m->Insert_Product_File($file_arr);
                //실제 파일 delete는 차후에 추가
            }

            if (fn_ArrayCnt($goods) > 0) {
                $Cnt = $product_m->Delete_Product_Goods($pdcode);
                $goods_arr = [];
                foreach ($goods as $d) {
                    $t_arr = [
                        'fk_pdcode' => $pdcode,
                        'fk_gcode' => $d['gcode'],
                        'cnt' => $d['gcnt']
                    ];

                    array_push($goods_arr, $t_arr);
                }
                $Cnt = $product_m->Insert_Product_Goods($goods_arr);
            }

            if (fn_ArrayCnt($match) > 0) {
                $Cnt = $product_m->Delete_Product_Match($pdcode);
                $match_arr = [];
                foreach ($match as $d) {
                    $t_arr = [
                        'fk_pdcode' => $pdcode,
                        'fk_excode' => $d['m_code'],
                        'ex_type' => $d['m_type'],
                        'is_del' => 0
                    ];

                    array_push($match_arr, $t_arr);
                }
                $Cnt = $product_m->Insert_Product_Match($match_arr);
            }else{
                $Cnt = $product_m->Delete_Product_Match($pdcode);
            }


            if (fn_ArrayCnt($material)>0) {
                $Cnt = $product_m->Delete_Product_Material($pdcode);
                $pouch_arr = [];
                foreach ($material as $d) {
                    $t_arr = [
                        'fk_pdcode' => $pdcode,
                        'fk_mtcode' => $d['pcode'],
                        'cnt' => $d['pcnt']
                    ];

                    array_push($pouch_arr, $t_arr);
                }
                $Cnt = $product_m->Insert_Product_Material($pouch_arr);
            }else{
                $Cnt = $product_m->Delete_Product_Material($pdcode);
            }

            $i_arr =['gdcode' => $pdcode];

            $result = 'ok';
            $data = $i_arr;
            $message = '';
        }

        $return = [
            'result' => $result,
            'info' => $data,
            'message' => $message
        ];
        return $this->respond($return);
    }

    public function Load_Product_Info(){
        $sessinarr = $this->GetSessionData();
        $pdcode = ($this->request->getPost('code')==='') ? '' : $this->request->getPost('code');
        if($sessinarr['islogin']==false) {
            $result = 'NoLogin';
            $data = [];
            $message = '로그인이 필요합니다.';
        }else if(!Check_Token($sessinarr)) {
            $result = 'Error002';
            $data = [];
            $message = '잘못된 토큰입니다.';
        }else{
            $product_m = model('Product_m');
            $iRs = $product_m->Load_Product_Info($pdcode);
            $p_arr = [];
            if(fn_ArrayCnt($iRs)===0){
                alert('존재하지 않는 상품입니다.');
            }else{
                $info_arr = $iRs[0];

                $fRs = $product_m->Load_Product_File($pdcode);
                $file_arr = (fn_ArrayCnt($fRs)===0) ? [] : $fRs;
                $mRs = $product_m->Load_Product_Match($pdcode);
                $match_arr = (fn_ArrayCnt($mRs)===0) ? [] : $mRs;
                $sRs = $product_m->Load_Product_sub($pdcode);
                $goods_arr = (fn_ArrayCnt($sRs)===0) ? [] : $sRs;
                $tRs = $product_m->Load_Product_Material($pdcode);
                $material_arr = (fn_ArrayCnt($tRs)===0) ? [] : $tRs;

                $p_arr = [
                    'info' => $info_arr,
                    'file' => $file_arr,
                    'match' => $match_arr,
                    'goods' => $goods_arr,
                    'material' => $material_arr
                ];
            }

            $i_arr = [
                'info' => $p_arr
            ];

            $result = 'ok';
            $data = $i_arr;
            $message = '';
        }

        $return = [
            'result' => $result,
            'info' => $data,
            'message' => $message
        ];
        return $this->respond($return);

    }


    public function Load_Product_List(){
        $sessinarr = $this->GetSessionData();
        $search = ($this->request->getPost('search')==='') ? '' : $this->request->getPost('search');
        if($sessinarr['islogin']==false) {
            $result = 'NoLogin';
            $data = [];
            $message = '로그인이 필요합니다.';
        }else if(!Check_Token($sessinarr)) {
            $result = 'Error002';
            $data = [];
            $message = '잘못된 토큰입니다.';
        }else{
            $product_m = model('Product_m');
            $pRs = $product_m->Load_Product_All($search);
            $p_arr = [];
            if(fn_ArrayCnt($pRs)>0){
                foreach ($pRs as $d){
                    $t_arr = [
                        'seq' => $d['seq'],
                        'pdcode' => $d['pdcode'],
                        'pdname' => $d['pdname'],
                        'pdWeigth' => $d['pdweigth'],
                        'cname' => fnGetProductNameByCode($d['pdcategory']),
                        'pdprice' => $d['pdprice'],
                        'indate' => fn_Short_Date($d['indate']),
                        'mCnt' => $d['mCnt'],
                        'gCnt' => $d['gCnt']
                    ];
                    array_push($p_arr,$t_arr);
                }
            }

            $i_arr = [
                'list' => $p_arr,
                'total' => fn_ArrayCnt($pRs)
            ];

            $result = 'ok';
            $data = $i_arr;
            $message = '';
        }

        $return = [
            'result' => $result,
            'info' => $data,
            'message' => $message
        ];
        return $this->respond($return);

    }

    public function Insert_Product(){
        $sessinarr = $this->GetSessionData();
        $data = $this->request->getPost('data') ?? [];
        if($sessinarr['islogin']==false) {
            $result = 'NoLogin';
            $data = [];
            $message = '로그인이 필요합니다.';
        }else if(fn_ArrayCnt($data)===0){
            $result = 'Error001';
            $data = [];
            $message = '잘못된 접근입니다.';
        }else if(!Check_Token($sessinarr)) {
            $result = 'Error002';
            $data = [];
            $message = '잘못된 토큰입니다.';
        }else{
            $info = $data['info'];
            $file = $data['file'] ?? [];
            $goods = $data['goods'] ?? [];
            $match = $data['macthing'] ?? [];
            $material = $data['pouch'] ?? [];

            $product_m = model('Product_m');

            $pdcode = $info['pdcode'];
            $info_arr = [
                'pdcode' => $pdcode,
                'pdname' => $info['pTitle'],
                'pdcategory' => $info['category'],
	            'pdprice' => $info['pPrice'],
	            'pdWeigth' => $info['pWeigth'],
	            'content' => $info['str_editor'],
	            'is_sale' => $info['sell_type'],
	            'is_del' => 0
            ];
            $Cnt1 = $product_m->Insert_Product_Info($info_arr);
            if($Cnt1===0){
                $result = 'Error003';
                $data = [];
                $message = '상품정보 등록에 실패 하였습니다.';
            }else if($file['fname']==='') {
                $result = 'Error004';
                $data = [];
                $message = '대표이미지는 필수 입력 항목입니다.';
            }else {
                $file_arr = [
                    'fk_pdcode' => $pdcode,
                    'fname' => $file['fname']
                ];
                $Cnt2 = $product_m->Insert_Product_File($file_arr);
                if ($Cnt2 === 0) {
                    $result = 'Error005';
                    $data = [];
                    $message = '파일 등록에 실패 하였습니다.';
                } else if (fn_ArrayCnt($goods) === 0) {
                    $result = 'Error006';
                    $data = [];
                    $message = '제품정보는 필수 입력 항목입니다.';
                } else {
                    $goods_arr = [];
                    foreach ($goods as $d) {
                        $t_arr = [
                            'fk_pdcode' => $pdcode,
                            'fk_gcode' => $d['gcode'],
                            'cnt' => $d['gcnt']
                        ];

                        array_push($goods_arr, $t_arr);
                    }
                    $Cnt3 = $product_m->Insert_Product_Goods($goods_arr);
                    if ($Cnt3 === 0) {
                        $result = 'Error007';
                        $data = [];
                        $message = '제품정보 등록에 실패 하였습니다.';
                    } else {
                        if (fn_ArrayCnt($match) > 0) {
                            $match_arr = [];
                            foreach ($match as $d) {
                                $t_arr = [
                                    'fk_pdcode' => $pdcode,
                                    'fk_excode' => $d['m_code'],
                                    'ex_type' => $d['m_type'],
                                    'is_del' => 0
                                ];

                                array_push($match_arr, $t_arr);
                            }
                            $Cnt = $product_m->Insert_Product_Match($match_arr);
                        }

                        if (fn_ArrayCnt($material)>0) {
                            $material_arr = [];
                            foreach ($material as $d) {
                                $t_arr = [
                                    'fk_pdcode' => $pdcode,
                                    'fk_mtcode' => $d['pcode'],
                                    'cnt' => $d['pcnt']
                                ];

                                array_push($material_arr, $t_arr);
                            }
                            $Cnt = $product_m->Insert_Product_Material($material_arr);
                        }

                        $i_arr =['gdcode' => $pdcode];

                        $result = 'ok';
                        $data = $i_arr;
                        $message = '';
                    }
                }
            }
            if($result!='ok'){
                $cRs = $product_m->Initialize_Product($pdcode);
            }
        }

        $return = [
            'result' => $result,
            'info' => $data,
            'message' => $message
        ];
        return $this->respond($return);
    }


    public function Upload_file()
    {
        $key = ($this->request->getPost('key') == '') ? '' : $this->request->getPost('key');
        if ($key == '') {
            $result = 'type101';
            $message = '잘못된 접근입니다.';
        } else {
            $allow = $request->getPost('allow');
//            $fn_code = $request->getPost('hn_code');
            $fn_code = $request->getPost('fname');
            $typ = $request->getPost('typ');
            $method = $request->getPost('method');
            $allowed_extensions = explode(',', $allow);
            $file = $this->request->getFile($key);
            if ($file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $max_file_size = 5242880; // 5M
                    $filename = $file->getName();
                    $ext = substr($filename, strrpos($filename, '.') + 1);
                    $size = $file->getSize();
                    if (!in_array($ext, $allowed_extensions)) {
                        $result = 'type102';
                        $message = '업로드는 [' . $allow . '] 확장자만 가능합니다.';
                    } else if ($size >= $max_file_size) {
                        $result = 'type103';
                        $message = '업로드는 [' . fn_Str_File_Sise($max_file_size) . '] 까지만 가능합니다.';
                    } else {
                        if ($key == 'attachImg') {
                            $dir = "././assets/product/image";
                            $upload_dir = $dir . '/';
                        } else if ($key == 'attachFile') {
                            $dir = "././assets/product/data";
                            $upload_dir = $dir . '/';
                        } else {
                            $timeNow = date("Ymd");
                            $dir = "././assets/upload/$timeNow";
                            $upload_dir = $dir . '/';
                        }
                        if (is_dir($dir) != true) {
                            mkdir($dir, 0777, true);
                        }
                        helper('text');
                        $fileName = random_string('alnum', 16);
                        $path = $fileName . '.' . $ext;
                        if (move_uploaded_file($file->getTempName(), $upload_dir . $path)) {
                            $insert = [
                                'fk_fncode' => $fn_code,
                                'fname' => $path,
                                'typ' => $typ
                            ];
                            $herb_m = model('Herb_m');
                            $insertid = $herb_m->Insert_Attach_File($insert);
                            if ($insertid > 0) {
                                if($method=='edit') {
                                    $param = ['isDel' => 1];
                                    $DelCnt = $herb_m->Update_Product_File2($fn_code,$typ, $insertid, $param);
                                }
                                $result = 'ok';
                                $message = 'success';
                            } else {
                                $result = 'type106';
                                $message = '파일 업로드 정보 업데이트에 실패 하였습니다.(Error101)';
                            }
                        } else {
                            $result = 'type105';
                            $message = '파일 업로드 정보 업데이트에 실패 하였습니다.(Error102)';
                        }
                    }
                } else {
                    $result = 'type104';
                    $message = '파일이 선택되지 않았습니다. 다시 시도하여주세요.(Error103)';
                }
            } else {
                $result = 'type111';
                $message = '파일이 선택되지 않았습니다. 다시 시도하여주세요.(Error104)';
            }
        }
        $return = [
            'result' => $result,
            'info' => '',
            'message' => $message
        ];
        return $this->respond($return);
    }

}
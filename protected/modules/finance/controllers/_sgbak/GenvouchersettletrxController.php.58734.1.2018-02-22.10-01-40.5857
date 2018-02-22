<?php

Class GenvouchersettletrxController extends AAdminController
{
    public $layout='//layouts/admin_column3';
    public $menuName = 'GENERATE VOUCHER SETTLE TRX';
    
    public function actionAjxGetDueDate()
    {
        $due_date = '';
        
        if(isset($_POST['trxDate']))
        {
            $trx_date = $_POST['trxDate'];
            $result2 = DAO::queryRowSql("SELECT TO_CHAR(GET_DUE_DATE(F_GET_SETTDAYS(TO_DATE('$trx_date','DD/MM/YYYY')), TO_DATE('$trx_date','DD/MM/YYYY')),'DD/MM/YYYY') due_date FROM dual");
            
            $due_date = $result2['due_date'];
        }
        
        echo json_encode($due_date);
    }
    
    public function actionIndex()
    {
        $model = new GenVoucherSettleTrx('header');
        $modelVoucherList = array();
        $retrieved = false;
        $valid = false;
        $success = false;
        
        if(isset($_POST['GenVoucherSettleTrx']))
        {
            $model->attributes = $_POST['GenVoucherSettleTrx'];
            
            if($model->client_type == 'C')
            {
                $scenario = 'custody';
            }
            else if($model->client_type == 'R')
            {
                $scenario = 'regular';  
            }
            else if($model->client_type=='CR')
            {
                $scenario = 'custody';
            }
            else 
            {

            }   
                
            if($_POST['submit'] == 'retrieve')
            {
                if($model->validate())
                {
                    if($model->client_type == 'C')
                    {
                        $result = DAO::queryAllSql(GenVoucherSettleTrx::getSettleTrxCustodySql($model->trx_date, $model->due_date,'N'));
                    }
                    else if($model->client_type == 'R')
                    {
                        $result = DAO::queryAllSql(GenVoucherSettleTrx::getSettleTrxRegularSql($model->trx_date, $model->due_date, $model->brch_cd));
                    }
                    else if($model->client_type == 'CR')
                    {
                        $result = DAO::queryAllSql(GenVoucherSettleTrx::getSettleTrxCustodySql($model->trx_date, $model->due_date,'Y'));
                    }
                    else {
                        $result = '';
                    }
                    
                    if($result)$retrieved = true;
                    

                    
                    $x = 0;
                    foreach($result as $row)
                    {
                        $modelVoucherList[$x] = new GenVoucherSettleTrx($scenario);
                        $modelVoucherList[$x]->attributes = $row;
                                                
                        $x++;
                    }
                    
                    $check = Sysparam::model()->find("param_id = 'SYSTEM' AND param_cd1 = 'VCH_REF' ")->dflg1;
                    if($check == 'Y' && $model->client_type == 'R')
                    {
                        $folder_cd2 = Sysparam::model()->find("param_id = 'VOUCHER ENTRY' AND param_cd1 = 'PAYMENT' AND param_cd2 = 'FOLDERCD' AND param_cd3 = 'CHAR3' ");
                        
                        /*if($folder_cd1 && $folder_cd2)
                        {
                            foreach($modelVoucherList as $row)
                            {
                                $row->vch_ref = $folder_cd1->dstr1.$folder_cd2->dstr1;
                            }
                        }*/
                        
                        foreach($modelVoucherList as $row)
                        {
                            $result = DAO::queryRowSql("SELECT bank_cd FROM MST_CLIENT_FLACCT WHERE client_cd = '$row->client_cd' AND acct_stat IN ('A','I')");
                            $bank_cd = $result['bank_cd'];
                            
                            $folder_cd1 = DAO::queryRowSql("SELECT dstr1 FROM MST_SYS_PARAM WHERE param_id = 'VOUCHER ENTRY' AND param_cd1 = 'RDI_PAY' AND param_cd2 = 'FOLDERCD' AND param_cd3 = '$bank_cd' ");
                            
                            if(!$folder_cd1)$folder_cd1['dstr1'] = '';
                            
                            if($folder_cd2)
                                $row->vch_ref = $folder_cd1['dstr1'].$folder_cd2->dstr1;
                            else 
                                $row->vch_ref = $folder_cd1['dstr1'];
                        }
                    }

                    $model->trx_date = DateTime::createFromFormat('Y-m-d',$model->trx_date)->format('d/m/Y');
                    $model->due_date = DateTime::createFromFormat('Y-m-d',$model->due_date)->format('d/m/Y');
                }
            }
            else 
            {
                $retrieved = true;
                $valid = true;          
                $generateFlg = false;
                
                $x = 0;
                
                foreach($_POST['VoucherList'] as $row)
                {
                    $modelVoucherList[$x] = new GenVoucherSettleTrx($scenario);
                    $modelVoucherList[$x]->attributes = $row;
                    $modelVoucherList[$x]->trx_date = $model->trx_date;
                    
                    if($row['generate'] == 'Y')
                    {
                        $generateFlg = true;
                        $modelVoucherList[$x]->payrec_date = $modelVoucherList[$x]->due_date;
                        $modelVoucherList[$x]->folder_cd = strtoupper($modelVoucherList[$x]->vch_ref);
                        $valid = $modelVoucherList[$x]->validate() && $valid;
                    }
                    
                    $x++;
                }
                
                if($model->client_type == 'R')
                {
                    if($valid)
                    {
                        $vchListCnt = count($modelVoucherList);
                        for($x=0;$valid && $x<$vchListCnt;$x++)
                        {
                            if($modelVoucherList[$x]->generate == 'Y')
                            {
                                for($y=$x+1;$y<$vchListCnt;$y++)
                                {
                                    if($modelVoucherList[$y]->generate == 'Y')
                                    {
                                        if($modelVoucherList[$x]->vch_ref == $modelVoucherList[$y]->vch_ref)
                                        {
                                            $valid = false;
                                            $modelVoucherList[$y]->addError('vch_ref','Duplicated Folder Code');
                                            break;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                
                if($valid && $generateFlg)
                {
                    $connection  = Yii::app()->db;
                    $transaction = $connection->beginTransaction();
                    
                    $success = TRUE;
                    
                    $successCnt = $failCnt = 0;
                    $failMsg = '';
                    $outs_client=array();
                    foreach($modelVoucherList as $row)
                    {
                        if($row->generate == 'Y')
                        {
                             
                            if( ( $model->client_type=='R' && $row->piutang == 0 && $row->net_buy < $row->net_sell) || ($model->client_type=='R' && $row->net_buy > $row->net_sell)  || $model->client_type=='C' ||$model->client_type=='CR')
                            {
                                
                                if($success && $row->executeSpHeader(AConstant::INBOX_STAT_INS,$this->menuName) > 0)$success = TRUE;
                                else {
                                    $success = FALSE;
                                }
                                
                                if($success && $row->executeSpSettleCustody(AConstant::INBOX_STAT_INS, $model->client_type) > 0)$success = TRUE;
                                else {
                                    $success = FALSE;
                                }
                                
                                if($success)
                                {
                                    if($row->fail_vch == 0)$successCnt++;
                                    else {
                                        $failCnt++;
                                        $failMsg = $row->error_msg;
                                    }
                                }
                                else {
                                    break;
                                }
                            }
                            else//if outstanding 
                            {
                            	$outs_client[]=$row->client_cd .' Outstading = '.$row->piutang;
                            }       
                        }
                    }
                    
                    if($success)
                    {
                        $transaction->commit();
                        
                        if($successCnt > 0)
                        {
                            Yii::app()->user->setFlash('success', 'Generate Voucher Success: '.$successCnt.' --- Fail: '.$failCnt.'. '.$failMsg);
                            //$this->redirect(array('index'));
                        }
                        else {
                            Yii::app()->user->setFlash('error', 'Generate Voucher Success: '.$successCnt.' --- Fail: '.$failCnt.'. '.$failMsg);
                        }
                       
                       $msg = '';
                       $x=0;
                        foreach($outs_client as $row)
                        {
                            if($x>0)$msg.=" , ";
                            $msg.=$row;
                           $x++;
                        }
                        if($msg)
                        {
                           Yii::app()->user->setFlash('info',$msg);
                        }
                             
                    }
                    else {
                        $transaction->rollback();
                    }
                }
            }
        }
        else 
        {
            $model->client_type = 'C';
            
            $result = DAO::queryRowSql("SELECT TO_CHAR(MAX(CONTR_DT),'DD/MM/YYYY') trx_date FROM T_CONTRACTS WHERE CONTR_DT >= TRUNC(SYSDATE) - 20");
            
            if($result)
            {
                $model->trx_date = $result['trx_date'];
                $result2 = DAO::queryRowSql("SELECT TO_CHAR(GET_DUE_DATE(F_GET_SETTDAYS(TO_DATE('$model->trx_date','DD/MM/YYYY')), TO_DATE('$model->trx_date','DD/MM/YYYY')),'DD/MM/YYYY') due_date FROM dual");
                $model->due_date = $result2['due_date'];
            }
        }
        
        $this->render('index',array(
            'model'=>$model,
            'modelVoucherList'=>$modelVoucherList,
            'retrieved'=>$retrieved,
        ));
    }
}

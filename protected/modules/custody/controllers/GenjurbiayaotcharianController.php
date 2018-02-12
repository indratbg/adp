<?php

class GenjurbiayaotcharianController extends AAdminController
{

    public $layout = '//layouts/admin_column3';

    public function actionIndex()
    {
        $model = new Genjurbiayaotcharian;
        $model->doc_dt = date('d/m/Y');
        $model->jur_date = date('d/m/Y');
        $model->otc_fee = 20000;
        $this->render('index', array(
            'model'=>$model
        ));
    }

    public function actionGetListData()
    {
        $resp['status'] = 'error';
        if (isset($_POST['doc_dt']) && isset($_POST['otc_fee']))
        {
            $resp['status'] = 'success';
            $resp['error_msg'] = '';
            $doc_dt = $_POST['doc_dt'];
            $otc_fee = $_POST['otc_fee'];
            $model = new Genjurbiayaotcharian;
            $model->doc_dt = $doc_dt;
            $model->otc_fee = $otc_fee;
            $model->scenario = 'retrieve';
            if ($model->validate())
            {
                try
                {
                    $resp['list'] =DAO::queryAllSql(Genjurbiayaotcharian::getDataClientOtcHarian($model->doc_dt, $model->otc_fee));
                    if(!$resp['list'])
                    {
                        $sql="SELECT DISTINCT XN_DOC_NUM  FROM T_DAILY_OTC_JUR WHERE jur_date=to_date('$model->doc_dt','yyyy-mm-dd') ";
                        $exec =DAO::queryAllSql($sql); 
                        if($exec)
                        {
                            $doc_num='';
                            $x=0;
                            foreach($exec as $row)
                            {
                                if($x>0)$doc_num.=' , ';
                                $doc_num.=$row['xn_doc_num'];
                                $x++;
                            }
                            $resp['error_msg'] = 'Sudah dijurnal dengan journal number '.$doc_num ;
                        }
                        else {
                            $resp['error_msg'] = 'Tidak ada data untuk dijurnal';
                        }
                    }

                }
                catch (Exception $e)
                {
                    $resp['error_msg'] = $e->getMessage();
                }
            }
            else
            {
                $err_msg = '';

                foreach ($model->getErrors() as $row)
                {
                    $x = 0;
                    foreach ($row as $key=>$value)
                    {
                        if ($x > 0)
                            $err_msg .= ', ';
                        $err_msg .= $value;
                        $x++;
                    }
                }

                $resp['error_msg'] = $err_msg;
            }
        }
        echo json_encode($resp);
    }

    public function actionSaveData()
    {
        $resp['status'] = 'error';
        if (isset($_POST['record']) && isset($_POST['folder_cd']) && isset($_POST['jur_date']))
        {
            $resp['status'] = 'success';
            $resp['error_msg'] = '';
            $data = $_POST['record'];
            $success = true;
            $connection = Yii::app()->db;
            $transaction = $connection->beginTransaction();
            $doc_dt = '';
            
            
            foreach ($data as $row)
            {
                if (DateTime::createFromFormat('Y-m-d H:i:s', $row['doc_dt']))
                    $row['doc_dt'] = DateTime::createFromFormat('Y-m-d H:i:s', $row['doc_dt'])->format('Y-m-d');

                $model = new Tdailyotcjur;
                $model->jur_date = $row['doc_dt'];
                $model->doc_num = $row['doc_num'];
                $model->client_cd = $row['client_cd'];
                $model->sum_otc = $row['sum_otc'];
                $model->tidak_dijurnal = $row['tidak_dijurnal'];
                $doc_dt = $row['doc_dt'];
                if ($success && $model->validate() && $model->executeSpInsert() > 0)
                {
                    $success = true;
                }
                else
                {
                    $resp['error_msg'] = $model->error_code . ' ' . $model->error_msg;
                    $success = false;
                    break;
                }
               
            }
            if ($success)
            {
                $model = new Genjurbiayaotcharian;
                $model->scenario = 'save';
                $model->doc_dt = $doc_dt;
                $model->folder_cd = $_POST['folder_cd'];
                $model->jur_date = $_POST['jur_date'];
                if ($model->validate())
                {
                    if ($model->executeSpJurOTC() > 0)
                    {
                        
                        $transaction->commit();
                        $resp['success_msg'] = 'Jurnal OTC berhasil digenerate';
                    }
                    else
                    {
                        $transaction->rollback();
                        $resp['error_msg'] = $model->error_code . ' ' . $model->error_msg;
                    }
                   
                }
                else
                {
                    $err_msg = '';

                    foreach ($model->getErrors() as $row)
                    {
                        $x = 0;
                        foreach ($row as $key=>$value)
                        {
                            if ($x > 0)
                                $err_msg .= ', ';
                            $err_msg .= $value;
                            $x++;
                        }
                    }

                    $resp['error_msg'] = $err_msg;
                }
            }
            if (!$doc_dt)
            {
                $resp['error_msg'] = 'Tidak ada jurnal yang digenerate';
            }
        }
        echo json_encode($resp);
    }

}

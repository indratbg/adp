<?php

class Tvd55Controller extends AAdminController
{
    public $layout = '//layouts/admin_column3';
    public function actionIndex()
    {
        $model = array();
        $old_mkbd_date = '';
        $valid = true;
        $success = false;
        $modeldummy = new Tvd55;
        $is_duplicated = false;
        $mkbd_date = null;
        $is_notfound = '';

        $dropdownline = Tvd55::model()->findAll(array('condition'=>"approved_stat ='A'"));

        if (isset($_POST['scenario']))
        {
            $scenario = $_POST['scenario'];
            if ($scenario == 'filter')
            {
                $mkbd_date = $_POST['mkbd_date'];

                $old_mkbd_date = $_POST['Tvd55_old_mkbd_date'];

                $modeldummy->mkbd_date = $mkbd_date;
                $modeldummy->mkbd_cd = 'aa';
                if (DateTime::createFromFormat('Y-m-d', $old_mkbd_date))
                    $old_mkbd_date = DateTime::createFromFormat('Y-m-d', $old_mkbd_date)->format('d/m/Y');
                $modeldummy->validate();

                $model = Tvd55::model()->findAll(array(
                    'select'=>'mkbd_date, line_desc,mkbd_cd, tanggal,qty1,qty2',
                    'condition'=>"mkbd_date = to_date('$mkbd_date','DD/MM/YYYY') AND t.approved_stat = 'A'",
                    'order'=>'mkbd_cd'
                ));

                foreach ($model as $row)
                {
                    if ($row->mkbd_date)
                        $row->mkbd_date = DateTime::createFromFormat('Y-m-d G:i:s', $row->mkbd_date)->format('d/m/Y');
                    if ($row->tanggal)
                        $row->tanggal = DateTime::createFromFormat('Y-m-d G:i:s', $row->tanggal)->format('d/m/Y');
                    $row->old_mkbd_date = $row->mkbd_date;
                    $row->old_mkbd_cd = $row->mkbd_cd;

                }

                if (!$model)
                {
                    if (DateTime::createFromFormat('Y-m-d', $modeldummy->mkbd_date))
                        $modeldummy->mkbd_date = DateTime::createFromFormat('Y-m-d', $modeldummy->mkbd_date)->format('d/m/Y');

                    $is_notfound = 'notfound();';
                }
            }
            else
            {
                $rowCount = $_POST['rowCount'];
                foreach ($model as $row)
                {
                    if ($row->mkbd_date)
                        $row->mkbd_date = DateTime::createFromFormat('Y-m-d G:i:s', $row->mkbd_date)->format('d/m/Y');
                    if ($row->tanggal)
                        $row->tanggal = DateTime::createFromFormat('Y-m-d G:i:s', $row->tanggal)->format('d/m/Y');
                    $row->old_mkbd_date = $row->mkbd_date;
                    $row->old_mkbd_cd = $row->mkbd_cd;
                }

                $x;

                $save_flag = false;
                //False if no record is saved

                for ($x = 0; $x < $rowCount; $x++)
                {
                    $model[$x] = new Tvd55;
                    $model[$x]->attributes = $_POST['Tvd55'][$x + 1];

                    if (isset($_POST['Tvd55'][$x + 1]['save_flg']) && $_POST['Tvd55'][$x + 1]['save_flg'] == 'Y')
                    {
                        $save_flag = true;

                        //UPDATE
                        $model[$x]->scenario = 'update';

                        $valid = $model[$x]->validate() && $valid;
                    }
                }

                $valid = $valid && $save_flag;

                if ($valid)
                {
                    $success = true;
                    $connection = Yii::app()->db;
                    $transaction = $connection->beginTransaction();

                    for ($x = 0; $success && $x < $rowCount; $x++)
                    {
                        if ($model[$x]->mkbd_cd == 38 || $model[$x]->mkbd_cd == 39)
                        {
                            if ($model[$x]->qty2 == NULL || $model[$x]->qty2 == '')
                            {
                                $model[$x]->qty2 = 0;
                            }

                        }

                        if ($model[$x]->old_mkbd_date != '' && $model[$x]->save_flg == 'Y')
                        {
                            //UPDATE
                            if ($success && $model[$x]->executeSp(AConstant::INBOX_STAT_UPD, $model[$x]->old_mkbd_date, $model[$x]->old_mkbd_cd) > 0)
                                $success = true;
                            else
                            {
                                $success = false;
                            }
                        }
                        else
                        {
                            if ($model[$x]->save_flg == 'Y')
                            {
                                //INSERT
                                if ($success && $model[$x]->executeSp(AConstant::INBOX_STAT_INS, $model[$x]->old_mkbd_date, $model[$x]->old_mkbd_cd) > 0)
                                    $success = true;
                                else
                                {
                                    $success = false;
                                }
                            }
                        }
                    }

                    if ($success)
                    {
                        $transaction->commit();

                        Yii::app()->user->setFlash('success', 'Data Successfully Saved');
                        $this->redirect(array('/glaccounting/Tvd55/index'));
                    }
                    else
                    {
                        $transaction->rollback();
                    }
                }
                foreach ($model as $row)
                {
                    if (DateTime::createFromFormat('Y-m-d', $row->mkbd_date))
                        $row->mkbd_date = DateTime::createFromFormat('Y-m-d', $row->mkbd_date)->format('d/m/Y');
                    if (DateTime::createFromFormat('Y-m-d', $row->tanggal))
                        $row->tanggal = DateTime::createFromFormat('Y-m-d', $row->tanggal)->format('d/m/Y');
                }

            }
        }
        else
        {
            $model = Tvd55::model()->findAllBySql("select * from t_vd55 where mkbd_date =( select max(mkbd_date) from t_vd55)order by mkbd_cd");
            //$model= null;
            foreach ($model as $row)
            {
                if ($row->mkbd_date)
                    $row->mkbd_date = DateTime::createFromFormat('Y-m-d G:i:s', $row->mkbd_date)->format('d/m/Y');
                if ($row->tanggal)
                    $row->tanggal = DateTime::createFromFormat('Y-m-d G:i:s', $row->tanggal)->format('d/m/Y');
                $row->old_mkbd_date = $row->mkbd_date;
                $row->old_mkbd_cd = $row->mkbd_cd;

            }
            $modeldummy->mkbd_date = $model[0]->mkbd_date;

        }

        $this->render('index', array(
            'model'=>$model,
            'modeldummy'=>$modeldummy,
            'mkbd_date'=>$mkbd_date,
            'is_notfound'=>$is_notfound,
            'dropdownline'=>$dropdownline,
            'old_mkbd_date'=>$old_mkbd_date
        ));
    }

    public function actionAjxValidateCancel()//LO: The purpose of this 'empty'
    // function is to check whether a user is authorized to perform cancellation
    {
        $resp = '';
        echo json_encode($resp);
    }

    public function actionCek_date()
    {
        $resp['status'] = 'error';

        if (isset($_POST['tanggal']))
        {
            $tanggal = $_POST['tanggal'];
            $sql = "select f_is_holiday('$tanggal') holiday from dual";
            $check = DAO::queryRowSql($sql);
            if ($check['holiday'] == '1')
            {
                $resp['status'] = 'success';
            }
        }
        echo json_encode($resp);
    }

}

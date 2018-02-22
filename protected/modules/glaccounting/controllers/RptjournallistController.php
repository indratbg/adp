<?php
class RptjournallistController extends AAdminController
{
    public $layout = '//layouts/admin_column3';
    public function actionIndex()
    {
        $model = new Rptjournallist('JOURNAL_LIST', 'R_JOURNAL_LIST', 'Journal_list.rptdesign');
        $model->from_date = date('d/m/Y');
        $model->to_date = date('d/m/Y');
        $model->type = 0;
        $url = '';
        $resp['status']='error';
        if (isset($_POST['Rptjournallist']) && isset($_POST['scenario']))
        {
            $model->attributes = $_POST['Rptjournallist'];
            $scenario = $_POST['scenario'];
            $resp['status']='success';
            if($model->validate())
            {


                if ($scenario == 'print')
                {

                    $type = '';
                    if ($model->type == '0')
                    {
                        $type = 'ALL';
                    }
                    else if ($model->type == '1')
                    {
                        $type = 'TRX';
                    }
                    else if ($model->type == '2')
                    {
                        $type = 'REVERSAL';
                    }
                    if ($model->validate() && $model->executeRpt($type) > 0)
                    {
                        $from_date = DateTime::createFromFormat('Y-m-d',$model->from_date)->format('d/m/Y');
                        $to_date = DateTime::createFromFormat('Y-m-d',$model->to_date)->format('d/m/Y');
                        $rpt_link = $model->showReport($from_date, $to_date);
                        $url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
                    }
                    else
                    {
                        $resp['error_msg'] = $model->vo_errcd . ' ' . $model->vo_errmsg;
                    }
                    $resp['url']=$url;
                    $resp['vo_random_value']=$model->vo_random_value;
                    $resp['vp_userid']=$model->vp_userid;

                }
                //scenario
                else
                {
                    $condition="where rand_value=$model->vo_random_value and user_id='$model->vp_userid' ORDER BY doc_date, seqcd,  sdoc_a,  sdoc_b,  tal_id ";
                    $this->ExportToExcel('INSISTPRO_RPT',$model,$condition,'Journal List');

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
            echo json_encode($resp);
        }
        else
        {

            $this->render('index', array(
                'model'=>$model,
                'url'=>$url
            ));
        }

    }

}



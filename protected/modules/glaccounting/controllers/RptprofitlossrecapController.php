<?php
class RptprofitlossrecapController extends AAdminController
{

    public $layout = '//layouts/admin_column3';
    public function actionIndex()
    {
        $model = new Rptprofitlossrecap('PROFIT_LOSS_RECAP', 'R_PROFIT_LOSS_RECAP', 'Profit_Loss_Recap.rptdesign');
        $url = '';
        $resp['status']='error';
        if (isset($_POST['Rptprofitlossrecap']) && isset($_POST['scenario']))
        {
            $resp['status']='success';
            $model->attributes = $_POST['Rptprofitlossrecap'];
            $scenario=$_POST['scenario'];
            if($scenario=='print')
            {
                
                $bgn_date = date('Y-m-d', strtotime("$model->year" . '-' . "$model->month" . '-01'));
                $end_date = date('Y-m-t', strtotime("$model->year" . '-' . "$model->month" . '-01'));
                if($model->validate())
                {
                    if ($model->validate() && $model->executeRpt($bgn_date, $end_date) > 0)
                    {
                        $rpt_link = $model->showReport();
                        $url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
                       
                    }                
                    else
                    {
                        $resp['error_msg'] = $model->vo_errcd . ' ' . $model->vo_errmsg;
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
                $resp['url']=$url;
                $resp['vo_random_value']=$model->vo_random_value;
                $resp['vp_userid']=$model->vp_userid;
                echo json_encode($resp);
            }
            else if($scenario=='export')
            {
                $condition = "where rand_value=$model->vo_random_value and user_id='$model->vp_userid' order by grp1,gl_acct_group,gl_acct_cd,subacct";
                $this->ExportToExcel('insistpro_rpt',$model,$condition,'Laba Rugi Cabang');
            }

        }
        else
        {
                $model->month = date('m');
                $model->year = date('Y');
                $this->render('index', array(
                    'model'=>$model,
                    'url'=>$url
                ));
        }

        
    }

}

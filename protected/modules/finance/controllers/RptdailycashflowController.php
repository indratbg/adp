<?php

class RptdailycashflowController extends AAdminController
{

    public $layout = '//layouts/admin_column3';
    private $rptName = 'Daily_budget_cashflow_with_sesi.rptdesign';
    public function actionIndex()
    {
        $resp['status'] = 'error';
        $model = new Rptdailycashflow('DAILY CASH FLOW', 'R_DAILY_CASH_FLOW', $this->rptName);
        $model->end_date = date('d/m/Y');
        $url = '';

        if (isset($_POST['Rptdailycashflow']))
        {
              $resp['status'] = 'success';
            $model->attributes = $_POST['Rptdailycashflow'];

            if ($model->validate())
            {
                if ($model->executeRpt() > 0)
                {
                    $bgn_date = DateTime::createFromFormat('Y-m-d', $model->end_date)->format('d-M-Y');
                    $rpt_link = $model->showReport($bgn_date, $bgn_date);
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
            $resp['url'] = $url;
            $resp['vp_user_id'] = $model->vp_userid;
            $resp['rand_value'] = $model->vo_random_value;
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

    public function actionAjxFilter()
    {
        $resp['status'] = 'error';
        if (isset($_POST['Rptdailycashflow']))
        {
            $resp['status'] = 'success';
            $bgn_date = $_POST['Rptdailycashflow']['end_date'];
            $bgn_date = DateTime::createFromFormat('d/m/Y', $bgn_date)->format('d-M-Y');
            $end_date = $bgn_date;
            $rand_value = $_POST['Rptdailycashflow']['vo_random_value'];
            $user_id = $_POST['Rptdailycashflow']['vp_userid'];
            $kategori_flg = $_POST['Rptdailycashflow']['kategori_flg'];
            $format = DAO::queryRowSql("SELECT dstr1 FROM MST_SYS_PARAM WHERE param_id = 'SYSTEM' AND param_cd1 = 'DECPOINT'");

            if ($format['dstr1'] == ',')
            {
                $locale = '&__locale=in_ID';
            }
            else
            {
                $locale = '&__locale=en_US';
            }

            $param = '&ACC_TOKEN=' . 'XX' . '&ACC_USER_ID=' . $user_id . '&RP_RANDOM_VALUE=' . $rand_value . '&BGN_DATE=' . $bgn_date . '&END_DATE=' . $end_date . '&KATEGORI_FLG=' . $kategori_flg;
            $resp['url'] = Constanta::URL . $this->rptName . $locale . $param . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';

        }
        echo json_encode($resp);
    }

}

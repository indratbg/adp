<?php

class RptclientprofileController extends AAdminController
{
    /**
     * @var string the default layout for the views. Defaults to
     * '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/admin_column3';

    public function actionGetclient()
    {
        $i = 0;
        $src = array();
        $term = strtoupper($_REQUEST['term']);
        $status = strtoupper($_REQUEST['status']);

        $qSearch = DAO::queryAllSql("
				Select client_cd, susp_stat, client_name FROM MST_CLIENT 
				Where (client_cd like '" . $term . "%')
				AND ((susp_stat='N' and '" . $status . "'='N')
				or (susp_stat='C' and '" . $status . "'='C')
				or (susp_stat = 'Y' and '" . $status . "'='Y')
				or (susp_stat like '%' and '" . $status . "'='%')
				)
      			AND CLIENT_TYPE_1 <>'B'
      			AND CIFS IS NOT NULL
      			AND rownum <= 200
      			ORDER BY client_cd
      			");

        foreach ($qSearch as $search)
        {
            $src[$i++] = array(
                'label'=>$search['client_cd'] . ' - ' . $search['susp_stat'] . ' - ' . $search['client_name'],
                'labelhtml'=>$search['client_cd'],
                'value'=>$search['client_cd']
            );
        }

        echo CJSON::encode($src);
        Yii::app()->end();
    }

    public function actionGetOldCd()
    {
        $i = 0;
        $src = array();
        $term = strtoupper($_REQUEST['term']);
        $status = strtoupper($_REQUEST['status']);

        $qSearch = DAO::queryAllSql("
				Select rpad(old_ic_num,10,' ')old_ic_num, client_cd, susp_stat, client_name FROM MST_CLIENT 
				Where (old_ic_num like '" . $term . "%')
				AND ((susp_stat='N' and '" . $status . "'='N')
				or (susp_stat='C' and '" . $status . "'='C')
				or (susp_stat = 'Y' and '" . $status . "'='Y')
				or (susp_stat like '%' and '" . $status . "'='%')
				)
      			AND CLIENT_TYPE_1 <>'B'
      			and old_ic_num is not null
      			AND CIFS IS NOT NULL
      			AND rownum <= 200
      			ORDER BY client_cd
      			");

        foreach ($qSearch as $search)
        {
            $src[$i++] = array(
                'label'=>trim($search['old_ic_num']) . ' - ' . $search['client_cd'] . ' - ' . $search['susp_stat'] . ' - ' . $search['client_name'],
                'labelhtml'=>trim($search['old_ic_num']),
                'value'=>trim($search['old_ic_num'])
            );
        }

        echo CJSON::encode($src);
        Yii::app()->end();
    }

    public function actionIndex()
    {
        $model = new Rptclientprofile('CLIENT_PROFILE', 'R_CLIENT_PROFILE', 'Client_Profile_Individual.rptdesign');
        $url = NULL;
        $model->vp_status = 'ALL';

        if (isset($_POST['Rptclientprofile']))
        {
            $model->attributes = $_POST['Rptclientprofile'];
            if ($model->validate())
            {
                $resp['status'] = 'success';               
                $check = Client::model()->find("client_cd='$model->vp_client' ")->client_type_1;
                if ($check == 'C' || $check == 'H')
                {
                    $model->rptname = 'Client_Profile_Institusional.rptdesign';
                }

                if ($model->executeReportGenSp() > 0)
                {
                    $url = $model->showReport() . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
                    $this->renderPartial('_report', array(
                        'model'=>$model,
                        'url'=>$url
                    ));
                }
            
            }
         echo $model->getError('vo_errmsg');
        }
        else
        {
            $this->render('index', array(
                'model'=>$model,
                'url'=>$url,
            ));
        }

    }

}

<?php

class PostingintselectedController extends AAdminController
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='//layouts/admin_column3';

    public function actionIndex()
    {
        $branchFlg = Sysparam::model()->find("param_id='SYSTEM' and param_cd1='CHECK' AND PARAM_CD2='ACCTBRCH'")->dflg1;
        $model = new Postingintselected;
        $modelDetail = array();
        $model->bulan = date('m');
        $model->year = date('Y');
        $model->int_dt_from = date('01/m/Y');
        $model->int_dt_to = date('t/m/Y');
        
        if(isset($_POST['scenario']))
        {
            $scenario = $_POST['scenario'];
            $model->attributes = $_POST['Postingintselected'];
            $model->scenario="filter";
            $model->validate();
            
            $branch_cd= $model->brch_cd?$model->brch_cd:'%';
          
            if($scenario =='retrieve')
            {
              
                 $modelDetail=Postingintselected::model()->findAllBySql(Postingintselected::GetListInterest($model->int_dt_from, $model->int_dt_to, $branch_cd));
                 if(!$modelDetail)
                 {
                     Yii::app()->user->setFlash('danger', 'Data tidak ditemukan');
                 }

            }
             //Proses
             else if($scenario=='process') 
             {
                 $checkHoliday = Sysparam::model()->find("PARAM_ID='SYSTEM' AND PARAM_CD1='CHECK' AND PARAM_CD2='HOLIDAY'")->dflg1;
                
                 if($checkHoliday=='Y')
                 {
                        $model->journal_date=AConstant::getEndDateBourse($model->int_dt_from);    
                 }
                 else 
                 {
                    $model->journal_date = date('Y-m-t',strtotime($model->int_dt_from));    
                 }
                 if(DateTime::createFromFormat('d/m/Y',$model->journal_date))$model->journal_date=DateTime::createFromFormat('d/m/Y',$model->journal_date)->format('Y-m-d');
                 
                 if($model->executeSpPostingInt('%', '_', $branch_cd, 'Y')>0)
                 {
                      Yii::app()->user->setFlash('success', 'Data successfully posting');
                 }
             }
            
        }
        
        if(DateTime::createFromFormat('Y-m-d',$model->int_dt_from))$model->int_dt_from=DateTime::createFromFormat('Y-m-d',$model->int_dt_from)->format('d/m/Y');
        if(DateTime::createFromFormat('Y-m-d',$model->int_dt_to))$model->int_dt_to=DateTime::createFromFormat('Y-m-d',$model->int_dt_to)->format('d/m/Y');
        
        $this->render('index',array('model'=>$model,'modelDetail'=>$modelDetail,'branchFlg'=>$branchFlg));
    }
    public function actionUpdateJurnalSts()
    {
        
            $resp['status'] = 'error';
            if (isset($_POST['int_dt_from']) && isset($_POST['int_dt_to']) && isset($_POST['jurnal_sts']) && isset($_POST['client_cd']) )
            {
                $resp['status'] = 'success';
                $client_cd = $_POST['client_cd'];
                $jurnal_sts=$_POST['jurnal_sts'];
                $bgn_date = $_POST['int_dt_from'];
                $end_date = $_POST['int_dt_to'];
                $sql="update t_interest set post_flg='$jurnal_sts' where int_dt between to_date('$bgn_date','dd/mm/yyyy') and to_date('$end_date','dd/mm/yyyy')
                        and client_cd = '$client_cd' ";
                $exec = DAO::executeSql($sql);        
            }
    
          echo json_encode($resp);
    }
    
}
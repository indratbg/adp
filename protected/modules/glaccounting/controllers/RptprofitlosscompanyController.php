<?php

class RptprofitlosscompanyController extends AAdminController
{
	
	public $layout='//layouts/admin_column3';
	
	
	public function actionIndex()
    {
		$rpt_name = 'PL_Company_YJ.rptdesign';
    	$model = new Rptprofitlosscompany('PROFIT_LOSS_COMPANY','R_PROFIT_LOSS_COMPANY',$rpt_name);
		$url='';
	
		$resp['status']='error';
		if(isset($_POST['Rptprofitlosscompany']) && isset($_POST['scenario']))
		{
			$resp['status']='error';
			$model->attributes = $_POST['Rptprofitlosscompany'];
			$scenario = $_POST['scenario'];
			if($scenario =='print')
			{
					if($model->validate())
					{
						
						if($model->bgn_branch)
						{
							$bgn_branch = $model->bgn_branch;
							$end_branch = $model->end_branch;
						}
						else 
						{
							$bgn_branch = '%';
							$end_branch = '_';	
						}
					
						if($model->executeRpt($bgn_branch, $end_branch)>0)
						{
							$rpt_link =$model->showReport();
							$url = $rpt_link.'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
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
					}//end validate
			}//end scenario print
			else if($scenario =='export')//export to excel
			{
				$condition = "where rand_value=$model->vo_random_value and user_id='$model->vp_userid' order by 3,4,5,6,7";
				$this->ExportToExcel('INSISTPRO_RPT',$model,$condition,'Profit Loss Company');
			}
			

			$resp['url']=$url;
            $resp['vo_random_value']=$model->vo_random_value;
            $resp['vp_userid']=$model->vp_userid;
			echo json_encode($resp);
		}
		else
		{
			$branch_cd = Branch::model()->findAll(array('select'=>"brch_cd, brch_cd ||' - '|| brch_name as brch_name",'condition'=>"approved_stat='A' ",'order'=>'brch_cd' ));
			$model->bgn_date = date('d/m/Y');
			$model->year = date('Y');
			$model->month = date('m');

			$this->render('index',array('model'=>$model,
									'url'=>$url,
									'branch_cd'=>$branch_cd));
		}
		
	
	}
}
?>
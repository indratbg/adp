<?php

class RptlistofclientController extends AAdminController
{

	public $layout = '//layouts/admin_column3';

	public function actionGetclient()
	{
		 $i = 0;
		 $src = array();
		 $term = strtoupper($_REQUEST['term']);
		 $qSearch = DAO::queryAllSql("
			 Select client_cd, client_name, MST_CIF.sid FROM MST_CLIENT join MST_CIF on MST_CLIENT.cifs=MST_CIF.cifs
				 Where (client_cd like '" . $term . "%') AND MST_CIF.sid is not null
				 AND rownum <= 11
      			 ORDER BY client_cd
      			 ");

		 foreach ($qSearch as $search)
		 {
			 $src[$i++] = array(
				 'label' => $search['client_cd'] . ' - ' . $search['client_name'],
				 'labelhtml' => $search['client_cd'],
				 'value' => $search['sid']
			 );
		 }
 
		 echo CJSON::encode($src);
		 Yii::app()->end();
	 }

	public function actionIndex()
	{
		$rpt='List_of_Client-client.rptdesign';
		$model = new Rptlistofclient('LIST_OF_CLIENT', 'R_LIST_OF_CLIENT', $rpt);
		$url = '';
		$url_xls= '';
		$model->p_afil_opt='0';
		$model->totalck='print';
		$model->p_bgn_open_dt = date('01/01/1900');
		$model->p_end_open_dt = date('01/01/2100');
		$model->p_stat='N';
		$model->p_client_type1='%';
		$model->p_client_type2='%';
		$model->p_afil='0';
		$model->p_open='0';
		$model->opt_marg='%';
		$model->p_bgn_subrek='';
		$model->p_end_subrek='';
		$sql = "select cl_desc, margin_cd||' - '||cl_desc margin_cd,cl_type3  from lst_type3 order by cl_desc";
		$p_margin=Lsttype3::model()->findAllBySql($sql);
		$sql_1 = "select brch_cd, brch_cd||' - '||def_addr_1 def_addr_1 from mst_branch order by brch_cd";
		$branch_cd=Branch::model()->findAllBySql($sql_1);
		$sql_2 = "select rem_cd, rem_cd||' - '||rem_name rem_name from mst_sales order by rem_cd";
		$rem_cd=Sales::model()->findAllBySql($sql_2);
		$sql_3 = "select prm_desc from MST_parameter where prm_cd_1='AB' AND prm_cd_2 ='000'";
		$ab=Parameter::model()->findBySql($sql_3);
		$k1='%';
		$k2='_';
		$model->p_client_type3='%';
		

		// $model->cnt_disp=3;
		// $client_cd=Client::model()->findAll(array(
			// 'select'=>"client_cd"
		// ));
		if (isset($_POST['Rptlistofclient']))
		{
			$scenario = $_POST['scenario'];
			$model->attributes = $_POST['Rptlistofclient'];
			
			$sortby=$model->sortby;
			
			// var_dump($rpt);die();
			
			if($model->opt_marg=='%')
			{
				$model->p_margin_cd='%';
			}
			elseif($model->opt_marg=='M')
			{
				$model->p_margin_cd='M';
			}
			elseif($model->opt_marg=='R')
			{
				$model->p_margin_cd='R';
			}
			elseif($model->opt_marg=='SPEC')
			{
				$model->p_margin_cd;
				if($model->p_margin_cd=='MARGIN')
				{
					$model->p_margin_cd='M';
				}
				elseif($model->p_margin_cd=='SHORT SELL')
				{
					$model->p_margin_cd='L';
				}
				else
				{
					$model->p_margin_cd='R';
				}
			}
			
			$model->totalck='export';
			
			
			if($model->p_afil_opt=='0')
			{
				$model->p_afil='%';}
			elseif($model->p_afil_opt=='1')
			{
				$model->p_afil='Y';
			}
			elseif($model->p_afil_opt=='2')
			{
				$model->p_afil='N';
			}
			if($model->p_open=='1')
			{
				$p_bgn_open_dt=$model->p_bgn_open_dt;
				$p_end_open_dt=$model->p_end_open_dt;
			}
			else
			{
				$p_bgn_open_dt=$model->p_bgn_open_dt;
				$p_end_open_dt=$model->p_end_open_dt;
			}
			if($model->client_cd)
			{
				$model->p_sid=$model->client_cd;
			}
			else{$model->p_sid='%';
			}
			
			if($model->p_bgn_subrek && strlen($model->p_bgn_subrek)<9)
			{
				$bgn_sub=$ab['prm_desc'].$model->p_bgn_subrek.'%';
			}
			elseif($model->p_bgn_subrek && strlen($model->p_bgn_subrek)>=9)
			{
				$bgn_sub=$ab['prm_desc'].$model->p_bgn_subrek;
			}
			else
			{
				$bgn_sub='%';
			}
			
			if($model->p_end_subrek)
			{
				$end_sub=$ab['prm_desc'].$model->p_end_subrek.'_';
			}
			else
			{
				$end_sub='_';
			}
			if($model->opt_branch=='1')
			{
				$model->p_bgn_branch=$model->branch_cd;
				$model->p_end_branch=$model->branch_cd;
			}
			else
			{
				$model->p_bgn_branch='%';
				$model->p_end_branch='_';
			}
			if($model->opt_rem=='1')
			{
				$model->p_bgn_rem=$model->rem_cd;
				$model->p_end_rem=$model->rem_cd;
			}
			else
			{
				$model->p_bgn_rem='%';
				$model->p_end_rem='_';
			}
			if($model->dtb!='Y'){$model->dtb='N';}
			if($model->ktp!='Y'){$model->ktp='N';}
			if($model->ktp_1!='Y'){$model->ktp_1='N';}
			if($model->ktp_2!='Y'){$model->ktp_2='N';}
			if($model->email!='Y'){$model->email='N';}
			if($model->telp!='Y'){$model->telp='N';}
			if($model->hp!='Y'){$model->hp='N';}
			if($model->fax!='Y'){$model->fax='N';}
			if($model->clt!='Y'){$model->clt='N';}
			if($model->oltrad!='Y'){$model->oltrad='N';}
			if($model->opac!='Y'){$model->opac='N';}
			if($model->ocac!='Y'){$model->ocac='N';}
			if($model->sls!='Y'){$model->sls='N';}
			if($model->norek!='Y'){$model->norek='N';}
			
			// var_dump($model->ktp_1);var_dump($model->ktp_2);die();
			// var_dump($model->p_afil);die();		
			//08feb2017 untuk testing [IN]
			if($model->sortby==1 or $model->sortby==2){
				$model->rptname='List_of_Client_1.rptdesign';
			}else{
				$model->rptname='List_of_Client_2.rptdesign';
			}
			if ($model->validate())
			{
				// $url_xls = $rpt_link .'&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';	
				if ($model->executeReport($bgn_sub,$end_sub,$sortby)>0)
				
				{
					$rpt_link =$model->showReport();	
					$url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
					$url_xls = $rpt_link .'&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
				}
			//var_dump('test');die();
			}
		}
		
		

		if (DateTime::createFromFormat('Y-m-d', $model->p_bgn_open_dt))
			$model->p_bgn_open_dt = DateTime::createFromFormat('Y-m-d', $model->p_bgn_open_dt)->format('d/m/Y');
		if (DateTime::createFromFormat('Y-m-d', $model->p_end_open_dt))
			$model->p_end_open_dt = DateTime::createFromFormat('Y-m-d', $model->p_end_open_dt)->format('d/m/Y');
		
		$this->render('index', array(
			'model' => $model,
			'url' => $url,
			'p_margin' => $p_margin,
			'branch_cd' => $branch_cd,
			'rem_cd' => $rem_cd,
			'url_xls'=> $url_xls,
		));
	}


	
}




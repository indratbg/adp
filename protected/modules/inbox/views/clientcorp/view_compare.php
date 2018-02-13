<style>
	#tabMenu ul
	{
		border-top:2px solid #ddd;
		border-bottom:2px solid #ddd;
		border-left:2px solid #ddd;
		border-radius:5px;
	}	
	#tabMenu li
	{
		border-right:1px solid #ddd;
		border-radius:5px;
	}
	#tabMenu li:not(:first-child)
	{
		border-left:1px solid #ddd;
		border-radius:5px;
	}
	.tnumber{text-align:right;}
	/*#tabMenu  li:not(.active)*/
</style>

<?php
$this->breadcrumbs=array(
	'Client Profile Inbox'=>array('index'),
	$model->update_seq,
);

$this->menu=array(
	array('label'=>'View Institutional Client Profile Inbox #'.$model->update_seq, 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'Unprocessed','icon'=>'list','url'=>array('index'),'itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Processed','icon'=>'list','url'=>array('indexProcessed'),'itemOptions'=>array('style'=>'float:right')),
);
?>

<?php 
	$minimumFeeFlg = Sysparam::model()->find("param_id = 'CLIENT MASTER' AND param_cd1 = 'MINFEE' AND param_cd2 = 'DEFAULT'");
	$withholdingTaxFlg = Sysparam::model()->find("param_id = 'CLIENT MASTER' AND param_cd1 = 'WHTAX' AND param_cd2 = 'DEFAULT'");
	$acopenFeeFlg = Sysparam::model()->find("param_id = 'CLIENT MASTER' AND param_cd1 = 'OTC' AND param_cd2 = 'DEFAULT'");
	$taxOnInterestFlg = Sysparam::model()->find("param_id = 'CLIENT MASTER' AND param_cd1 = 'INTTAX' AND param_cd2 = 'DEFAULT'");
	
	if($modelCifDetail->sid)$modelCifDetail->sid = substr($modelCifDetail->sid,0,2).'.'.substr($modelCifDetail->sid,2,1).'.'.substr($modelCifDetail->sid,3,4).'.'.substr($modelCifDetail->sid,7,6).'.'.substr($modelCifDetail->sid,13,2);
	if($modelCifDetail->npwp_no)$modelCifDetail->npwp_no = substr($modelCifDetail->npwp_no,0,2).'.'.substr($modelCifDetail->npwp_no,2,3).'.'.substr($modelCifDetail->npwp_no,5,3).'.'.substr($modelCifDetail->npwp_no,8,1).'-'.substr($modelCifDetail->npwp_no,9,3).'.'.substr($modelCifDetail->npwp_no,12,3);
	if($modelCifDetailCurr->sid)$modelCifDetailCurr->sid = substr($modelCifDetailCurr->sid,0,2).'.'.substr($modelCifDetailCurr->sid,2,1).'.'.substr($modelCifDetailCurr->sid,3,4).'.'.substr($modelCifDetailCurr->sid,7,6).'.'.substr($modelCifDetailCurr->sid,13,2);
	if($modelCifDetailCurr->npwp_no)$modelCifDetailCurr->npwp_no = substr($modelCifDetailCurr->npwp_no,0,2).'.'.substr($modelCifDetailCurr->npwp_no,2,3).'.'.substr($modelCifDetailCurr->npwp_no,5,3).'.'.substr($modelCifDetailCurr->npwp_no,8,1).'-'.substr($modelCifDetailCurr->npwp_no,9,3).'.'.substr($modelCifDetailCurr->npwp_no,12,3);
?>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'client-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

<?php if(isset($modelClientDetailCurr)): ?>
	
<h4>Data Client Profile</h4> 
<div id="clientCurr">
	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<?php echo $form->label($modelClientDetailCurr,'client_cd',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo $form->textField($modelClientDetailCurr,'client_cd',array('class'=>'span3','readonly'=>'readonly','maxlength'=>12,'placeholder'=>'Fill Client Code','style'=>"width:100px")); ?>
				</div>
			</div>
		</div>
		<div class="span6">
			<?php echo $form->textFieldRow($modelClientDetailCurr,'cifs',array('class'=>'span3','readonly'=>'readonly','style'=>"width:100px")); ?>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<?php echo $form->labelEx($modelClientDetailCurr,'client_name',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo $form->textField($modelClientDetailCurr,'client_name',array('class'=>'span8','readonly'=>'readonly')); ?>
				</div>
			</div>
		</div>	
		<div class="span6">
			<?php echo $form->textFieldRow($modelClientDetailCurr,'client_class',array('class'=>'span8','readonly'=>'readonly','value'=>Parameter::getParamDesc('CLASS',$modelClientDetailCurr->client_class))); ?>
		</div>
	</div>	
	
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->textFieldRow($modelClientDetailCurr,'client_type_3',array('class'=>'span8','readonly'=>'readonly','value'=>Lsttype3::model()->find("cl_type3 = '$modelClientDetailCurr->client_type_3'")->cl_desc)); ?>
		</div>
		<div class="span6">
			<?php echo $form->textFieldRow($modelClientDetailCurr,'contact_pers',array('class'=>'span8','readonly'=>'readonly')); ?>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->textFieldRow($modelClientDetailCurr,'acct_open_dt',array('class'=>'span4','readonly'=>'readonly','value'=>Tmanydetail::reformatDate($modelClientDetailCurr->acct_open_dt))); ?>
		</div>
		<div class="span6">
			<?php echo $form->textFieldRow($modelClientDetailCurr,'old_ic_num',array('class'=>'span4','readonly'=>'readonly')); ?>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->textFieldRow($modelClientDetailCurr,'branch_code',array('class'=>'span8','readonly'=>'readonly')); ?>		
		</div>
		<div class="span6">
			<?php echo $form->textFieldRow($modelClientDetailCurr,'rem_cd',array('class'=>'span8','readonly'=>'readonly','value'=>Sales::model()->find("rem_cd = '$modelClientDetailCurr->rem_cd'")->rem_name)); ?>	
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span6">
			<div class="span9">
				<div class="control-group">
					<?php echo $form->labelEx($modelClientDetailCurr,'commission_per',array('class'=>'control-label','readonly'=>'readonly')); ?>
					<div class="controls">
						<?php echo $form->textField($modelClientDetailCurr,'commission_per',array('class'=>'span6 tnumber','readonly'=>'readonly','value'=>$modelClientDetailCurr->commission_per/100)); ?>
						<?php echo $form->error($modelClientDetailCurr,'commission_per', array('class'=>'help-inline error')); ?>	
					</div>
				</div>
			</div>
			<div class="span3">
				OLT
				<?php echo $form->textField($modelClientDetailCurr,'olt',array('class'=>'span6','readonly'=>'readonly')); ?>
			</div>	
		</div>
		<div class="span6">
			<div class="control-group">
				<?php echo $form->labelEx($modelClientDetailCurr,'subrek001_1',array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->textField($modelClientDetailCurr,'subrek001_1',array('class'=>'span2','readonly'=>'readonly')); ?>
					001
					<?php echo $form->textField($modelClientDetailCurr,'subrek001_2',array('class'=>'span1','readonly'=>'readonly', 'style'=>'width:30px')); ?>
					/
					<?php echo $form->textField($modelClientDetailCurr,'subrek004_1',array('class'=>'span2','readonly'=>'readonly')); ?>
					004
					<?php echo $form->textField($modelClientDetailCurr,'subrek004_2',array('class'=>'span1','readonly'=>'readonly', 'style'=>'width:30px')); ?>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span6">
			<div class="span9">
				<div class="control-group">
					<?php echo $form->labelEx($modelClientDetailCurr,'rebate',array('class'=>'control-label','readonly'=>'readonly')); ?>
					<div class="controls">
						<?php echo $form->textField($modelClientDetailCurr,'rebate',array('class'=>'span6 tnumber','readonly'=>'readonly','value'=>$modelClientDetailCurr->rebate/100)); ?>	
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span6">
			<div class="span9">
				<div class="control-group">
					<?php echo $form->label($modelClientDetailCurr,'rebate',array('class'=>'control-label','readonly'=>'readonly')); ?>
					<div class="controls">
						<?php echo $form->textField($modelClientDetailCurr,'rebate',array('class'=>'span6 tnumber','readonly'=>'readonly','value'=>$modelClientDetailCurr->rebate/100)); ?>
						<?php echo $form->error($modelClientDetailCurr,'rebate', array('class'=>'help-inline error')); ?>	
					</div>
				</div>
			</div>	
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->textFieldRow($modelClientDetailCurr,'rebate_basis',array('class'=>'span6','readonly'=>'readonly','value'=>AConstant::$client_rebate_basis[$modelClientDetailCurr->rebate_basis])); ?>
		</div>
		<div class="span6">
			<div class="control-group">
				<?php echo $form->label($modelClientDetailCurr,'stop_pay',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo $form->textField($modelClientDetailCurr,'e_mail1',array('class'=>'span6','readonly'=>'readonly')); ?>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->labelEx($modelClientDetailCurr,'def_addr_1',array('class'=>'control-label'));?>
			<?php echo $form->textFieldRow($modelClientDetailCurr,'def_addr_1',array('class'=>'span8','label'=>false,'readonly'=>'readonly')); ?>
			<?php echo $form->label($modelClientDetailCurr,'&nbsp',array('class'=>'control-label'));?>
			<?php echo $form->textFieldRow($modelClientDetailCurr,'def_addr_2',array('class'=>'span8','label'=>false,'readonly'=>'readonly')); ?>
			<?php echo $form->label($modelClientDetailCurr,'&nbsp',array('class'=>'control-label'));?>
			<?php echo $form->textFieldRow($modelClientDetailCurr,'def_addr_3',array('class'=>'span8','label'=>false,'readonly'=>'readonly')); ?>
			<?php echo $form->textFieldRow($modelClientDetailCurr,'post_cd',array('class'=>'span3','readonly'=>'readonly')); ?>
		</div>
		<div class="span6">
			<?php echo $form->textFieldRow($modelClientDetailCurr,'def_city',array('class'=>'span8','readonly'=>'readonly')); ?>
			<?php echo $form->textFieldRow($modelClientDetailCurr,'print_flg', array('readonly'=>'readonly','value'=>AConstant::$client_print_flg[$modelClientDetailCurr->print_flg])); ?>
			<?php echo $form->textFieldRow($modelClientDetailCurr,'custodian_cd',array('class'=>'span8','readonly'=>'readonly','value'=>Parameter::getParamDesc('CUSTO', $modelClientDetailCurr->custodian_cd))); ?>
			
			Afiliasi
			<?php echo $form->textField($modelClientDetailCurr,'cust_client_flg',array('class'=>'span1','readonly'=>'readonly')); ?>
			&emsp;
			<div class="minFee" style="display:<?php if($minimumFeeFlg->dflg1 == 'Y')echo 'inline';else echo 'none' ?>">
				Minimum Fee
				<?php echo $form->textField($modelClientDetailCurr,'internet_client',array('class'=>'span1','readonly'=>'readonly')); ?>
				&emsp;
			</div>
			
			<div class="withholdingTax" style="display:<?php if($withholdingTaxFlg->dflg1 == 'Y')echo 'inline';else echo 'none' ?>">
				Withholding tax
				<?php echo $form->textField($modelClientDetailCurr,'desp_pref',array('class'=>'span1','readonly'=>'readonly')); ?>
				&emsp;
			</div>
			
			<div class="taxOnInterest" style="display:<?php if($taxOnInterestFlg->dflg1 == 'Y')echo 'inline';else echo 'none' ?>">
				Tax On Interest
				<?php echo $form->textField($modelClientDetailCurr,'tax_on_interest',array('class'=>'span1','readonly'=>'readonly')); ?>
				&emsp;
			</div>
			
			<div class="acopenFee" style="display:<?php if($acopenFeeFlg->dflg1 == 'Y')echo 'inline';else echo 'none' ?>">
				OTC
				<?php echo $form->textField($modelClientDetailCurr,'acopen_fee_flg',array('class'=>'span1','readonly'=>'readonly')); ?>
			</div>
		</div>
	</div>
	</br/><br/>
</div>
<?php endif; ?>	

<div id="client">	
	<h4><?php if(isset($modelClientDetailCurr)) echo 'Data Client Profile (Updated)';else echo 'Data Client Profile (NEW)' ?></h4> 

	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<?php echo $form->label($modelClientDetail,'client_cd',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo $form->textField($modelClientDetail,'client_cd',array('class'=>'span3','readonly'=>'readonly','maxlength'=>12,'placeholder'=>'Fill Client Code','style'=>"width:100px")); ?>
				</div>
			</div>
		</div>
		<div class="span6">
			<?php echo $form->textFieldRow($modelClientDetail,'cifs',array('class'=>'span3','readonly'=>'readonly','style'=>"width:100px")); ?>
		</div>
		
	</div>
	
	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<?php echo $form->labelEx($modelClientDetail,'client_name',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo $form->textField($modelClientDetail,'client_name',array('class'=>'span8','readonly'=>'readonly')); ?>
				</div>
			</div>
		</div>
		<div class="span6">
			<?php echo $form->textFieldRow($modelClientDetail,'client_class',array('class'=>'span8','readonly'=>'readonly','value'=>Parameter::getParamDesc('CLASS',$modelClientDetail->client_class))); ?>
		</div>
	</div>	
	
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->textFieldRow($modelClientDetail,'client_type_3',array('class'=>'span8','readonly'=>'readonly','value'=>Lsttype3::model()->find("cl_type3 = '$modelClientDetail->client_type_3'")->cl_desc)); ?>
		</div>
		<div class="span6">
			<?php echo $form->textFieldRow($modelClientDetail,'contact_pers',array('class'=>'span8','readonly'=>'readonly')); ?>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->textFieldRow($modelClientDetail,'acct_open_dt',array('class'=>'span4','readonly'=>'readonly','value'=>Tmanydetail::reformatDate($modelClientDetail->acct_open_dt))); ?>
		</div>
		<div class="span6">
			<?php echo $form->textFieldRow($modelClientDetail,'old_ic_num',array('class'=>'span4','readonly'=>'readonly')); ?>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->textFieldRow($modelClientDetail,'branch_code',array('class'=>'span8','readonly'=>'readonly')); ?>		
		</div>
		<div class="span6">
			<?php echo $form->textFieldRow($modelClientDetail,'rem_cd',array('class'=>'span8','readonly'=>'readonly','value'=>Sales::model()->find("rem_cd = '$modelClientDetail->rem_cd'")->rem_name)); ?>	
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span6">
			<div class="span9">
				<div class="control-group">
					<?php echo $form->labelEx($modelClientDetail,'commission_per',array('class'=>'control-label','readonly'=>'readonly')); ?>
					<div class="controls">
						<?php echo $form->textField($modelClientDetail,'commission_per',array('class'=>'span6 tnumber','readonly'=>'readonly','value'=>substr($modelClientDetail->commission_per,0,1 === '0')?$modelClientDetail->commission_per:'0'.$modelClientDetail->commission_per)); ?>
						<?php echo $form->error($modelClientDetail,'commission_per', array('class'=>'help-inline error')); ?>	
					</div>
				</div>
			</div>
			<div class="span3">
				OLT
				<?php echo $form->textField($modelClientDetail,'olt',array('class'=>'span6','readonly'=>'readonly')); ?>
			</div>	
		</div>
		<div class="span6">
			<div class="control-group">
				<?php echo $form->labelEx($modelClientDetail,'subrek001_1',array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->textField($modelClientDetail,'subrek001_1',array('class'=>'span2','readonly'=>'readonly')); ?>
					001
					<?php echo $form->textField($modelClientDetail,'subrek001_2',array('class'=>'span1','readonly'=>'readonly', 'style'=>'width:30px')); ?>
					/
					<?php echo $form->textField($modelClientDetail,'subrek004_1',array('class'=>'span2','readonly'=>'readonly')); ?>
					004
					<?php echo $form->textField($modelClientDetail,'subrek004_2',array('class'=>'span1','readonly'=>'readonly', 'style'=>'width:30px')); ?>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span6">
			<div class="span9">
				<div class="control-group">
					<?php echo $form->labelEx($modelClientDetail,'rebate',array('class'=>'control-label','readonly'=>'readonly')); ?>
					<div class="controls">
						<?php echo $form->textField($modelClientDetail,'rebate',array('class'=>'span6 tnumber','readonly'=>'readonly',
						'value'=>substr($modelClientDetail->rebate,0,1 === '0')?$modelClientDetail->rebate:'0'.$modelClientDetail->rebate)); ?>	
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->textFieldRow($modelClientDetail,'rebate_basis',array('class'=>'span6','readonly'=>'readonly','value'=>AConstant::$client_rebate_basis[$modelClientDetail->rebate_basis])); ?>
		</div>
		<div class="span6">
			<div class="control-group">
				<?php echo $form->label($modelClientDetail,'stop_pay',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo $form->textField($modelClientDetail,'e_mail1',array('class'=>'span6','readonly'=>'readonly')); ?>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->labelEx($modelClientDetail,'def_addr_1',array('class'=>'control-label'));?>
			<?php echo $form->textFieldRow($modelClientDetail,'def_addr_1',array('class'=>'span8','label'=>false,'readonly'=>'readonly')); ?>
			<?php echo $form->label($modelClientDetail,'&nbsp',array('class'=>'control-label'));?>
			<?php echo $form->textFieldRow($modelClientDetail,'def_addr_2',array('class'=>'span8','label'=>false,'readonly'=>'readonly')); ?>
			<?php echo $form->label($modelClientDetail,'&nbsp',array('class'=>'control-label'));?>
			<?php echo $form->textFieldRow($modelClientDetail,'def_addr_3',array('class'=>'span8','label'=>false,'readonly'=>'readonly')); ?>
			<?php echo $form->textFieldRow($modelClientDetail,'post_cd',array('class'=>'span3','readonly'=>'readonly')); ?>
		</div>
		<div class="span6">
			<?php echo $form->textFieldRow($modelClientDetail,'def_city',array('class'=>'span8','readonly'=>'readonly')); ?>
			<?php echo $form->textFieldRow($modelClientDetail,'print_flg', array('readonly'=>'readonly','value'=>AConstant::$client_print_flg[$modelClientDetail->print_flg])); ?>
			<?php echo $form->textFieldRow($modelClientDetail,'custodian_cd',array('class'=>'span8','readonly'=>'readonly','value'=>Parameter::getParamDesc('CUSTO', $modelClientDetail->custodian_cd))); ?>
			
			Afiliasi
			<?php echo $form->textField($modelClientDetail,'cust_client_flg',array('class'=>'span1','readonly'=>'readonly')); ?>
			&emsp;
			<div class="minFee" style="display:<?php if($minimumFeeFlg->dflg1 == 'Y')echo 'inline';else echo 'none' ?>">
				Minimum Fee
				<?php echo $form->textField($modelClientDetail,'internet_client',array('class'=>'span1','readonly'=>'readonly')); ?>
				&emsp;
			</div>
			
			<div class="withholdingTax" style="display:<?php if($withholdingTaxFlg->dflg1 == 'Y')echo 'inline';else echo 'none' ?>">
				Withholding tax
				<?php echo $form->textField($modelClientDetail,'desp_pref',array('class'=>'span1','readonly'=>'readonly')); ?>
				&emsp;
			</div>
			
			<div class="taxOnInterest" style="display:<?php if($taxOnInterestFlg->dflg1 == 'Y')echo 'inline';else echo 'none' ?>">
				Tax On Interest
				<?php echo $form->textField($modelClientDetail,'tax_on_interest',array('class'=>'span1','readonly'=>'readonly')); ?>
				&emsp;
			</div>
			
			<div class="acopenFee" style="display:<?php if($acopenFeeFlg->dflg1 == 'Y')echo 'inline';else echo 'none' ?>">
				OTC
				<?php echo $form->textField($modelClientDetail,'acopen_fee_flg',array('class'=>'span1','readonly'=>'readonly')); ?>
			</div>
		</div>
	</div>

	</br/><br/>
</div>

<div id="cifCurr">
	<h4>Data CIF Profile</h4> 

	<?php
		$tabs;

		$tabs = array(
			array(
	                'label'   => 'Corporate Information',
	                'content' =>  $this->renderPartial('_view_client_corp',array('modelClientInstDetail'=>$modelClientInstDetailCurr,'modelCifDetail'=>$modelCifDetailCurr,'form'=>$form),true,false),
	                'active'  => true
	            ),
             array(
	                'label'   => 'Authorized Persons',
	                'content' =>  $this->renderPartial('_view_client_authorized',array('modelClientInstDetail'=>$modelClientInstDetailCurr,'modelCifDetail'=>$modelCifDetailCurr,'modelClientAuthoDetail'=>$modelClientAuthoDetailCurr,'form'=>$form),true,false),
	                'active'  => false
	            ),
			array(
					'label' => 'Fund',
					'content' => $this->renderPartial('_view_client_fund',array('modelClientInstDetail'=>$modelClientInstDetailCurr,'modelCifDetail'=>$modelCifDetailCurr,'form'=>$form),true,false),
					'active' => false
			),
			array(
					'label' => 'Bank',
					'content' => $this->renderPartial('_view_client_bank',array('modelClientInstDetail'=>$modelClientInstDetailCurr,'modelCifDetail'=>$modelCifDetailCurr,'modelClientBankDetail'=>$modelClientBankDetailCurr,'form'=>$form),true,false),
					'active' => false
			),
		);
		
		if(isset($modelClientDetailCurr))
		{
			$temp = array(
						array(
								'label' => 'Instruction and Information',
								'content' => $this->renderPartial('_view_client_instruction',array('modelClientDetail'=>$modelClientDetailCurr,'modelClientInstDetail'=>$modelClientInstDetailCurr,'modelCifDetail'=>$modelCifDetailCurr,'form'=>$form),true,false),
								'active' => false
						),
						array(
								'label' => 'Broker Authorization',
								'content' => $this->renderPartial('_view_client_broker',array('curr'=>true,'modelClientDetail'=>$modelClientDetailCurr,'modelClientInstDetail'=>$modelClientInstDetailCurr,'modelCifDetail'=>$modelCifDetailCurr,'form'=>$form),true,false),
								'active' => false
						)
					);
		
			$tabs = array_merge($tabs,$temp);
		}

		
		$this->widget(
		   'bootstrap.widgets.TbTabs',
		    array(
		        'type' => 'pills', // 'tabs' or 'pills'
		        'tabs' => $tabs,
		        'htmlOptions' => array('id'=>'tabMenu'),
		    )
		);
	?>
	
	<br/><br/>
</div>

<div id="cif">
	<h4>Data CIF Profile (Updated)</h4> 
	
	<?php
	$tabs;

		$tabs = array(
			array(
	                'label'   => 'Corporate Information',
	                'content' =>  $this->renderPartial('_view_client_corp',array('modelClientDetail'=>$modelClientDetail,'modelClientInstDetail'=>$modelClientInstDetail,'modelCifDetail'=>$modelCifDetail,'form'=>$form),true,false),
	                'active'  => true
	            ),
            array(
	                'label'   => 'Authorized Persons',
	                'content' =>  $this->renderPartial('_view_client_authorized',array('modelClientDetail'=>$modelClientDetail,'modelClientInstDetail'=>$modelClientInstDetail,'modelCifDetail'=>$modelCifDetail,'modelClientAuthoDetail'=>$modelClientAuthoDetail,'listTmanyClientAuthoDetail'=>$listTmanyClientAuthoDetail,'form'=>$form),true,false),
	                'active'  => false
	            ),
			array(
					'label' => 'Fund',
					'content' => $this->renderPartial('_view_client_fund',array('modelClientDetail'=>$modelClientDetail,'modelClientInstDetail'=>$modelClientInstDetail,'modelCifDetail'=>$modelCifDetail,'form'=>$form),true,false),
					'active' => false
			),
			array(
					'label' => 'Bank',
					'content' => $this->renderPartial('_view_client_bank',array('modelClientDetail'=>$modelClientDetail,'modelClientInstDetail'=>$modelClientInstDetail,'modelCifDetail'=>$modelCifDetail,'modelClientBankDetail'=>$modelClientBankDetail,'listTmanyClientBankDetail'=>$listTmanyClientBankDetail,'form'=>$form),true,false),
					'active' => false
			),
			array(
					'label' => 'Instruction and Information',
					'content' => $this->renderPartial('_view_client_instruction',array('modelClientDetail'=>$modelClientDetail,'modelClientInstDetail'=>$modelClientInstDetail,'modelCifDetail'=>$modelCifDetail,'form'=>$form),true,false),
					'active' => false
			),
			array(
					'label' => 'Broker Authorization',
					'content' => $this->renderPartial('_view_client_broker',array('curr'=>false,'modelClientDetail'=>$modelClientDetail,'modelClientInstDetail'=>$modelClientInstDetail,'modelCifDetail'=>$modelCifDetail,'form'=>$form),true,false),
					'active' => false
			),
		);

		
		$this->widget(
		   'bootstrap.widgets.TbTabs',
		    array(
		        'type' => 'pills', // 'tabs' or 'pills'
		        'tabs' => $tabs,
		        'htmlOptions' => array('id'=>'tabMenu'),
		    )
		);
	?>
</div>	
<?php $this->endWidget(); ?>

<script>
	var ctr;
	var rowIndex;
	var rowid;
	var activeRow;
	var x;
	var maxCtr;
	
	$(document).ready(function()
	{	
		if($('#clientCurr').length)
		{
			ctr = 0;
			$('#clientCurr').find("input").each(function() {
				var temp  = $(this).val().trim();
				
				var objUpdate = $("#client input").get(ctr);
				var temp2 = $(objUpdate).val().trim();
				
				if(temp != temp2){
					$(objUpdate).css({'background-color':'green','color':'white'});
		  		}
		  		ctr++;
	  		});
  		}
  		
  		var tabCount = 0;
  		
  		$('#cifCurr #tabMenu .tab-content .tab-pane').each(function() {
  			
			ctr = 0;
			
			if(tabCount != 1 && tabCount != 3)
				$(this).find("input").each(function()
				{
					var temp  = $(this).val().trim();
					
					var objUpdate = $("#cif #tabMenu .tab-content .tab-pane:eq("+tabCount+") input").get(ctr);
					var temp2 = $(objUpdate).val().trim();

					if(temp != temp2){
			  			$(objUpdate).css({'background-color':'green','color':'white'});
			  		}
			  		ctr++;
				});
  		
	  		tabCount++;
  		})	
  		
  		$("#tableAutho tbody tr").each(function()
		{
			if($(this).find(".rowidAutho").val())
			{
				if($(this).find("td:eq(8)").html().trim() == 'Update')
				{
					rowid = $(this).find(".rowidAutho").val();
						
					$("#tableAuthoCurr tbody tr").each(function()
					{
						if($(this).find(".rowidAutho").length && $(this).find(".rowidAutho").val() == rowid)
						{
							rowIndex  = $(this).index();
							return false;
						}
					});
					
					activeRow = $(this);
					
					for(x=0;x<3;x++)
					{
						switch(x) //First Row has 8 columns that need to be compared while the rest have only 6 columns
						{
							case 0:
								maxCtr = 8;
								break;
							default:
								activeRow = activeRow.next();
								maxCtr = 6;
								break;
						}
						
						ctr = 0;
						
						activeRow.find("td").each(function()
						{
							var temp  = $(this).html().trim();
							
							var objCurr = $("#tableAuthoCurr tbody tr:eq("+(rowIndex+x)+") td").get(ctr);
							var temp2 = $(objCurr).html().trim();
							
							if(temp != temp2){
				  				$(this).css({'background-color':'green','color':'white'});
							}
							ctr++;
							
							if(ctr == maxCtr)return false;
						})
					}
				}
				else
				{
					$(this).css({'background-color':'#BB0000','color':'white'});
					$(this).next().css({'background-color':'#BB0000','color':'white'});
					$(this).next().next().css({'background-color':'#BB0000','color':'white'});
				}
			}
			
		});	
  		
  		$("#tableBank tbody tr").each(function()
		{
			if($(this).find("td:eq(8)").html() == 'Update')
			{
				rowid = $(this).find(".rowid").val();
				
				$("#tableBankCurr tbody tr").each(function()
				{
					if($(this).find(".rowid").val() == rowid)
					{
						rowIndex  = $(this).index();
					}
				});
				
				ctr = 0;
				
				$(this).find("td").each(function()
				{
					var temp  = $(this).html().trim();
					
					var objCurr = $("#tableBankCurr tbody tr:eq("+rowIndex+") td").get(ctr);
					var temp2 = $(objCurr).html().trim();
					
					if(temp != temp2){
		  				$(this).css({'background-color':'green','color':'white'});
					}
					ctr++;
					
					if(ctr == 7)return false;
				})
			}
			else if($(this).find("td:eq(8)").html() == 'Cancel')
			{
				$(this).css({'background-color':'#BB0000','color':'white'});
			}
		});	
  	});
	
</script>

<h4>Approval Attributes</h4>
<div class="row-fluid">
	<div class="span6">
		<?php $this->widget('bootstrap.widgets.TbDetailView',array(
			'data'=>$model,
			'attributes'=>array(
				array('name'=>'status','value'=>AConstant::$inbox_stat[$model->status]),
				array('name'=>'update_date','type'=>'datetime'),
				'user_id',
				'ip_address',
				array('name'=>$model->status!='U'?'cancel_reason':'edit_reason','type'=>'raw','value'=>nl2br($model->cancel_reason)),
			),
		)); ?>
	</div>
	<div class="span6">
		<?php $this->widget('bootstrap.widgets.TbDetailView',array(
			'data'=>$model,
			'attributes'=>array(
				array('name'=>'approved_status','value'=>AConstant::$inbox_app_stat[$model->approved_status]),
				array('name'=>'approved_date','type'=>'datetime'),
				'approved_user_id',
				array('name'=>'reject_reason','type'=>'raw','value'=>nl2br($model->reject_reason)),
			),
		)); ?>
	</div>
</div>

<?php if($model->approved_status == AConstant::INBOX_APP_STAT_ENTRY): ?>	
	<br/>
	<div style="text-align:right;">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'type'=>'secondary',
			'icon'=>'ok',
			'url'=>$this->createUrl('approve',array('id'=>$model->primaryKey)),
			'label'=>'Approve',
		)); ?>
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'type'=>'secondary',
			'icon'=>'remove',
			'url'=>$this->createUrl('reject',array('id'=>$model->primaryKey)),
			'htmlOptions'=>array('class'=>'reject-inbox'),
			'label'=>'Reject',
		)); ?>
	</div>
	<?php 
		$param  = array(array('class'=>'reject-inbox','title'=>'Reject Reason','url'=>'AjxPopReject','urlparam'=>array('id'=>$model->primaryKey,'label'=>false)));
	  	AHelper::popupwindow($this, 600, 500, $param);
	?>
<?php endif; ?>

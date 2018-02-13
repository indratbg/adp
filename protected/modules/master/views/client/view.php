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
	'Clients'=>array('index'),
	$modelClientDetail->client_cd,
);

$this->menu=array(
	array('label'=>'View Individual Client '.$modelClientDetail->client_cd, 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'List','icon'=>'list','url'=>array('index'),'itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Create','icon'=>'plus','url'=>array('create'),'itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Update','icon'=>'pencil','url'=>array('update','id'=>$modelClientDetail->client_cd),'itemOptions'=>array('style'=>'float:right')),
	array('label'=>'View','icon'=>'eye-open','url'=>array('view','id'=>$modelClientDetail->client_cd),'itemOptions'=>array('class'=>'active','style'=>'float:right')),
);
?>

<?php 
	$minimumFeeFlg = Sysparam::model()->find("param_id = 'CLIENT MASTER' AND param_cd1 = 'MINFEE' AND param_cd2 = 'DEFAULT'");
	$withholdingTaxFlg = Sysparam::model()->find("param_id = 'CLIENT MASTER' AND param_cd1 = 'WHTAX' AND param_cd2 = 'DEFAULT'");
	$acopenFeeFlg = Sysparam::model()->find("param_id = 'CLIENT MASTER' AND param_cd1 = 'OTC' AND param_cd2 = 'DEFAULT'");
	$taxOnInterestFlg = Sysparam::model()->find("param_id = 'CLIENT MASTER' AND param_cd1 = 'INTTAX' AND param_cd2 = 'DEFAULT'");
?>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h3>Primary Attributes</h3>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'client-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

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
			<div class="control-group">
				<?php echo $form->label($modelClientDetail,'cifs',array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->textField($modelClientDetail,'cifs',array('class'=>'span3','readonly'=>'readonly','style'=>"width:100px")); ?>
					&emsp;
					RDN
					<?php echo $form->textField($modelClientDetail,'rdn',array('class'=>'span4','readonly'=>'readonly')); ?>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<?php echo $form->labelEx($modelClientDetail,'client_name',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo $form->textField($modelCifDetail,'client_title',array('class'=>'span2','readonly'=>'readonly')); ?>
					<?php echo $form->textField($modelClientDetail,'client_name',array('class'=>'span7','readonly'=>'readonly')); ?>
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
			<?php echo $form->textFieldRow($modelClientDetail,'rem_cd',array('class'=>'span8','readonly'=>'readonly','value'=>Sales::model()->find("rem_cd = TRIM('$modelClientDetail->rem_cd')")->rem_name)); ?>	
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span6">
			<div class="span9">
				<div class="control-group">
					<?php echo $form->labelEx($modelClientDetail,'commission_per',array('class'=>'control-label','readonly'=>'readonly')); ?>
					<div class="controls">
						<?php echo $form->textField($modelClientDetail,'commission_per',array('class'=>'span6 tnumber','readonly'=>'readonly','value'=>$modelClientDetail->commission_per/100)); ?>
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
						<?php echo $form->textField($modelClientDetail,'rebate',array('class'=>'span6 tnumber','readonly'=>'readonly','value'=>$modelClientDetail->rebate/100)); ?>	
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

	</br/>
	
	<?php
	$tabs;

		$tabs = array(
			array(
	                'label'   => 'Client Individual',
	                'content' =>  $this->renderPartial('_view_client_indi',array('modelClientDetail'=>$modelClientDetail,'modelClientIndiDetail'=>$modelClientIndiDetail,'modelCifDetail'=>$modelCifDetail,'modelClientEmerDetail'=>$modelClientEmerDetail,'form'=>$form),true,false),
	                'active'  => true
	            ),
             array(
	                'label'   => 'Occupation',
	                'content' =>  $this->renderPartial('_view_client_occupation',array('modelClientDetail'=>$modelClientDetail,'modelClientIndiDetail'=>$modelClientIndiDetail,'modelCifDetail'=>$modelCifDetail,'form'=>$form),true,false),
	                'active'  => false
	            ),
	         array(
		         	'label' => 'Spouse / Parent',
		         	'content' =>  $this->renderPartial('_view_client_spouse',array('modelClientDetail'=>$modelClientDetail,'modelClientIndiDetail'=>$modelClientIndiDetail,'modelCifDetail'=>$modelCifDetail,'form'=>$form),true,false),
		            'active'  => false
				 ),
			array(
					'label' => 'Fund',
					'content' => $this->renderPartial('_view_client_fund',array('modelClientDetail'=>$modelClientDetail,'modelClientIndiDetail'=>$modelClientIndiDetail,'modelCifDetail'=>$modelCifDetail,'form'=>$form),true,false),
					'active' => false
			),
			array(
					'label' => 'Bank',
					'content' => $this->renderPartial('_view_client_bank',array('modelClientDetail'=>$modelClientDetail,'modelClientIndiDetail'=>$modelClientIndiDetail,'modelCifDetail'=>$modelCifDetail,'modelClientBankDetail'=>$modelClientBankDetail,'form'=>$form),true,false),
					'active' => false
			),
			array(
					'label' => 'Instruction and Information',
					'content' => $this->renderPartial('_view_client_instruction',array('modelClientDetail'=>$modelClientDetail,'modelClientIndiDetail'=>$modelClientIndiDetail,'modelCifDetail'=>$modelCifDetail,'form'=>$form),true,false),
					'active' => false
			),
			array(
					'label' => 'Broker Authorization',
					'content' => $this->renderPartial('_view_client_broker',array('curr'=>true,'modelClientDetail'=>$modelClientDetail,'modelClientIndiDetail'=>$modelClientIndiDetail,'modelCifDetail'=>$modelCifDetail,'form'=>$form),true,false),
					'active' => false
			),
			array(
					'label' => 'Member',
					'content' => $this->renderPartial('_view_client_member',array('modelClientMember'=>$modelClientMember,'form'=>$form),true,false),
					'active' => false
			)
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
	
<?php $this->endWidget(); ?>


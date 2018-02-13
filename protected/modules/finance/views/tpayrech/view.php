<style>
	.tabMenu ul
	{
		border-top:2px solid #ddd;
		border-bottom:2px solid #ddd;
		border-left:2px solid #ddd;
		border-radius:5px;
	}	
	.tabMenu li
	{
		border-right:1px solid #ddd;
		border-radius:5px;
	}
	.tabMenu li:not(:first-child)
	{
		border-left:1px solid #ddd;
		border-radius:5px;
	}
	.tnumber, .tnumberdec
	{
		text-align:right;
	}
</style>

<?php AHelper::applyFormatting() ?>

<?php
$this->breadcrumbs=array(
	'Voucher'=>array('index'),
	$model->payrec_num,
);

$this->menu=array(
	array('label'=>'View Voucher '.$model->payrec_num, 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'List','icon'=>'list','url'=>array('index'),'itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Create','icon'=>'plus','url'=>array('create'),'itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Update','icon'=>'pencil','url'=>array('update','id'=>$model->payrec_num),'itemOptions'=>array('style'=>'float:right;display:inline')),
	array('label'=>'View','icon'=>'eye-open','url'=>array('view','id'=>$model->payrec_num),'itemOptions'=>array('class'=>'active','style'=>'float:right')),
);
?>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tpayrech-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>
	
	<div class="row-fluid">
		<div class="span4">
			<div id="payrecType_div">
				<div class="span5">
					<?php echo $form->labelEx($model,'payrec_type',array('class'=>'control-label')) ?>
				</div>
				<?php echo $form->textField($model,'payrec_type',array('id'=>'payrecType','class'=>'span5','value'=>substr($model->payrec_type,0,1)=='R'?'RECEIPT':'PAYMENT','disabled'=>'disabled')); ?>
			</div>
		</div>
		<div class="span4">
			<div class="control-group">
				<div class="span4" id="clientCd_span">
					<?php echo $form->labelEx($model,'client_cd',array('id'=>'clientLabel','class'=>'control-label')) ?>
				</div>
				<?php echo $form->textField($model,'client_cd',array('id'=>'clientCd','class'=>'span4','disabled'=>'disabled')); ?>
				<?php echo $form->textField($model,'client_type',array('id'=>'clientType','class'=>'span2','readonly'=>'readonly')); ?>
				<?php echo $form->textField($model,'branch_code',array('id'=>'branchCode','class'=>'span2','readonly'=>'readonly')); ?>
			</div>
		</div>
		<div class="span4">
			<?php echo $form->textField($model,'client_name',array('id'=>'clientName','class'=>'span12','readonly'=>'readonly')); ?>
		</div>
	</div>

	<div class="row-fluid">
		<div class="span4">
			<div class="span5">
				<?php echo $form->labelEx($model,'payrec_date',array('class'=>'control-label')) ?>
			</div>
			<?php echo $form->textField($model,'payrec_date',array('id'=>'payrecDate','class'=>'tdate span6','readonly'=>'readonly','value'=>Tmanydetail::reformatDate($model->payrec_date))); ?>
		</div>
		<div class="span4">
			<div class="control-group">
				<div class="span4">
					
				</div>
				<?php echo $form->textField($model,'olt',array('id'=>'olt','class'=>'span2','readonly'=>'readonly')); ?>
				<?php echo $form->textField($model,'client_type_3',array('id'=>'clientType3','class'=>'span4','readonly'=>'readonly')); ?>
				<?php echo $form->textField($model,'recov_charge_flg',array('id'=>'recovChargeFlg','class'=>'span2','readonly'=>'readonly')); ?>
			</div>
		</div>
		<div class="span4">
			<div class="span5">
				<?php echo $form->labelEx($model,'int_adjust',array('class'=>'control-label')) ?>
			</div>
			<?php echo $form->textField($model,'int_adjust',array('id'=>'intAdjust','class'=>'span1','readonly'=>'readonly','style'=>'width:30px;float:left')); ?>

			<div class="span4">
				<?php echo $form->labelEx($model,'trf_ksei',array('class'=>'control-label')) ?>
			</div>
			<?php echo $form->textField($model,'trf_ksei',array('id'=>'trfKsei','class'=>'span1','readonly'=>'readonly','style'=>'width:30px;float:left')); ?>
		</div>		
	</div>
	
	<div class="row-fluid">
		<div class="span4">
		</div>
		<div class="span4">
			<div class="control-group">
				<div class="span4">
					<?php echo $form->labelEx($model,'bank_cd',array('class'=>'control-label')) ?>
				</div>
				<?php echo $form->textField($model,'bank_cd',array('id'=>'bankCd','class'=>'span3','readonly'=>'readonly')); ?>
				<?php echo $form->textField($model,'bank_acct_fmt',array('id'=>'bankAcctFmt','class'=>'span5','readonly'=>'readonly')); ?>
			</div>
		</div>
		<div class="span4">
			<?php echo $form->textField($model,'active',array('id'=>'active','class'=>'span4','readonly'=>'readonly','style'=>'float:left')); ?>
			<div class="span3">
				<?php echo $form->labelEx($model,'rdi_pay_flg',array('class'=>'')) ?>
			</div>
			<?php echo $form->textField($model,'rdi_pay_flg',array('id'=>'rdiPayFlg','class'=>'span2','readonly'=>'readonly')); ?>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span4">
			<div class="control-group">
				<div class="span5">
					<?php echo $form->labelEx($model,'gl_acct_cd',array('class'=>'control-label')) ?>
				</div>
				<div class="controls">
					<?php echo $form->textField($model,'gl_acct_cd',array('id'=>'glAcctCd','class'=>'span3','readonly'=>'readonly')); ?>
					<?php echo $form->textField($model,'sl_acct_cd',array('id'=>'slAcctCd','class'=>'span4','readonly'=>'readonly')); ?>
				</div>
			</div>
		</div>
		<div class="span4">
			<div id="currAmt_div">
				<div id="currAmt_span" class="span4">
					<?php echo $form->labelEx($model,'curr_amt',array('class'=>'control-label')) ?>
				</div>
				<?php echo $form->textField($model,'curr_amt',array('id'=>'currAmt','class'=>'span8 tnumberdec','readonly'=>'readonly')); ?>
			</div>
		</div>
		<div class="span4">
			<?php echo $form->textField($model,'acct_name',array('id'=>'acctName','class'=>'span12','readonly'=>'readonly')); ?>		
		</div>	
	</div>
	
	<div class="row-fluid">
		<div class="span4">
			<div id="folderCd_span" class="span5">
				<?php echo $form->labelEx($model,'folder_cd',array('class'=>'control-label')) ?>
			</div>
			<?php echo $form->textField($model,'folder_cd',array('id'=>'folderCd','class'=>'span7','readonly'=>'readonly')); ?>
		</div>
		<div class="span8">
			<div class="control-group">
				<div id="remarks_span" class="span2">
					<?php echo $form->labelEx($model,'remarks',array('class'=>'control-label')) ?>
				</div>
				<?php echo $form->textField($model,'remarks',array('id'=>'remarks','class'=>'span8','readonly'=>'readonly')); ?>
			</div>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span8">
			<div class="control-group">
				<div id="payrecFrto_span" class="span2">
					<?php echo $form->labelEx($model,'payrec_frto',array('class'=>'control-label')) ?>
				</div>
				<?php echo $form->textField($model,'payrec_frto',array('id'=>'payrecFrto','class'=>'span8','readonly'=>'readonly')); ?>
			</div>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span4">
			<div class="control-group">
				<div class="span5">
					<?php echo $form->labelEx($model,'client_bank_acct',array('class'=>'control-label')) ?>
				</div>
				<?php echo $form->textField($model,'client_bank_acct',array('id'=>'clientBankAcct','class'=>'span7','readonly'=>'readonly')); ?>
			</div>
		</div>
		<div class="span8">
			<div id="clientBankName_span" class="span4">
				<?php echo $form->labelEx($model,'client_bank_cd',array('class'=>'control-label')) ?>
			</div>
			<?php echo $form->textField($model,'client_bank_name',array('id'=>'clientBankName','class'=>'span8','readonly'=>'readonly')); ?>
		</div>
	</div>
		
	<br/>
	<?php
		$tabs = array(
			array(
	                'label'   => 'Journal',
	                'content' =>  $this->renderPartial('/tpayrech/_view_detail',array('model'=>$model,'modelDetail'=>$modelDetail,'form'=>$form),true,false),
	                'active'  => true
	            ),
             array(
	                'label'   => 'Cheque',
	                'content' =>  $this->renderPartial('/tpayrech/_view_cheq',array('model'=>$model,'modelCheq'=>$modelCheq,'form'=>$form),true,false),
	                'active'  => false
	            ),
	    );
	
		$this->widget(
		   'bootstrap.widgets.TbTabs',
		    array(
		        'type' => 'pills', // 'tabs' or 'pills'
		        'tabs' => $tabs,
		        'htmlOptions' => array('id'=>'tabMenu','class'=>'tabMenu'),
		    )
		);
	 ?>

<?php $this->endWidget(); ?>

<script>
	$(window).resize(function()
	{
		$("#clientBankName_span").css('width',$("#clientCd_span").width()+'px');
		$("#remarks_span").css('width',$("#clientCd_span").width()+'px');
		$("#payrecFrto_span").css('width',$("#folderCd_span").width()+'px');
	});
	$(window).trigger('resize');
</script>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'type'=>'horizontal'
)); ?>

<h4>Primary Attributes</h4>
	<?php echo $form->textFieldRow($model,'doc_num',array('class'=>'span5','maxlength'=>17)); ?>
<!--
	<div class="control-group">
		<?php echo $form->label($model,'doc_date',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'doc_date_date',array('maxlength'=>'2','class'=>'span1','placeholder'=>'dd')); ?>
			<?php echo $form->textField($model,'doc_date_month',array('maxlength'=>'2','class'=>'span1','placeholder'=>'mm')); ?>
			<?php echo $form->textField($model,'doc_date_year',array('maxlength'=>'4','class'=>'span1','placeholder'=>'yyyy')); ?>
		</div>
	</div>
	-->

<div class="row-fluid control-group">
	<div class="span4">
		<?php echo $form->datePickerRow($model,'from_date',array('class'=>'span5'));?>
	</div>
	<div class="span6" style="margin-left: -10px;">
		<div class="span2">
			<label>To Date</label>
		</div>
		
		<div class="span5" style="margin-left: -20px;">
		<?php echo $form->datePickerRow($model,'to_date',array('class'=>'span8','label'=>FALSE));?>	
		</div>
		
	</div>
</div>
	
	<?php echo $form->dropDownListRow($model,'trx_type',Constanta::$movement_type,array('class'=>'span5','maxlength'=>1,'prompt'=>'-Select type-')); ?>
	<?php echo $form->textFieldRow($model,'client_cd',array('class'=>'span5','maxlength'=>12)); ?>
	<?php echo $form->textFieldRow($model,'brch_cd',array('class'=>'span5','maxlength'=>2)); ?>
	<?php echo $form->dropDownListRow($model,'source',array(''=>'-ALL-','H2H'=>'HOST TO HOST','INPUT'=>'INPUT','IPO'=>'IPO','MUTASI'=>'MUTASI'),array('class'=>'span5','maxlength'=>10)); ?>

	<div class="control-group">
		<?php echo $form->label($model,'bank_mvmt_date',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'bank_mvmt_date_date',array('maxlength'=>'2','class'=>'span1','placeholder'=>'dd')); ?>
			<?php echo $form->textField($model,'bank_mvmt_date_month',array('maxlength'=>'2','class'=>'span1','placeholder'=>'mm')); ?>
			<?php echo $form->textField($model,'bank_mvmt_date_year',array('maxlength'=>'4','class'=>'span1','placeholder'=>'yyyy')); ?>
		</div>
	</div>
	<?php echo $form->textFieldRow($model,'acct_name',array('class'=>'span5','maxlength'=>50)); ?>
	<?php echo $form->textFieldRow($model,'remarks',array('class'=>'span5','maxlength'=>50)); ?>
	<?php echo $form->textFieldRow($model,'from_client',array('class'=>'span5','maxlength'=>12)); ?>
	<?php echo $form->textFieldRow($model,'from_acct',array('class'=>'span5','maxlength'=>25)); ?>
	<?php echo $form->textFieldRow($model,'from_bank',array('class'=>'span5','maxlength'=>30)); ?>
	<?php echo $form->textFieldRow($model,'to_client',array('class'=>'span5','maxlength'=>12)); ?>
	<?php echo $form->textFieldRow($model,'to_acct',array('class'=>'span5','maxlength'=>25)); ?>
	<?php echo $form->textFieldRow($model,'to_bank',array('class'=>'span5','maxlength'=>30)); ?>
	<?php echo $form->textFieldRow($model,'trx_amt',array('class'=>'span5')); ?>
	
	<?php echo $form->textFieldRow($model,'fee',array('class'=>'span5')); ?>
	<?php echo $form->textFieldRow($model,'folder_cd',array('class'=>'span5','maxlength'=>8)); ?>
	<?php echo $form->textFieldRow($model,'fund_bank_cd',array('class'=>'span5','maxlength'=>30)); ?>
	<?php echo $form->textFieldRow($model,'fund_bank_acct',array('class'=>'span5','maxlength'=>25)); ?>
	<?php echo $form->textFieldRow($model,'reversal_jur',array('class'=>'span5','maxlength'=>17)); ?>
	

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

<script>
	$('#Tfundmovement_from_date').datepicker({format : "dd/mm/yyyy"});
	$('#Tfundmovement_to_date').datepicker({format : "dd/mm/yyyy"});
	
	$('#Tfundmovement_trx_type').change(function(){
	if($('#Tfundmovement_trx_type').val()=='B'){	
		$('#Tfundmovement_from_client').val('BUNGA');
	}
	else{
		$('#Tfundmovement_from_client').val('');
	}
	});
	
	$('#Tfundmovement_from_date').change(function(){
		$('#Tfundmovement_to_date').val($('#Tfundmovement_from_date').val());
	});
	
	
</script>


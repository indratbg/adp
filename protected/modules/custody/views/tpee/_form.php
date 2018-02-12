<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tpee-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>


	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<div class="row-fluid">
		<div class="span9">
			<?php if($model->isNewRecord || !$check): ?>
				<?php echo $form->textFieldRow($model,'stk_cd',array('class'=>'span4','maxlength'=>50)); ?>
			<?php else: ?>
				<?php echo $form->textFieldRow($model,'stk_cd',array('class'=>'span4','maxlength'=>50,'readonly'=>'readonly')); ?>
			<?php endif ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span9">
			<?php echo $form->dropDownListRow($model,'jenis_penjaminan',array('KESANGGUPAN PENUH' => 'KESANGGUPAN PENUH','USAHA TERBAIK' => 'USAHA TERBAIK','PEMBELI SIAGA' => 'PEMBELI SIAGA'),array('class'=>'span4')); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span9">
			<?php echo $form->textFieldRow($model,'stk_name',array('class'=>'span8','maxlength'=>80)); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span10">
			<div class="span6">
				<?php echo $form->datePickerRow($model,'tgl_kontrak',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yy','class'=>'tdate span6','options'=>array('format' => 'dd/mm/yy'))); ?>
			</div>
			<div class="span6">
				<?php if(!$model->getAttribute('nilai_komitment')): ?>
					<?php echo $form->textFieldRow($model,'nilai_komitment',array('class'=>'span6 tnumber','maxlength'=>19,'style'=>'text-align:right','value'=>0)); ?>
				<?php else: ?>
					<?php echo $form->textFieldRow($model,'nilai_komitment',array('class'=>'span6 tnumber','maxlength'=>19,'style'=>'text-align:right')); ?>
				<?php endif ?>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span10">
			<div class="span6">
				<?php echo $form->datePickerRow($model,'eff_dt_fr',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yy','class'=>'tdate span6','options'=>array('format' => 'dd/mm/yy'))); ?>
			</div>
			<div class="span6">
				<?php echo $form->datePickerRow($model,'eff_dt_to',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yy','class'=>'tdate span6','options'=>array('format' => 'dd/mm/yy'))); ?>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span10">
			<div class="span6">
				<?php echo $form->datePickerRow($model,'offer_dt_fr',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yy','class'=>'tdate span6','options'=>array('format' => 'dd/mm/yy'))); ?>
			</div>
			<div class="span6">
				<?php echo $form->datePickerRow($model,'offer_dt_to',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yy','class'=>'tdate span6','options'=>array('format' => 'dd/mm/yy'))); ?>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span10">
			<div class="span6">
				<?php echo $form->datePickerRow($model,'allocate_dt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yy','class'=>'tdate span6','options'=>array('format' => 'dd/mm/yy'))); ?>
			</div>
			<div class="span6">
				<?php echo $form->datePickerRow($model,'distrib_dt_fr',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yy','class'=>'tdate span6','options'=>array('format' => 'dd/mm/yy'))); ?>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span10">
			<div class="span6">
				<?php echo $form->datePickerRow($model,'paym_dt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yy','class'=>'tdate span6','options'=>array('format' => 'dd/mm/yy'))); ?>
			</div>
			<div class="span6">
				<?php if(!$model->getAttribute('unsubscribe_qty')): ?>
					<?php echo $form->textFieldRow($model,'unsubscribe_qty',array('class'=>'span6 tnumber','maxlength'=>16,'style'=>'text-align:right','value'=>0)); ?>
				<?php else: ?>
					<?php echo $form->textFieldRow($model,'unsubscribe_qty',array('class'=>'span6 tnumber','maxlength'=>16,'style'=>'text-align:right')); ?>
				<?php endif ?>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span10">
			<div class="span6">
				<?php if(!$model->getAttribute('price')): ?>
					<?php echo $form->textFieldRow($model,'price',array('class'=>'span6 tnumber','maxlength'=>9,'style'=>'text-align:right','value'=>0)); ?>
				<?php else: ?>
					<?php echo $form->textFieldRow($model,'price',array('class'=>'span6 tnumber','maxlength'=>9,'style'=>'text-align:right')); ?>
				<?php endif ?>
			</div>
			<div class="span6">
				<?php echo $form->textFieldRow($model,'bank_garansi',array('class'=>'span6 tnumber','maxlength'=>18,'style'=>'text-align:right')); ?>	
			</div>	
		</div>
	</div>
	<div class="row-fluid">
		<div class="span10">
			<div class="span6">
				<?php echo $form->textFieldRow($model,'order_price',array('class'=>'span6 tnumber','maxlength'=>18,'style'=>'text-align:right')); ?>	
			</div>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span10">
			<div class="span6">
				<?php echo $form->dropDownListRow($model,'ipo_bank_cd',CHtml::listData(Ipbank::model()->findAll(array('condition'=>"approved_stat='A'",'order'=>'bank_cd')),'bank_cd','DropDownName'),array('class'=>'span6','prompt'=>'-Choose-','style'=>'font-family:courier')); ?>	
			</div>
			<div class="span6">
				<?php echo $form->textFieldRow($model,'ipo_bank_acct',array('class'=>'span6','maxlength'=>30)); ?>	
			</div>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span9">
			<?php echo $form->textFieldRow($model,'ipo_acct_name',array('class'=>'span8','maxlength'=>50)); ?>
		</div>
	</div>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

<script>
	$.fn.datepicker.defaults.format = "dd/mm/yy";
	
	$("#Tpee_stk_cd").on('keyup blur', function()
	{
		$("#Tpee_stk_cd").val($("#Tpee_stk_cd").val().toUpperCase());
	});
</script>

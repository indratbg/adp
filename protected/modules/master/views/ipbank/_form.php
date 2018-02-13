<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'ipbank-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
    <?php echo $form->textFieldRow($model,'bank_cd',array('class'=>'span5','maxlength'=>3)); ?>
	<?php echo $form->textFieldRow($model,'bi_code',array('class'=>'span5','maxlength'=>7)); ?>
	<?php echo $form->textFieldRow($model,'bank_short_name',array('class'=>'span5','maxlength'=>30)); ?>

	<?php echo $form->textFieldRow($model,'bank_name',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->dropDownListRow($model,'bank_stat',AConstant::$bank_stat,array('class'=>'span2','style'=>'font-family:courier','id'=>'bank_stat'));?>
	<?php //echo $form->datePickerRow($model,'cre_dt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate','options'=>array('format' => 'dd/mm/yyyy'))); ?>

	<?php //echo $form->textFieldRow($model,'user_id',array('class'=>'span5','maxlength'=>10)); ?>

	<?php //echo $form->datePickerRow($model,'upd_dt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate','options'=>array('format' => 'dd/mm/yyyy'))); ?>

	<?php //echo $form->textFieldRow($model,'upd_by',array('class'=>'span5','maxlength'=>10)); ?>

	<?php //echo $form->datePickerRow($model,'approved_dt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate','options'=>array('format' => 'dd/mm/yyyy'))); ?>

	<?php //echo $form->textFieldRow($model,'approved_stat',array('class'=>'span5','maxlength'=>1)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
<script>
    $('#Ipbank_bank_cd').change(function(){
         $('#Ipbank_bank_cd').val($('#Ipbank_bank_cd').val().toUpperCase());
    })
    $('#Ipbank_bank_short_name').change(function(){
         $('#Ipbank_bank_short_name').val($('#Ipbank_bank_short_name').val().toUpperCase());
    })
     $('#Ipbank_bank_name').change(function(){
         $('#Ipbank_bank_name').val($('#Ipbank_bank_name').val().toUpperCase());
    })
</script>
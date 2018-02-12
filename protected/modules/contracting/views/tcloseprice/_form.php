<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tclosepricegen-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
    <?php echo $form->datePickerRow($model,'stk_date',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
	<?php echo $form->textFieldRow($model,'stk_cd',array('class'=>'span2','maxlength'=>50,'onchange'=>'strToUpper(this)')); ?>

	<?php echo $form->textFieldRow($model,'stk_name',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'stk_prev',array('class'=>'span2 tnumber', 'style'=>'text-align:right')); ?>

	<?php echo $form->textFieldRow($model,'stk_high',array('class'=>'span2 tnumber', 'style'=>'text-align:right')); ?>

	<?php echo $form->textFieldRow($model,'stk_low',array('class'=>'span2 tnumber', 'style'=>'text-align:right')); ?>

	<?php echo $form->textFieldRow($model,'stk_clos',array('class'=>'span2 tnumber', 'style'=>'text-align:right')); ?>

	<?php echo $form->textFieldRow($model,'stk_volm',array('class'=>'span2 tnumber', 'style'=>'text-align:right')); ?>

	<?php echo $form->textFieldRow($model,'stk_amt',array('class'=>'span2 tnumber', 'style'=>'text-align:right')); ?>

	<?php echo $form->textFieldRow($model,'stk_indx',array('class'=>'span2 tnumber', 'style'=>'text-align:right')); ?>

	<?php echo $form->textFieldRow($model,'stk_pidx',array('class'=>'span2 tnumber', 'style'=>'text-align:right')); ?>

	<?php echo $form->textFieldRow($model,'stk_askp',array('class'=>'span2 tnumber', 'style'=>'text-align:right')); ?>

	<?php echo $form->textFieldRow($model,'stk_askv',array('class'=>'span2 tnumber', 'style'=>'text-align:right')); ?>

	<?php echo $form->textFieldRow($model,'stk_askf',array('class'=>'span2 tnumber','maxlength'=>5, 'style'=>'text-align:right')); ?>

	<?php echo $form->textFieldRow($model,'stk_bidp',array('class'=>'span2 tnumber', 'style'=>'text-align:right')); ?>

	<?php echo $form->textFieldRow($model,'stk_bidv',array('class'=>'span2 tnumber', 'style'=>'text-align:right')); ?>

	<?php echo $form->textFieldRow($model,'stk_bidf',array('class'=>'span2','maxlength'=>5, 'style'=>'text-align:right')); ?>

	<?php echo $form->textFieldRow($model,'stk_open',array('class'=>'span2 tnumber', 'style'=>'text-align:right')); ?>

	<?php echo $form->textFieldRow($model,'isin_code',array('class'=>'span3','maxlength'=>20)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>


<script>
    function strToUpper(obj)
    {
        $(obj).val($(obj).val().toUpperCase());
    }
</script>
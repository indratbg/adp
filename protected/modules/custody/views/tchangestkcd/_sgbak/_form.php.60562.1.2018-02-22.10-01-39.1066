<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tchangestkcd-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<div class="control-group">
		<label class="control-label required" for="Tchangestkcd_stk_cd_old">
			Old Stock Code
			<span class="required">*</span>
		</label>
		<div class="controls">
			<?php $this->widget('application.extensions.widget.JuiAutoCompleteStd', array(
								'model'=>$model,
								'attribute'=>'stk_cd_old',
								'ajaxlink'=>array('getstock'),
								'htmlOptions'=>array('id'=>'auto_comp_stock','class'=>'span6'),
						)); ?>
		</div>
	</div>
	
	<?php /*echo $form->dropDownListRow($model,'stk_cd_old',Chtml::listData(Counter::model()->findAll(array('condition'=>'approved_stat = \'A\'','order'=>'stk_cd')),'stk_cd', 'StockCdAndDesc'),
						array('class'=>'span6','prompt'=>'-Choose Old Stock-')); */?>
	
	<?php echo $form->textFieldRow($model,'stk_cd_new',array('class'=>'span6','maxlength'=>25)); ?>

	<?php echo $form->datePickerRow($model,'eff_dt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','id'=>'effdt','class'=>'span8 tdate','options'=>array('format' => 'dd/mm/yyyy'))); ?>

	<?php echo $form->datePickerRow($model,'run_dt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','id'=>'rundt','class'=>'span8 tdate','options'=>array('format' => 'dd/mm/yyyy'))); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

<script>
	$("#effdt").change(function(){
		var effdtval = $("#effdt").val();
		$("#rundt").val(effdtval);
	});
</script>

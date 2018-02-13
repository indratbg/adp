<style>
	form table tr td{padding: 0px;}
	.help-inline.error{display: none;}
	
</style>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'texceptionsplitting-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<?php echo $form->datePickerRow($model,'available_dt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
	
	<div class="control-group">
		<label class="control-label required">
			Client
			<span class="required">*</span>
		</label>
		<div class="controls">
			<?php $this->widget('application.extensions.widget.JuiAutoCompleteStd', array(
								'model'=>$model,
								'attribute'=>'client_cd',
								'ajaxlink'=>array('getclient'),
								'htmlOptions'=>array('id'=>'auto_comp_client','class'=>'span6'),
						)); ?>
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

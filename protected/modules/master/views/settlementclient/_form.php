<style>
	.help-inline.error{display: none;}
	.radio.inline label{margin-left: 15px;}
	.span12.special .control-label{width: 200px;} 
</style>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'settlementclient-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<label class="control-label required" for="Settlementclient_client_cd">
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
			<?php echo $form->datePickerRow($model,'eff_dt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy',
				'class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
		</div>
		<div class="span6">
			
			<?php echo $form->dropDownListRow($model, 'market_type', Parameter::getCombo('MARKET','-Choose Market Type-'),array('class'=>'span8')); ?>
			<?php echo $form->dropDownListRow($model, 'ctr_type', Parameter::getCombo('CTRTYP','-Choose Stock Type-'),array('class'=>'span8')); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span12">
			<?php echo $form->radioButtonListInlineRow($model, 'sale_sts', array('P'=>'Buy','S'=>'Sell')); ?>
		</div>
	</div>
	
	<hr/>
	
	<div class="row-fluid">
		<div class="span12 special">
			<?php echo $form->textFieldRow($model, 'csd_value', array('class'=>'span3','id'=>'clientarap')); ?>
			<?php echo $form->textFieldRow($model, 'csd_script', array('class'=>'span3','id'=>'ksei')); ?>
			<?php echo $form->textFieldRow($model, 'kds_value', array('class'=>'span3','id'=>'kpei')); ?>									
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
	$("#clientarap").change(function(){
		var clientarapval = $("#clientarap").val();
		$("#ksei").val(clientarapval);
		$("#kpei").val(clientarapval);
	});
</script>

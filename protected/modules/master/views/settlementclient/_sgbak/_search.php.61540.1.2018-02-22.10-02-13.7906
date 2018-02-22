<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'type'=>'horizontal'
)); ?>

<h4>Primary Attributes</h4>
	
	<div class="control-group">
		<?php echo $form->label($model,'eff_dt',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'eff_dt_date',array('maxlength'=>'2','class'=>'span1','placeholder'=>'dd')); ?>
			<?php echo $form->textField($model,'eff_dt_month',array('maxlength'=>'2','class'=>'span1','placeholder'=>'mm')); ?>
			<?php echo $form->textField($model,'eff_dt_year',array('maxlength'=>'4','class'=>'span1','placeholder'=>'yyyy')); ?>
		</div>
	</div>
	<?php echo $form->textFieldRow($model,'client_cd',array('class'=>'span5','maxlength'=>12)); ?>
	<?php echo $form->dropDownListRow($model, 'market_type', Parameter::getCombo('MARKET','-Choose Market Type-'),array('class'=>'span4')); ?>
	<?php echo $form->dropDownListRow($model, 'ctr_type', Parameter::getCombo('CTRTYP','-Choose Stock Type-'),array('class'=>'span4')); ?>
	<?php echo $form->dropDownListRow($model, 'sale_sts', array('P'=>'Buy','S'=>'Sell'),array('class'=>'span3','prompt'=>'Buy / Sell')); ?>
	<?php //echo $form->radioButtonListInlineRow($model, 'sale_sts', array('P'=>'Buy','S'=>'Sell')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

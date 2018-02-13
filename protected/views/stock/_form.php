<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'stock-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'stockname',array('class'=>'span5','maxlength'=>40)); ?>

	<?php echo $form->textFieldRow($model,'status',array('class'=>'span5','maxlength'=>4)); ?>

	<?php echo $form->textFieldRow($model,'previousprice',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'openprice',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'highestprice',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'lowestprice',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'lastprice',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'lastvolume',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'change',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'changepercentage',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'bid',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'bidvolume',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'offer',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'offervolume',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'totalfrequency',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'totalvolume',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'totalvalue',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

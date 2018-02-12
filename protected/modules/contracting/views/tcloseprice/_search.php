<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'type'=>'horizontal'
)); ?>

<h4>Primary Attributes</h4>
	
	<?php echo $form->datePickerRow($model,'stk_date',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
	<?php echo $form->textFieldRow($model,'stk_cd',array('class'=>'span5','maxlength'=>50)); ?>
	<?php echo $form->textFieldRow($model,'stk_name',array('class'=>'span5','maxlength'=>50)); ?>
	<?php echo $form->textFieldRow($model,'stk_prev',array('class'=>'span5')); ?>
	<?php echo $form->textFieldRow($model,'stk_high',array('class'=>'span5')); ?>
	<?php echo $form->textFieldRow($model,'stk_low',array('class'=>'span5')); ?>
	<?php echo $form->textFieldRow($model,'stk_clos',array('class'=>'span5')); ?>
	<?php echo $form->textFieldRow($model,'stk_volm',array('class'=>'span5')); ?>
	<?php echo $form->textFieldRow($model,'stk_amt',array('class'=>'span5')); ?>
	<?php echo $form->textFieldRow($model,'stk_indx',array('class'=>'span5')); ?>
	<?php echo $form->textFieldRow($model,'stk_pidx',array('class'=>'span5')); ?>
	<?php echo $form->textFieldRow($model,'stk_askp',array('class'=>'span5')); ?>
	<?php echo $form->textFieldRow($model,'stk_askv',array('class'=>'span5')); ?>
	<?php echo $form->textFieldRow($model,'stk_askf',array('class'=>'span5','maxlength'=>5)); ?>
	<?php echo $form->textFieldRow($model,'stk_bidp',array('class'=>'span5')); ?>
	<?php echo $form->textFieldRow($model,'stk_bidv',array('class'=>'span5')); ?>
	<?php echo $form->textFieldRow($model,'stk_bidf',array('class'=>'span5','maxlength'=>5)); ?>
	<?php echo $form->textFieldRow($model,'stk_open',array('class'=>'span5')); ?>
	<?php echo $form->textFieldRow($model,'isin_code',array('class'=>'span5','maxlength'=>20)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

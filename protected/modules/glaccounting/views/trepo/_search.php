<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'type'=>'horizontal'
)); ?>

<h4>Primary Attributes</h4>
	<?php echo $form->textFieldRow($model,'repo_num',array('class'=>'span5','maxlength'=>17)); ?>
	<?php echo $form->textFieldRow($model,'repo_ref',array('class'=>'span5','maxlength'=>30)); ?>
	<?php echo $form->textFieldRow($model,'extent_num',array('class'=>'span5','maxlength'=>30)); ?>
	<?php echo $form->textFieldRow($model,'repo_type',array('class'=>'span5','maxlength'=>10)); ?>
	<div class="control-group">
		<?php echo $form->label($model,'repo_date',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'repo_date_date',array('maxlength'=>'2','class'=>'span1','placeholder'=>'dd')); ?>
			<?php echo $form->textField($model,'repo_date_month',array('maxlength'=>'2','class'=>'span1','placeholder'=>'mm')); ?>
			<?php echo $form->textField($model,'repo_date_year',array('maxlength'=>'4','class'=>'span1','placeholder'=>'yyyy')); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->label($model,'extent_dt',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'extent_dt_date',array('maxlength'=>'2','class'=>'span1','placeholder'=>'dd')); ?>
			<?php echo $form->textField($model,'extent_dt_month',array('maxlength'=>'2','class'=>'span1','placeholder'=>'mm')); ?>
			<?php echo $form->textField($model,'extent_dt_year',array('maxlength'=>'4','class'=>'span1','placeholder'=>'yyyy')); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->label($model,'due_date',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'due_date_date',array('maxlength'=>'2','class'=>'span1','placeholder'=>'dd')); ?>
			<?php echo $form->textField($model,'due_date_month',array('maxlength'=>'2','class'=>'span1','placeholder'=>'mm')); ?>
			<?php echo $form->textField($model,'due_date_year',array('maxlength'=>'4','class'=>'span1','placeholder'=>'yyyy')); ?>
		</div>
	</div>
	<?php echo $form->textFieldRow($model,'repo_val',array('class'=>'span5')); ?>
	<?php echo $form->textFieldRow($model,'return_val',array('class'=>'span5')); ?>
	<?php echo $form->textFieldRow($model,'fee',array('class'=>'span5')); ?>
	<?php echo $form->textFieldRow($model,'fee_per',array('class'=>'span5')); ?>
	<?php echo $form->textFieldRow($model,'client_cd',array('class'=>'span5','maxlength'=>12)); ?>
	<?php echo $form->textFieldRow($model,'client_type',array('class'=>'span5','maxlength'=>1)); ?>
	<?php echo $form->textFieldRow($model,'sett_val',array('class'=>'span5')); ?>


	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

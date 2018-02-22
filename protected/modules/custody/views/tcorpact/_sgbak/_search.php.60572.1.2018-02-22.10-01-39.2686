<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'type'=>'horizontal'
)); ?>
<?php $criteriaCorp = new CDbCriteria;
		
		$criteriaCorp->select = 'prm_desc,prm_desc2';
		$criteriaCorp->condition = "prm_cd_1 = 'CATYPE'";
		$criteriaCorp->order = 'prm_cd_2';
		?>
<h4>Primary Attributes</h4>
	<?php echo $form->textFieldRow($model,'stk_cd',array('class'=>'span5','maxlength'=>50)); ?>
	<?php echo $form->dropDownListRow($model,'ca_type',CHtml::listData(Parameter::model()->findAll($criteriaCorp),'prm_desc','prm_desc2'),array('class'=>'span5','prompt'=>'-Select Corporate Action Type-')); ?>
	<div class="control-group">
		<?php echo $form->label($model,'cum_dt',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'cum_dt_date',array('maxlength'=>'2','class'=>'span1','placeholder'=>'dd')); ?>
			<?php echo $form->textField($model,'cum_dt_month',array('maxlength'=>'2','class'=>'span1','placeholder'=>'mm')); ?>
			<?php echo $form->textField($model,'cum_dt_year',array('maxlength'=>'4','class'=>'span1','placeholder'=>'yyyy')); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->label($model,'recording_dt',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'recording_dt_date',array('maxlength'=>'2','class'=>'span1','placeholder'=>'dd')); ?>
			<?php echo $form->textField($model,'recording_dt_month',array('maxlength'=>'2','class'=>'span1','placeholder'=>'mm')); ?>
			<?php echo $form->textField($model,'recording_dt_year',array('maxlength'=>'4','class'=>'span1','placeholder'=>'yyyy')); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->label($model,'distrib_dt',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'distrib_dt_date',array('maxlength'=>'2','class'=>'span1','placeholder'=>'dd')); ?>
			<?php echo $form->textField($model,'distrib_dt_month',array('maxlength'=>'2','class'=>'span1','placeholder'=>'mm')); ?>
			<?php echo $form->textField($model,'distrib_dt_year',array('maxlength'=>'4','class'=>'span1','placeholder'=>'yyyy')); ?>
		</div>
	</div>
	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

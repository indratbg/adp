<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'type'=>'horizontal'
)); ?>

<h4>Primary Attributes</h4>
	<div class="control-group">
		<?php echo $form->label($model,'begin_dt',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'begin_dt_date',array('maxlength'=>'2','class'=>'span1','placeholder'=>'dd')); ?>
			<?php echo $form->textField($model,'begin_dt_month',array('maxlength'=>'2','class'=>'span1','placeholder'=>'mm')); ?>
			<?php echo $form->textField($model,'begin_dt_year',array('maxlength'=>'4','class'=>'span1','placeholder'=>'yyyy')); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->label($model,'end_dt',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'end_dt_date',array('maxlength'=>'2','class'=>'span1','placeholder'=>'dd')); ?>
			<?php echo $form->textField($model,'end_dt_month',array('maxlength'=>'2','class'=>'span1','placeholder'=>'mm')); ?>
			<?php echo $form->textField($model,'end_dt_year',array('maxlength'=>'4','class'=>'span1','placeholder'=>'yyyy')); ?>
		</div>
	</div>
	<?php echo $form->textFieldRow($model,'tax_type',array('class'=>'span5','maxlength'=>25)); ?>
	<?php echo $form->textFieldRow($model,'client_cd',array('class'=>'span5','maxlength'=>12)); ?>
	<?php echo $form->textFieldRow($model,'stk_cd',array('class'=>'span5','maxlength'=>12)); ?>
	<?php echo $form->textFieldRow($model,'client_type_1',array('class'=>'span5','maxlength'=>1)); ?>
	<?php echo $form->textFieldRow($model,'client_type_2',array('class'=>'span5','maxlength'=>1)); ?>
	<?php echo $form->textFieldRow($model,'rate_1',array('class'=>'span5')); ?>
	<?php echo $form->textFieldRow($model,'rate_2',array('class'=>'span5')); ?>
	<?php echo $form->textFieldRow($model,'tax_desc',array('class'=>'span5','maxlength'=>50)); ?>
	
	<!--
	<div class="control-group">
		<?php echo $form->label($model,'cre_dt',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'cre_dt_date',array('maxlength'=>'2','class'=>'span1','placeholder'=>'dd')); ?>
			<?php echo $form->textField($model,'cre_dt_month',array('maxlength'=>'2','class'=>'span1','placeholder'=>'mm')); ?>
			<?php echo $form->textField($model,'cre_dt_year',array('maxlength'=>'4','class'=>'span1','placeholder'=>'yyyy')); ?>
		</div>
	</div>
	<?php echo $form->textFieldRow($model,'user_id',array('class'=>'span5','maxlength'=>10)); ?>
	
	<div class="control-group">
		<?php echo $form->label($model,'upd_dt',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'upd_dt_date',array('maxlength'=>'2','class'=>'span1','placeholder'=>'dd')); ?>
			<?php echo $form->textField($model,'upd_dt_month',array('maxlength'=>'2','class'=>'span1','placeholder'=>'mm')); ?>
			<?php echo $form->textField($model,'upd_dt_year',array('maxlength'=>'4','class'=>'span1','placeholder'=>'yyyy')); ?>
		</div>
	</div>
	<?php echo $form->textFieldRow($model,'upd_by',array('class'=>'span5','maxlength'=>10)); ?>
	<div class="control-group">
		<?php echo $form->label($model,'approved_dt',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'approved_dt_date',array('maxlength'=>'2','class'=>'span1','placeholder'=>'dd')); ?>
			<?php echo $form->textField($model,'approved_dt_month',array('maxlength'=>'2','class'=>'span1','placeholder'=>'mm')); ?>
			<?php echo $form->textField($model,'approved_dt_year',array('maxlength'=>'4','class'=>'span1','placeholder'=>'yyyy')); ?>
		</div>
	</div>
	<?php echo $form->textFieldRow($model,'approved_by',array('class'=>'span5','maxlength'=>10)); ?>
	<?php echo $form->textFieldRow($model,'approved_stat',array('class'=>'span5','maxlength'=>1)); ?>
	-->

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

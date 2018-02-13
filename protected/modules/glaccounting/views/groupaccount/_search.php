<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'type'=>'horizontal'
)); ?>

<h4>Primary Attributes</h4>
	<?php echo $form->textFieldRow($model,'pl_bs_flg',array('class'=>'span5','maxlength'=>1)); ?>
	<?php echo $form->textFieldRow($model,'grp_1',array('class'=>'span5')); ?>
	<?php echo $form->textFieldRow($model,'grp_2',array('class'=>'span5')); ?>
	<?php echo $form->textFieldRow($model,'grp_3',array('class'=>'span5')); ?>
	<?php echo $form->textFieldRow($model,'grp_4',array('class'=>'span5')); ?>
	<?php echo $form->textFieldRow($model,'grp_5',array('class'=>'span5')); ?>
	<?php echo $form->textFieldRow($model,'gl_acct_cd',array('class'=>'span5','maxlength'=>12)); ?>
	<div class="control-group">
		<?php echo $form->label($model,'cre_dt',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'cre_dt_date',array('maxlength'=>'2','class'=>'span1','placeholder'=>'dd')); ?>
			<?php echo $form->textField($model,'cre_dt_month',array('maxlength'=>'2','class'=>'span1','placeholder'=>'mm')); ?>
			<?php echo $form->textField($model,'cre_dt_year',array('maxlength'=>'4','class'=>'span1','placeholder'=>'yyyy')); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->label($model,'upd_dt',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'upd_dt_date',array('maxlength'=>'2','class'=>'span1','placeholder'=>'dd')); ?>
			<?php echo $form->textField($model,'upd_dt_month',array('maxlength'=>'2','class'=>'span1','placeholder'=>'mm')); ?>
			<?php echo $form->textField($model,'upd_dt_year',array('maxlength'=>'4','class'=>'span1','placeholder'=>'yyyy')); ?>
		</div>
	</div>
	<?php echo $form->textFieldRow($model,'user_id',array('class'=>'span5','maxlength'=>10)); ?>
	<?php echo $form->textFieldRow($model,'line_desc',array('class'=>'span5','maxlength'=>50)); ?>
	<?php echo $form->textFieldRow($model,'formula',array('class'=>'span5','maxlength'=>50)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

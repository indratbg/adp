<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'type'=>'horizontal'
)); ?>

<h4>Primary Attributes</h4>
	<?php echo $form->dropDownListRow($model, 'cl_type1', Constanta::$client_type1,array('class'=>'span4','prompt'=>'- Select Client Type 1 -'));?>
	<?php echo $form->dropDownListRow($model, 'cl_type2', Constanta::$client_type2,array('class'=>'span4','prompt'=>'- Select Client Type 2 -')); ?>

	<?php echo $form->dropDownListRow($model, 'cl_type3', Constanta::$client_type3,array('class'=>'span4','prompt'=>'- Select Client Type 3 -')); ?>
	<?php echo $form->textFieldRow($model,'type_desc',array('class'=>'span4','maxlength'=>255)); ?>
	<?php //echo $form->textFieldRow($model,'dup_contract',array('class'=>'span5','maxlength'=>1)); ?>
	<?php //echo $form->textFieldRow($model,'avg_contract',array('class'=>'span5','maxlength'=>1)); ?>
	<?php // echo $form->textFieldRow($model,'nett_allow',array('class'=>'span5','maxlength'=>1)); ?>
	<?php // echo $form->textFieldRow($model,'rebate_pct',array('class'=>'span5')); ?>
	<?php // echo $form->textFieldRow($model,'comm_pct',array('class'=>'span5')); ?>
	<?php //echo $form->textFieldRow($model,'user_id',array('class'=>'span5','maxlength'=>10)); ?>
	<!--<div class="control-group">
		<?php // echo $form->label($model,'cre_dt',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php //echo $form->textField($model,'cre_dt_date',array('maxlength'=>'2','class'=>'span1','placeholder'=>'dd')); ?>
			<?php // echo $form->textField($model,'cre_dt_month',array('maxlength'=>'2','class'=>'span1','placeholder'=>'mm')); ?>
			<?php // echo $form->textField($model,'cre_dt_year',array('maxlength'=>'4','class'=>'span1','placeholder'=>'yyyy')); ?>
		</div>
	</div>
	<div class="control-group">
		<?php //echo $form->label($model,'upd_dt',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php // echo $form->textField($model,'upd_dt_date',array('maxlength'=>'2','class'=>'span1','placeholder'=>'dd')); ?>
			<?php //echo $form->textField($model,'upd_dt_month',array('maxlength'=>'2','class'=>'span1','placeholder'=>'mm')); ?>
			<?php //echo $form->textField($model,'upd_dt_year',array('maxlength'=>'4','class'=>'span1','placeholder'=>'yyyy')); ?>
		</div>
	</div>
-->
	<?php echo $form->textFieldRow($model,'os_p_acct_cd',array('class'=>'span4','maxlength'=>12)); ?>
	<?php echo $form->textFieldRow($model,'os_s_acct_cd',array('class'=>'span4','maxlength'=>12)); ?>
	<?php echo $form->textFieldRow($model,'os_contra_g_acct_cd',array('class'=>'span4','maxlength'=>12)); ?>
	<?php echo $form->textFieldRow($model,'os_contra_l_acct_cd',array('class'=>'span4','maxlength'=>12)); ?>
	<?php // echo $form->textFieldRow($model,'os_setoff_g_acct_cd',array('class'=>'span5','maxlength'=>12)); ?>
	<?php //echo $form->textFieldRow($model,'os_setoff_l_acct_cd',array('class'=>'span5','maxlength'=>12)); ?>
	<?php //echo $form->textFieldRow($model,'int_on_payable',array('class'=>'span5')); ?>
	<?php //echo $form->textFieldRow($model,'int_on_receivable',array('class'=>'span5')); ?>
	<?php // echo $form->textFieldRow($model,'int_on_pay_chrg_cd',array('class'=>'span5','maxlength'=>5)); ?>
	<?php //echo $form->textFieldRow($model,'int_on_rec_chrg_cd',array('class'=>'span5','maxlength'=>5)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

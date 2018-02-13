<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'type'=>'horizontal'
)); ?>

<h4>Primary Attributes</h4>
	<?php echo $form->textFieldRow($model,'bond_cd',array('class'=>'span5','maxlength'=>20)); ?>
	<?php echo $form->dropDownListRow($model,'bond_group_cd',CHtml::listData(Parameter::model()->findAll("prm_cd_1='BONDGR'"),'prm_cd_2', 'prm_desc'),array('class'=>'span5','maxlength'=>100,'prompt'=>'-Pilih Issuer Type-')); ?>
	<?php echo $form->dropDownListRow($model,'product_type',CHtml::listData(Parameter::model()->findAll("prm_cd_1='BPROD'"),'prm_desc', 'prm_desc'),array('class'=>'span5','maxlength'=>100,'prompt'=>'-Pilih Product Type-')); ?>
	<?php echo $form->textFieldRow($model,'bond_desc',array('class'=>'span5','maxlength'=>100)); ?>
	<?php echo $form->textFieldRow($model,'short_desc',array('class'=>'span5','maxlength'=>50)); ?>
	<?php echo $form->textFieldRow($model,'isin_code',array('class'=>'span5','maxlength'=>20)); ?>
	<?php echo $form->textFieldRow($model,'issuer',array('class'=>'span5','maxlength'=>100)); ?>
	<?php echo $form->dropDownListRow($model,'sec_sector',CHtml::listData(Parameter::model()->findAll("prm_cd_1='BINDUS'"),'prm_cd_2', 'prm_desc'),array('class'=>'span5','maxlength'=>100,'prompt'=>'-Pilih Industry Type-')); ?>
	<div class="control-group">
		<?php echo $form->label($model,'maturity_date',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'maturity_date_date',array('maxlength'=>'2','class'=>'span1','placeholder'=>'dd')); ?>
			<?php echo $form->textField($model,'maturity_date_month',array('maxlength'=>'2','class'=>'span1','placeholder'=>'mm')); ?>
			<?php echo $form->textField($model,'maturity_date_year',array('maxlength'=>'4','class'=>'span1','placeholder'=>'yyyy')); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->label($model,'listing_date',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'listing_date_date',array('maxlength'=>'2','class'=>'span1','placeholder'=>'dd')); ?>
			<?php echo $form->textField($model,'listing_date_month',array('maxlength'=>'2','class'=>'span1','placeholder'=>'mm')); ?>
			<?php echo $form->textField($model,'listing_date_year',array('maxlength'=>'4','class'=>'span1','placeholder'=>'yyyy')); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->label($model,'issue_date',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'issue_date_date',array('maxlength'=>'2','class'=>'span1','placeholder'=>'dd')); ?>
			<?php echo $form->textField($model,'issue_date_month',array('maxlength'=>'2','class'=>'span1','placeholder'=>'mm')); ?>
			<?php echo $form->textField($model,'issue_date_year',array('maxlength'=>'4','class'=>'span1','placeholder'=>'yyyy')); ?>
		</div>
	</div>
	<?php echo $form->dropDownListRow($model,'int_type',CHtml::listData(Parameter::model()->findAll("prm_cd_1='BRATE'"),'prm_desc', 'prm_desc'),array('class'=>'span5','maxlength'=>100,'prompt'=>'-Pilih Rate Type-')); ?>
	<?php echo $form->textFieldRow($model,'interest',array('class'=>'span5')); ?>
	<?php echo $form->dropDownListRow($model,'int_freq',CHtml::listData(Parameter::model()->findAll("prm_cd_1='BFREQ'"),'prm_desc', 'prm_desc'),array('class'=>'span5','id'=>'int_freq','maxlength'=>100,'prompt'=>'-Pilih Frequency-')); ?>
	<?php echo $form->dropDownListRow($model,'day_count_basis',CHtml::listData(Parameter::model()->findAll("prm_cd_1='BDAYC'"),'prm_desc', 'prm_desc'),array('class'=>'span5','id'=>'day_count_basis','maxlength'=>100,'prompt'=>'-Pilih Day Count Basis -')); ?>
	<?php echo $form->textFieldRow($model,'fee_ijarah',array('class'=>'span5')); ?>
	<?php echo $form->textFieldRow($model,'nisbah',array('class'=>'span5')); ?>
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
	<?php echo $form->textFieldRow($model,'approved_sts',array('class'=>'span5','maxlength'=>1)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'bond-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>
<?php // $code=sysparam::model()->find("param_cd2='GOVN'") ?>


	<p class="help-block">Fields with <span class="required">*</span> are required.</p>
<div class="row-fluid">
	<div class="span6">
	<?php echo $form->errorSummary($model); ?>
<?php echo $form->textFieldRow($model,'bond_cd',array('class'=>'span6','maxlength'=>20,'readonly'=>$model->scenario!='update'?'':'readonly')); ?>
<?php echo $form->dropDownListRow($model,'bond_group_cd',CHtml::listData(Parameter::model()->findAll("prm_cd_1='BONDGR'"),'prm_cd_2', 'prm_desc'),array('class'=>'span8','maxlength'=>100,'prompt'=>'-Pilih Issuer Type-')); ?>
<?php echo $form->dropDownListRow($model,'product_type',CHtml::listData(Parameter::model()->findAll("prm_cd_1='BPROD'"),'prm_desc', 'prm_desc'),array('class'=>'span8','maxlength'=>100)); ?>
<?php echo $form->textAreaRow($model,'bond_desc',array('class'=>'span8','maxlength'=>100,'rows'=>'4')); ?>
<?php echo $form->textFieldRow($model,'short_desc',array('class'=>'span8','maxlength'=>50)); ?>
<?php echo $form->textFieldRow($model,'isin_code',array('class'=>'span8','maxlength'=>20)); ?>
<?php echo $form->textFieldRow($model,'issuer',array('class'=>'span8','maxlength'=>100)); ?>
<?php echo $form->dropDownListRow($model,'sec_sector',CHtml::listData(Parameter::model()->findAll("prm_cd_1='BINDUS'"),'prm_cd_2', 'prm_desc'),array('class'=>'span8','maxlength'=>100,'prompt'=>'-Pilih Industry Type-')); ?>
</div>
<div class="span6">
<?php echo $form->datePickerRow($model,'maturity_date',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','id'=>'maturity_date','options'=>array('format' => 'dd/mm/yyyy'))); ?>
<?php echo $form->datePickerRow($model,'first_coupon_date',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','id'=>'first_coupon_date','options'=>array('format' => 'dd/mm/yyyy'))); ?>
<?php echo $form->datePickerRow($model,'listing_date',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','id'=>'listing_date','options'=>array('format' => 'dd/mm/yyyy'))); ?>
<?php echo $form->datePickerRow($model,'issue_date',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
<?php echo $form->textFieldRow($model,'interest',array('class'=>'span8')); ?>
<?php echo $form->dropDownListRow($model,'int_type',CHtml::listData(Parameter::model()->findAll("prm_cd_1='BRATE'"),'prm_desc', 'prm_desc'),array('class'=>'span8','maxlength'=>100)); ?>
<?php echo $form->dropDownListRow($model,'int_freq',CHtml::listData(Parameter::model()->findAll("prm_cd_1='BFREQ'"),'prm_desc', 'prm_desc'),array('class'=>'span8','id'=>'int_freq','maxlength'=>100,'prompt'=>'-Pilih Frequency-')); ?>
<?php echo $form->dropDownListRow($model,'day_count_basis',CHtml::listData(Parameter::model()->findAll("prm_cd_1='BDAYC'"),'prm_desc', 'prm_desc'),array('class'=>'span8','id'=>'day_count_basis','maxlength'=>100,'prompt'=>'-Pilih Day Count Basis -')); ?>
<?php echo $form->textFieldRow($model,'fee_ijarah',array('class'=>'span8')); ?>
<?php echo $form->textFieldRow($model,'nisbah',array('class'=>'span8')); ?>
<?php /*
<?php echo $form->textFieldRow($model,'gl_acct_cd',array('class'=>'span8','maxlength'=>4,'id'=>'glacctcd')); ?>
<?php echo $form->textFieldRow($model,'sl_acct_cd',array('class'=>'span8','maxlength'=>12,'id'=>'slacctcd')); ?>
 *
 */
 ?>
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
	$('#Bond_bond_group_cd').change(function(){
		if($('#Bond_bond_group_cd').val() == '02'){
			
			$('#int_freq').val('3 MONTHS');
			$('#day_count_basis').val('30/360');
			
		}
		else {
				$('#int_freq').val('SEMI-ANNUAL');
			$('#day_count_basis').val('ACTUAL/ACTUAL');
		}
		
		
	});
	
	
</script>



<style>
	#icExpiry .input-prepend
	{
		//width:140px;
	}
</style>

<?php
	$cityList = City::model()->findAll(array('condition'=>"city_cd <> 999",'order'=>'city'));
	$cityList = array_merge($cityList,City::model()->findAll(array('condition'=>'city_cd = 999')));
	
	$addinc = Parameter::model()->findAll(array('condition'=>"prm_cd_1 = 'ADDINC'",'order'=>'prm_cd_2'));
?>

<div class="row-fluid">
	<div class="span6">
	    <?php echo $form->textFieldRow($modelClientindi,'spouse_name',array('class'=>'span7','maxlength'=>50)); ?>
	</div>
	<div class="span6">
		<?php echo $form->dropDownListRow($modelClientindi,'spouse_relationship',Parameter::getCombo('SPOUSE','-Choose Relationship-',null,null,'cd'),array('class'=>'span8')); ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span5">
		<?php echo $form->dropDownListRow($modelClientindi,'spouse_ic_type',Parameter::getCombo('IDTYPE','-Choose ID Type-'),array('class'=>'span6')); ?>
	</div>
	<div class="span4" style="width:300px">
		<div class="span4">
			<?php echo $form->label($modelClientindi,'spouse_ic_num',array('class'=>'control-label')) ?>
		</div>
		<?php echo $form->textFieldRow($modelClientindi,'spouse_ic_num',array('class'=>'span6','maxlength'=>20,'label'=>false)); ?>	
	</div>
	<div class="span4" style="width:250px;margin-left:-20px">
		<div class="span4" style="margin-left:10px">
			<?php echo $form->label($modelClientindi,'spouse_ic_expiry',array('class'=>'control-label')) ?>
		</div>
		<div id="icExpiry" style="margin-left:80px">
			<?php echo $form->datePickerRow($modelClientindi,'spouse_ic_expiry',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','label'=>false,'options'=>array('format' => 'dd/mm/yyyy'))); ?>
		</div>
	</div>
</div>

<br/>

<div class="row-fluid">
	<div class="span6">
		<div class="control-group">
			<?php echo $form->labelEx($modelClientindi,'spouse_occup',array('class'=>'control-label')); ?>
	  		<div class="controls">
		  		<?php //echo $form->dropDownList($modelClientindi,'spouse_occup',Parameter::getCombo('WORK','-Choose Occupation-',null,null,'cd')); ?>
		  		<?php echo $form->textField($modelClientindi,'spouse_occup',array('class'=>'span5','maxlength'=>30,'class'=>'span8')); ?>
				<?php echo $form->error($modelClientindi,'spouse_occup', array('class'=>'help-inline error')); ?>
			</div>
		</div>	
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
 		<?php echo $form->textFieldRow($modelClientindi,'spouse_empr_name',array('class'=>'span8','maxlength'=>50)); ?>
	</div>
	<div class="span6">
	 	<?php echo $form->textFieldRow($modelClientindi,'spouse_empr_biz',array('class'=>'span8','maxlength'=>30)); ?>	
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<?php echo $form->textFieldRow($modelClientindi,'spouse_job_position',array('class'=>'span8','maxlength'=>30)); ?>	
	</div>
	<div class="span6">
		<?php echo $form->textFieldRow($modelClientindi,'spouse_lama_kerja',array('class'=>'span5','maxlength'=>15)); ?>	
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<?php echo $form->labelEx($modelClientindi,'spouse_empr_addr1',array('class'=>'control-label'));?>
		<?php echo $form->textFieldRow($modelClientindi,'spouse_empr_addr1',array('class'=>'span8','label'=>false,'maxlength'=>50)); ?>
		<?php echo $form->label($modelClientindi,'&nbsp',array('class'=>'control-label'));?>
		<?php echo $form->textFieldRow($modelClientindi,'spouse_empr_addr2',array('class'=>'span8','label'=>false,'maxlength'=>50)); ?>
		<?php echo $form->label($modelClientindi,'&nbsp',array('class'=>'control-label'));?>
		<?php echo $form->textFieldRow($modelClientindi,'spouse_empr_addr3',array('class'=>'span8','label'=>false,'maxlength'=>30)); ?>		
		<?php echo $form->textFieldRow($modelClientindi,'spouse_empr_post_cd',array('class'=>'span3','maxlength'=>6)); ?>
	</div>
	<div class="span6">
		<?php echo $form->textFieldRow($modelClientindi,'spouse_empr_city',array('class'=>'span8')); ?>
		<?php echo $form->textFieldRow($modelClientindi,'spouse_empr_province',array('class'=>'span8','maxlength'=>40)); ?>
		<?php echo $form->textFieldRow($modelClientindi,'spouse_empr_country',array('class'=>'span8')); ?>	
		<?php echo $form->textFieldRow($modelClientindi,'spouse_empr_email',array('class'=>'span8 email','maxlength'=>50)); ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<?php echo $form->textFieldRow($modelClientindi,'spouse_empr_phone',array('class'=>'span5','maxlength'=>15)); ?>
	</div>
	<div class="span6">
    	<?php echo $form->textFieldRow($modelClientindi,'spouse_empr_fax',array('class'=>'span5','maxlength'=>15)); ?>
    </div>
</div>


<br/>

<div class="row-fluid">
	<div class="span6">
		<?php echo $form->dropDownListRow($modelClientindi,'spouse_income_cd',Parameter::getCombo('INCOME','-Choose Income-',null,null,'cd'),array('class'=>'span8')); ?>
	</div>
	<div class="span6">
		<?php echo $form->dropDownListRow($modelClientindi,'spouse_addl_amount',CHtml::listData($addinc, 'prm_cd_2', 'prm_desc'),array('class'=>'span4',count($addinc)>2?'prompt':''=>'-Choose Additional Income-')); ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<?php echo $form->labelEx($modelClientindi,'spouse_source_cd',array('class'=>'control-label')) ?>
		<?php echo $form->dropDownListRow($modelClientindi,'spouse_source_cd',Parameter::getCombo('FUND','-Choose Source-',null,null,'cd'),array('class'=>'span8','label'=>false)); ?>
		
		<div class="control-group">
			<?php echo $form->label($modelClientindi,'&nbsp',array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->textField($modelClientindi,'spouse_source_other',array('class'=>'span8','maxlength'=>30,'placeholder'=>'Fill Source Here')); ?>
				<?php echo $form->error($modelClientindi,'spouse_source_other', array('class'=>'help-inline error')); ?>
			</div>
		</div>
	</div>
	<div class="span6">
		<?php echo $form->labelEx($modelClientindi,'spouse_addl_income',array('class'=>'control-label')) ?>
		<?php echo $form->dropDownListRow($modelClientindi,'spouse_addl_income',Parameter::getCombo('FUND','-Choose Source-',null,null,'cd'),array('class'=>'span8','label'=>false)); ?>
		
		<div class="control-group">
			<?php echo $form->label($modelClientindi,'&nbsp',array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->textField($modelClientindi,'spouse_addl_other',array('class'=>'span8','maxlength'=>30,'placeholder'=>'Fill Source Here')); ?>
				<?php echo $form->error($modelClientindi,'spouse_addl_other', array('class'=>'help-inline error')); ?>
			</div>
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<?php echo $form->dropDownListRow($modelClientindi,'spouse_expense',Parameter::getCombo('EXPNSE','-Choose Expense-',null,null,'cd'),array('class'=>'span8')); ?>
	</div>
</div>

<script>
/*
	$('#Clientindi_spouse_occup').change(function(){
		var cmbval = $(this).val();
		if(cmbval == '90')
			$('#Clientindi_spouse_occup_other').show().attr('required','required');
		else 
			$('#Clientindi_spouse_occup_other').hide().removeAttr('required');
	});
*/
	$('#Clientindi_spouse_occup').trigger('change');
	
	$('#Clientindi_spouse_source_cd').change(function(){
		var cmbval = $(this).val();
		if(cmbval == '90')
			$('#Clientindi_spouse_source_other').show().attr('required','required');
		else 
			$('#Clientindi_spouse_source_other').hide().removeAttr('required');
	});
	$('#Clientindi_spouse_source_cd').trigger('change');
	
	$('#Clientindi_spouse_addl_income').change(function(){
		var cmbval = $(this).val();
		if(cmbval == '90')
			$('#Clientindi_spouse_addl_other').show().attr('required','required');
		else 
			$('#Clientindi_spouse_addl_other').hide().removeAttr('required');
	});
	$('#Clientindi_spouse_addl_income').trigger('change');
</script>
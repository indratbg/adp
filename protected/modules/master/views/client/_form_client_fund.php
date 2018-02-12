<?php 
	$addinc = Parameter::model()->findAll(array('condition'=>"prm_cd_1 = 'ADDINC'",'order'=>'prm_cd_2'));
?>

<div class="row-fluid">
	<?php echo $form->dropDownListRow($modelCif,'annual_income_cd',Parameter::getCombo('INCOME','-Choose Income-',null,null,'cd'),array('class'=>'span4')); ?>
</div>

<div class="row-fluid">
	<div class="control-group">
		<?php echo $form->labelEx($modelCif,'funds_code',array('class'=>'control-label')) ?>
		<div class="controls">
			<?php echo $form->dropDownList($modelCif,'funds_code',Parameter::getCombo('FUND','-Choose Source-',null,null,'cd')); ?>
			<?php echo $form->textField($modelCif,'source_of_funds',array('class'=>'span5','maxlength'=>30,'placeholder'=>'Fill Source Here')); ?>
			<?php echo $form->error($modelCif,'source_of_funds', array('class'=>'help-inline error')); ?>
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="control-group">
		<?php echo $form->labelEx($modelCif,'addl_fund_cd',array('class'=>'control-label')) ?>
		<div class="controls">
			<?php echo $form->dropDownList($modelCif,'addl_fund_cd',CHtml::listData($addinc, 'prm_cd_2', 'prm_desc'),array('class'=>'span4',count($addinc)>2?'prompt':''=>'-Choose Additional Income-')); ?>
			<?php echo $form->textField($modelCif,'addl_fund',array('class'=>'span5','maxlength'=>40,'placeholder'=>'Fill Additional Income Here')); ?>
			<?php echo $form->error($modelCif,'addl_fund', array('class'=>'help-inline error')); ?>
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="control-group">
		<?php echo $form->labelEx($modelCif,'source_addl_fund_cd',array('class'=>'control-label')) ?>
		<div class="controls">
			<?php echo $form->dropDownList($modelCif,'source_addl_fund_cd',Parameter::getCombo('FUND','-Choose Source-',null,null,'cd')); ?>
			<?php echo $form->textField($modelCif,'source_addl_fund',array('class'=>'span5','maxlength'=>30,'placeholder'=>'Fill Source Here')); ?>
			<?php echo $form->error($modelCif,'source_addl_fund', array('class'=>'help-inline error')); ?>
		</div>
	</div>
</div>

<?php echo $form->dropDownListRow($modelCif,'expense_amount_cd',Parameter::getCombo('EXPNSE','-Choose Expense-',null,null,'cd'),array('class'=>'span4')); ?>

<div class="row-fluid">
	<div class="control-group">
		<?php echo $form->labelEx($modelCif,'Purpose of Investment',array('class'=>'control-label')) ?>
		<div class="controls">
			<?php echo $form->checkBox($modelCif,'purpose01',array('value' => '01', 'uncheckValue'=>'00')); ?>
			Keuntungan
			&emsp;
			<?php echo $form->checkBox($modelCif,'purpose02',array('value' => '02', 'uncheckValue'=>'00')); ?>
			Apresiasi Harga
			&emsp;
			<?php echo $form->checkBox($modelCif,'purpose03',array('value' => '03', 'uncheckValue'=>'00')); ?>
			Investasi Jangka Panjang
			&emsp;
			<?php echo $form->checkBox($modelCif,'purpose04',array('value' => '04', 'uncheckValue'=>'00')); ?>
			Spekulasi
			
			<br/>
			
			<?php echo $form->checkBox($modelCif,'purpose05',array('value' => '05', 'uncheckValue'=>'00')); ?>
			Pendapatan
			&emsp;
			<?php echo $form->checkBox($modelCif,'purpose90',array('value' => '90', 'uncheckValue'=>'00')); ?>
			Lainnya
			&nbsp;
			<?php echo $form->textField($modelCif,'purpose_lainnya',array('class'=>'span3','maxlength'=>30,'placeholder'=>'Fill Purpose Here')); ?>
			<?php echo $form->error($modelCif,'purpose_lainnya', array('class'=>'help-inline error')); ?>
		</div>
	</div>
</div>

<br/>

<?php echo $form->dropDownListRow($modelCif,'invesment_period',CHtml::listData(Parameter::model()->findAll("prm_cd_1 = 'JANGKA'"), 'prm_desc', 'prm_desc'),array('class'=>'span4','prompt'=>'-Choose Period-')); ?>

<?php echo $form->dropDownListRow($modelCif,'net_asset_cd',Parameter::getCombo('IASSET','-Choose Net Worth-',null,null,'cd'),array('class'=>'span4')); ?>

<script>
	$('#Cif_funds_code').change(function(){
		var cmbval = $(this).val();
		if(cmbval == '90')
			$('#Cif_source_of_funds').show().attr('required','required');
		else 
			$('#Cif_source_of_funds').hide().removeAttr('required');
	});
	$('#Cif_funds_code').trigger('change');
	
	$('#Cif_addl_fund_cd').change(function(){
		var cmbval = $(this).val();
		if(cmbval == 'Y')
			$('#Cif_addl_fund').show().attr('required','required');
		else 
			$('#Cif_addl_fund').hide().removeAttr('required');
	});
	$('#Cif_addl_fund_cd').trigger('change');
	
	$('#Cif_source_addl_fund_cd').change(function(){
		var cmbval = $(this).val();
		if(cmbval == '90')
			$('#Cif_source_addl_fund').show().attr('required','required');
		else 
			$('#Cif_source_addl_fund').hide().removeAttr('required');
	});
	$('#Cif_source_addl_fund_cd').trigger('change');
	
	$('#Cif_purpose90').change(function(){
		if($('#Cif_purpose90').is(':checked'))
			$('#Cif_purpose_lainnya').show().attr('required','required');
		else 
			$('#Cif_purpose_lainnya').hide().removeAttr('required');
	});
	$('#Cif_purpose90').trigger('change');
</script>
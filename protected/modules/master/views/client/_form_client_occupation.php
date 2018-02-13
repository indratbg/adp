<?php
	$cityList = City::model()->findAll(array('condition'=>"city_cd <> 999",'order'=>'city'));
	$cityList = array_merge($cityList,City::model()->findAll(array('condition'=>'city_cd = 999')))
?>

<div class="row-fluid">
	<div class="span12">
		<div class="control-group">
			<?php echo $form->labelEx($modelClientindi,'occup_code',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo $form->dropDownList($modelClientindi,'occup_code',Parameter::getCombo('WORK','-Choose Occupation-',null,null,'cd')); ?>
				<?php echo $form->textField($modelClientindi,'occupation',array('class'=>'span5','maxlength'=>30,'placeholder'=>'Fill Occupation Here')); ?>
				<?php echo $form->error($modelClientindi,'occupation', array('class'=>'help-inline error')); ?>
			</div>
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<?php echo $form->textFieldRow($modelClientindi,'empr_name',array('class'=>'span8','maxlength'=>50)); ?>	
	</div>
	<div class="span6">
	 	<?php echo $form->textFieldRow($modelClientindi,'empr_biz_type',array('class'=>'span8','maxlength'=>30)); ?>	
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<?php echo $form->textFieldRow($modelClientindi,'job_position',array('class'=>'span8','maxlength'=>30)); ?>	
	</div>
	<div class="span6">
		<?php echo $form->textFieldRow($modelClientindi,'lama_kerja',array('class'=>'span5','maxlength'=>15)); ?>	
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<?php echo $form->label($modelClientindi,'empr_addr_1',array('class'=>'control-label'));?>
		<?php echo $form->textFieldRow($modelClientindi,'empr_addr_1',array('class'=>'span8','label'=>false,'maxlength'=>50)); ?>
		<?php echo $form->label($modelClientindi,'&nbsp',array('class'=>'control-label'));?>
		<?php echo $form->textFieldRow($modelClientindi,'empr_addr_2',array('class'=>'span8','label'=>false,'maxlength'=>50)); ?>
		<?php echo $form->label($modelClientindi,'&nbsp',array('class'=>'control-label'));?>
		<?php echo $form->textFieldRow($modelClientindi,'empr_addr_3',array('class'=>'span8','label'=>false,'maxlength'=>30)); ?>
		<?php echo $form->textFieldRow($modelClientindi,'empr_post_cd',array('class'=>'span3','maxlength'=>6)); ?>		
	</div>
	<div class="span6">
		<?php echo $form->dropDownListRow($modelClientindi,'empr_city',Chtml::listData($cityList,'city','city'),array('class'=>'span8','prompt'=>'-Choose City-')); ?>
		<?php echo $form->dropDownListRow($modelClientindi,'empr_country',CHtml::listData(Parameter::model()->findAll(array('condition'=>"prm_cd_1 = 'NEGARA'",'order'=>'prm_desc')), 'prm_desc', 'prm_desc'),array('class'=>'span8','prompt'=>'-Choose Country-')); ?>	
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<?php echo $form->textFieldRow($modelClientindi,'empr_phone',array('class'=>'span5','maxlength'=>15)); ?>
	</div>
	<div class="span6">
    	<?php echo $form->textFieldRow($modelClientindi,'empr_fax',array('class'=>'span5','maxlength'=>15)); ?>
    </div>
</div>

<?php echo $form->textFieldRow($modelClientindi,'empr_email',array('class'=>'span3 email','maxlength'=>50)); ?>    

<!--
<fieldset>
	<legend><h4>Client Spouse Data</h4></legend>
	<div class="row-fluid">
		<div class="span12">
		    <?php echo $form->textFieldRow($modelClientindi,'spouse_name',array('class'=>'span5','maxlength'=>50)); ?>
		    <?php echo $form->textFieldRow($modelClientindi,'spouse_occup',array('class'=>'span5','maxlength'=>30)); ?>
		    <?php echo $form->textFieldRow($modelClientindi,'spouse_empr_name',array('class'=>'span5','maxlength'=>50)); ?>
   		</div>
   	</div>
    <div class="row-fluid">
		<div class="span6">
			<?php echo $form->label($modelClientindi,'spouse_empr_addr1',array('class'=>'control-label'));?>
			<?php echo $form->textFieldRow($modelClientindi,'spouse_empr_addr1',array('class'=>'span8','label'=>false,'maxlength'=>50)); ?>
			<?php echo $form->label($modelClientindi,'&nbsp',array('class'=>'control-label'));?>
			<?php echo $form->textFieldRow($modelClientindi,'spouse_empr_addr2',array('class'=>'span8','label'=>false,'maxlength'=>50)); ?>
			<?php echo $form->label($modelClientindi,'&nbsp',array('class'=>'control-label'));?>
			<?php echo $form->textFieldRow($modelClientindi,'spouse_empr_addr3',array('class'=>'span8','label'=>false,'maxlength'=>30)); ?>		
		</div>
		<div class="span6">
		    <?php echo $form->textFieldRow($modelClientindi,'spouse_empr_post_cd',array('class'=>'span5','maxlength'=>6)); ?>
		</div>
	</div>
</fieldset>  

<fieldset>
	<legend><h4>Client Funds Data</h4></legend>
	
	<div class="row-fluid">
		<div class="span12">
			<div class="control-group">
				<?php echo $form->label($modelCif,'annual_income_cd',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo $form->dropDownList($modelCif,'annual_income_cd',Parameter::getCombo('INCOME','-Choose Annual Income-')); ?>
					<?php echo $form->textField($modelCif,'annual_income',array('class'=>'span5','maxlength'=>40,'placeholder'=>'Fill Annual Income Here')); ?>
					<?php echo $form->error($modelCif,'annual_income', array('class'=>'help-inline error')); ?>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span12">
			<div class="control-group">
				<?php echo $form->label($modelCif,'funds_code',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo $form->dropDownList($modelCif,'funds_code',Parameter::getCombo('FUND','-Choose Source Of Fund-')); ?>
					<?php echo $form->textField($modelCif,'source_of_funds',array('class'=>'span5','maxlength'=>30,'placeholder'=>'Fill Source Of Fund Here')); ?>
					<?php echo $form->error($modelCif,'source_of_funds', array('class'=>'help-inline error')); ?>
				</div>
			</div>
		</div>
	</div>
	 
	<div class="row-fluid">
		<div class="span12">
			<div class="control-group">
				<label class="control-label">Fund Objectives</label>
				<div class="controls">
					<table style="width: 0px;">
						<tr>
							<td><?php echo $form->checkBox($modelCif,'purpose01'); ?> Keuntungan</td>
							<td><?php echo $form->checkBox($modelCif,'purpose02'); ?> Apresiasi Harga</td>
							<td><?php echo $form->checkBox($modelCif,'purpose03'); ?> Investasi Jangka Panjang</td>
						</tr>
						<tr>
							<td><?php echo $form->checkBox($modelCif,'purpose04'); ?> Spekulasi</td>
							<td><?php echo $form->checkBox($modelCif,'purpose05'); ?> Pendapatan</td>
							<td><?php echo $form->checkBox($modelCif,'purpose06'); ?> Pendapatan Tambahan</td>
						</tr>
						<tr>
							<td><?php echo $form->checkBox($modelCif,'purpose90',array('label'=>false)); ?> Lainnya</td>
							<td colspan="2">
							    <?php echo $form->textField($modelCif,'purpose_lainnya',array('class'=>'span10','maxlength'=>30)); ?>
							</td>
						</tr>
					</table>			
				</div>
			</div>
		</div>
	</div>

    <?php //AR[AKAN DIHAPUS] echo $form->textFieldRow($modelCif,'invesment_period',array('class'=>'span5','maxlength'=>20)); ?>

	<div class="row-fluid">
		<div class="span12">
			<div class="control-group">
				<?php echo $form->label($modelCif,'net_asset_cd',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo $form->dropDownList($modelCif,'net_asset_cd',Parameter::getCombo('IASSET','-Choose Net Asset-')); ?>
					<?php echo $form->textField($modelCif,'net_asset',array('class'=>'span5','maxlength'=>40,'placeholder'=>'Fill Net Asset Here')); ?>
					<?php echo $form->error($modelCif,'net_asset', array('class'=>'help-inline error')); ?>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span12">
			<div class="control-group">
				<?php echo $form->label($modelCif,'addl_fund_cd',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo $form->dropDownList($modelCif,'addl_fund_cd',Parameter::getCombo('ADDINC','-Choose Additional Income-')); ?>
					<?php echo $form->textField($modelCif,'addl_fund',array('class'=>'span5','maxlength'=>30,'placeholder'=>'Fill Additional Income Here')); ?>
					<?php echo $form->error($modelCif,'addl_fund', array('class'=>'help-inline error')); ?>
				</div>
			</div>
		</div>
	</div>
	
</fieldset>
<div class="row-fluid">
	<div class="span12">
	    <?php echo $form->textFieldRow($modelClientindi,'heir',array('class'=>'span5','maxlength'=>30)); ?>
	    <?php echo $form->textFieldRow($modelClientindi,'heir_relation',array('class'=>'span5','maxlength'=>30)); ?>
	</div>
</div>
-->

<script>
	
	$('#Clientindi_occup_code').change(function(){
		var cmbval = $(this).val();
		if(cmbval == '90')
			$('#Clientindi_occupation').show().attr('required','required');
		else 
			$('#Clientindi_occupation').hide().removeAttr('required');
	});
	$('#Clientindi_occup_code').trigger('change');
	
	$('#Cif_client_type_2').trigger('change');

/*
	$('#Cif_annual_income_cd').change(function(){
		var cmbval = $(this).val();
		if(cmbval == '90')
			$('#Cif_annual_income').show().attr('required','required');
		else 
			$('#Cif_annual_income').hide().removeAttr('required');
	});
	$('#Cif_annual_income_cd').trigger('change');
	
	$('#Cif_funds_code').change(function(){
		var cmbval = $(this).val();
		
		if(cmbval == '90')
			$('#Cif_source_of_funds').show().attr('required','required');
		else 
			$('#Cif_source_of_funds').hide().removeAttr('required');
	});
	$('#Cif_funds_code').trigger('change');
	
	$('#Cif_net_asset_cd').change(function(){
		var cmbval = $(this).val();
		
		if(cmbval == '90')
			$('#Cif_net_asset').show().attr('required','required');
		else 
			$('#Cif_net_asset').hide().removeAttr('required');
	});
	$('#Cif_net_asset_cd').trigger('change');
	
	$('#Cif_addl_fund_cd').change(function(){
		var cmbval = $(this).val();
		
		if(cmbval == '90')
			$('#Cif_addl_fund').show().attr('required','required');
		else 
			$('#Cif_addl_fund').hide().removeAttr('required');
	});
	$('#Cif_addl_fund_cd').trigger('change');
*/
</script>
	
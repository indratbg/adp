<?php
	$tasset = Parameter::model()->findAll(array('condition'=>"prm_cd_1 = 'TASSET'",'order'=>'prm_cd_2'));
?>

<div class="row-fluid">
	<div class="span6">
		<?php echo $form->textFieldRow($modelCif,'modal_dasar',array('class'=>'span8','maxlength'=>30)); ?>
	</div>
	<div class="span6">
		<?php if($tasset): ?>
			<?php echo $form->dropDownListRow($modelCif,'modal_disetor',CHtml::listData($tasset, 'prm_desc', 'prm_desc'),array('class'=>'span8')); ?>
		<?php else: ?>
			<?php echo $form->textFieldRow($modelCif,'modal_disetor',array('class'=>'span8','maxlength'=>30)); ?>
		<?php endif; ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span12">
		<div class="control-group">
			<?php echo $form->labelEx($modelCif,'funds_code',array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->dropDownList($modelCif,'funds_code',Parameter::getCombo('FUNDC','-Choose Source-',null,null,'cd'),array('class'=>'span4')); ?>
				<?php echo $form->textField($modelCif,'source_of_funds',array('class'=>'span4','maxlength'=>30,'placeholder'=>'Fill Source Here')); ?>
				<?php echo $form->error($modelCif,'source_of_funds', array('class'=>'help-inline error')); ?>
			</div>
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<div class="control-group">
			<?php echo $form->labelEx($modelCif,'net_asset_cd',array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->dropDownList($modelCif,'net_asset_cd',Parameter::getCombo('NASSET','-Choose Net Asset-',null,null,'cd'),array('class'=>'span8')); ?>
			</div>
		</div>
	</div>
	<div class="span6">
		<div class="control-group">
			<?php echo $form->labelEx($modelCif,'profit_cd',array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->dropDownList($modelCif,'profit_cd',Parameter::getCombo('PROFIT','-Choose Profit-',null,null,'cd'), array('class'=>'span4')); ?>
				&emsp;&emsp;Year&emsp;
				<?php echo $form->textField($modelCif,'net_asset_yr',array('class'=>'span2','maxlength'=>4)); ?>
			</div>
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<div class="control-group">
			<?php echo $form->labelEx($modelClientinst,'net_asset_cd2',array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->dropDownList($modelClientinst,'net_asset_cd2',Parameter::getCombo('NASSET','-Choose Net Asset-',null,null,'cd'),array('class'=>'span8')); ?>
			</div>
		</div>
	</div>
	<div class="span6">
		<div class="control-group">
			<?php echo $form->labelEx($modelClientinst,'profit_cd2',array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->dropDownList($modelClientinst,'profit_cd2',Parameter::getCombo('PROFIT','-Choose Profit-',null,null,'cd'), array('class'=>'span4')); ?>
				&emsp;&emsp;Year&emsp;
				<?php echo $form->textField($modelClientinst,'net_asset_yr2',array('class'=>'span2','maxlength'=>4)); ?>
			</div>
		</div>
	</div>
</div>
<div class="row-fluid">
	<div class="span6">
		<div class="control-group">
			<?php echo $form->labelEx($modelClientinst,'net_asset_cd3',array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->dropDownList($modelClientinst,'net_asset_cd3',Parameter::getCombo('NASSET','-Choose Net Asset-',null,null,'cd'),array('class'=>'span8')); ?>
			</div>
		</div>
	</div>
	<div class="span6">
		<div class="control-group">
			<?php echo $form->labelEx($modelClientinst,'profit_cd3',array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->dropDownList($modelClientinst,'profit_cd3',Parameter::getCombo('PROFIT','-Choose Profit-',null,null,'cd'), array('class'=>'span4')); ?>
				&emsp;&emsp;Year&emsp;
				<?php echo $form->textField($modelClientinst,'net_asset_yr3',array('class'=>'span2','maxlength'=>4)); ?>
			</div>
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<?php echo $form->textFieldRow($modelClientinst,'net_profit_text',array('class'=>'span8','maxlength'=>30)); ?>
	</div>
	<div class="span6">
		<?php echo $form->textFieldRow($modelClientinst,'non_opr_incm_text',array('class'=>'span8','maxlength'=>30)); ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<?php //echo $form->textFieldRow($modelClientinst,'liability',array('class'=>'span8','maxlength'=>30)); ?>
		<?php if($tasset): ?>
			<?php echo $form->dropDownListRow($modelClientinst,'liability',CHtml::listData($tasset, 'prm_desc', 'prm_desc'),array('class'=>'span8')); ?>
		<?php else: ?>
			<?php echo $form->textFieldRow($modelClientinst,'liability',array('class'=>'span8','maxlength'=>30)); ?>
		<?php endif; ?>
	</div>
</div>

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

<div class="row-fluid">
	<div class="span9">
	<?php echo $form->dropDownListRow($modelCif,'invesment_period',CHtml::listData(Parameter::model()->findAll("prm_cd_1 = 'JANGKA'"), 'prm_desc', 'prm_desc'),array('class'=>'span4','prompt'=>'-Choose Period-')); ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<div class="control-group">
			<?php echo $form->labelEx($modelClientinst,'investment_type',array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->dropDownList($modelClientinst,'investment_type',Parameter::getCombo('INSTRU','-Choose-',null,null,'cd'),array('class'=>'span3')); ?>
				<?php echo $form->textField($modelClientinst,'investment_type_text',array('class'=>'span5','maxlength'=>30)); ?>
				<?php echo $form->error($modelClientinst,'investment_type_text', array('class'=>'help-inline error')); ?>
			</div>
		</div>
	</div>
	<div class="span6">
		<?php echo $form->dropDownListRow($modelClientinst,'transaction_freq',Parameter::getCombo('TRXFRQ','-Choose Transaction Frequency-',null,null,'cd'),array('class'=>'span8')); ?>
	</div>
</div>

<script>
	$('#Cif_funds_code').change(function(){
		var cmbval = $(this).val();
		if(cmbval == '90')
			$('#Cif_source_of_funds').show();
		else 
			$('#Cif_source_of_funds').hide();
	});
	$('#Cif_funds_code').trigger('change');
	
	$('#Cif_industry_cd').change(function(){
		var cmbval = $(this).val();
		if(cmbval == '90')
			$('#Cif_addl_fund').show();
		else 
			$('#Cif_addl_fund').hide();
	});
	$('#Cif_industry_cd').trigger('change');
	
	$('#Cif_purpose90').change(function(){
		if($('#Cif_purpose90').is(':checked'))
			$('#Cif_purpose_lainnya').show();
		else 
			$('#Cif_purpose_lainnya').hide();
	});
	$('#Cif_purpose90').trigger('change');
	
	$('#Clientinst_investment_type').change(function(){
		var cmbval = $(this).val();
		if(cmbval == '9')
			$('#Clientinst_investment_type_text').show();
		else 
			$('#Clientinst_investment_type_text').hide();
	});
	$('#Clientinst_investment_type').trigger('change');
</script>
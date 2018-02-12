<style>
	#idAddress, #defAddress
	{
		border-bottom: 1px solid #e5e5e5;
	}
	#defAddress
	{
		margin-bottom: 10px;
	}
</style>

<?php
	$cityList = City::model()->findAll(array('condition'=>"city_cd <> 999",'order'=>'city'));
	$cityOther = City::model()->findAll(array('condition'=>'city_cd = 999'));
	/*$birthPlaceList = array();
	$x = 0;
	foreach($cityList as $row)
	{
		$birthPlaceList[$x] = new City;
		if($row->province_cd == 5)
		{
			$birthPlaceList[$x]->city = 'JAKARTA';
		}
		else {
			$birthPlaceList[$x]->city = $row->city;
		}
		$x++;
	}*/
	
	$cityList = array_merge($cityList,$cityOther);
	//$birthPlaceList = array_merge($birthPlaceList,$cityOther);
?>

<div class="row-fluid">
	<div class="span6">
		<?php echo $form->textFieldRow($modelCif,'sid',array('class'=>'span5','maxlength'=>15)); ?>
	</div>
	<div class="span6">
		<?php echo $form->dropDownListRow($modelCif,'client_type_2',Chtml::listData(Lsttype2::model()->findAll(),'cl_type2', 'cl_desc'),array('class'=>'span3')); ?>
	</div>
</div>	

<div class="row-fluid">
	<div class="span6">
		<?php echo $form->textFieldRow($modelCif,'cif_name',array('class'=>'span8','maxlength'=>50)); ?>
	</div>
	<div class="span6">
		<div class="control-group">
			<?php echo $form->labelEx($modelCif,'ic_type',array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->dropDownList($modelCif,'ic_type',CHtml::listData(Parameter::model()->findAll("prm_cd_1 = 'IDTYPE' AND prm_cd_2 NOT IN ('0','2')"), 'prm_cd_2', 'prm_desc'), array('class'=>'span3','prompt'=>'-Choose-','style'=>'width:90px')); ?>
				Number
				<?php echo $form->textField($modelCif,'client_ic_num',array('class'=>'span5','maxlength'=>30)); ?>
			</div>
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<div class="control-group">
			<?php echo $form->labelEx($modelCif,'inst_type',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo $form->dropDownList($modelCif,'inst_type',Parameter::getCombo('KARAK','-Choose Type-',null,null,'cd'),array('class'=>'span4')); ?>
				<?php echo $form->textField($modelCif,'inst_type_txt',array('class'=>'span5','maxlength'=>30,'placeholder'=>'Fill Institution Type Here')); ?>
				<?php echo $form->error($modelCif,'inst_type_txt', array('class'=>'help-inline error')); ?>
			</div>
		</div>
	</div>
	<div class="span6">
		<?php echo $form->dropDownListRow($modelCif,'tax_id',Parameter::getCombo('TAXCDC','-Choose Tax Type-'), array('class'=>'span8')); ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<?php echo $form->labelEx($modelCif,'tempat_pendirian',array('class'=>'control-label')) ?>
		<select name="Clientindi[tempat_pendirian]" class="span8">
			<option value="">-Choose City-</option>
			<?php foreach($cityList as $row) {?>
			<option value="<?php if($row->province_cd == '5' && $row->city_cd != '140')echo 'JAKARTA';else echo $row->city ?>" <?php if($row->city == $modelCif->tempat_pendirian || ($row->province_cd == '5' && $row->city_cd != '140' && $modelCif->tempat_pendirian == 'JAKARTA'))echo 'selected' ?>><?php if($row->province_cd == '5' && $row->city_cd != '140')echo 'JAKARTA';else echo $row->city ?></option>
			<?php } ?>
		</select>
	</div>
	<div class="span6">
		<?php echo $form->datePickerRow($modelCif,'client_birth_dt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">	
		<?php echo $form->textFieldRow($modelCif,'act_first', array('class'=>'span8','maxlength'=>30)); ?>
	</div>
	<div class="span6">
		<?php echo $form->datePickerRow($modelCif,'act_first_dt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">	
		<?php echo $form->textFieldRow($modelCif,'act_last', array('class'=>'span8','maxlength'=>30)); ?>
	</div>
	<div class="span6">
		<?php echo $form->datePickerRow($modelCif,'act_last_dt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">	
		<?php echo $form->textFieldRow($modelCif,'siup_no',array('class'=>'span8','maxlength'=>30)); ?>
	</div>
	<div class="span6">
		<?php echo $form->textFieldRow($modelCif,'tdp_no',array('class'=>'span8','maxlength'=>30)); ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">	
		<?php echo $form->textFieldRow($modelCif,'npwp_no',array('class'=>'span8','maxlength'=>15)); ?>
	</div>
	<div class="span6">
		<?php echo $form->datePickerRow($modelCif,'npwp_date',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
	</div>
</div>

<h5>Domicile Address</h5>
<div id="defAddress">
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->labelEx($modelCif,'def_addr_1',array('class'=>'control-label'));?>
			<?php echo $form->textFieldRow($modelCif,'def_addr_1',array('class'=>'span8','label'=>false,'maxlength'=>30)); ?>
			<?php echo $form->label($modelCif,'&nbsp',array('class'=>'control-label'));?>
			<?php echo $form->textFieldRow($modelCif,'def_addr_2',array('class'=>'span8','label'=>false,'maxlength'=>30)); ?>
			<?php echo $form->label($modelCif,'&nbsp',array('class'=>'control-label'));?>
			<?php echo $form->textFieldRow($modelCif,'def_addr_3',array('class'=>'span8','label'=>false,'maxlength'=>30)); ?>	
			<?php echo $form->textFieldRow($modelCif,'post_cd',array('class'=>'span3','maxlength'=>6)); ?>	
		</div>
		<div class="span6">
			<?php echo $form->dropDownListRow($modelCif,'def_city',CHtml::listData($cityList,'city','city'),array('class'=>'span8','prompt'=>'-Choose City-')); ?>
			<?php echo $form->dropDownListRow($modelCif,'country',CHtml::listData(Parameter::model()->findAll(array('condition'=>"prm_cd_1 = 'NEGARA'",'order'=>'prm_desc')), 'prm_desc', 'prm_desc'),array('class'=>'span8','prompt'=>'-Choose Country-')); ?>
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<div class="control-group">
			<?php echo $form->label($modelCif,'phone_num',array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->textField($modelCif,'phone_num',array('class'=>'span4','maxlength'=>15)); ?>
				<?php echo $form->textField($modelCif,'phone2_1',array('class'=>'span4','maxlength'=>15)); ?>
			</div>
		</div>
	</div>
	<div class="span6">
		<div class="control-group">
			<?php echo $form->label($modelCif,'hp_num',array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->textField($modelCif,'hp_num',array('class'=>'span4','maxlength'=>15)); ?>
				<?php echo $form->textField($modelCif,'hand_phone1',array('class'=>'span4','maxlength'=>15)); ?>
			</div>
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<?php echo $form->textFieldRow($modelCif,'e_mail1',array('class'=>'span8','maxlength'=>50)); ?>
	</div>
	<div class="span6">
		<?php echo $form->textFieldRow($modelCif,'fax_num',array('class'=>'span5','maxlength'=>15)); ?>		
	</div>
</div>
  
<script type="text/javascript">

	$('#Clientindi_residence_status').change(function(){
		var cmbval = $(this).val();
		if(cmbval == '90')
			$('#Clientindi_residence').show().attr('required','required');
		else 
			$('#Clientindi_residence').hide().removeAttr('required');
	});
	$('#Clientindi_residence_status').trigger('change');
	
	$('#Clientindi_educ_code').change(function(){
		var cmbval = $(this).val();
		if(cmbval == '90')
			$('#Clientindi_education').show().attr('required','required');
		else 
			$('#Clientindi_education').hide().removeAttr('required');
	});
	$('#Clientindi_educ_code').trigger('change');
	
	$('#Cif_ic_type').change(function(){
		if($('#Cif_ic_type').val() == '0' || $('#Cif_ic_type').val() == '2')
		{
			$('#Cif_ic_expiry_dt').attr('required','required');
			
			if($('#Cif_ic_type').val() == '0')
			{
				$('#idRtrw').show();
				$("[for=Clientindi_id_klurahn]").css('visibility','');
				$("[for=Clientindi_id_kcamatn]").css('visibility','');
			}
			else
			{
				$('#idRtrw').hide();
				$("[for=Clientindi_id_klurahn]").css('visibility','hidden');
				$("[for=Clientindi_id_kcamatn]").css('visibility','hidden');
			}
		}
		else
		{
			$('#Cif_ic_expiry_dt').removeAttr('required');
			$('#idRtrw').hide();
			$("[for=Clientindi_id_klurahn]").css('visibility','hidden');
			$("[for=Clientindi_id_kcamatn]").css('visibility','hidden');
		}
	});
	$('#Cif_ic_type').trigger('change');
	
	$('#Cif_client_type_2, #Clientindi_nationality, #Clientindi_id_negara, #Cif_country').change(function(){
		if($('#Cif_client_type_2').val() == 'L')
		{
			$('#Clientindi_nationality').val('INDONESIAN');
			$('#Clientindi_id_negara').val('INDONESIA');
			$('#Cif_country').val('INDONESIA');
		}
		else
		{
			if($('#Clientindi_nationality').val() == 'INDONESIAN')$('#Clientindi_nationality').val('');
			if($('#Clientindi_id_negara').val() == 'INDONESIA')$('#Clientindi_id_negara').val('');
		}
	});
	
	
	$('#Cif_client_type_2').change(function()
	{
		if($('#Cif_client_type_2').val() == 'L')
		{
			$('#Cif_tax_id').val('1010');
		}
		else
		{
			$('#Cif_tax_id').val('1011');
		}
	});
	$('#Cif_client_type_2').trigger('change');
	
	$('#Clientindi_id_rtrw').on('focus blur keyup', function(event) 
	{
		var value = $('#Clientindi_id_rtrw').val();
		
		var search = value.search(/[^A-Za-z]/); //Get index of first non alphabetic character
		var str = value.substr(search);
			
		if(search == -1)str = '';
			
		$('#Clientindi_id_rtrw').val('RT' + str);
	});
	$('#Clientindi_id_rtrw').trigger('keyup');
	
	$("#Cif_sid").mask("AA.A.@@@@.@@@@@@.@@");
	$("#Cif_npwp_no").mask("99.999.999.9-999.999");
	
	$('#btnLifeTime').click(function()
	{
		$('#Cif_ic_expiry_dt').val('01/01/5000');
	});
</script>

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
	$cityList = City::model()->findAll(array('condition'=>"city_cd NOT IN (998,999)",'order'=>'city'));
	$cityOther = City::model()->findAll(array('condition'=>'city_cd IN (998,999)'));
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
			<?php echo $form->label($modelClientindi,'nick_name',array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->textField($modelClientindi,'nick_name',array('class'=>'span4','maxlength'=>20)); ?>
			</div>
		</div>		
	</div>
</div>	


<div class="row-fluid">
	<div class="span6">
		<?php //echo $form->dropDownListRow($modelClientindi,'birth_place',Chtml::listData($birthPlaceList,'city','city'),array('class'=>'span8','prompt'=>'-Choose City-')); ?>
		<?php echo $form->labelEx($modelClientindi,'birth_place',array('class'=>'control-label')) ?>
		<select id="Clientindi_birth_place" name="Clientindi[birth_place]" class="span8" style="width:285px">
			<option value="">-Choose City-</option>
			<?php foreach($cityList as $row) {?>
			<option value="<?php if($row->province_cd == '5' && $row->city_cd != '140')echo 'JAKARTA';else echo $row->city ?>" <?php if($row->city == $modelClientindi->birth_place || ($row->province_cd == '5' && $row->city_cd != '140' && $modelClientindi->birth_place == 'JAKARTA'))echo 'selected' ?>><?php if($row->province_cd == '5' && $row->city_cd != '140')echo 'JAKARTA';else echo $row->city ?></option>
			<?php } ?>
		</select>
	</div>
	<div class="span6">
		<?php echo $form->datePickerRow($modelCif,'client_birth_dt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">	
		<?php echo $form->dropDownListRow($modelClientindi,'sex_code',Parameter::getCombo('GENDER','-Choose Gender-'), array('class'=>'span8')); ?>
	</div>
	<div class="span6">
		<?php echo $form->dropDownListRow($modelClientindi,'marital_status',Parameter::getCombo('MARITL','-Choose Status-'), array('class'=>'span8')); ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">	
		<?php echo $form->dropDownListRow($modelClientindi,'nationality',CHtml::listData(Parameter::model()->findAll(array('condition'=>"prm_cd_1 = 'NATION'",'order'=>'prm_desc')), 'prm_desc', 'prm_desc'), array('class'=>'span8','prompt'=>'-Choose Nation-')); ?>	
	</div>
	<div class="span6">
		<?php echo $form->textFieldRow($modelClientindi,'jml_tanggungan',array('class'=>'span2','maxlength'=>2)); ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">	
		<?php echo $form->textFieldRow($modelCif,'mother_name',array('class'=>'span8','maxlength'=>50)); ?>
	</div>
	<div class="span6">
		<?php echo $form->dropDownListRow($modelClientindi,'religion',Parameter::getCombo('RELIG','-Choose Religion-',1), array('class'=>'span8')); ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<div class="control-group">
			<?php echo $form->labelEx($modelCif,'ic_type',array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->dropDownList($modelCif,'ic_type',CHtml::listData(Parameter::model()->findAll("prm_cd_1 = 'IDTYPE' AND prm_cd_2 IN ('0','2')"), 'prm_cd_2', 'prm_desc'), array('class'=>'span3','prompt'=>'-Choose-','style'=>'width:90px')); ?>
				Number
				<?php echo $form->textField($modelCif,'client_ic_num',array('class'=>'span5','maxlength'=>30)); ?>
			</div>
		</div>
	</div>

	<div class="span5" style="width:310px">
		<?php echo $form->datePickerRow($modelCif,'ic_expiry_dt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
	</div>
	<div class="span1" style="margin-left:-30px">
		<input type="button" id="btnLifeTime" value="Seumur Hidup"/>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">	
		<?php echo $form->textFieldRow($modelClientindi,'kitas_num',array('class'=>'span5','maxlength'=>20)); ?>
	</div>
	<div class="span6">
		<?php echo $form->datePickerRow($modelClientindi,'kitas_expiry_dt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">	
		<?php echo $form->textFieldRow($modelCif,'npwp_no',array('class'=>'span5','maxlength'=>15)); ?>
	</div>
	<div class="span6">
		<?php echo $form->datePickerRow($modelCif,'npwp_date',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
	</div>
</div>
<div class="row-fluid">
	<div class="span6">
		<?php echo $form->dropDownListRow($modelCif,'tax_id',Parameter::getCombo('TAXCDI','-Choose Tax Type-'), array('class'=>'span8')); ?>
	</div>
</div>

<h5>ID Card Address</h5>
<div id="idAddress">
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->textFieldRow($modelClientindi,'id_addr',array('class'=>'span8','maxlength'=>50)); ?>
		</div>
		<div class="span6">
			<div id="idRtrw">
				<?php echo $form->textFieldRow($modelClientindi,'id_rtrw',array('class'=>'span8','maxlength'=>50)); ?>
			</div>
		</div>
	</div>	
	
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->textFieldRow($modelClientindi,'id_klurahn',array('class'=>'span8','maxlength'=>50)); ?>
	    	<?php echo $form->textFieldRow($modelClientindi,'id_kcamatn',array('class'=>'span8','maxlength'=>50)); ?>
	    	<?php echo $form->textFieldRow($modelClientindi,'id_post_cd',array('class'=>'span3','maxlength'=>6)); ?>
		</div>
		<div class="span6">
			<?php echo $form->dropDownListRow($modelClientindi,'id_kota',CHtml::listData($cityList,'city','city'),array('class'=>'span8','prompt'=>'-Choose City-')); ?>
			<?php echo $form->dropDownListRow($modelClientindi,'id_negara',CHtml::listData(Parameter::model()->findAll(array('condition'=>"prm_cd_1 = 'NEGARA'",'order'=>'prm_desc')), 'prm_desc', 'prm_desc'),array('class'=>'span8','prompt'=>'-Choose Country-')); ?>
		</div>
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
		<?php echo $form->textFieldRow($modelCif,'e_mail1',array('class'=>'span8 email','maxlength'=>50)); ?>
	</div>
	<div class="span6">
		<?php echo $form->textFieldRow($modelCif,'fax_num',array('class'=>'span5','maxlength'=>15)); ?>		
	</div>
</div>


<div class="row-fluid">	
	<div class="span6">
		<div class="control-group">
			<?php echo $form->labelEx($modelClientindi,'residence_status',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo $form->dropDownList($modelClientindi,'residence_status',Parameter::getCombo('HOUSE','-Choose Residence-',null,null,'cd'),array('class'=>'span4')); ?>
				<?php echo $form->textField($modelClientindi,'residence',array('class'=>'span5','maxlength'=>30,'placeholder'=>'Fill Residence Status Here')); ?>
				<?php echo $form->error($modelClientindi,'residence', array('class'=>'help-inline error')); ?>
			</div>
		</div>
	</div>
	<div class="span6">
		<div class="control-group">
		<?php echo $form->labelEx($modelClientindi,'educ_code',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->dropDownList($modelClientindi,'educ_code',Parameter::getCombo('EDUC','-Choose Education-',null,null,'cd'),array('class'=>'span4')); ?>
			<?php echo $form->textField($modelClientindi,'education',array('class'=>'span5','maxlength'=>30,'placeholder'=>'Fill Education Here')); ?>
			<?php echo $form->error($modelClientindi,'education', array('class'=>'help-inline error')); ?>
		</div>
	</div>
	</div>
</div>

<?php echo $form->textFieldRow($modelClientindi,'residence_since',array('class'=>'span3','maxlength'=>20)); ?>


<div class="row-fluid">
	<div class="span6">
		<?php echo $form->textFieldRow($modelClientindi,'heir',array('class'=>'span8','maxlength'=>30)); ?>
	</div>
	<div class="span6">
		<?php echo $form->textFieldRow($modelClientindi,'heir_relation',array('class'=>'span8','maxlength'=>30)); ?>		
	</div>
</div>

<h5>Emergency Address</h5>
<div id="emergency">
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->textFieldRow($modelClientEmergency,'emergency_name',array('class'=>'span8','maxlength'=>50)); ?>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->labelEx($modelClientEmergency,'emergency_addr1',array('class'=>'control-label'));?>
			<?php echo $form->textFieldRow($modelClientEmergency,'emergency_addr1',array('class'=>'span8','label'=>false,'maxlength'=>30)); ?>
			<?php echo $form->label($modelClientEmergency,'&nbsp',array('class'=>'control-label'));?>
			<?php echo $form->textFieldRow($modelClientEmergency,'emergency_addr2',array('class'=>'span8','label'=>false,'maxlength'=>30)); ?>
			<?php echo $form->label($modelClientEmergency,'&nbsp',array('class'=>'control-label'));?>
			<?php echo $form->textFieldRow($modelClientEmergency,'emergency_addr3',array('class'=>'span8','label'=>false,'maxlength'=>30)); ?>	
			<?php echo $form->textFieldRow($modelClientEmergency,'emergency_postcd',array('class'=>'span3','maxlength'=>6)); ?>
		</div>
		<div class="span6">	
			<?php echo $form->textFieldRow($modelClientEmergency,'emergency_phone',array('class'=>'span5','maxlength'=>15)); ?>		
			<?php echo $form->textFieldRow($modelClientEmergency,'emergency_hp',array('class'=>'span5','maxlength'=>15)); ?>			
		</div>
	</div>
</div>

<!--
<h4>Default Correspondence Address</h4>

    <?php echo $form->dropDownListRow($modelCif,'tax_id',Parameter::getCombo('TAXCDI','-Choose Tax-')); ?>
    
    <div class="row-fluid">
		<div class="span12">
			<div class="control-group">
				<?php echo $form->label($model,'residence_status',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo $form->dropDownList($modelClientindi,'residence_status',Parameter::getCombo('HOUSE','-Choose Residence-')); ?>
					<?php echo $form->textField($modelClientindi,'residence',array('class'=>'span5','maxlength'=>30,'placeholder'=>'Fill Residence Here')); ?>
					<?php echo $form->error($modelClientindi,'residence', array('class'=>'help-inline error')); ?>
				</div>
			</div>
		</div>
	</div>
	
    <div class="row-fluid">
		<div class="span12">
			<div class="control-group">
				<?php echo $form->label($model,'educ_code',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo $form->dropDownList($modelClientindi,'educ_code',Parameter::getCombo('EDUC','-Choose Education-')); ?>
					<?php echo $form->textField($modelClientindi,'education',array('class'=>'span5','maxlength'=>30,'placeholder'=>'Fill Education Here')); ?>
					<?php echo $form->error($modelClientindi,'education', array('class'=>'help-inline error')); ?>
				</div>
			</div>
		</div>
	</div>
-->   
  
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
			$('#Cif_ic_type').val(0).trigger('change');
			$('#Clientindi_empr_country').val('INDONESIA');
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
	
	//$("#Cif_sid").mask("?AA.A.@@@@.@@@@@@.@@",{placeholder:""});
	//$("#Cif_npwp_no").mask("?99.999.999.9-999.999",{placeholder:""});
	
	$("#Cif_sid").blur(function()
	{
		var sid = $(this).val();
		var formattedSid = sid.substr(0,2) + '.' + sid.substr(2,1) + '.' + sid.substr(3,4) + '.' + sid.substr(7,6) + '.' + sid.substr(13,2);
		$(this).val(formattedSid.toUpperCase());
	});
	$("#Cif_sid").trigger('blur');
	
	$("#Cif_sid").focus(function()
	{
		var sid = $(this).val();
		$(this).val(sid.replace(/[.]/g,''));
	});
	
	$("#Cif_npwp_no").blur(function()
	{
		var npwp = $(this).val();
		var formattedNpwp = npwp.substr(0,2) + '.' + npwp.substr(2,3) + '.' + npwp.substr(5,3) + '.' + npwp.substr(8,1) + '-' + npwp.substr(9,3) + '.' + npwp.substr(12,3);
		$(this).val(formattedNpwp.toUpperCase());
	});
	$("#Cif_npwp_no").trigger('blur');
	
	$("#Cif_npwp_no").focus(function()
	{
		var npwp = $(this).val();
		$(this).val(npwp.replace(/[.-]/g,''));
	});
	
	$('#btnLifeTime').click(function()
	{
		var dateAndMonth;
		
		if($("#Cif_client_birth_dt").val())
		{
			dateAndMonth = $("#Cif_client_birth_dt").val().substr(0,5);
		}
		else
		{
			dateAndMonth = '01/01';
			
		}
		
		$('#Cif_ic_expiry_dt').val(dateAndMonth+'/9999');
		//$('#Cif_ic_expiry_dt').data('datepicker').update();
	});
	
	$('#Clientindi_marital_status, #Clientindi_sex_code').change(function()
	{
		if($('#Clientindi_marital_status').val() == 'M')
		{
			if($('#Clientindi_sex_code').val() == 'M')
			{
				$('#Clientindi_spouse_relationship').val(2);
			}
			else if($('#Clientindi_sex_code').val() == 'F')
			{
				$('#Clientindi_spouse_relationship').val(1);
			}
		}
	});
</script>

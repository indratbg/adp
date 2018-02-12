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
			<?php echo $form->labelEx($modelCif,'inst_type',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo $form->dropDownList($modelCif,'inst_type',Parameter::getCombo('KARAK','-Choose Type-',null,null,'cd'),array('class'=>'span4')); ?>
				<?php echo $form->textField($modelCif,'inst_type_txt',array('class'=>'span5','maxlength'=>30,'placeholder'=>'Fill Institution Type Here')); ?>
				<?php echo $form->error($modelCif,'inst_type_txt', array('class'=>'help-inline error')); ?>
			</div>
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="span12">
		<div class="control-group">
			<?php echo $form->labelEx($modelCif,'industry_cd',array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->dropDownList($modelCif,'industry_cd',Parameter::getCombo('INDUST','-Choose Industry-',null,null,'cd'),array('class'=>'span4')); ?>
				<?php echo $form->textField($modelCif,'addl_fund',array('class'=>'span4','maxlength'=>30,'placeholder'=>'Fill Industry Here')); ?>
				<?php echo $form->error($modelCif,'addl_fund', array('class'=>'help-inline error')); ?>
			</div>
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<?php echo $form->textFieldRow($modelCif,'industry',array('class'=>'span8','maxlength'=>30)); ?>
	</div>
	<div class="span6">
		<?php echo $form->dropDownListRow($modelCif,'biz_type',Parameter::getCombo('BIZTYP','-Choose Business-',null,null,'cd'),array('class'=>'span8')); ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<div class="control-group">
			<?php echo $form->labelEx($modelClientinst,'Persentase Kepemilikan Saham',array('class'=>'control-label')); ?>
			<div class="controls">
				&emsp;
				Lokal &nbsp;
				<?php echo $form->textField($modelClientinst,'local_share_perc',array('class'=>'span3 tnumber','maxlength'=>3)); ?>
				&emsp;
				Asing &nbsp;
				<?php echo $form->textField($modelClientinst,'foreign_share_perc',array('class'=>'span3 tnumber','maxlength'=>3)); ?>
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
		<select name="Cif[tempat_pendirian]" class="span8">
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
		<?php echo $form->textFieldRow($modelCif,'npwp_no',array('class'=>'span8','maxlength'=>15)); ?>
	</div>
	<div class="span6">
		<?php echo $form->datePickerRow($modelCif,'npwp_date',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">	
		<?php echo $form->textFieldRow($modelCif,'skd_no',array('class'=>'span8','maxlength'=>30)); ?>
	</div>
	<div class="span6">
		<?php echo $form->datePickerRow($modelCif,'skd_expiry',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span4">	
		<?php echo $form->textFieldRow($modelCif,'siup_no',array('class'=>'span7','maxlength'=>30)); ?>
	</div>
	<div class="span4">
		<div class="span5">
			<?php echo $form->labelEx($modelCif,'siup_expiry_date',array('class'=>'control-label')); ?>
		</div>
		<?php echo $form->datePickerRow($modelCif,'siup_expiry_date',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','label'=>false,'options'=>array('format' => 'dd/mm/yyyy'))); ?>
	</div>
	<div class="span4">
		<?php echo $form->textFieldRow($modelCif,'siup_issued',array('class'=>'span7','maxlength'=>30)); ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span4">	
		<?php echo $form->textFieldRow($modelCif,'tdp_no',array('class'=>'span7','maxlength'=>30)); ?>
	</div>
	<div class="span4">
		<div class="span5">
			<?php echo $form->labelEx($modelCif,'tdp_expiry_date',array('class'=>'control-label')); ?>
		</div>
		<?php echo $form->datePickerRow($modelCif,'tdp_expiry_date',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','label'=>false,'options'=>array('format' => 'dd/mm/yyyy'))); ?>
	</div>
	<div class="span4">
		<?php echo $form->textFieldRow($modelCif,'tdp_issued',array('class'=>'span7','maxlength'=>30)); ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span4">	
		<?php echo $form->textFieldRow($modelCif,'pma_no',array('class'=>'span7','maxlength'=>30)); ?>
	</div>
	<div class="span4">
		<div class="span5">
			<?php echo $form->labelEx($modelCif,'pma_expiry_date',array('class'=>'control-label')); ?>
		</div>
		<?php echo $form->datePickerRow($modelCif,'pma_expiry_date',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','label'=>false,'options'=>array('format' => 'dd/mm/yyyy'))); ?>
	</div>
	<div class="span4">
		<?php echo $form->textFieldRow($modelCif,'pma_issued',array('class'=>'span7','maxlength'=>30)); ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span4">	
		<?php echo $form->dropDownListRow($modelClientinst,'suppl_doc_type',Parameter::getCombo('SUPPL','-Choose Supplementary Doc-',NULL,NULL,'asc'), array('class'=>'span7')); ?>
	</div>
	<div class="span4">
		<div class="span5">
			<?php echo $form->labelEx($modelClientinst,'suppl_exp_date',array('class'=>'control-label')); ?>
		</div>
		<?php echo $form->datePickerRow($modelClientinst,'suppl_exp_date',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','label'=>false,'options'=>array('format' => 'dd/mm/yyyy'))); ?>
	</div>
</div>

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
		<?php echo $form->dropDownListRow($modelClientinst,'legal_domicile',CHtml::listData(Parameter::model()->findAll(array('condition'=>"prm_cd_1 = 'NEGARA'",'order'=>'prm_desc')), 'prm_desc', 'prm_desc'),array('class'=>'span8','prompt'=>'-Choose Country-')); ?>
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
			<?php echo $form->labelEx($modelClientinst,'premise_stat',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo $form->dropDownList($modelClientinst,'premise_stat',Parameter::getCombo('OFFICE','-Choose Premises Status-',null,null,'cd'),array('class'=>'span4')); ?>
				<?php echo $form->textField($modelClientinst,'premise_stat_text',array('class'=>'span5','maxlength'=>30,'placeholder'=>'Fill Premises Status Here')); ?>
				<?php echo $form->error($modelClientinst,'premise_stat_text', array('class'=>'help-inline error')); ?>
			</div>
		</div>
	</div>
	<div class="span6">
		<?php echo $form->textFieldRow($modelClientinst,'premise_age', array('class'=>'span5')); ?>
	</div>
</div>
  
<script type="text/javascript">
	var newRecord = <?php if($model->isNewRecord)echo 'true';else echo 'false' ?>;
	var arraySuppl = [<?php echo $supplRequired; ?>];
	
	init();
	
	function init(){
		tax_to_suppl();
	}

	$('#Cif_inst_type').change(function()
	{
		if($(this).val() == 90)$('#Cif_inst_type_txt').show();
		else
			$('#Cif_inst_type_txt').hide();
	});
	$('#Cif_inst_type').trigger('change');
	
	$('#Clientinst_premise_stat').change(function()
	{
		if($(this).val() == 9)$('#Clientinst_premise_stat_text').show();
		else
			$('#Clientinst_premise_stat_text').hide();
	});
	$('#Clientinst_premise_stat').trigger('change');

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
			$('#Cif_tax_id').val('1037');
			$('#Clientinst_legal_domicile').val('INDONESIA');
			if(newRecord)$("#Client_desp_pref").prop('checked',true);
		}
		else
		{
			$('#Cif_tax_id').val('1017');
			if(newRecord)$("#Client_desp_pref").prop('checked',false);
		}
	});
	
	$('#Cif_tax_id').change(function(){
		tax_to_suppl();
	});
	
	$("form").submit(function () {
		tax_to_suppl();
	});
	
	function tax_to_suppl()
	{
		if(jQuery.inArray($('#Cif_tax_id').val(), arraySuppl) != -1){
			$("#Clientinst_suppl_doc_type").prop('required',true);
			$("#Clientinst_suppl_exp_date").prop('required',true);
		}else{
			$("#Clientinst_suppl_doc_type").prop('required',false);
			$("#Clientinst_suppl_exp_date").prop('required',false);
		}
	};
	
	// $('#Cif_client_type_2').trigger('change');
	
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
		$('#Cif_ic_expiry_dt').val('01/01/5000');
	});
</script>

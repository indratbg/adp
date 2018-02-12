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

<div class="row-fluid">
	<div class="span6">
		<?php echo $form->textFieldRow($modelCifDetail,'sid',array('class'=>'span5','readonly'=>'readonly')); ?>
	</div>
	<div class="span6">
		<?php echo $form->textFieldRow($modelCifDetail,'client_type_2',array('class'=>'span3','readonly'=>'readonly','value'=>Lsttype2::model()->find("cl_type2 = '$modelCifDetail->client_type_2'")?Lsttype2::model()->find("cl_type2 = '$modelCifDetail->client_type_2'")->cl_desc:$modelCifDetail->client_type_2)); ?>
	</div>
</div>	

<div class="row-fluid">
	<div class="span6">
		<?php echo $form->textFieldRow($modelCifDetail,'cif_name',array('class'=>'span8','readonly'=>'readonly')); ?>
	</div>
	<div class="span6">
		<div class="control-group">
			<?php echo $form->label($modelClientIndiDetail,'nick_name',array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->textField($modelClientIndiDetail,'nick_name',array('class'=>'span4','readonly'=>'readonly')); ?>
			</div>
		</div>		
	</div>
</div>	

<div class="row-fluid">
	<div class="span6">
		<?php echo $form->textFieldRow($modelClientIndiDetail,'birth_place',array('class'=>'span8','readonly'=>'readonly')); ?>
	</div>
	<div class="span6">
		<?php echo $form->textFieldRow($modelCifDetail,'client_birth_dt',array('class'=>'span3','readonly'=>'readonly','value'=>Tmanydetail::reformatDate($modelCifDetail->client_birth_dt))); ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">	
		<?php echo $form->textFieldRow($modelClientIndiDetail,'sex_code', array('class'=>'span8','readonly'=>'readonly','value'=>Parameter::getParamDesc('GENDER', $modelClientIndiDetail->sex_code))); ?>
	</div>
	<div class="span6">
		<?php echo $form->textFieldRow($modelClientIndiDetail,'marital_status', array('class'=>'span8','readonly'=>'readonly','value'=>Parameter::getParamDesc('MARITL', $modelClientIndiDetail->marital_status))); ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">	
		<?php echo $form->textFieldRow($modelClientIndiDetail,'nationality', array('class'=>'span8','readonly'=>'readonly')); ?>	
	</div>
	<div class="span6">
		<?php echo $form->textFieldRow($modelClientIndiDetail,'jml_tanggungan',array('class'=>'span2','readonly'=>'readonly')); ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">	
		<?php echo $form->textFieldRow($modelCifDetail,'mother_name',array('class'=>'span6','readonly'=>'readonly')); ?>
	</div>
	<div class="span6">
		<?php echo $form->textFieldRow($modelClientIndiDetail,'religion', array('class'=>'span8','readonly'=>'readonly','value'=>Parameter::getParamDesc('RELIG', $modelClientIndiDetail->religion))); ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<div class="control-group">
			<?php echo $form->label($modelCifDetail,'ic_type',array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->textField($modelCifDetail,'ic_type', array('class'=>'span3','readonly'=>'readonly','value'=>Parameter::getParamDesc('IDTYPE',$modelCifDetail->ic_type),'style'=>'width:80px')); ?>
				Number
				<?php echo $form->textField($modelCifDetail,'client_ic_num',array('class'=>'span5','readonly'=>'readonly')); ?>
			</div>
		</div>
	</div>
	<div class="span6">
		<?php echo $form->textFieldRow($modelCifDetail,'ic_expiry_dt',array('class'=>'span3','readonly'=>'readonly','value'=>Tmanydetail::reformatDate($modelCifDetail->ic_expiry_dt))); ?>
	</div>
</div>


<div class="row-fluid">
	<div class="span6">	
		<?php echo $form->textFieldRow($modelClientIndiDetail,'kitas_num',array('class'=>'span5','readonly'=>'readonly')); ?>
	</div>
	<div class="span6">
		<?php echo $form->textFieldRow($modelClientIndiDetail,'kitas_expiry_dt',array('class'=>'span3','readonly'=>'readonly','value'=>Tmanydetail::reformatDate($modelClientIndiDetail->kitas_expiry_dt))); ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">	
		<?php echo $form->textFieldRow($modelCifDetail,'npwp_no',array('class'=>'span5','readonly'=>'readonly')); ?>
	</div>
	<div class="span6">
		<?php echo $form->textFieldRow($modelCifDetail,'npwp_date',array('class'=>'span3','readonly'=>'readonly','value'=>Tmanydetail::reformatDate($modelCifDetail->npwp_date))); ?>
	</div>
</div>
<div class="row-fluid">
	<div class="span6">
		<?php echo $form->textFieldRow($modelCifDetail,'tax_id', array('class'=>'span8','readonly'=>'readonly','value'=>Parameter::getParamDesc('TAXCDI', $modelCifDetail->tax_id))); ?>
	</div>
</div>

<h5>ID Card Address</h5>
<div id="idAddress">
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->textFieldRow($modelClientIndiDetail,'id_addr',array('class'=>'span8','readonly'=>'readonly')); ?>
		</div>
		<div class="span6">
			<div id="idRtrw">
				<?php echo $form->textFieldRow($modelClientIndiDetail,'id_rtrw',array('class'=>'span8','readonly'=>'readonly')); ?>
			</div>
		</div>
	</div>	
	
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->textFieldRow($modelClientIndiDetail,'id_klurahn',array('class'=>'span8','readonly'=>'readonly')); ?>
	    	<?php echo $form->textFieldRow($modelClientIndiDetail,'id_kcamatn',array('class'=>'span8','readonly'=>'readonly')); ?>
	    	<?php echo $form->textFieldRow($modelClientIndiDetail,'id_post_cd',array('class'=>'span3','readonly'=>'readonly')); ?>
		</div>
		<div class="span6">
			<?php echo $form->textFieldRow($modelClientIndiDetail,'id_kota',array('class'=>'span8','readonly'=>'readonly')); ?>
			<?php echo $form->textFieldRow($modelClientIndiDetail,'id_negara',array('class'=>'span8','readonly'=>'readonly')); ?>
		</div>
	</div>
</div>

<h5>Domicile Address</h5>
<div id="defAddress">
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->labelEx($modelCifDetail,'def_addr_1',array('class'=>'control-label'));?>
			<?php echo $form->textFieldRow($modelCifDetail,'def_addr_1',array('class'=>'span8','label'=>false,'readonly'=>'readonly')); ?>
			<?php echo $form->label($modelCifDetail,'&nbsp',array('class'=>'control-label'));?>
			<?php echo $form->textFieldRow($modelCifDetail,'def_addr_2',array('class'=>'span8','label'=>false,'readonly'=>'readonly')); ?>
			<?php echo $form->label($modelCifDetail,'&nbsp',array('class'=>'control-label'));?>
			<?php echo $form->textFieldRow($modelCifDetail,'def_addr_3',array('class'=>'span8','label'=>false,'readonly'=>'readonly')); ?>	
			<?php echo $form->textFieldRow($modelCifDetail,'post_cd',array('class'=>'span3','readonly'=>'readonly')); ?>	
		</div>
		<div class="span6">
			<?php echo $form->textFieldRow($modelCifDetail,'def_city',array('class'=>'span8','readonly'=>'readonly')); ?>
			<?php echo $form->textFieldRow($modelCifDetail,'country',array('class'=>'span8','readonly'=>'readonly')); ?>
		</div>
	</div>
</div>


<div class="row-fluid">
	<div class="span6">
		<div class="control-group">
			<?php echo $form->label($modelCifDetail,'phone_num',array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->textField($modelCifDetail,'phone_num',array('class'=>'span4','readonly'=>'readonly')); ?>
				<?php echo $form->textField($modelCifDetail,'phone2_1',array('class'=>'span4','readonly'=>'readonly')); ?>
			</div>
		</div>
	</div>
	<div class="span6">
		<div class="control-group">
			<?php echo $form->label($modelCifDetail,'hp_num',array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->textField($modelCifDetail,'hp_num',array('class'=>'span4','readonly'=>'readonly')); ?>
				<?php echo $form->textField($modelCifDetail,'hand_phone1',array('class'=>'span4','readonly'=>'readonly')); ?>
			</div>
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<?php echo $form->textFieldRow($modelCifDetail,'e_mail1',array('class'=>'span8','readonly'=>'readonly')); ?>
	</div>
	<div class="span6">
		<?php echo $form->textFieldRow($modelCifDetail,'fax_num',array('class'=>'span5','readonly'=>'readonly')); ?>		
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<div class="control-group">
			<?php echo $form->labelEx($modelClientIndiDetail,'residence_status',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($modelClientIndiDetail,'residence',array('class'=>'span4','readonly'=>'readonly')); ?>
			</div>
		</div>
	</div>	
	<div class="span6">
		<div class="control-group">
			<?php echo $form->labelEx($modelClientIndiDetail,'educ_code',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($modelClientIndiDetail,'education',array('class'=>'span4','readonly'=>'readonly')); ?>
			</div>
		</div>
	</div>
</div>

<?php echo $form->textFieldRow($modelClientIndiDetail,'residence_since',array('class'=>'span3','readonly'=>'readonly')); ?>

<div class="row-fluid">
	<div class="span6">
		<?php echo $form->textFieldRow($modelClientIndiDetail,'heir',array('class'=>'span8','readonly'=>'readonly')); ?>
	</div>
	<div class="span6">
		<?php echo $form->textFieldRow($modelClientIndiDetail,'heir_relation',array('class'=>'span8','readonly'=>'readonly')); ?>		
	</div>
</div>

<h5>Emergency</h5>
<div id="emergency">
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->textFieldRow($modelClientEmerDetail,'emergency_name',array('class'=>'span8','readonly'=>'readonly')); ?>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->labelEx($modelClientEmerDetail,'emergency_addr1',array('class'=>'control-label'));?>
			<?php echo $form->textFieldRow($modelClientEmerDetail,'emergency_addr1',array('class'=>'span8','label'=>false,'readonly'=>'readonly')); ?>
			<?php echo $form->label($modelClientEmerDetail,'&nbsp',array('class'=>'control-label'));?>
			<?php echo $form->textFieldRow($modelClientEmerDetail,'emergency_addr2',array('class'=>'span8','label'=>false,'readonly'=>'readonly')); ?>
			<?php echo $form->label($modelClientEmerDetail,'&nbsp',array('class'=>'control-label'));?>
			<?php echo $form->textFieldRow($modelClientEmerDetail,'emergency_addr3',array('class'=>'span8','label'=>false,'readonly'=>'readonly')); ?>	
			<?php echo $form->textFieldRow($modelClientEmerDetail,'emergency_postcd',array('class'=>'span3','readonly'=>'readonly')); ?>
		</div>
		<div class="span6">	
			<?php echo $form->textFieldRow($modelClientEmerDetail,'emergency_phone',array('class'=>'span5','readonly'=>'readonly')); ?>		
			<?php echo $form->textFieldRow($modelClientEmerDetail,'emergency_hp',array('class'=>'span5','readonly'=>'readonly')); ?>			
		</div>
	</div>
</div>

<script>
	$(document).ready(function()
	{
		if($('#Cif_ic_type').val() == 'KTP')
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
	});
</script>
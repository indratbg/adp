<div class="row-fluid">
	<div class="span6">
		<?php echo $form->textFieldRow($modelCifDetail,'sid',array('class'=>'span5','readonly'=>'readonly')); ?>
	</div>
	<div class="span6">
		<?php echo $form->textFieldRow($modelCifDetail,'client_type_2',array('class'=>'span3','readonly'=>'readonly','value'=>Lsttype2::model()->find("cl_type2 = '$modelCifDetail->client_type_2'")->cl_desc)); ?>
	</div>
</div>	

<div class="row-fluid">
	<div class="span6">
		<?php echo $form->textFieldRow($modelCifDetail,'cif_name',array('class'=>'span8','readonly'=>'readonly')); ?>
	</div>
	<div class="span6">
		<?php echo $form->textFieldRow($modelCifDetail,'inst_type',array('class'=>'span8','readonly'=>'readonly','value'=>Parameter::getParamDesc('KARAK', $modelCifDetail->inst_type))); ?>
	</div>
</div>	

<div class="row-fluid">
	<div class="span6">
		<div class="control-group">
			<?php echo $form->label($modelCifDetail,'industry_cd',array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->textField($modelCifDetail,'addl_fund',array('class'=>'span8','readonly'=>'readonly')); ?>
			</div>
		</div>
	</div>
	<div class="span6">
		<?php echo $form->textFieldRow($modelCifDetail,'industry',array('class'=>'span8','readonly'=>'readonly')); ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<?php echo $form->textFieldRow($modelCifDetail,'biz_type',array('class'=>'span8','readonly'=>'readonly','value'=>Parameter::getParamDesc('BIZTYP', $modelCifDetail->biz_type))); ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<div class="control-group">
			<?php echo $form->label($modelClientInstDetail,'Persentase Kepemilikan Saham',array('class'=>'control-label')); ?>
			<div class="controls">
				&emsp;
				Lokal &nbsp;
				<?php echo $form->textField($modelClientInstDetail,'local_share_perc',array('class'=>'span3 tnumber','readonly'=>'readonly')); ?>
				&emsp;
				Asing &nbsp;
				<?php echo $form->textField($modelClientInstDetail,'foreign_share_perc',array('class'=>'span3 tnumber','readonly'=>'readonly')); ?>
			</div>
		</div>
	</div>
	<div class="span6">
		<?php echo $form->textFieldRow($modelCifDetail,'tax_id', array('class'=>'span8','readonly'=>'readonly','value'=>Parameter::getParamDesc('TAXCDC', $modelCifDetail->tax_id))); ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">	
		<?php echo $form->textFieldRow($modelCifDetail,'tempat_pendirian', array('class'=>'span8','readonly'=>'readonly')); ?>	
	</div>
	<div class="span6">
		<?php echo $form->textFieldRow($modelCifDetail,'client_birth_dt', array('class'=>'span8','readonly'=>'readonly','value'=>Tmanydetail::reformatDate($modelCifDetail->client_birth_dt))); ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">	
		<?php echo $form->textFieldRow($modelCifDetail,'act_first', array('class'=>'span8','readonly'=>'readonly')); ?>	
	</div>
	<div class="span6">
		<?php echo $form->textFieldRow($modelCifDetail,'act_first_dt', array('class'=>'span8','readonly'=>'readonly','value'=>Tmanydetail::reformatDate($modelCifDetail->act_first_dt))); ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">	
		<?php echo $form->textFieldRow($modelCifDetail,'act_last', array('class'=>'span8','readonly'=>'readonly')); ?>	
	</div>
	<div class="span6">
		<?php echo $form->textFieldRow($modelCifDetail,'act_last_dt', array('class'=>'span8','readonly'=>'readonly','value'=>Tmanydetail::reformatDate($modelCifDetail->act_last_dt))); ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">	
		<?php echo $form->textFieldRow($modelCifDetail,'npwp_no', array('class'=>'span8','readonly'=>'readonly')); ?>	
	</div>
	<div class="span6">
		<?php echo $form->textFieldRow($modelCifDetail,'npwp_date', array('class'=>'span8','readonly'=>'readonly','value'=>Tmanydetail::reformatDate($modelCifDetail->npwp_date))); ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">	
		<?php echo $form->textFieldRow($modelCifDetail,'skd_no', array('class'=>'span8','readonly'=>'readonly')); ?>	
	</div>
	<div class="span6">
		<?php echo $form->textFieldRow($modelCifDetail,'skd_expiry', array('class'=>'span8','readonly'=>'readonly','value'=>Tmanydetail::reformatDate($modelCifDetail->npwp_date))); ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span4">	
		<?php echo $form->textFieldRow($modelCifDetail,'siup_no',array('class'=>'span7','readonly'=>'readonly')); ?>
	</div>
	<div class="span3">
		<div class="span7">
			<?php echo $form->label($modelCifDetail,'siup_expiry_date',array('class'=>'control-label')); ?>
		</div>
		<?php echo $form->textField($modelCifDetail,'siup_expiry_date', array('class'=>'span5','readonly'=>'readonly','value'=>Tmanydetail::reformatDate($modelCifDetail->siup_expiry_date))); ?>
	</div>
	<div class="span5">
		<?php echo $form->textFieldRow($modelCifDetail,'siup_issued',array('class'=>'span7','readonly'=>'readonly')); ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span4">	
		<?php echo $form->textFieldRow($modelCifDetail,'tdp_no',array('class'=>'span7','readonly'=>'readonly')); ?>
	</div>
	<div class="span3">
		<div class="span7">
			<?php echo $form->label($modelCifDetail,'tdp_expiry_date',array('class'=>'control-label')); ?>
		</div>
		<?php echo $form->textField($modelCifDetail,'tdp_expiry_date', array('class'=>'span5','readonly'=>'readonly','value'=>Tmanydetail::reformatDate($modelCifDetail->tdp_expiry_date))); ?>
	</div>
	<div class="span5">
		<?php echo $form->textFieldRow($modelCifDetail,'tdp_issued',array('class'=>'span7','readonly'=>'readonly')); ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span4">	
		<?php echo $form->textFieldRow($modelCifDetail,'pma_no',array('class'=>'span7','readonly'=>'readonly')); ?>
	</div>
	<div class="span3">
		<div class="span7">
			<?php echo $form->label($modelCifDetail,'pma_expiry_date',array('class'=>'control-label')); ?>
		</div>
		<?php echo $form->textField($modelCifDetail,'pma_expiry_date', array('class'=>'span5','readonly'=>'readonly','value'=>Tmanydetail::reformatDate($modelCifDetail->pma_expiry_date))); ?>
	</div>
	<div class="span5">
		<?php echo $form->textFieldRow($modelCifDetail,'pma_issued',array('class'=>'span7','readonly'=>'readonly')); ?>
	</div>
</div>

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
		<?php echo $form->textFieldRow($modelClientInstDetail,'legal_domicile',array('class'=>'span8','readonly'=>'readonly')); ?>
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
			<?php echo $form->labelEx($modelClientInstDetail,'premise_stat',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($modelClientInstDetail,'premise_stat_text',array('class'=>'span4','readonly'=>'readonly')); ?>
			</div>
		</div>
	</div>	
	<div class="span6">
		<?php echo $form->textFieldRow($modelClientInstDetail,'premise_age',array('class'=>'span4','readonly'=>'readonly')); ?>
	</div>
</div>
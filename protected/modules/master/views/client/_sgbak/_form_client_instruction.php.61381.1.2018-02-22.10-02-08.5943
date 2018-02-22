<div class="row-fluid">
	<div class="span6">
		<?php echo $form->dropDownListRow($model,'trade_conf_send_to',Parameter::getCombo('TCTO', '-Choose-',null,null,'cd'),array('class'=>'span5')); ?>
	</div>
	<div class="span6">
		<?php echo $form->dropDownListRow($model,'trade_conf_send_freq',Parameter::getCombo('TCFREQ', '-Choose-',null,null,'cd'),array('class'=>'span5')); ?>
	</div>
</div>

<div class="row-fluid">
	<div class="control-group">
		<div class="span6">
			<?php //echo $form->label($modelClientindi,'fam_financial_company',array('class'=>'control-label')) ?>
			Apakah Nasabah atau Anggota Keluarga Bekerja di Perusahaan Keuangan Sejenis? <br/> Bila Ya, Sebutkan
		</div>
		<div class="controls">
			<div class="span2">
				<?php echo $form->radioButtonListInlineRow($modelClientindi,'fam_financial_company',array('Y'=>'ya','N'=>'tidak'),array('label'=>false)) ?>
			</div>
			<?php echo $form->textField($modelClientindi,'fam_financial_company_name',array('class'=>'span4','maxlength'=>30,'placeholder'=>'Fill Company Name Here')) ?>
			<?php echo $form->error($modelCif,'fam_financial_company_name', array('class'=>'help-inline error')); ?>
		</div>
	</div>
</div>

<br/>

<div class="row-fluid">
	<div class="control-group">
		<div class="span6">
			<?php //echo $form->label($modelClientindi,'fam_suspended_share',array('class'=>'control-label')) ?>
			Apakah Nasabah Memiliki Anggota Keluarga Seorang Karyawan Perusahaan Pengendalian, yang Memiliki Saham yang Dilarang? <br/> Bila Ya, Sebutkan
		</div>
		<div class="controls">
			<div class="span2">
				<?php echo $form->radioButtonListInlineRow($modelClientindi,'fam_suspended_share',array('Y'=>'ya','N'=>'tidak'),array('label'=>false)) ?>
			</div>
			<?php echo $form->textField($modelClientindi,'fam_suspended_share_name',array('class'=>'span4','maxlength'=>30,'placeholder'=>'Fill Share Name Here')) ?>
			<?php echo $form->error($modelClientindi,'fam_suspended_share_name', array('class'=>'help-inline error')); ?>
		</div>
	</div>
</div>

<br/>

<div class="row-fluid">
	<div class="control-group">
		<div class="span6">
			<?php //echo $form->label($modelClientindi,'other_broker_acc',array('class'=>'control-label')) ?>
			Apakah Nasabah Memiliki Rekening Efek Pada Perusahaan Lainnya? <br/> Bila Ya, Sebutkan
		</div>
		<div class="controls">
			<div class="span2">
				<?php echo $form->radioButtonListInlineRow($modelClientindi,'other_broker_acc',array('Y'=>'ya','N'=>'tidak'),array('label'=>false)) ?>
			</div>
			<?php echo $form->textField($modelClientindi,'other_broker_acc_name',array('class'=>'span4','maxlength'=>30,'placeholder'=>'Fill Company Name Here')) ?>
			<?php echo $form->error($modelClientindi,'other_broker_acc_name', array('class'=>'help-inline error')); ?>
		</div>
	</div>
</div>

<br/>

<div class="row-fluid">
	<div class="control-group">
		<div class="span6">
			<?php //echo $form->label($modelClientindi,'own_public_share',array('class'=>'control-label')) ?>
			Apakah Nasabah Memiliki 5% Saham Pada Perusahaan Publik? <br/> Bila Ya, Sebutkan 
		</div>
		<div class="controls">
			<div class="span2">
				<?php echo $form->radioButtonListInlineRow($modelClientindi,'own_public_share',array('Y'=>'ya','N'=>'tidak'),array('label'=>false)) ?>
			</div>
			<?php echo $form->textField($modelClientindi,'own_public_share_name',array('class'=>'span4','maxlength'=>30,'placeholder'=>'Fill Share Name Here')) ?>
			<?php echo $form->error($modelClientindi,'own_public_share_name', array('class'=>'help-inline error')); ?>
		</div>
	</div>
</div>

<script>
	$("#Clientindi_fam_financial_company").change(function(){
		if($("#Clientindi_fam_financial_company_0").is(':checked'))
			$('#Clientindi_fam_financial_company_name').show().attr('required','required');
		else 
			$('#Clientindi_fam_financial_company_name').hide().removeAttr('required');
	});
	$('#Clientindi_fam_financial_company').trigger('change');
	
	$("#Clientindi_fam_suspended_share").change(function(){
		if($("#Clientindi_fam_suspended_share_0").is(':checked'))
			$('#Clientindi_fam_suspended_share_name').show().attr('required','required');
		else 
			$('#Clientindi_fam_suspended_share_name').hide().removeAttr('required');
	});
	$('#Clientindi_fam_suspended_share').trigger('change');
	
	$("#Clientindi_other_broker_acc").change(function(){
		if($("#Clientindi_other_broker_acc_0").is(':checked'))
			$('#Clientindi_other_broker_acc_name').show().attr('required','required');
		else 
			$('#Clientindi_other_broker_acc_name').hide().removeAttr('required');
	});
	$('#Clientindi_other_broker_acc').trigger('change');
	
	$("#Clientindi_own_public_share").change(function(){
		if($("#Clientindi_own_public_share_0").is(':checked'))
			$('#Clientindi_own_public_share_name').show().attr('required','required');
		else 
			$('#Clientindi_own_public_share_name').hide().removeAttr('required');
	});
	$('#Clientindi_own_public_share').trigger('change');
</script>
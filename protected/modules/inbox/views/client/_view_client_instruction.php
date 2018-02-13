<?php if($modelClientDetail): ?>
<div class="row-fluid">
	<div class="span6">
		<?php echo $form->textFieldRow($modelClientDetail,'trade_conf_send_to',array('class'=>'span5','readonly'=>'readonly','value'=>Parameter::getParamDesc('TCTO', $modelClientDetail->trade_conf_send_to))); ?>
	</div>
	<div class="span6">
		<?php echo $form->textFieldRow($modelClientDetail,'trade_conf_send_freq',array('class'=>'span5','readonly'=>'readonly','value'=>Parameter::getParamDesc('TCFREQ', $modelClientDetail->trade_conf_send_freq))); ?>
	</div>
</div>
<?php endif; ?>

<div class="row-fluid">
	<div class="span6">
		Perusahaan Keuangan Sejenis Tempat Nasabah / Anggota Keluarga Bekerja
	</div>
	<?php echo $form->textField($modelClientIndiDetail,'fam_financial_company_name',array('class'=>'span3','readonly'=>'readonly')) ?>
</div>

<br/>

<div class="row-fluid">
	<div class="span6">
		Kepemilikan Anggota Keluarga Nasabah Atas Saham yang Dilarang
	</div>
	<?php echo $form->textField($modelClientIndiDetail,'fam_suspended_share_name',array('class'=>'span3','readonly'=>'readonly')) ?>
</div>

<br/>

<div class="row-fluid">
	<div class="span6">
		Perusahaan Lain Tempat Nasabah Mempunyai Rekening Efek
	</div>
	<?php echo $form->textField($modelClientIndiDetail,'other_broker_acc_name',array('class'=>'span3','readonly'=>'readonly')) ?>
</div>

<br/>

<div class="row-fluid">
	<div class="span6">
		Nama Saham yang Dimiliki Nasabah Pada Perusahaan Publik (5%)
	</div>
	<?php echo $form->textField($modelClientIndiDetail,'own_public_share_name',array('class'=>'span3','readonly'=>'readonly')) ?>
</div>
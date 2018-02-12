<style>
	.checkBox
	{
		width:30px !important;
	}
</style>

<div class="row-fluid">
	<div class="span6">
		<?php echo $form->textFieldRow($modelCifDetail,'annual_income_cd',array('class'=>'span8','readonly'=>'readonly','value'=>Parameter::getParamDesc('INCOME', $modelCifDetail->annual_income_cd))); ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<div class="control-group">
			<?php echo $form->labelEx($modelCifDetail,'funds_code',array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->textField($modelCifDetail,'source_of_funds',array('class'=>'span8','readonly'=>'readonly')); ?>
			</div>
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<?php echo $form->textFieldRow($modelCifDetail,'addl_fund_cd',array('class'=>'span8','readonly'=>'readonly','value'=>trim($modelCifDetail->addl_fund_cd)!='N'?Parameter::getParamDesc('INCOME', $modelCifDetail->addl_fund_cd):'TIDAK ADA')); ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<div class="control-group">
			<?php echo $form->labelEx($modelCifDetail,'source_addl_fund_cd',array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->textField($modelCifDetail,'source_addl_fund',array('class'=>'span8','readonly'=>'readonly')); ?>
			</div>
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<?php echo $form->textFieldRow($modelCifDetail,'expense_amount_cd',array('class'=>'span8','readonly'=>'readonly','value'=>Parameter::getParamDesc('EXPNSE', $modelCifDetail->expense_amount_cd))); ?>
	</div>
</div>

<div class="row-fluid">
	<div class="control-group">
		<?php echo $form->labelEx($modelCifDetail,'Purpose of Investment',array('class'=>'control-label')) ?>
		<div class="controls">
			Keuntungan
			<?php echo $form->textField($modelCifDetail,'purpose01',array('class' => 'span1 checkBox', 'readonly'=>'readonly','value'=>$modelCifDetail->purpose01=='00'?'N':'Y')); ?>
			&emsp;
			Apresiasi Harga
			<?php echo $form->textField($modelCifDetail,'purpose02',array('class' => 'span1 checkBox', 'readonly'=>'readonly','value'=>$modelCifDetail->purpose02=='00'?'N':'Y')); ?>
			&emsp;
			Investasi Jangka Panjang
			<?php echo $form->textField($modelCifDetail,'purpose03',array('class' => 'span1 checkBox', 'readonly'=>'readonly','value'=>$modelCifDetail->purpose03=='00'?'N':'Y')); ?>
			&emsp;
			Spekulasi
			<?php echo $form->textField($modelCifDetail,'purpose04',array('class' => 'span1 checkBox', 'readonly'=>'readonly','value'=>$modelCifDetail->purpose04=='00'?'N':'Y')); ?>
			<br/>
			
			Pendapatan
			<?php echo $form->textField($modelCifDetail,'purpose05',array('class' => 'span1 checkBox', 'readonly'=>'readonly','value'=>$modelCifDetail->purpose05=='00'?'N':'Y')); ?>
			&emsp;
			Lainnya
			<?php echo $form->textField($modelCifDetail,'purpose_lainnya',array('class' => 'span3', 'readonly'=>'readonly')); ?>
		</div>
	</div>
</div>

<br/>

<?php echo $form->textFieldRow($modelCifDetail,'invesment_period',array('class'=>'span4','readonly'=>'readonly')); ?>

<?php echo $form->textFieldRow($modelCifDetail,'net_asset_cd',array('class' => 'span4', 'readonly'=>'readonly','value'=>Parameter::getParamDesc('IASSET', $modelCifDetail->net_asset_cd))); ?>
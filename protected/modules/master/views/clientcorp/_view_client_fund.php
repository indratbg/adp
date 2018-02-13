<style>
	.checkBox
	{
		width:30px !important;
	}
</style>

<div class="row-fluid">
	<div class="span6">
		<?php echo $form->textFieldRow($modelCifDetail,'modal_dasar',array('class'=>'span8','readonly'=>'readonly')); ?>
	</div>
	<div class="span6">
		<?php echo $form->textFieldRow($modelCifDetail,'modal_disetor',array('class'=>'span8','readonly'=>'readonly')); ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<div class="control-group">
			<?php echo $form->label($modelCifDetail,'funds_code',array('class'=>'control-label')) ?>
			<div class="controls">		
				<?php echo $form->textField($modelCifDetail,'source_of_funds',array('class'=>'span8','readonly'=>'readonly')); ?>
			</div>
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<div class="control-group">
			<?php echo $form->label($modelCifDetail,'net_asset_cd',array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->textField($modelCifDetail,'net_asset',array('class'=>'span8','readonly'=>'readonly')); ?>
			</div>
		</div>
	</div>
	<div class="span6">
		<div class="control-group">
			<?php echo $form->label($modelCifDetail,'profit_cd',array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->textField($modelCifDetail,'profit', array('class'=>'span4','readonly'=>'readonly')); ?>
				&emsp;&emsp;Year&emsp;
				<?php echo $form->textField($modelCifDetail,'net_asset_yr',array('class'=>'span2','readonly'=>'readonly')); ?>
			</div>
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<div class="control-group">
			<?php echo $form->label($modelClientInstDetail,'net_asset_cd2',array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->textField($modelClientInstDetail,'net_asset2',array('class'=>'span8','readonly'=>'readonly')); ?>
			</div>
		</div>
	</div>
	<div class="span6">
		<div class="control-group">
			<?php echo $form->label($modelClientInstDetail,'profit_cd2',array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->textField($modelClientInstDetail,'profit2', array('class'=>'span4','readonly'=>'readonly')); ?>
				&emsp;&emsp;Year&emsp;
				<?php echo $form->textField($modelClientInstDetail,'net_asset_yr2',array('class'=>'span2','readonly'=>'readonly')); ?>
			</div>
		</div>
	</div>
</div>
<div class="row-fluid">
	<div class="span6">
		<div class="control-group">
			<?php echo $form->label($modelClientInstDetail,'net_asset_cd3',array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->textField($modelClientInstDetail,'net_asset3',array('class'=>'span8','readonly'=>'readonly')); ?>
			</div>
		</div>
	</div>
	<div class="span6">
		<div class="control-group">
			<?php echo $form->label($modelClientInstDetail,'profit_cd3',array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->textField($modelClientInstDetail,'profit3', array('class'=>'span4','readonly'=>'readonly')); ?>
				&emsp;&emsp;Year&emsp;
				<?php echo $form->textField($modelClientInstDetail,'net_asset_yr3',array('class'=>'span2','readonly'=>'readonly')); ?>
			</div>
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<div class="control-group">
			<?php echo $form->label($modelCifDetail,'profit_cd',array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->textField($modelCifDetail,'profit',array('class'=>'span8','readonly'=>'readonly')); ?>
			</div>
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<?php echo $form->textFieldRow($modelClientInstDetail,'net_profit_text',array('class'=>'span8','readonly'=>'readonly')); ?>
	</div>
	<div class="span6">
		<?php echo $form->textFieldRow($modelClientInstDetail,'non_opr_incm_text',array('class'=>'span8','readonly'=>'readonly')); ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<?php echo $form->textFieldRow($modelClientInstDetail,'liability',array('class'=>'span8','readonly'=>'readonly')); ?>
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

<div class="row-fluid">
	<div class="span9">
		<?php echo $form->textFieldRow($modelCifDetail,'invesment_period',array('class'=>'span4','readonly'=>'readonly')); ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<div class="control-group">
			<?php echo $form->label($modelClientInstDetail,'investment_type',array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->textField($modelClientInstDetail,'investment_type_text',array('class'=>'span5','readonly'=>'readonly')); ?>
			</div>
		</div>
	</div>
	<div class="span6">
		<?php echo $form->textFieldRow($modelClientInstDetail,'transaction_freq',array('class'=>'span8','readonly'=>'readonly','value'=>Parameter::getParamDesc('TRXFRQ',$modelClientInstDetail->transaction_freq))); ?>
	</div>
</div>
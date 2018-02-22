<style>
	.checkBox
	{
		width:30px !important;
	}
</style>

<div class="row-fluid">
	<?php echo $form->textFieldRow($modelClientDetail,'recommended_by_other',array('class'=>'span3','readonly'=>'readonly')) ?>
</div>

<?php echo $form->textFieldRow($modelClientDetail,'transaction_limit',array('class'=>'span3 tnumber','readonly'=>'readonly','value'=>AFormatter::formatNumberNonDec($modelClientDetail->transaction_limit))) ?>

<div class="row-fluid">
	<div class="control-group">
		<?php echo $form->label($modelClientDetail,'Commission',array('class'=>'control-label')); ?>
		<div class="controls">
			Buy
			&emsp;
			<?php echo $form->textField($modelClientDetail,'commission_per_buy',array('class'=>'span2 tnumber','readonly'=>'readonly','value'=>$curr?$modelClientDetail->commission_per_buy/100:(substr($modelClientDetail->commission_per_buy,0,1)==='0'?$modelClientDetail->commission_per_buy:'0'.$modelClientDetail->commission_per_buy))); ?>
			&emsp;&emsp;	
			Sell
			&emsp;	
			<?php echo $form->textField($modelClientDetail,'commission_per_sell',array('class'=>'span2 tnumber','readonly'=>'readonly','value'=>$curr?$modelClientDetail->commission_per_sell/100:(substr($modelClientDetail->commission_per_sell,0,1)==='0'?$modelClientDetail->commission_per_sell:'0'.$modelClientDetail->commission_per_sell))); ?>
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="control-group">
		<?php echo $form->label($modelClientDetail,'Initial Deposit',array('class'=>'control-label')); ?>
		<div class="controls">
			<div class="span1" style="width:70px">
				Dana &emsp;
			</div>
			<div class="danaDetail span9"/>
				<?php echo $form->textField($modelClientDetail,'init_deposit_amount',array('class'=>'span4 tnumber','readonly'=>'readonly','value'=>AFormatter::formatNumberNonDec($modelClientDetail->init_deposit_amount))) ?>
			</div>
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->label($modelClientDetail,'',array('class'=>'control-label')); ?>
		<div class="controls">
			<div class="span1" style="width:70px">
				Efek &emsp;
			</div>
			<div class="efekDetail span9"/>
				<?php echo $form->textField($modelClientDetail,'init_deposit_efek',array('class'=>'span3','readonly'=>'readonly')) ?>
				&emsp;
				Price
				<?php echo $form->textField($modelClientDetail,'init_deposit_efek_price',array('class'=>'span4 tnumber','readonly'=>'readonly','value'=>AFormatter::formatNumberNonDec($modelClientDetail->init_deposit_efek_price))) ?>
				&emsp;
				Date
				<?php echo $form->textField($modelClientDetail,'init_deposit_efek_date',array('class'=>'tdate span3','readonly'=>'readonly','value'=>Tmanydetail::reformatDate($modelClientDetail->init_deposit_efek_date))); ?>
			</div>
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="control-group">
		<?php echo $form->label($modelClientDetail,'Kelengkapan Data',array('class'=>'control-label')); ?>
		<div class="controls">
			Fotocopy KTP
			<?php echo $form->textField($modelClientDetail,'id_copy_flg',array('class' => 'span1 checkBox', 'readonly'=>'readonly')); ?>
			&emsp;
			Fotocopy NPWP
			<?php echo $form->textField($modelClientDetail,'npwp_copy_flg',array('class' => 'span1 checkBox', 'readonly'=>'readonly')); ?>
			&emsp;
			Rekening Koran / Surat Kuasa
			<?php echo $form->textField($modelClientDetail,'koran_copy_flg',array('class' => 'span1 checkBox', 'readonly'=>'readonly')); ?>
			&emsp;
			Other
			<?php echo $form->textField($modelClientDetail,'copy_other',array('class'=>'span3', 'readonly'=>'readonly')) ?>
		</div>
	</div>
</div>
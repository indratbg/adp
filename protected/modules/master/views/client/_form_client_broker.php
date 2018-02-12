<div class="row-fluid">
	<div class="control-group">
		<?php echo $form->label($model,'recommended_by_cd',array('class'=>'control-label')); ?>
		<div class="controls">
 			<?php echo $form->dropDownList($model,'recommended_by_cd',Parameter::getCombo('RECBY', '-Choose Recommender-',null,null,'cd'),array('class'=>'span3')); ?>
 			<?php echo $form->textField($model,'recommended_by_other',array('class'=>'span4','maxlength'=>30,'placeholder'=>'Fill Recommender Here')) ?>
 			<?php echo $form->error($model,'recommended_by_other', array('class'=>'help-inline error')); ?>
		</div>
	</div>
</div>

<?php echo $form->textFieldRow($model,'transaction_limit',array('class'=>'span3 tnumber','maxlength'=>21)) ?>

<div class="row-fluid">
	<div class="control-group">
		<?php echo $form->label($model,'Commission',array('class'=>'control-label')); ?>
		<div class="controls">
			Buy
			&emsp;
			<?php echo $form->textField($model,'commission_per_buy',array('class'=>'span2 tnumber')); ?>
			<?php echo $form->error($model,'commission_per_buy', array('class'=>'help-inline error')); ?>
			&emsp;&emsp;	
			Sell
			&emsp;	
			<?php echo $form->textField($model,'commission_per_sell',array('class'=>'span2 tnumber')); ?>
			<?php echo $form->error($model,'commission_per_sell', array('class'=>'help-inline error')); ?>	
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="control-group">
		<?php echo $form->label($model,'Initial Deposit',array('class'=>'control-label')); ?>
		<div class="controls">
			<div class="span1" style="width:70px">
				<input type="checkBox" id="dana" name="dana" value="<?php echo AConstant::INIT_DEPOSIT_CD_DANA ?>" <?php if($init_deposit_cd['dana'] == 'D')echo 'checked' ?>/> Dana &emsp;
			</div>
			<div class="danaDetail span3"/>
				<?php echo $form->textField($model,'init_deposit_amount',array('class'=>'span10 tnumber','maxlength'=>21,'placeholder'=>'Fill Amount Here')) ?>
				<?php echo $form->error($model,'init_deposit_amount', array('class'=>'help-inline error')); ?>
			</div>
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->label($model,'',array('class'=>'control-label')); ?>
		<div class="controls">
			<div class="span1" style="width:70px">
				<input type="checkBox" id="efek" name="efek" value="<?php echo AConstant::INIT_DEPOSIT_CD_EFEK ?>" <?php if($init_deposit_cd['efek'] == 'E')echo 'checked' ?>/> Efek &emsp;
			</div>
			<div class="efekDetail span9"/>
				<?php echo $form->textField($model,'init_deposit_efek',array('class'=>'span3','maxlength'=>20,'placeholder'=>'Fill Efek Name Here')) ?>
				<?php echo $form->error($model,'init_deposit_efek', array('class'=>'help-inline error')); ?>
				&emsp;
				Price
				<?php echo $form->textField($model,'init_deposit_efek_price',array('class'=>'span4 tnumber','maxlength'=>21)) ?>
				<?php echo $form->error($model,'init_deposit_efek_price', array('class'=>'help-inline error')); ?>
				&emsp;
				Date
				<?php echo $form->textField($model,'init_deposit_efek_date',array('class'=>'tdate span3','placeholder'=>'dd/mm/yyyy')); ?>
			</div>
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="control-group">
		<?php echo $form->label($model,'Kelengkapan Data',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->checkBox($model,'id_copy_flg',array('value' => 'Y', 'uncheckValue'=>'N')); ?>
			Fotocopy KTP
			&emsp;
			<?php echo $form->checkBox($model,'npwp_copy_flg',array('value' => 'Y', 'uncheckValue'=>'N')); ?>
			Fotocopy NPWP
			&emsp;
			<?php echo $form->checkBox($model,'koran_copy_flg',array('value' => 'Y', 'uncheckValue'=>'N')); ?>
			Rekening Koran / Surat Kuasa
			&emsp;
			<?php echo $form->checkBox($model,'copy_other_flg',array('value' => 'Y', 'uncheckValue'=>'N')); ?>
			Other
			<?php echo $form->textField($model,'copy_other',array('class'=>'span3','maxlength'=>30,'placeholder'=>'Fill Document Here')) ?>
			<?php echo $form->error($model,'copy_other', array('class'=>'help-inline error')); ?>
		</div>
	</div>
</div>

<script>
	$("#Client_recommended_by_cd").change(function(){
		if($("#Client_recommended_by_cd").val() == 9)
			$('#Client_recommended_by_other').show().attr('required','required');
		else 
			$('#Client_recommended_by_other').hide().removeAttr('required');
	});
	$('#Client_recommended_by_cd').trigger('change');
	
	$("#dana").change(function(){
		if($("#dana").is(':checked'))
		{
			$('.danaDetail').show();
			$('#Client_init_deposit_amount').attr('required','required');
		}
		else
		{
			$('.danaDetail').hide();
			$('#Client_init_deposit_amount').removeAttr('required');
		}
	});
	$("#dana").trigger('change');
	
	$("#efek").change(function(){
		if($("#efek").is(':checked'))
		{	
			$('.efekDetail').show();
			$('#Client_init_deposit_efek').attr('required','required');
			$('#Client_init_deposit_efek_price').attr('required','required');
			$('#Client_init_deposit_efek_date').attr('required','required'); 
		}
		else
		{
			$('.efekDetail').hide();
			$('#Client_init_deposit_efek').removeAttr('required');
			$('#Client_init_deposit_efek_price').removeAttr('required');
			$('#Client_init_deposit_efek_date').removeAttr('required');
		}	
	});
	$("#efek").trigger('change');
	
	$("#Client_copy_other_flg").change(function(){
		if($("#Client_copy_other_flg").is(':checked'))
			$('#Client_copy_other').show().attr('required','required');
		else 
			$('#Client_copy_other').hide().removeAttr('required');
	});
	$('#Client_copy_other_flg').trigger('change');
	
	$("#Client_init_deposit_efek_date").datepicker({format : "dd/mm/yyyy"});
	
	$("#Client_commission_per_buy").mask("0.?999999");
	$("#Client_commission_per_sell").mask("0.?999999");
</script>

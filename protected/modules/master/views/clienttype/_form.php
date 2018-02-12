<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'clienttype-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->dropDownListRow($model, 'cl_type1', Constanta::$client_type1,array('class'=>'span4'));?>

	<?php echo $form->dropDownListRow($model, 'cl_type2', Constanta::$client_type2,array('class'=>'span4')); ?>

	<?php echo $form->dropDownListRow($model, 'cl_type3', Constanta::$client_type3,array('class'=>'span4')); ?>

	<?php echo $form->textFieldRow($model,'type_desc',array('class'=>'span4','maxlength'=>255)); ?>
	<?php echo $form->textFieldRow($model,'os_p_acct_cd',array('class'=>'span4','maxlength'=>12)); ?>
	<?php echo $form->textFieldRow($model,'os_s_acct_cd',array('class'=>'span4','maxlength'=>12)); ?>

	<?php echo $form->textFieldRow($model,'os_contra_g_acct_cd',array('class'=>'span4','maxlength'=>12)); ?>

	<?php echo $form->textFieldRow($model,'os_contra_l_acct_cd',array('class'=>'span4','maxlength'=>12)); ?>



	<?php //echo $form->textFieldRow($model,'dup_contract',array('class'=>'span5','maxlength'=>1)); ?>

	<?php //echo $form->textFieldRow($model,'avg_contract',array('class'=>'span5','maxlength'=>1)); ?>

	<?php //echo $form->textFieldRow($model,'nett_allow',array('class'=>'span5','maxlength'=>1)); ?>

	<?php //echo $form->textFieldRow($model,'rebate_pct',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'comm_pct',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'user_id',array('class'=>'span5','maxlength'=>10)); ?>

	<?php //echo $form->datePickerRow($model,'cre_dt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate','options'=>array('format' => 'dd/mm/yyyy'))); ?>

	<?php //echo $form->datePickerRow($model,'upd_dt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate','options'=>array('format' => 'dd/mm/yyyy'))); ?>

	

	
	<?php //echo $form->textFieldRow($model,'os_setoff_g_acct_cd',array('class'=>'span5','maxlength'=>12)); ?>

	<?php //echo $form->textFieldRow($model,'os_setoff_l_acct_cd',array('class'=>'span5','maxlength'=>12)); ?>

	<?php //echo $form->textFieldRow($model,'int_on_payable',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'int_on_receivable',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'int_on_pay_chrg_cd',array('class'=>'span5','maxlength'=>5)); ?>

	<?php //echo $form->textFieldRow($model,'int_on_rec_chrg_cd',array('class'=>'span5','maxlength'=>5)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>


<script>
		$('#Clienttype_cl_type1, #Clienttype_cl_type2, #Clienttype_cl_type3, #Clienttype_cl_desc').change(function(){
			
			
			
		if($('#Clienttype_cl_type1').val() !='' && $('#Clienttype_cl_type2').val() !='' && $('#Clienttype_cl_type3').val() !='' ){
				$('#Clienttype_type_desc').val($('#Clienttype_cl_type1').val()+ $('#Clienttype_cl_type2').val()+ $('#Clienttype_cl_type3').val());
		}
		
	});
	
	
//	$('#Clienttype_os_p_acct_cd, #Clienttype_os_s_acct_cd, #Clienttype_os_contra_g_acct_cd, #Clienttype_os_contra_l_acct_cd').change(function(){
	
	//cekGL_A();
	
	
// });

function cekGL_A(){
	var gl_acct_buy = $('#Clienttype_os_p_acct_cd').val();
	var gl_acct_sell = $('#Clienttype_os_s_acct_cd').val();
	var gl_acct_saldo_kredit = $('#Clienttype_os_contra_g_acct_cd').val();
	var gl_acct_saldo_debit = $(' #Clienttype_os_contra_l_acct_cd').val();
	
	$.ajax({
	    		'type'     :'POST',
	    		'url'      : '<?php echo $this->createUrl('CekGL'); ?>',
				'dataType' : 'json',
				'data'     : {'acct_buy' : gl_acct_buy,
								'acct_sell' : gl_acct_sell,
								'acct_kredit' : gl_acct_saldo_kredit,
								'acct_debit' : gl_acct_saldo_debit
							  
							},
				'success'  : function(data){
						var acct = data.cek;
						if (acct =='fail'){
							alert('Tidak Boleh');
						}
						
						
				}
			});
			
	
	
}
</script>

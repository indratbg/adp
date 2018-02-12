<!--<style>
	.help-inline.error{display: none;}
	.radio.inline label{margin-left: 15px;}
	.well { padding: 2px; margin: 0px 0px 5px 0px; text-align: center;}
	.table-compact{ padding: 0px; }
	.table-compact tr td{ padding: 0px; } 
</style>-->
<!--<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'client-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>-->

<style>
	#tabMenu ul
	{
		border-top:2px solid #ddd;
		border-bottom:2px solid #ddd;
		border-left:2px solid #ddd;
		border-radius:5px;
	}	
	#tabMenu li
	{
		border-right:1px solid #ddd;
		border-radius:5px;
	}
	#tabMenu li:not(:first-child)
	{
		border-left:1px solid #ddd;
		border-radius:5px;
	}
	
	.markCancel
	{
		background-color:#BB0000;
	}
	
	/*#tabMenu  li:not(.active)*/
</style>

<?php
	$cityList = City::model()->findAll(array('condition'=>"city_cd <> 999",'order'=>'city'));
	$cityList = array_merge($cityList,City::model()->findAll(array('condition'=>'city_cd = 999')));
	
	$highRiskCountry = Highriskname::model()->findAll("kategori = 'COUNTRY' AND approved_stat = 'A'");
	$highRiskBiz = Highriskname::model()->findAll("kategori = 'BUSINESS' AND approved_stat = 'A'");
?>

	<!--<p class="help-block">Fields with <span class="required">*</span> are required.</p>-->
	
	<input type="hidden" name="Client[copy_client]" value="<?php //echo $model->copy_client ?>" />

	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<?php echo $form->label($model,'client_cd',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php if($model->isNewRecord): ?>
					<div class="span6" style="margin-left:-30px;">
						<?php echo $form->radioButtonListInlineRow($model, 'client_code_opt', AConstant::$client_code_opt,array('label'=>false)); ?>
					</div>
					<?php endif; ?>
					<?php echo $form->textField($model,'client_cd',array('class'=>'span3','readonly'=>!$model->isNewRecord?'readonly':'','maxlength'=>12,'placeholder'=>'Fill Client Code','style'=>$model->isNewRecord?"width:100px;margin-left:-5px;":"width:100px")); ?>
					<?php echo $form->error($model,'client_cd', array('class'=>'help-inline error')); ?>
				</div>
			</div>
		</div>
		<div class="span6">
			<?php echo $form->textFieldRow($modelCif,'cifs',array('readonly'=>'readonly','value'=>$modelCif->cifs?$modelCif->cifs:'NEW','class'=>'span3','style'=>"width:100px")); ?>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<?php echo $form->labelEx($model,'client_name',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo $form->textField($model,'client_name',array('class'=>'span8','maxlength'=>50)); ?>
				</div>
			</div>
		</div>
		<div class="span6">
			<?php echo $form->dropDownListRow($model,'client_class',CHtml::listData(Parameter::model()->findAll(array('condition'=>"prm_cd_1 = 'CLASS'",'order'=>'prm_cd_2')), 'prm_cd_2', 'prm_desc'),array('class'=>'span8')); ?>
		</div>
	</div>	
	
	<div class="row-fluid">	
		<div class="span6">
			<?php echo $form->dropDownListRow($model,'client_type_3',Chtml::listData(Lsttype3::model()->findAll(array('condition'=>!$modelCif->cifs||$modelCif->cifs == 'NEW'?"cl_type3 NOT IN ('M','L')":'','order'=>'cl_type3')),'cl_type3', 'cl_desc'),array('class'=>'span8')); ?>
		</div>
		<div class="span6">
			<?php echo $form->textFieldRow($model,'contact_pers',array('class'=>'span8','maxlength'=>40)); ?>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->datePickerRow($model,'acct_open_dt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
		</div>
		<div class="span6">
			<?php echo $form->textFieldRow($model,'old_ic_num',array('class'=>'span4','maxlength'=>12)); ?>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->dropDownListRow($model,'branch_code',Chtml::listData(Branch::model()->findAll(array('condition'=>"approved_stat <> 'C'",'order'=>'brch_cd')),'brch_cd', 'brch_name'),array('class'=>'span8','prompt'=>'-Choose Branch-')); ?>		
			<input type="hidden" id="branch_hid" value="<?php echo $model->old_branch_code ?>" />
			<input type="hidden" id="branch_change_flg" name="Client[branch_change_flg]" value="0" />
		</div>
		<div class="span6">
			<?php echo $form->dropDownListRow($model,'rem_cd',Chtml::listData(Sales::model()->findAll(array('condition'=>"approved_stat <> 'C' AND rem_susp_stat = 'N'",'order'=>'rem_cd')),'rem_cd', 'CodeAndName'),array('class'=>'span8','prompt'=>'-Choose Sales-')); ?>	
			<input type="hidden" id="rem_hid" value="<?php echo $model->old_rem_cd ?>" />
			<input type="hidden" id="rem_change_flg" name="Client[rem_change_flg]" value="0" />
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span6">
			<div class="span9">
				<div class="control-group">
					<?php echo $form->labelEx($model,'commission_per',array('class'=>'control-label')); ?>
					<div class="controls">
						<?php echo $form->textField($model,'commission_per',array('class'=>'span6 tnumber','readonly'=>$model->client_type_1=='H'?'readonly':false)); ?>
						<?php echo $form->error($model,'commission_per', array('class'=>'help-inline error')); ?>	
					</div>
				</div>
			</div>
			OLT&nbsp;
			<?php echo $form->dropDownList($model,'olt',Parameter::getCombo('OLTFLG', ''),array('class'=>'span2')) ?> 		
		</div>
		<div class="span6">
			<div class="control-group">
				<?php echo $form->labelEx($model,'subrek001_1',array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->textField($model,'subrek001_1',array('class'=>'span2','maxlength'=>4)); ?>
					001
					<?php echo $form->textField($model,'subrek001_2',array('class'=>'span1','maxlength'=>2, 'style'=>'width:30px')); ?>
					/
					<?php echo $form->textField($model,'subrek004_1',array('class'=>'span2','maxlength'=>4)); ?>
					004
					<?php echo $form->textField($model,'subrek004_2',array('class'=>'span1','maxlength'=>2, 'style'=>'width:30px')); ?>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span6">
			<div class="span9">
				<div class="control-group">
					<?php echo $form->labelEx($model,'rebate',array('class'=>'control-label')); ?>
					<div class="controls">
						<?php echo $form->textField($model,'rebate',array('class'=>'span6 tnumber')); ?>
						<?php echo $form->error($model,'rebate', array('class'=>'help-inline error')); ?>	
					</div>
				</div>
			</div>	
		</div>
	</div>
	
	<!--
	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<?php echo $form->label($model,'client type:',array('class'=>'control-label')); ?>
				<div class="controls">
					<div class="span2">
						<?php echo $form->label($model,'client_type_2',array('class'=>'control-label')); ?>
					</div>
					<?php echo $form->dropDownList($model,'client_type_2',Chtml::listData(Lsttype2::model()->findAll(),'cl_type2', 'cl_desc'),array('class'=>'span7')); ?>
				</div>
			</div>
		</div>
		<div class="span6">
			<?php echo $form->dropDownListRow($model,'client_type_3',Chtml::listData(Lsttype3::model()->findAll(),'cl_type3', 'cl_desc'),array('class'=>'span8')); ?>
		</div>
	</div>
	-->
	
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->dropDownListRow($model,'rebate_basis',array('DM' => 'alamat surat = alamat domisili', 'SU' => 'alamat surat beda dr lainnya')); ?>
		</div>
		<div class="span6">
			<div class="control-group">
				<?php echo $form->label($model,'stop_pay',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo $form->dropDownList($model,'stop_pay',array('Y'=>'Yes','N'=>'No'),array('class'=>'span2'/*,'disabled'=>$model->cif_opt==Client::CIF_OPTION_NEW?'disabled':''*/)); ?>
					<?php echo $form->textField($model,'e_mail1',array('class'=>'span7 email','maxlength'=>50,'placeholder'=>'Email Address')); ?>
					<?php echo $form->error($model,'e_mail1', array('class'=>'help-inline error')); ?>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->labelEx($model,'def_addr_1',array('class'=>'control-label'));?>
			<?php echo $form->textFieldRow($model,'def_addr_1',array('class'=>'span8','label'=>false)); ?>
			<?php echo $form->label($model,'&nbsp',array('class'=>'control-label'));?>
			<?php echo $form->textFieldRow($model,'def_addr_2',array('class'=>'span8','label'=>false)); ?>
			<?php echo $form->label($model,'&nbsp',array('class'=>'control-label'));?>
			<?php echo $form->textFieldRow($model,'def_addr_3',array('class'=>'span8','label'=>false)); ?>
			<?php echo $form->textFieldRow($model,'post_cd',array('class'=>'span3','maxlength'=>6)); ?>
		</div>
		<div class="span6">
			<?php echo $form->dropDownListRow($model,'def_city',Chtml::listData($cityList,'city','city'),array('class'=>'span8','prompt'=>'-Choose City-')); ?>
			<?php echo $form->dropDownListRow($model, 'print_flg', AConstant::$client_print_flg); ?>
			
			<?php echo $form->dropDownListRow($model,'custodian_cd',Parameter::getCombo('CUSTO','-Choose Custodian-'),array('class'=>'span8')); ?>

			<?php echo $form->checkBox($model,'cust_client_flg',array('value' => 'A', 'uncheckValue'=>'Y')); ?>
			Afiliasi
			&nbsp&nbsp
			
			<div class="minFee" style="display:<?php if($minimumFeeFlg->dflg1 == 'Y')echo 'inline';else echo 'none' ?>">
				<?php echo $form->checkBox($model,'internet_client',array('value' => 'Y', 'uncheckValue'=>'N')); ?>
				Minimum Fee
				&nbsp&nbsp
			</div>
			
			<div class="withholdingTax" style="display:<?php if($withholdingTaxFlg->dflg1 == 'Y')echo 'inline';else echo 'none' ?>">
				<?php echo $form->checkBox($model,'desp_pref',array('value' => 'Y', 'uncheckValue'=>'A')); ?>
				Withholding tax
				&nbsp&nbsp
			</div>
			
			<div class="taxOnInterest" style="display:<?php if(0/*$taxOnInterestFlg->dflg1 == 'Y'*/)echo 'inline';else echo 'none' ?>">
				<?php echo $form->checkBox($model,'tax_on_interest',array('value' => 'Y', 'uncheckValue'=>'N')); ?>
				Tax On Interest
				&nbsp&nbsp
			</div>
			
			<div class="acopenFee" style="display:<?php if($acopenFeeFlg->dflg1 == 'Y')echo 'inline';else echo 'none' ?>">
				<?php echo $form->checkBox($model,'acopen_fee_flg',array('value' => 'Y', 'uncheckValue'=>'N')); ?>
				OTC
				&nbsp&nbsp
			</div>
						
			<div class="pphApplFlg" style="display:<?php if($pphFlg->dflg1 == 'Y')echo 'inline';else echo 'none' ?>">
				<?php echo $form->checkBox($model,'pph_appl_flg',array('value' => 'Y', 'uncheckValue'=>'N')); ?>
				PPH
			</div>
		</div>
	</div>

	<br/>
	

	<?php
		$tabs;

		$tabs = array(
			array(
	                'label'   => 'Corporate Information',
	                'content' =>  $this->renderPartial('_form_client_corp',array('model'=>$model,'supplRequired'=>$supplRequired,'modelClientinst'=>$modelClientinst,'modelCif'=>$modelCif,'form'=>$form),true,false),
	                'active'  => true
	            ),
             array(
	                'label'   => 'Authorized Persons',
	                'content' =>  $this->renderPartial('_form_client_authorized',array('model'=>$model,'modelClientinst'=>$modelClientinst,'modelCif'=>$modelCif,'modelClientAutho'=>$modelClientAutho,'cancel_reason_autho'=>$cancel_reason_autho,'form'=>$form),true,false),
	                'active'  => false
	            ),
			array(
					'label' => 'Fund',
					'content' => $this->renderPartial('_form_client_fund',array('model'=>$model,'modelClientinst'=>$modelClientinst,'modelCif'=>$modelCif,'form'=>$form),true,false),
					'active' => false
			),
			array(
					'label' => 'Bank',
					'content' => $this->renderPartial('_form_client_bank',array('model'=>$model,'modelClientinst'=>$modelClientinst,'modelCif'=>$modelCif,'modelClientBank'=>$modelClientBank,'cancel_reason'=>$cancel_reason,'form'=>$form),true,false),
					'active' => false
			),
			array(
					'label' => 'Instruction and Information',
					'content' => $this->renderPartial('_form_client_instruction',array('model'=>$model,'modelClientinst'=>$modelClientinst,'modelCif'=>$modelCif,'form'=>$form),true,false),
					'active' => false
			),
			array(
					'label' => 'Broker Authorization',
					'content' => $this->renderPartial('_form_client_broker',array('model'=>$model,'modelClientinst'=>$modelClientinst,'modelCif'=>$modelCif,'init_deposit_cd'=>$init_deposit_cd,'form'=>$form),true,false),
					'active' => false
			),
		);

		if(count($modelClientMember))
		{
			$memberTab = array(
				array(
					'label' => 'Member',
					'content' => $this->renderPartial('_view_client_member',array('modelClientMember'=>$modelClientMember,'form'=>$form),true,false),
					'active' => false
				)
			);
			$tabs = array_merge($tabs,$memberTab);
		}
		
		
		$this->widget(
		   'bootstrap.widgets.TbTabs',
		    array(
		        'type' => 'pills', // 'tabs' or 'pills'
		        'tabs' => $tabs,
		        'htmlOptions' => array('id'=>'tabMenu'),
		    )
		);
	?>
	
	

	<!--<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>-->

<script>
	var highRiskCountry = [];
	var highRiskBiz = [];

	$(document).ready(function()
	{
		cancel_reason();
		cancel_reason_autho();
		
		$('.authoDate').datepicker({format : "dd/mm/yyyy"});
		
		var x = 0;
		<?php foreach($highRiskCountry as $row){ ?>
			highRiskCountry[x] = [];
			highRiskCountry[x]['Name'] = "<?php echo str_replace(array('"',chr(10),chr(13)),array('\"',' ',' '),$row->name) ?>";
			x++;
		<?php } ?>
		
		x = 0;
		<?php foreach($highRiskBiz as $row){ ?>
			highRiskBiz[x] = [];
			highRiskBiz[x]['Name'] = "<?php echo str_replace(array('"',chr(10),chr(13)),array('\"',' ',' '),$row->name) ?>";
			x++;
		<?php } ?>
		
		if(<?php if($model->isNewRecord)echo 1;else echo 0 ?>)$('#Client_rebate_basis').trigger('change');
	});

	$(window).resize(function() {
		var body = $("#tableBank").find('tbody');
		if(body.get(0).scrollHeight > body.height()) //check whether  tbody has a scrollbar
		{
			$('#tableBank thead').css('width', '100%').css('width', '-=17px');	
		}
		else
		{
			$('#tableBank thead').css('width', '100%');	
		}
		
		alignColumn();
		
		body = $("#tableAutho").find('tbody');
		if(body.get(0).scrollHeight > body.height())
		{
			$('#tableAutho thead').css('width', '100%').css('width', '-=17px');	
		}
		else
		{
			$('#tableAutho thead').css('width', '100%');	
		}
		
		alignColumnAutho();
	})
	$(window).trigger('resize');
	
	$("#Client_subrek001_1").change(function()
	{
		if($("#Cif_cifs").val() == 'NEW')
		{
			$("#Client_subrek004_1").val($(this).val());
		}
	});

	$("#Client_client_code_opt").change(function(){
		if($("#Client_client_code_opt_1").is(':checked'))
			$('#Client_client_cd').show().attr('required','required');
		else 
			$('#Client_client_cd').hide().removeAttr('required');
	});
	$('#Client_client_code_opt').trigger('change');
	
	$("#Client_stop_pay").change(function(){
		if($("#Client_stop_pay").val() == 'N')
			$('#Client_e_mail1').show();
		else 
			$('#Client_e_mail1').hide();
	});
	$('#Client_stop_pay').trigger('change');
	
	$("#Client_client_cd, #Client_client_name, #Client_client_title").on('change',function()
	{
		$(this).val($(this).val().toUpperCase());
	});
	
	$("#Client_client_name").change(function(){
		$("#Client_contact_pers").val($("#Client_client_name").val());
		
		if($("#Cif_cifs").val() == 'NEW')$("#Cif_cif_name").val($("#Client_client_name").val());
	});
	$("#Client_client_name").trigger('change');
	
	<?php if($model->commission_per == 0){?>
		$("#Client_commission_per").val("0.0");
	<?php }?>
	
	$("#Client_commission_per").mask("0.?999999");
	
	<?php if($model->rebate == 0){?>
		$("#Client_rebate").val("0.0");
	<?php }?>
	
	$("#Client_rebate").mask("0.?999999");
	
	<?php if(!$model->client_type_3){ ?>
		$("#Client_client_type_3").val('R');
	<?php } ?>
	
	$("#Client_client_type_3").change(function()
	{
		if($(this).val()=='<?php echo $taxOnInterestFlg->dstr1 ?>')
		{
			//$("#Client_tax_on_interest").prop('checked',true);
		}
		else
		{
			$("#Client_tax_on_interest").prop('checked',false);
		}
	});
	
	$('#Client_rebate_basis').change(function()
	{
		var rebate = $('#Client_rebate_basis').val();
		
		if(rebate == 'DM')
		{
			$('#Client_def_addr_1')/*.prop('readonly',true)*/.val($('#Cif_def_addr_1').val());
			$('#Client_def_addr_2')/*.prop('readonly',true)*/.val($('#Cif_def_addr_2').val());
			$('#Client_def_addr_3')/*.prop('readonly',true)*/.val($('#Cif_def_addr_3').val());
			$('#Client_post_cd')/*.prop('readonly',true)*/.val($('#Cif_post_cd').val());
			$('#Client_def_city').val($('#Cif_def_city').val()).css('cursor','not-allowed');
			$('#Client_def_city option:not(:selected)').prop('disabled', true);
			$('#Client_def_city option:selected').prop('disabled',false);

		}
		else
		{
			$('#Client_def_addr_1').prop('readonly',false);
			$('#Client_def_addr_2').prop('readonly',false);
			$('#Client_def_addr_3').prop('readonly',false);
			$('#Client_post_cd').prop('readonly',false);
			$('#Client_def_city').css('cursor','pointer');
			$('#Client_def_city option').prop('disabled', false)
		}
	});
	
	$('#Cif_def_addr_1, #Cif_def_addr_2, #Cif_def_addr_3, #Cif_post_cd, #Cif_def_city').change(function()
	{
		if($('#Client_rebate_basis').val() == 'DM')
		{
			$('#Client_def_addr_1').val($('#Cif_def_addr_1').val());
			$('#Client_def_addr_2').val($('#Cif_def_addr_2').val());
			$('#Client_def_addr_3').val($('#Cif_def_addr_3').val());
			$('#Client_post_cd').val($('#Cif_post_cd').val());
			$('#Client_def_city').val($('#Cif_def_city').val());
			$('#Client_def_city option:not(:selected)').prop('disabled', true);
			$('#Client_def_city option:selected').prop('disabled',false);
		}
	});
	
	$('#Cif_industry_cd').change(function(){
		highRisk('biz',$(this).find("option:selected").text());
	});
		
	$('#Clientinst_legal_domicile, #Cif_country').change(function(){
		highRisk('country',$(this).find("option:selected").text());
	});
	
	function highRisk(category,value)
	{
		switch(category)
		{
			case 'name':
				$.each(highRiskName, function()
				{
					if(this['Name'].trim().toUpperCase() == value.trim().toUpperCase())
					{
						alert("This client is on the high risk list");
						return false;
					}
				})
				
				break;
			case 'job':
				$.each(highRiskJob, function()
				{
					if(this['Name'].trim().toUpperCase() == value.trim().toUpperCase())
					{
						alert("This job is on the high risk list");
						return false;
					}
				})
				
				break;
			case 'country':
				$.each(highRiskCountry, function()
				{
					if(this['Name'].trim().toUpperCase() == value.trim().toUpperCase())
					{
						alert("This country is on the high risk list");
						return false;
					}
				})
				
				break;
			case 'biz':
				$.each(highRiskBiz, function()
				{
					if(this['Name'].trim().toUpperCase() == value.trim().toUpperCase())
					{
						alert("This business is on the high risk list");
						return false;
					}
				})
				
				break;
		}
	}
</script>
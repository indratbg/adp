<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'clientflacct-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

<!--Use this to load the masked input script-->
<?php 	
	$base = Yii::app()->baseUrl;
	$urlMasked = $base.'/js/jquery.maskedinput.js';
?>
<script type="text/javascript"> 

	function stopRKey(evt) { 
	  var evt = (evt) ? evt : ((event) ? event : null); 
	  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null); 
	  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;} 
	} 
	
	document.onkeypress = stopRKey; 

</script>
<script type="text/javascript" src='<?php echo $urlMasked;?>'></script>
<!--Use this to load the masked input script-->

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<div class="control-group">
		<label class="control-label required" for="Clientflacct_client_cd">
			Client
			<span class="required">*</span>
		</label>
		<div class="controls">
		
		<?php /* $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
							'model'=>$model,
						    'name'=>'Clientflacct[client_cd]',
						    'attribute'=>'client_cd',
						    // additional javascript options for the autocomplete plugin
						    'options'=>array(
						        'minLength'=>'1',
						    ),
						    'source'=>$this->createUrl("/master/Clientflacct/getclient"),
						    'htmlOptions'=>array( 'value'=>$model->client_cd, 'id'=>'auto_comp_client','class'=>'span5'
						      //  'style'=>'height:20px;margin-left:26px;','showAnim'=>'fold',
						    ),
						));*/
	
	?>
		
		
		<?php $this->widget('application.extensions.widget.JuiAutoCompleteStd', array(
												'model'=>$model,
												'attribute'=>'client_cd',
												'ajaxlink'=>array('getclient'),
												'options'=>array('minLength'=>1),
												'htmlOptions'=>array(
																'id'=>'auto_comp_client',
																'name'=>'Clientflacct[client_cd]',
																'class'=>'span5',
																),
										)); ?>
										
		
		
		
		
			<?php /* $this->widget('application.extensions.widget.JuiAutoCompleteStd', array(
								'model'=>$model,
								'attribute'=>'client_cd',
								'ajaxlink'=>array('getclient'),
								'htmlOptions'=>array('id'=>'auto_comp_client','class'=>'span6'),
						)); */ ?>
		</div>
	</div>
	<?php //echo $form->dropDownListRow($model,'client_cd',CHtml::listData(Client::model()->findAll(array('condition'=>"susp_stat = 'N' AND approved_stat = 'A' AND client_type_1 <> 'B' AND custodian_cd IS NULL",'order'=>'client_cd')),'client_cd','CodeAndName'),array('prompt'=>'--Select Client--','id'=>'clientcd','class'=>'span8')); ?>
	<div class="row-fluid">
		<div class="span12">
			<div class="control-group">
				<label class="control-label">SID - Sub Rekening 001</label>
				<div class="controls">
					<input type="text" class="span5 readonly" id="infoclientcd" readonly="readonly" />
				</div>
			</div>
		</div>
	</div>
	<?php echo $form->dropDownListRow($model,'bank_cd',CHtml::listData(Fundbank::model()->findAll(array('order'=>'bank_cd')),'bank_cd','bank_name'), array('id'=>'bankcd','class'=>'span3')); ?>
	<?php echo $form->textField($model,'bank_short_name', array('id'=>'bank_short_name','class'=>'span3','style'=>'display:none;')); ?>
	
	<?php
		$format = $model->account_format;
		//echo $format;
		if(!$model->is_format_null)
			echo $form->maskedTextFieldRow($model,'bank_acct_num',$format,array('class'=>'span3','id'=>'bankacct','maxlength'=>12)); 
		else
			echo $form->textFieldRow($model,'bank_acct_num',array('class'=>'span3','id'=>'bankacct','maxlength'=>12));
		?>
	<?php echo $form->textFieldRow($model,'acct_name',array('class'=>'span6','maxlength'=>50,'id'=>'acctname')); ?>
	
	<?php echo $form->dropDownListRow($model,'acct_stat',CHtml::listData(Parameter::model()->findAll(array('condition'=>"prm_cd_1='RDISTS'",'order'=>'prm_desc')),'prm_cd_2', 'prm_desc'),
		array('class'=>'span3','id'=>'acctstat','maxlength'=>100)); ?>
	
	<?php //echo $form->textFieldRow($model,'from_dt',array('class'=>'span3','id'=>'fromdt','maxlength'=>12));?>
	
	<?php //echo $form->textFieldRow($model,'to_dt',array('class'=>'span3','id'=>'todt','maxlength'=>12));?>
	
	<?php echo $form->datePickerRow($model,'from_dt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
	
	<?php echo $form->datePickerRow($model,'to_dt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
	
	<input type="hidden" name="flag" value="TRUE" id="flag"/>
	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'id'=>'savebtn',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

<script type="text/javascript" charset="utf-8">
	
	showSid();
	/*
	$('#fromdt').mask('99/99/9999 99:00');
	$('#todt').mask('99/99/9999 99:00');
	$('#fromdt').attr('placeholder','dd/mm/yyyy hh:mi');
	$('#todt').attr('placeholder','dd/mm/yyyy hh:mi');
	*/
	<?php //if(!$model->from_dt){?>
		//$('#fromdt').val('<?php //echo date('d/m/Y H:00');?>');
	<?php //}else{?>
		//$('#fromdt').val('<?php //echo $model->from_dt;?>');
	<?php //}?>
	
	<?php //if(!$model->to_dt){?>
		//$('#todt').val('31/12/2030 00:00');
	<?php //}else{?>
		//$('#todt').val('<?php //echo $model->to_dt;?>');
	<?php //}?>
	
	$('#bankcd').change(function(){
		
		//$('#flag').val('FALSE');
		//$('#clientflacct-form').submit();
		
		getAcctMask();
		setBankName();
	});
	

	/*
	$('#yw0').click(function(e){
		e.preventDefault();
		$('#flag').val('TRUE');
		$('#clientflacct-form').submit();
	});
	*/
	
	$("#auto_comp_client").change(function(){
		checkSID();
	});
	function checkSID(){
		//alert('aa');
		var clientval = $("#auto_comp_client").val();
		var pos = clientval.indexOf("-") + 1;
		var acctnameval = $.trim(clientval.substring(pos));
		$("#acctname").val(acctnameval);
		
		showSid();
		if ($("#acctstat option:selected").val() == 'C'){
			status();
			//alert('bisalah');
		}
	}
		
	$("#acctstat").change(function(){
		if ($("#acctstat option:selected").val() == 'C'){
			status();
			//alert('bisa');
		}else{
			$("#savebtn").attr('disabled',false);
		}
	});
	
	$('#Clientflacct_bank_acct_num').change(function(e){
		checkacct();
		//alert('aas');
	});
	
	
	function checkacct(){
		var bank_acct_num = $("#Clientflacct_bank_acct_num").val();
		//alert('asas');
			$.ajax({
	    		'type'     :'POST',
	    		'url'      : '<?php echo $this->createUrl('Acct_num'); ?>',
				'dataType' : 'json',
				'data'     : {'bank_acct_num' : bank_acct_num
							  
							},
				'success'  : function(data){
						var status = data.fail;
						if(status == true){
							alert("Account Bank Number Sudah Digunakan");
						}
						
				}
			});
			
	}
		
	function showSid(){
		var valclientcd = $("#auto_comp_client").val();
		var pos = valclientcd.indexOf(" ");
		var client_cd = $.trim(valclientcd.substring(0,pos));
		//alert('client_cd');
			$.ajax({
	    		'type'     :'POST',
	    		'url'      : '<?php echo $this->createUrl('Showsid'); ?>',
				'dataType' : 'json',
				'data'     : {'client_cd' : client_cd
							  
							},
				'success'  : function(data){
						var sid = data.sid;
						var subrek001 = data.subrek001;
						if(sid != null && subrek001 != null)
							var info = sid + " - " + subrek001;
						else
							var info = "-";
						$('#infoclientcd').val(info);
						
				}
			});
			
	}
	
	
	function status(){
		var valclientcd = $("#auto_comp_client").val();
		var pos = valclientcd.indexOf(" ");
		var clientcd = $.trim(valclientcd.substring(0,pos));
		if(clientcd == null || clientcd =='' ){
			
		}
		else{
			$.ajax({
	    		'type'     :'POST',
	    		'url'      : '<?php echo $this->createUrl('status'); ?>',
				'dataType' : 'json',
				'data'     : {'Clientcd' : clientcd
							  
							},
				'success'  : function(data){
						var acctstatus = data.cek;
						var balance = data.balance;
						if(acctstatus == 'fail'){
							alert("Rekening tidak dapat diclose, masih ada balance: " + setting.func.number.addCommas(balance) );
							$("#savebtn").attr('disabled','disabled');
						}else{
							$("#savebtn").attr('disabled',false);
						}
						
				}
			});
		}
	}

	function getAcctMask(){
		<?php
			if($listMask){
		?>
				var bankcdval = $("#bankcd option:selected").val();
				
				if(bankcdval == '<?php echo $listMask[0]['bank_cd'];?>'){
					$("#bankacct").mask("<?php echo $listMask[0]['acct_mask'];?>");
				}
		<?php
				foreach ($listMask as $mask){
		?>
				else if (bankcdval == '<?php echo $mask['bank_cd'];?>' && ("format<?php echo $mask['acct_mask']?>" != "format")){
					$("#bankacct").mask("<?php echo $mask['acct_mask'];?>");
				}
		<?php
				}
			}
		?>
				else{
					$("#bankacct").unmask();
				}
	}
$('#acctstat').change(function(){
	var acct_stat=$('#acctstat').val();
	if(acct_stat == 'C'){
		
		<?php $date1= date('d/m/Y',strtotime("-1 days"));
		$day=date('d',strtotime("-1 days"));
		$mounth=date('m',strtotime("-1 month"));
		$year=date('Y',strtotime("-1 days"));
		?>
		$('#Clientflacct_to_dt').val('<?php echo $date1 ?>');
		$('#Clientflacct_to_dt').datepicker("setDate",new Date(<?php echo $year ?>,<?php echo $mounth?>,<?php echo $day?>));
	}
	
})	

setBankName();
function setBankName()
{
	var bank_name = $('#bankcd').children('option:selected').text();
	
	$('#bank_short_name').val(bank_name);
}

</script>
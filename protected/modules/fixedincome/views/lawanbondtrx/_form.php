<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'lawan-bond-trx-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>
<?php
// $query="SELECT DISTINCT lawan_type, p.descrip,  capital_tax_pcn, deb_gl_acct, Cre_gl_acct
	//	FROM MST_LAWAN_BOND_TRX m ,
	//	( SELECT prm_cd_2, prm_desc AS descrip
	//	FROM MST_PARAMETER
//		WHERE prm_cd_1 = 'LAWAN') p
//		WHERE m.lawan_type = p.prm_cd_2
//		ORDER BY 1";
//$lawan_type_list=DAO::queryAllSql($query);

$query1="select cbest_cd || ' - ' ||custody_name  as cbest,cbest_cd
			from mst_bank_custody
			where approved_sts = 'A'
			and sr_custody_cd is not null
			order by 1";

$list_cbest_cd=DAO::queryAllSql($query1);


?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<?php echo $form->textFieldRow($model,'lawan',array('class'=>'span5','maxlength'=>50,'id'=>'lawan')); ?>
	
	<?php echo $form->textFieldRow($model,'lawan_name',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'ctp_cd',array('class'=>'span5','maxlength'=>25,'id'=>'ctpcd')); ?>
	
	<?php echo $form->dropDownListRow($model,'custody_cbest_cd',CHtml::listData($list_cbest_cd,'cbest_cd', 'cbest'),array('class'=>'span5','maxlength'=>30,'prompt'=>'--Choose--')); ?>
	<?php echo $form->dropDownListRow($model,'lawan_type',CHtml::listData(Parameter::model()->findAll("prm_cd_1='LAWAN'"),'prm_cd_2', 'prm_desc'),array('prompt'=>'--Select Type--','class'=>'span5','maxlength'=>30)); ?>
	
	
	<?php //CHtml::listData($lawan_type_list,'lawan_type', 'descrip'?>
	<?php // echo $form->dropDownListRow($model,'int_type',CHtml::listData(Parameter::model()->findAll("prm_cd_1='BRATE'"),'prm_cd_2', 'prm_desc'),array('class'=>'span8','maxlength'=>100,'prompt'=>'-Pilih Rate Type-')); ?>
	<?php echo $form->textFieldRow($model,'capital_tax_pcn',array('class'=>'span5')); ?>
	<?php echo $form->textFieldRow($model,'phone',array('class'=>'span5','maxlength'=>30)); ?>
	<?php echo $form->textFieldRow($model,'fax',array('class'=>'span5','maxlength'=>30)); ?>
	<?php echo $form->textFieldRow($model,'contact_person',array('class'=>'span5','maxlength'=>50)); ?>
	<?php echo $form->textFieldRow($model,'e_mail',array('class'=>'span5','maxlength'=>50)); ?>
	<?php echo $form->textFieldRow($model,'deb_gl_acct',array('class'=>'span5','maxlength'=>4)); ?>
	<?php echo $form->textFieldRow($model,'cre_gl_acct',array('class'=>'span5','maxlength'=>4)); ?>	
	<?php echo $form->textFieldRow($model,'sl_acct_cd',array('id'=>'sl_acct_cd','class'=>'span5','style'=>'text-transform: uppercase')) ?>
	<div class="control-group">
		<label class="control-label">Participant</label>
		<div class="controls"><?php echo $form->checkBox($model,'participant',array('value'=>'Y'))?></div>
	</div>	
	<div class="control-group">
		<label class="control-label">Active</label>
		<div class="controls"><?php echo $form->checkBox($model,'is_active',array('value'=>'Y'))?></div>
	</div>	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
<script>
	$(document).ready(function(){
		setAutoCompleteSL();
	});
	
	$('#sl_acct_cd').keyup(function() {
        $('#sl_acct_cd').val($('#sl_acct_cd').val().toUpperCase());
    });

	function setAutoCompleteSL()
	{
		var result;
		
		$("#sl_acct_cd").autocomplete(
		{
			source: function (request, response) 
			{
		        $.ajax({
		        	'type'		: 'POST',
		        	'url'		: '<?php echo $this->createUrl('getSub'); ?>',
		        	'dataType' 	: 'json',
		        	'data'		:	{
		        						'term': request.term,
		        					},
		        	'success'	: 	function (data) 
		        					{
				           				response(data);
				           				result = data;
				    				}
				});
		   },
		   minLength: 1
		  });}
		  
	$('#LawanBondTrx_lawan_type').change(function(){
				Slacct();
				Passiva();
				
				var type= $('#LawanBondTrx_lawan_type').val();
				
				if(type =='P'){
					$('#LawanBondTrx_capital_tax_pcn').val('0');
				}
				if(type =='F'){
					$('#LawanBondTrx_capital_tax_pcn').val('.20');
					Foreign();
				}			
	});
	
	$('#lawan').change(function(){
		var lawanval = $('#lawan').val();
		$('#ctpcd').val(lawanval);		
	});
	
	function Passiva(){
		var type=$('#LawanBondTrx_lawan_type').val();
			
			if(type == 'F'){
				type='P';
			}
				$.ajax({
	    		'type'     :'POST',
	    		'url'      : '<?php echo $this->createUrl('Glaccount'); ?>',
				'dataType' : 'json',
				'data'     : {'type' : type,
								
							  
							},
				'success'  : function(data){
						var gl=data.gl;
						var cre=data.cre;
						var pcn = data.pcn;
						if(type != 'P' ){
						$('#LawanBondTrx_capital_tax_pcn').val(pcn);
						}
					
					$('#LawanBondTrx_deb_gl_acct').val(gl);
					$('#LawanBondTrx_cre_gl_acct').val(cre);
				}
			});
			
	}
	function Slacct(){
		//alert('test');
		var ctp = $('#ctpcd').val();
		var type = $('#LawanBondTrx_lawan_type').val();
			if(type == 'F'){
				type='P'
			}
		var sum = ctp.length;
		var sl = ctp.substr(sum-2,sum);
		var slacct = sl.toUpperCase(sl);
		var lawanval = $("#lawan").val();
		if(type == 'S'){
		
			$('#sl_acct_cd').val(slacct);
		}
		else if(type != 'I'){
			$('#sl_acct_cd').val('000001');
		}
		else if(type == 'I'){
			$('#sl_acct_cd').val(ctp);
		}
		else{
			$('#sl_acct_cd').val('');
		}
		
	}
	
	$("#lawan").change(function(){
		Slacct();
	});
	
	function Foreign(){
		var type = $('#LawanBondTrx_lawan_type').val();
		
		if(type=='F'){
			type='R';
			$.ajax({
	    		'type'     :'POST',
	    		'url'      : '<?php echo $this->createUrl('Glaccount'); ?>',
				'dataType' : 'json',
				'data'     : {'type' : type,
								
							  
							},
				'success'  : function(data){
						var gl=data.gl;
						var cre=data.cre;
						var pcn = data.pcn;
						/*if(type != 'P' ){
						$('#LawanBondTrx_capital_tax_pcn').val(pcn);
						}*/
					
					$('#LawanBondTrx_deb_gl_acct').val(gl);
				//	$('#LawanBondTrx_cre_gl_acct').val(cre);
				}
			});
		}
		
	}
	
</script>


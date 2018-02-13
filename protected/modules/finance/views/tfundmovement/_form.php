<style>
	input[type="text"]{
		font-size:11pt;
	}
	label{
		font-size:11pt;
	}
	select{
		font-size:11pt;
	}
</style>


<?php $format = new CFormatter;
	$format->numberFormat=array('decimals'=>2, 'decimalSeparator'=>null, 'thousandSeparator'=>',');
 ?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tfundmovement-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php // echo $form->textFieldRow($model,'doc_num',array('class'=>'span8','readonly'=>$model->isNewRecord?'readonly':'','maxlength'=>25)); ?>
	<div class="row-fluid">
		<div class="span2">
			<label>Date</label>
		</div>
		<div class="span2">
			<label>Movement Type</label>
		</div>
		<div class="span2">
			<label>Client Cd</label>
		</div>
		<div class="span3">
			<label>Amount</label>
		</div>
		<div class="span3">
			<label>Description</label>
		</div>
	</div>
	
	<div class="row-fluid control-group">
		<div class="span2">
			<?php echo $form->textField($model,'doc_date',array('placeholder'=>'dd/mm/yyyy','onchange'=>'ceksaldo()','class'=>'span tdate'));?>
			<?php //echo $form->datePickerRow($model,'doc_date',array('label'=>false,'style'=>'margin-left:-30px;','placeholder'=>'dd/mm/yyyy','class'=>'span tdate')); ?>
		</div>
		<div class="span2">
			<?php echo $form->dropDownList($model,'trx_type',Constanta::$movement_type,array('class'=>'span','onchange'=>'movement_type()','maxlength'=>1,'prompt'=>'-Select type-')); ?>
		</div>
		<div class="span2">
			<?php  echo $form->textField($model,'client_cd',array('class'=>'span','maxlength'=>12));?>
	
		</div>
		<div class="span3">
			<?php echo $form->textField($model,'trx_amt',array('class'=>'span tnumber','maxlength'=>'16','onchange'=>'cekFee()','style'=>'text-align:right;')); ?>
		</div>
		<div class="span3">
			<?php echo $form->textField($model,'remarks',array('required'=>true,'class'=>'span','maxlength'=>50)); ?>
		</div>
	</div>
	
	<div class="row-fluid control-group">
		<div class="span1">
			<b id="text"></b>
			<label id="label_stock">Stock cd</label>
		</div>
		<div class="span2">
			<label id="rek_dana">Rekening Dana</label>
			<?php echo $form->textField($model,'sl_acct_cd',array('class'=>'span','id'=>'stk_cd'));?>
		</div>
		<div class="span5">
			<?php echo $form->textField($model,'acct_name',array('placeholder'=>'Client Name','class'=>'span','maxlength'=>50));?>
		
		</div>
		<div class="span1">
			<label>FEE</label>
		</div>
		<div class="span1">
			<?php echo $form->textField($model,'fee',array('class'=>'span','id'=>'fee','style'=>'text-align:right;')); ?>
		</div>
		<div class="span1">
			<label>REF</label>
		</div>
		<div class="span1"style="margin-left:-20px;width:85px;">
			<?php  echo $form->textField($model,'folder_cd',array('class'=>'span','id'=>'folder_cd','maxlength'=>8)); ?>
			
		</div>
	</div>
<div class="row-fluid control-group">
	<div class="span1">
		<label id="text_saldo">Saldo</label>
	</div>
	<div class="span2">
		<label id="saldo" style="font-weight:bold;" ></label>
		<label id="bank_cd_ipo">Bank Code</label>
	</div>
	<div class="span2">
		<?php  echo $form->textField($model,'to_bank',array('class'=>'span','id'=>'bank_atas','maxlength'=>30)); ?>
	</div>
	<div class="span2">
		<label id="no_rek_dana">No Rek Dana</label>
		
	</div>
	<div class="span2">
		<?php echo $form->textField($model,'to_acct',array('class'=>'span','style'=>'width:185px;','id'=>'acct_atas','maxlength'=>25)); ?>
			

		
	</div>
</div>
	<div class="row-fluid control-group">
		<div class="span1">
			<b id="text_bawah"></b>
		</div>
		<div class="span2">
			<label id="nama">NAMA</label>
		</div>
		<div class="span5">
				<?php echo $form->textField($model,'nama',array('class'=>'span','maxlength'=>50)); ?>
		</div>
	</div>
<div class="row-fluid control-group">
	<div class="span1">
		
	</div>
	<div class="span2">
		<label id="bank_rek_pribadi">Bank Rek Pribadi</label>
	</div>
	<div class="span5">
		<?php //echo $form->textField($model,'from_bank',array('class'=>'span','id'=>'bank_bawah','maxlength'=>12)); ?>
		<?php echo $form->dropDownList($model,'from_bank',CHtml::listData(Ipbank::model()->findAll(array('condition'=>"approved_stat='A' ",'order'=>'bank_cd')),'bank_cd', 'DropDownName'),array('class'=>'span','id'=>'bank_bawah','maxlength'=>12,'prompt'=>'-Select-','style'=>'font-family:courier'));?>
</div>
<div class="span3">
	<?php echo $form->dropDownList($model,'no_rek',array(),array('class'=>'span','id'=>'acct_bawah1','onchange'=>'set_acct()','maxlength'=>12));?>
</div>
</div>


<div class="row-fluid control-group">
	<div class="span3">
		
	</div>
	<div class="span5">
		<?php  echo $form->textField($model,'from_acct',array('class'=>'span','id'=>'acct_bawah','placeholder'=>'Input bank account number','maxlength'=>12));?>
		
		<!--<div class="control-group">
		
	<?php  /*$this->widget('zii.widgets.jui.CJuiAutoComplete',array(
					//		'model'=>$model,
						    'name'=>'Tfundmovement[from_acct]',
						    'attribute'=>'from_acct',
						     'id'=>'acct_bawah',
						    
						    // additional javascript options for the autocomplete plugin
						    'options'=>array(
						        'minLength'=>'1',
						    ),
						    //'source'=>$this->createUrl("/finance/Tfundmovement/Getacct"),
						    'source'=>'js: function(request, response) {
									    $.ajax({
									        url: "'.$this->createUrl('/finance/Tfundmovement/Getacct').'",
									        dataType: "json",
									        data: {
									            term: request.term,
									            client_cd: $("#Tfundmovement_client_cd").val(),
									           
									        },
									        success: function (data) {
									                response(data);
									        }
									    })
									 }',
						    'htmlOptions'=>array( 'value'=>$model->from_acct, 'onchange'=>'from_acct_num()',
						        'style'=>'height:18px;width:300px;','showAnim'=>'fold',
						    ),
						));
	*/
	?>
	</div>-->
	</div>
</div>
	<div class="row-fluid control-group"> 
		<div class="span1">
			
		</div>
		<div class="span2">
			<label id="bank_timestamp">Bank Timestamp</label>
		</div>
		<div class="span3">
			<?php echo $form->textField($model,'bank_mvmt_date',array('label'=>false,'id'=>'datetimepicker','placeholder'=>'dd/mm/yyyy hh:mm:ss','class'=>'span')); ?>
		</div>
		<div class="span3">
			<label id="placehold">DD/MM/YY HH:MM:SS</label>
		</div>
	</div>
<div class="row-fluid">
	<div class="span1">
		
	</div>
	<div class="span2">
		<label></label>
	</div>
	<div class="span3">
		<?php echo $form->textField($model,'source',array('class'=>'span','id'=>'source','value'=>'INPUT','style'=>'display:none;','maxlength'=>12)); ?>
	</div>
</div>

<!-------Yang Tergantung Movement type--->
<?php  echo $form->textField($model,'from_client',array('class'=>'span5','id'=>'from_client','onchange'=>'movement_type()','style'=>'display:none;','maxlength'=>12)); ?>
<?php echo $form->textField($model,'to_client',array('class'=>'span5','id'=>'to_client','onchange'=>'movement_type()','style'=>'display:none;','maxlength'=>12)); ?>

<!-------End Tergantung Movement type--->
<!-----auto fill value--------->
<?php  echo $form->textField($model,'fund_bank_cd',array('class'=>'span','id'=>'fund_bank_cd','style'=>'display:none;','maxlength'=>12)); ?>
<?php echo $form->textField($model,'fund_bank_acct',array('class'=>'span','id'=>'fund_bank_acct','style'=>'display:none;','maxlength'=>12)); ?>
<?php echo $form->textField($model,'brch_cd',array('class'=>'span','id'=>'branch_cd','style'=>'display:none;','maxlength'=>12)); ?>

<!-----end auto fill value--------->



	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
<?php 	
	$base = Yii::app()->baseUrl;
	$urlDateCss = $base.'/css/jquery.datetimepicker.css';
	$urlDate = $base.'/js/jquery.datetimepicker.js'; 

?>
<?php echo $form->datePickerRow($model,'cre_dt',array('label'=>false,'disabled'=>'disabled','style'=>'display:none','options'=>array('format' => 'dd/mm/yyyy'))); ?>
<link href="<?php echo $urlDateCss ;?>" rel="stylesheet" type="text/css"/>
<script src="<?php echo $urlDate ;?>" type="text/javascript"></script>


<script>
var authorizedBackDated = true;


$(document).ready(function()
	{
	$.ajax({
    		'type'     :'POST',
    		'url'      : '<?php echo $this->createUrl('ajxValidateBackDated'); ?>',
			'dataType' : 'json',
			'statusCode':
			{
				403		: function(data){
					authorizedBackDated = false;
				}
			}
		});

});

$(document).ajaxComplete(function( event, xhr, settings ) {
		if (settings.url === "<?php echo $this->createUrl('ajxValidateBackDated'); ?>" ) 
		{
      		if(!authorizedBackDated)
      		{
      			var date = new Date();
				var month = date.getMonth();
				var year = date.getFullYear();
				
				month = month + 1;
				if(month < 10)month = '0'+month;
				
				//$("#doc_dt").datepicker({format:"dd/mm/yyyy",startDate:"01/"+month+"/"+year});
				$("#Tfundmovement_doc_date").data('datepicker').setStartDate("01/"+month+"/"+year);
			}
      	}
  	});
  	

$('.tdate').datepicker({'format':'dd/mm/yyyy','language':'en'});
$('#datetimepicker').datetimepicker({format:'d/m/Y H:i:s'});
	movement_type();
	init();
	
	$('#bank_bawah').change(function(){
		
		cekFee();
	})

function init(){
	getClient();
	var movement_type = $('#Tfundmovement_trx_type').val();
	
	
	if(movement_type=='R'){
		$('#text_bawah').html('DARI');
		$('#rek_dana').show();
		$('#fee').show();
		$('#folder_cd').show();
		$('#text_saldo').show();
		$('#saldo').show();
		$('#no_rek_dana').show();
		$('#nama').show();
		$('#bank_rek_pribadi').show();
		$('#Tfundmovement_nama').show();
		$('#acct_atas').show();
		$('#stk_cd').hide();
		$('#label_stock').hide();
		$('#bank_cd_ipo').hide();
	
	}
	else if(movement_type=='W'){

		$('#text_bawah').html('KE');
		$('#fee').show();
		$('#folder_cd').show();
		$('#text_saldo').show();
		$('#saldo').show();
		$('#rek_dana').show();
		$('#no_rek_dana').show();
		$('#nama').show();
		$('#bank_rek_pribadi').show();
		$('#Tfundmovement_nama').show();
		$('#acct_atas').show();
		$('#stk_cd').hide();
		$('#label_stock').hide();
		$('#bank_cd_ipo').hide();
	
	}
	else if(movement_type=='I' || movement_type=='O'){
		$('#text_saldo').show();
		$('#saldo').hide();
		$('#rek_dana').hide();
		$('#fee').show();
		$('#folder_cd').show();
		$('#bank_atas').hide();
		$('#bank_bawah').hide();
		$('#no_rek_dana').hide();
		$('#nama').hide();
		$('#bank_rek_pribadi').hide();
		$('#Tfundmovement_nama').hide();
		$('#acct_atas').hide();
		$('#acct_bawah1').hide();
		$('#stk_cd').show();
		$('#label_stock').show();
		$('#bank_cd_ipo').show();
	}
	else{
		$('#text_saldo').hide();
		$('#saldo').show();
		$('#rek_dana').hide();
		$('#fee').show();
		$('#folder_cd').show();
		$('#bank_atas').hide();
		$('#bank_bawah').hide();
		$('#no_rek_dana').hide();
		$('#nama').hide();
		$('#bank_rek_pribadi').hide();
		$('#Tfundmovement_nama').hide();
		$('#acct_atas').hide();
		$('#acct_bawah1').hide();
		$('#stk_cd').hide();
		$('#label_stock').hide();
		$('#bank_cd_ipo').hide();
	}
}
	

	function movement_type(){
		
		var trx_amt=$('#Tfundmovement_trx_amt').val();
		var bank_bawah=$('#bank_bawah').val();
		var bank_atas=$('#bank_atas').val();
	
		var movement_type = $('#Tfundmovement_trx_type').val();
		var client_cd = $('#Tfundmovement_client_cd').val();
		var tanggal=$('#Tfundmovement_doc_date').val();
		var branch_cd=$('#branch_cd').val();
		
		if(movement_type == 'R'){
			//$('#bank_bawah').val('');
			//$('#acct_bawah').val('');
			$('#text').show();
			$('#text_bawah').show();
			$('#text').html('KE');
			$('#rek_dana').show();
			$('#fee').show();
			$('#folder_cd').show();
			$('#text_saldo').show();
			$('#saldo').show();
			$('#bank_atas').show();
			$('#no_rek_dana').show();
			$('#acct_atas').show();
			$('#text_bawah').html('DARI');
			$('#nama').show();
			$('#Tfundmovement_nama').show();
			$('#bank_rek_pribadi').show();
			$('#bank_bawah').show();
			$('#acct_bawah').show();
			$('#bank_timestamp').show();
			$('#datetimepicker').show();
			$('#placehold').show();
			$('#from_client').val('LUAR');
			$('#to_client').val('FUND');
			$('#bank_atas').attr('name','Tfundmovement[to_bank]');
			$('#acct_atas').attr('name','Tfundmovement[to_acct]');
			$('#bank_bawah').attr('name','Tfundmovement[from_bank]');
			$('#acct_bawah').attr('name','Tfundmovement[from_acct]');
			$('#acct_bawah1').show();
			$('#fee').val('0');
			$('#stk_cd').hide();
			$('#label_stock').hide();
			$('#bank_cd_ipo').hide();
			$.ajax({
	    		'type'     :'POST',
	    		'url'      : '<?php echo $this->createUrl('ClientCd'); ?>',
				'dataType' : 'json',
				'data'     : {'client_cd' : client_cd,
 								'tanggal': tanggal
							},
				'success'  : function(data){
						var acct_name= data.acct_name;
						var bank_cd=data.bank_cd;
						var bank_acct_num=data.bank_acct_num;
						var acct_name_client=data.acct_name_client;
						var bank_cd_client=data.bank_cd_client;
						var bank_acct_num_client=data.bank_acct_num_client;
						var bank_cd_mst_client=data.bank_cd_mst_client;
						var bank_acct_num_mst_client= data.bank_acct_num_mst_client;
						var saldo=data.saldo;
						
						if(saldo == null){
							$('#saldo').html('');
						}
						else{
							$('#saldo').html(setting.func.number.addCommasDec(saldo));
						}
					
					$('#Tfundmovement_acct_name').val(acct_name);
					
					$('#bank_atas').val(bank_cd);
					$('#acct_atas').val(bank_acct_num);
					$('#Tfundmovement_nama').val(acct_name_client);
					
					$('#acct_bawah').val(bank_acct_num_mst_client);
				
					
				},
			'async':false	
			});
			$.ajax({
	    		'type'     :'POST',
	    		'url'      : '<?php echo $this->createUrl('Getbankcd'); ?>',
				'dataType' : 'json',
				'data'     : {'client_cd' : client_cd,
 
							},
				'success'  : function(data){
							$(data.to_acct1).each(function(i){
							$('#bank_bawah').val(this.to_acct);
							$('#acct_bawah1').append($('<option>').val(this.acct_bawah).html(this.acct_num));
							
					});
					
				},
				'async':false
			});
			
		$('#acct_bawah1').empty();
		}
		else if(movement_type == 'W'){
	
			
			
			
				//$('#bank_bawah').val('');
				$('#acct_bawah').val('');
				$('#datetimepicker').val('');
				$('#text').show();
				$('#text_bawah').show();
				$('#from_client').val('FUND');
				$('#to_client').val('LUAR');
				$('#text').html('DARI');
				$('#text_bawah').html('KE');
				$('#bank_atas').attr('name','Tfundmovement[from_bank]');
				$('#acct_atas').attr('name','Tfundmovement[from_acct]');
				$('#bank_bawah').attr('name','Tfundmovement[to_bank]');
				$('#acct_bawah').attr('name','Tfundmovement[to_acct]');
				$('#rek_dana').show();
				$('#fee').show();
				$('#folder_cd').show();
				$('#text_saldo').show();
				$('#saldo').show();
				$('#bank_atas').show();
				$('#no_rek_dana').show();
				$('#acct_atas').show();
				$('#nama').show();
				$('#Tfundmovement_nama').show();
				$('#bank_rek_pribadi').show();
				$('#bank_bawah').show();
				$('#acct_bawah').show();
				$('#bank_timestamp').show();
				$('#acct_bawah1').show();
				$('#datetimepicker').show();
				$('#placehold').show();
				$('#stk_cd').hide();
				$('#label_stock').hide();
				$('#bank_cd_ipo').hide();
				$.ajax({
	    		'type'     :'POST',
	    		'url'      : '<?php echo $this->createUrl('ClientCd'); ?>',
				'dataType' : 'json',
				'data'     : {'client_cd' : client_cd,
 								'tanggal': tanggal
							},
				'success'  : function(data){
						var acct_name= data.acct_name_client;
						var bank_cd=data.bank_cd;
						var bank_acct_num=data.bank_acct_num;
						var acct_name_client=data.acct_name_client;
						var bank_cd_client=data.bank_cd_client;
						var bank_acct_num_client=data.bank_acct_num_client;
						var bank_cd_mst_client=data.bank_cd_mst_client;
						var bank_acct_num_mst_client= data.bank_acct_num_mst_client;
						var saldo=data.saldo;
						if(saldo == null){
							$('#saldo').html('');
						}
						else{
							$('#saldo').html(setting.func.number.addCommasDec(saldo));
						}
						
					$('#Tfundmovement_acct_name').val(acct_name);
				
					$('#bank_atas').val(bank_cd);
					$('#acct_atas').val(bank_acct_num);
					$('#Tfundmovement_nama').val(acct_name_client);
					//$('#bank_bawah').val(bank_cd_mst_client);
					$('#acct_bawah').val(bank_acct_num_mst_client);
					
				},
				'async':false
				});
				$.ajax({
	    		'type'     :'POST',
	    		'url'      : '<?php echo $this->createUrl('Getbankcd'); ?>',
				'dataType' : 'json',
				'data'     : {'client_cd' : client_cd,
 								
							},
				'success'  : function(data){
							$(data.to_acct1).each(function(i){
				//alert(this.to_acct);
							$('#bank_bawah').val(this.to_acct);
							$('#acct_bawah1').append($('<option>').val(this.acct_bawah).html(this.acct_num));
					});
					
				},
				'async':false
			});
			
		$('#acct_bawah1').empty();
				branchcd();
				cekFee();
			
		}
		else if(movement_type == 'B'){
			$('#fee').val('0');
			$('#from_client').val('BUNGA');
			$('#to_client').val('FUND');
			$('#text').hide();
			$('#text_bawah').hide();
			$('#rek_dana').hide();
			$('fee').show();
			$('#folder_cd').show();
			$('#text_saldo').show();
			$('#saldo').show();
			$('#bank_atas').hide();
			$('#no_rek_dana').hide();
			$('#acct_atas').hide();
			$('#nama').hide();
			$('#Tfundmovement_nama').hide();
			$('#bank_bawah').hide();
			//$('#bank_bawah').empty();
			$('#bank_rek_pribadi').hide();
			$('#bank_timestamp').show();
			
			$('#datetimepicker').show();
			$('#placehold').show();
			$('#acct_bawah').attr('name','Tfundmovement[from_acct]');
			$('#acct_bawah').val('-');
			$('#acct_bawah1').hide();
			$('#bank_cd_ipo').hide();
			$.ajax({
	    		'type'     :'POST',
	    		'url'      : '<?php echo $this->createUrl('ClientCd'); ?>',
				'dataType' : 'json',
				'data'     : {'client_cd' : client_cd,
 								'tanggal': tanggal
							},
				'success'  : function(data){
						var acct_name= data.acct_name_client;
						var bank_cd=data.bank_cd;
						var bank_acct_num=data.bank_acct_num;
						var saldo=data.saldo;
						if(saldo == null){
							$('#saldo').html('');
						}
						else{
							$('#saldo').html(setting.func.number.addCommasDec(saldo));
						}
					$('#Tfundmovement_acct_name').val(acct_name);
					
					
					$('#acct_atas').attr('name','Tfundmovement[to_acct]');
					$('#acct_atas').val(bank_acct_num);
					$('#bank_atas').attr('name','Tfundmovement[to_bank]');
					$('#bank_atas').val(bank_cd);
					$('#bank_bawah').attr('name','Tfundmovement[from_bank]');
					
				//	$('#bank_bawah').append($('<option>').val(bank_cd).html(bank_cd));
					
				},
				'async':false
				});
		$('#stk_cd').hide();
		$('#label_stock').hide();
		}
		else if(movement_type == 'I' || movement_type=='O'){
			
			$('#fee').val('0');
			//$('#from_client').val('UMUM');
			//$('#to_client').val('UMUM');
			$('#text').hide();
			$('#text_bawah').hide();
			$('#rek_dana').hide();
			$('fee').show();
			$('#folder_cd').show();
			$('#text_saldo').hide();
			$('#saldo').hide();
			$('#bank_atas').show();
			$('#no_rek_dana').show();
			$('#acct_atas').show();
			$('#acct_bawah').hide();
			$('#nama').hide();
			$('#Tfundmovement_nama').hide();
			$('#bank_bawah').hide();
			$('#bank_rek_pribadi').hide();
			$('#bank_timestamp').show();
			$('#acct_bawah1').hide();
			$('#datetimepicker').show();
			$('#placehold').show();
			$('#acct_bawah').attr('name','Tfundmovement[from_acct]');
			$('#stk_cd').show();
			$('#label_stock').show();
			$('#bank_cd_ipo').show();
			
			}
				
	branchcd();
	fundbank();
	
	
}
function branchcd(){
	//alert('test');
		var client_cd = $('#Tfundmovement_client_cd').val();
		$.ajax({
	    		'type'     :'POST',
	    		'url'      : '<?php echo $this->createUrl('BranchCode'); ?>',
				'dataType' : 'json',
				'data'     : {'client_cd' : client_cd,
 
							},
				'success'  : function(data){
						var branch= data.branch_cd;
						
					$('#branch_cd').val(branch);
					
				}
				});
		
	
}
function fundbank(){
	var client_cd = $('#Tfundmovement_client_cd').val();
	var tanggal=$('#Tfundmovement_doc_date').val();
	$.ajax({
	    		'type'     :'POST',
	    		'url'      : '<?php echo $this->createUrl('ClientCd'); ?>',
				'dataType' : 'json',
				'data'     : {'client_cd' : client_cd,
 							'tanggal': tanggal
							},
				'success'  : function(data){
					
						var bank_cd=data.bank_cd;
						var bank_acct_num=data.bank_acct_num;
				
					$('#fund_bank_cd').val(bank_cd);
					$('#fund_bank_acct').val(bank_acct_num);
					
				},
				'async':false
			});	

}

function from_acct_num(){
	var client_cd = $('#Tfundmovement_client_cd').val();
	var acct_bawah=$('#acct_bawah').val();
	$.ajax({
	    		'type'     :'POST',
	    		'url'      : '<?php echo $this->createUrl('Findbank'); ?>',
				'dataType' : 'json',
				'data'     : {'client_cd' : client_cd,
 							'acct_bawah':acct_bawah
							},	
					'success'  : function(data){
					var bank_cd=data.bank_cd;
					$('#bank_bawah').val(bank_cd);
					
				
				},
				'async':false
		});
			}	


function format(n, currency) {
    return currency + " " + n.toFixed(2).replace(/./g, function(c, i, a) {
        return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
    });
	}
function ceksaldo(){
	var client_cd = $('#Tfundmovement_client_cd').val();
	var tanggal=$('#Tfundmovement_doc_date').val();
	$.ajax({
	    		'type'     :'POST',
	    		'url'      : '<?php echo $this->createUrl('ClientCd'); ?>',
				'dataType' : 'json',
				'data'     : {'client_cd' : client_cd,
 							'tanggal': tanggal
							},
				'success'  : function(data){
					var saldo=data.saldo;
					
					if(saldo == null){
							$('#saldo').html('');
						}
						else{
							$('#saldo').html(setting.func.number.addCommasDec(saldo));
						}
				}
			});	
			
				$.ajax({
	    		'type'     :'POST',
	    		'url'      : '<?php echo $this->createUrl('CekHoliday'); ?>',
				'dataType' : 'json',
				'data'     : {
 							'tanggal': tanggal
							},
				'success'  : function(data){
					var holiday=data.holiday;
					
				
				if (holiday == 1){
					alert('Hari Libur Bursa');	
				}			
					
				}
			});	
			
			
}
function set_acct(){
	
	var client_cd = $('#Tfundmovement_client_cd').val();
	var acct_bawah=$('#acct_bawah1').val();
	
	$('#acct_bawah').val(acct_bawah);
	$.ajax({
	    		'type'     :'POST',
	    		'url'      : '<?php echo $this->createUrl('Findbank'); ?>',
				'dataType' : 'json',
				'data'     : {'client_cd' : client_cd,
 							'acct_bawah':acct_bawah
							},	
					'success'  : function(data){
					var bank_cd=data.bank_cd;
					
					$('#bank_bawah').val(bank_cd);
					
				
				},
				'async':false
		});
		cekFee();
}

function cekFee(){
		var trx_amt=$('#Tfundmovement_trx_amt').val();
		var bank_bawah=$('#bank_bawah').val();
		var bank_atas=$('#bank_atas').val();
	
		var movement_type = $('#Tfundmovement_trx_type').val();
		var client_cd = $('#Tfundmovement_client_cd').val();
		
		var branch_cd=$('#branch_cd').val();
		if(movement_type == 'W'){
			$.ajax({
	    		'type'     :'POST',
	    		'url'      : '<?php echo $this->CreateUrl('CheckFee'); ?>',
				'dataType' : 'json',
				'data'     : {'client_cd' : client_cd,
 								'trx_amt' :trx_amt,
 								'bank_bawah' :bank_bawah,
 								'bank_atas':bank_atas,
 								'branch_cd':branch_cd
							},
				'success'  : function(data){
						var fee= data.fee2;
					
					//$('#fee').val(Math.abs(fee));
					
					
				}
			});
			
		}
	
			
}

function getClient()
	{
		//alert('est');
		//var glAcctCd = $(obj).val();
		var result = [];
		$('#Tfundmovement_client_cd').autocomplete(
		{
			source: function (request, response) 
			{
		        $.ajax({
		        	'type'		: 'POST',
		        	'url'		: '<?php echo $this->createUrl('Getclientcd'); ?>',
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
		    change: function(event,ui)
	        {
	        	$(this).val($(this).val().toUpperCase());
	        	if (ui.item==null)
	            {
	            	// Only accept value that matches the items in the autocomplete list
	            	
	            	var inputVal = $(this).val();
	            	var match = false;
	            	
	            	$.each(result,function()
	            	{
	            		if(this.value.toUpperCase() == inputVal)
	            		{
	            			match = true;
	            			return false;
	            		}
	            	});
	            	/*
		            if(!match)
		            {
		            	alert("SL Account not found in chart of accounts");
		            	$(this).val('');
		            }
		            */
		            //$(this).focus();
	            }
	        },
		    minLength: 0,
		     open: function()
		   {
        		$(this).autocomplete("widget").width(400); 
           },
		}).focus(function(){     
            $(this).data("autocomplete").search($(this).val());
        });
	}
	$('#Tfundmovement_client_cd').change(function(){
	movement_type();	
		if($('#Tfundmovement_trx_type').val() =='I' || $('#Tfundmovement_trx_type').val() =='O')
		{
			$('#Tfundmovement_acct_name').val($('#Tfundmovement_client_cd').val().toUpperCase());
		}
		set_default_bank_client();
	})
	
	$('#stk_cd').change(function(){
			
			$('#stk_cd').val($('#stk_cd').val().toUpperCase());
			var stk_cd= $('#stk_cd').val(); 
			
			$.ajax({
	    		'type'     :'POST',
	    		'url'      : '<?php echo $this->CreateUrl('CheckBankStock'); ?>',
				'dataType' : 'json',
				'data'     : {'stk_cd' : stk_cd,
							},
				'success'  : function(data){
					
					
					$('#bank_atas').val(data.bank_cd);
					$('#acct_atas').val(data.bank_acct_num);
					$('#bank_bawah').val(data.bank_cd);
					$('#acct_bawah').val(data.bank_acct_num);
					$('#from_client').val($('#Tfundmovement_client_cd').val());
					$('#to_client').val($('#Tfundmovement_client_cd').val());
				}
			});
			
	})
	
	$('#Tfundmovement_remarks').change(function(){
		$('#Tfundmovement_remarks').val($('#Tfundmovement_remarks').val().toUpperCase());
	})
	
	function set_default_bank_client()
	{
				$.ajax({
	    		'type'     :'POST',
	    		'url'      : '<?php echo $this->CreateUrl('GetDefaultBank'); ?>',
				'dataType' : 'json',
				'data'     : {'client_cd' : $('#Tfundmovement_client_cd').val(),
							},
				'success'  : function(data){
					if($('#Tfundmovement_trx_type').val() !='B')
					{
					$('#bank_bawah').val(data.bank_cd);
					$('#acct_bawah').val(data.bank_acct_num);
					$('#acct_bawah1').val(data.bank_acct_num);
					}
				}
			});
	}
</script>

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

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tfundmovement-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

<?php
$sql="select bank_cd ||'-'|| bank_name AS BANK,bank_cd from mst_ip_bank where approved_stat='A' order by bank_cd";
$bank_cd=DAO::queryAllSql($sql);
?>
	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<?php echo $form->errorSummary($oldModel); ?>
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
			<?php echo $form->textField($model,'doc_date',array('placeholder'=>'dd/mm/yyyy','onchange'=>'ceklibur()','class'=>'span tdate'));?>
			<?php //echo $form->datePickerRow($model,'doc_date',array('label'=>false,'style'=>'margin-left:-30px;','placeholder'=>'dd/mm/yyyy','class'=>'span tdate')); ?>
		</div>
		<div class="span2">
			<?php echo $form->dropDownList($model,'trx_type',Constanta::$movement_type,array('class'=>'span','onchange'=>'movement_type()','maxlength'=>1,'prompt'=>'-Select type-')); ?>
		</div>
		<div class="span2">
			<?php //echo $form->dropDownList($model,'client_cd',CHtml::listData(Clientflacct::model()->findAll(array('order'=>'client_cd')),'client_cd', 'client_cd'),array('class'=>'span','onchange'=>'movement_type()','maxlength'=>12)); ?>
			<?php  echo $form->textField($model,'client_cd',array('class'=>'span','maxlength'=>12));?>	
				<!--<div class="control-group">
	
	<?php /* $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
							'model'=>$model,
						    'name'=>'Tfundmovement[client_cd]',
						    'attribute'=>'client_cd',
						    // additional javascript options for the autocomplete plugin
						    'options'=>array(
						        'minLength'=>'1',
						    ),
						    'source'=>$this->createUrl("/finance/tfundmovement/Getclientcd"),
						    'htmlOptions'=>array( 'value'=>$model->client_cd,'onchange'=>'movement_type()',
						        'style'=>'height:19px;width:100px;','showAnim'=>'fold',
						    ),
						));
	*/
	?>
	</div>-->
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
		</div>
		<div class="span2">
			<label id="rek_dana">Rekening Dana</label>
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
		<div class="span1" style="margin-left:-20px;width:85px;">
			<?php  echo $form->textField($model,'folder_cd',array('class'=>'span','id'=>'folder_cd','maxlength'=>8)); ?>
			
		</div>
	</div>
<div class="row-fluid control-group">
	<div class="span2">
		<label id="text_saldo">Saldo</label>
	</div>
	<div class="span1">
		<label id="saldo" ></label>
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
				<?php echo $form->textField($model,'nama',array('class'=>'span','value'=>$model->acct_name,'maxlength'=>50)); ?>
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
		<?php echo $form->dropDownList($model,'from_bank',CHtml::listData($bank_cd,'bank_cd', 'bank'),array('class'=>'span','id'=>'bank_bawah','maxlength'=>12));?>
</div>
<div class="span3">
	<?php echo $form->dropDownList($model,'no_rek',array(),array('class'=>'span','id'=>'acct_bawah1','onchange'=>'set_acct()','maxlength'=>12));?>
</div>
</div>


<div class="row-fluid control-group">
	<div class="span3">
		
	</div>
	<div class="span5">
		<?php  echo $form->textField($model,'from_acct',array('class'=>'span','id'=>'acct_bawah','onchange'=>'from_acct_num()','maxlength'=>12));?>
		<!--<div class="control-group">
		
	<?php /* $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
					//		'model'=>$model,
						    'name'=>'Tfundmovement[from_acct]',
						    'attribute'=>'from_acct',
						     'id'=>'acct_bawah',
						    'value'=>$model->from_acct,
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
	</div>--->
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
<div class="row-fluid control-group">
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
  	



init();
from_acct_num();


	
	$('#bank_bawah').change(function(){
		
		cekFee();
	});
	
	var from_client='<?php echo $model->from_client;?>';
	
	if(from_client =='BUNGA'){
		$('#Tfundmovement_trx_type').val('B');
	}
	else{
		$('#Tfundmovement_trx_type').val('<?php echo $model->trx_type;?>');
	}
	

function init(){
	getClient();
	var client_cd = $('#Tfundmovement_client_cd').val();
	var movement_type = $('#Tfundmovement_trx_type').val();
	if(movement_type=='R'){
		$('#text_bawah').show();
		$('#rek_dana').show();
		$('#fee').show();
		$('#text').show();
		$('#text').html('KE');
		$('#text_bawah').html('DARI');
		$('#folder_cd').show();
		$('#text_saldo').hide();
		$('#saldo').hide();
		$('#no_rek_dana').show();
		$('#nama').show();
		$('#bank_rek_pribadi').show();
		$('#Tfundmovement_nama').show();
		$('#acct_atas').show();
		$('#bank_atas').attr('name','Tfundmovement[to_bank]');
		$('#acct_atas').attr('name','Tfundmovement[to_acct]');
		$('#bank_bawah').attr('name','Tfundmovement[from_bank]');
		$('#acct_bawah').attr('name','Tfundmovement[from_acct]');
		$('#acct_bawah1').show();
		$.ajax({
	    		'type'     :'POST',
	    		'url'      : '<?php echo $this->createUrl('Getbankcd'); ?>',
				'dataType' : 'json',
				'data'     : {'client_cd' : client_cd,
 
							},
				'success'  : function(data){
							$(data.to_acct1).each(function(i){
				//alert(this.to_acct);
							
							$('#acct_bawah1').append($('<option>').val(this.acct_bawah).html(this.acct_num));
					});
					
				}
			});
		$('#acct_bawah1').empty();	
	}
	else if(movement_type=='W'){
		$('#text_bawah').show();
		$('#text_bawah').html('KE');
		$('#text').html('DARI');
		$('#text').show();
		$('#fee').show();
		$('#folder_cd').show();
		$('#folder_cd').show();
		$('#text_saldo').hide();
		$('#saldo').hide();
		$('#rek_dana').show();
		$('#no_rek_dana').show();
		$('#nama').show();
		$('#bank_rek_pribadi').show();
		$('#Tfundmovement_nama').show();
		$('#acct_atas').show();
		$('#bank_atas').attr('name','Tfundmovement[from_bank]');
		$('#acct_atas').attr('name','Tfundmovement[from_acct]');
		$('#bank_bawah').attr('name','Tfundmovement[to_bank]');
		$('#acct_bawah').attr('name','Tfundmovement[to_acct]');
		$('#acct_bawah1').show();
		$.ajax({
	    		'type'     :'POST',
	    		'url'      : '<?php echo $this->createUrl('Getbankcd'); ?>',
				'dataType' : 'json',
				'data'     : {'client_cd' : client_cd,
 
							},
				'success'  : function(data){
							$(data.to_acct1).each(function(i){
				//alert(this.to_acct);
							
							$('#acct_bawah1').append($('<option>').val(this.acct_bawah).html(this.acct_num));
					});
					
				}
			});
		$('#acct_bawah1').empty();	
		cekFee();
	}
	else{
		$('#text_saldo').hide();
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
		$('#acct_atas').attr('name','Tfundmovement[to_acct]');
		$('#bank_atas').attr('name','Tfundmovement[to_bank]');
		$('#bank_bawah').attr('name','Tfundmovement[from_bank]');
		$('#acct_bawah').attr('name','Tfundmovement[from_acct]');
		$('#acct_bawah1').hide();
	}
}



$('.tdate').datepicker({'format':'dd/mm/yyyy','language':'en'});
$('#datetimepicker').datetimepicker({format:'d/m/Y H:i:s'});
//	$('#text').html('KE');
	
	
	function movement_type(){
		
	
		var movement_type = $('#Tfundmovement_trx_type').val();
		var client_cd = $('#Tfundmovement_client_cd').val();
		if(movement_type == 'R'){
			$('#fee').val('');
			$('#bank_bawah').val('');
			//$('#acct_bawah').val('');
			$('#acct_bawah1').show();
			$('#text').show();
			$('#text_bawah').show();
			$('#text').html('KE');
			$('#rek_dana').show();
			$('#fee').show();
			$('#folder_cd').show();
			$('#text_saldo').hide();
			$('#saldo').hide();
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
			
			$.ajax({
	    		'type'     :'POST',
	    		'url'      : '<?php echo $this->createUrl('ClientCd'); ?>',
				'dataType' : 'json',
				'data'     : {'client_cd' : client_cd,
 								'tanggal':''
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
					$('#Tfundmovement_acct_name').val(acct_name);
					
					$('#bank_atas').val(bank_cd);
					$('#acct_atas').val(bank_acct_num);
					$('#Tfundmovement_nama').val(acct_name_client);
					
					$('#acct_bawah').val(bank_acct_num_mst_client);
				
					
				}
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
					
				}
			});
			
		$('#acct_bawah1').empty();
		}
		else if(movement_type == 'W'){
				$('#bank_bawah').val('');
				//$('#acct_bawah').val('');
				$('#datetimepicker').val('');
				$('#text').show();
				$('#text').html('DARI');
				$('#text_bawah').show();
				$('#from_client').val('FUND');
				$('#to_client').val('LUAR');
				$('#text_bawah').html('KE');
				
				$('#bank_atas').attr('name','Tfundmovement[from_bank]');
				$('#acct_atas').attr('name','Tfundmovement[from_acct]');
				$('#bank_bawah').attr('name','Tfundmovement[to_bank]');
				$('#acct_bawah').attr('name','Tfundmovement[to_acct]');
				$('#rek_dana').show();
				$('#fee').show();
				$('#folder_cd').show();
				$('#text_saldo').hide();
				$('#saldo').hide();
				$('#bank_atas').show();
				$('#no_rek_dana').show();
				$('#acct_atas').show();
				$('#nama').show();
				$('#Tfundmovement_nama').show();
				$('#bank_rek_pribadi').show();
				$('#bank_bawah').show();
				$('#acct_bawah').show();
				$('#acct_bawah1').show();
				$('#bank_timestamp').show();
				
				$('#datetimepicker').show();
				$('#placehold').show();
				$.ajax({
	    		'type'     :'POST',
	    		'url'      : '<?php echo $this->createUrl('ClientCd'); ?>',
				'dataType' : 'json',
				'data'     : {'client_cd' : client_cd,
 								'tanggal':''
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
					$('#Tfundmovement_acct_name').val(acct_name);
				
					$('#bank_atas').val(bank_cd);
					$('#acct_atas').val(bank_acct_num);
					$('#Tfundmovement_nama').val(acct_name_client);
					$('#bank_bawah').val(bank_cd_mst_client);
					$('#acct_bawah').val(bank_acct_num_mst_client);
					
				}
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
					
				}
			});
			
		$('#acct_bawah1').empty();
				branchcd();
			cekFee();
		}
		else{
			$('#fee').val('');
			$('#acct_bawah1').hide();
			$('#from_client').val('BUNGA');
			$('#to_client').val('FUND');
			$('#text').hide();
			$('#text_bawah').hide();
			$('#rek_dana').show();
			$('fee').show();
			$('#folder_cd').show();
			$('#text_saldo').hide();
			$('#saldo').hide();
			$('#bank_atas').hide();
			$('#no_rek_dana').hide();
			$('#acct_atas').hide();
			$('#nama').hide();
			$('#Tfundmovement_nama').hide();
			$('#bank_bawah').hide();
			$('#bank_rek_pribadi').hide();
			$('#bank_timestamp').show();
			
			$('#datetimepicker').show();
			$('#placehold').show();
			$('#acct_bawah').attr('name','Tfundmovement[from_acct]');
			$('#acct_bawah').val('-');
			$.ajax({
	    		'type'     :'POST',
	    		'url'      : '<?php echo $this->createUrl('ClientCd'); ?>',
				'dataType' : 'json',
				'data'     : {'client_cd' : client_cd,
 							'tanggal':''
							},
				'success'  : function(data){
						var acct_name= data.acct_name;
						var bank_cd=data.bank_cd;
						var bank_acct_num=data.bank_acct_num;
						//alert(bank_cd);
						
					$('#Tfundmovement_acct_name').val(acct_name);
					
				
					$('#acct_atas').attr('name','Tfundmovement[to_acct]');
					$('#acct_atas').val(bank_acct_num);
					$('#bank_atas').attr('name','Tfundmovement[to_bank]');
					$('#bank_atas').val(bank_cd);
					$('#bank_bawah').attr('name','Tfundmovement[from_bank]');
					$('#bank_bawah').append($('<option>').val(bank_cd).html(bank_cd));
					
				}
				});
				
		
				
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
						//alert(branch);
					$('#branch_cd').val(branch);
					
				}
				});
		
	
}
function fundbank(){
	var client_cd = $('#Tfundmovement_client_cd').val();
	$.ajax({
	    		'type'     :'POST',
	    		'url'      : '<?php echo $this->createUrl('ClientCd'); ?>',
				'dataType' : 'json',
				'data'     : {'client_cd' : client_cd,
 									'tanggal':''
							},
				'success'  : function(data){
					
						var bank_cd=data.bank_cd;
						var bank_acct_num=data.bank_acct_num;
				
					$('#fund_bank_cd').val(bank_cd);
					$('#fund_bank_acct').val(bank_acct_num);
					
				}
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
				//	$('#bank_bawah').val(bank_cd);
						
					
				}
			});	
}
function bank_bawah1(){
	var client_cd = $('#Tfundmovement_client_cd').val();
	var bank_bawah=$('#bank_bawah').val();
	$.ajax({
	    		'type'     :'POST',
	    		'url'      : '<?php echo $this->createUrl('Findacct'); ?>',
				'dataType' : 'json',
				'data'     : {'client_cd' : client_cd,
 							'bank_bawah':bank_bawah
							},
				'success'  : function(data){
					var bank_acct_num=data.bank_acct_num;
					$('#acct_bawah').val(bank_acct_num);
						
					
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
					
				
				}
		});
		cekFee();
	
}
function bank_num(){
	var bank_bawah=$('#bank_bawah').val();
	var client_cd = $('#Tfundmovement_client_cd').val();
	
	$.ajax({
	    		'type'     :'POST',
	    		'url'      : '<?php echo $this->createUrl('Getdropacct'); ?>',
				'dataType' : 'json',
				'data'     : {'client_cd' : client_cd,
 							'bank_bawah':bank_bawah
							},
				'success'  : function(data){
					var acct_bawah2=data.act_bawah2;
							$(data.to_acct1).each(function(i){
				//alert(this.to_acct);
							
							$('#acct_bawah1').append($('<option>').val(this.acct_bawah1).html(this.acct_num));
							$('#acct_bawah').val(this.acct_bawah1);
					});
					
				}
			});
			
		$('#acct_bawah1').empty();
}

function ceklibur(){
		var tanggal=$('#Tfundmovement_doc_date').val();
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
					
					$('#fee').val(Math.abs(fee));
				
					
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
		
	})
</script>
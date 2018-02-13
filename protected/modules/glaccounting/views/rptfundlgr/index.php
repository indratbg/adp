<style>
	.help-inline.error{display: none;}
	.radio.inline label{margin-left: 15px;}
	.well { padding: 2px; margin: 0px 0px 5px 0px; text-align: center;}
	.table-compact{ padding: 0px; }
	.table-compact tr td{ padding: 0px; } 
</style>

<?php 
	$this->breadcrumbs=array(
	'Report Fund Ledger'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Report Fund Ledger', 'itemOptions'=>array('style'=>'font-size:28px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	//array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/postinginterest/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
);

?>
	

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'importTransaction-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>
	
	<?php AHelper::showFlash($this) ?> 
	<?php echo $form->errorSummary(array($model)); ?>

	
<?php
	$month = array(
		1 => 'January',
		2 => 'February',
		3 => 'March',
		4 => 'April',
		5 => 'May',
		6 => 'June',
		7 => 'July',
		8 => 'August',
		9 => 'September',
		10 => 'October',
		11 => 'November',
		12 => 'December'
	);
	$currYear=date('Y');
	$year=array();
	
	$result=Dao::queryRowSql("SELECT DDATE1 FROM MST_SYS_PARAM WHERE PARAM_ID='SOA' AND PARAM_CD1='BGN_DATE'");
	$bgnDate=$result['ddate1'];
	
	$bgnYear = DateTime::createFromFormat('Y-m-d H:i:s',$bgnDate)->format('Y');
	
	for($x=$currYear;$x>=$bgnYear;$x--){
		$year[$x]=$x;
	}
	
?>
	<br>
	<div class="row-fluid">
		<div class="control-group">
		<div class='span5'>
		<div class="control-group">
			<div class="span2">
				<?php echo $form->label($model,'Month of ',array('class'=>'control-label')) ?>
			</div>
			<div class="span8">
				<?php echo $form->dropDownList($model,'month',$month,array('id'=>'month','class'=>'span4')) ?>
				<?php echo $form->dropDownList($model,'year',$year,array('id'=>'year','class'=>'span4')) ?>
				&nbsp;
				&nbsp;
				&nbsp;
			</div>
		</div>
		<div class="control-group">
		<div class="span2">
				<?php echo $form->label($model,'Date From ',array('class'=>'control-label')) ?>
		</div>
		<div class="span8">	
				<?php echo $form->textField($model,'from_dt',array('id'=>'fromDt','placeholder'=>'dd/mm/yyyy','class'=>'tdate span4','required'=>true)); ?>
				&emsp;
				To &nbsp;
				<?php echo $form->textField($model,'to_dt',array('id'=>'toDt','placeholder'=>'dd/mm/yyyy','class'=>'tdate span4','required'=>true)); ?>
			
		</div>
		</div>
		<div class="control-group">
			<div class="span2">
				<?php echo $form->label($model,'Pemilik ',array('class'=>'control-label')) ?>
			</div>
			<div class="span10">
				<?php echo $form->radioButton($model, 'selected_opt',array('id'=>'clientOpt1','value'=>'0','uncheckValue'=>null,'class'=>'span1 option'))?>Nasabah Pemilik Rekening
				&nbsp;</br>
				<?php echo $form->radioButton($model, 'selected_opt',array('id'=>'clientOpt2','value'=>'1','uncheckValue'=>null,'class'=>'span1 option','disabled'=>TRUE))?>Perusahaan Efek	
				&nbsp;</br>
				<?php echo $form->radioButton($model, 'selected_opt',array('id'=>'clientOpt3','value'=>'2','uncheckValue'=>null,'class'=>'span1 option','disabled'=>TRUE))?>Nasabah Umum
				&nbsp;</br>
				<?php echo $form->radioButton($model, 'selected_opt',array('id'=>'clientOpt4','value'=>'3','uncheckValue'=>null,'class'=>'span1 option','disabled'=>TRUE))?>All				
			</div>
		</div>
		</div>
		<div class='span7'>
		<div class="control-group">
			<div class="span3">
				<?php echo $form->label($model,'All GL account',array('class'=>'control-label')) ?>
				<?php echo $form->checkBox($model,'gl_a',array('id'=>'all_gl_a','value'=>'1','uncheckValue'=>null));?>
			</div>
			<div class="span8">
				Specified&nbsp;
				<?php echo $form->dropdownList($model,'val_gl_a',CHtml::listData($mGl_a, 'gl_a', 'gl_a'),array('id'=>'gl_a','class'=>'span5','prompt'=>'-- select GL Acct --'));?>
			</div>				
		</div>
		<div class="control-group">
			<div class="span3">
				<?php echo $form->label($model,'All GL sub acct',array('class'=>'control-label')) ?>
				<?php echo $form->checkBox($model,'sl_a',array('id'=>'all_sl_a','value'=>'1','uncheckValue'=>null));?>
			</div>
			<div class="span8">
				Specified&nbsp;
				<?php echo $form->dropdownList($model,'val_sl_a',CHtml::listData($mSl_a, 'bank_cd', 'acct_name'),array('id'=>'sl_a','class'=>'span5','prompt'=>'-- select SL Acct --'));?>
			</div>				
		</div>
		<div class="control-group">
			<div class="span3">
				<?php echo $form->label($model,'All fund ledger acct',array('class'=>'control-label')) ?>
				<?php echo $form->checkBox($model,'acct_cd',array('id'=>'all_fl_a','value'=>'1','uncheckValue'=>null));?>
			</div>
			<div class="span8">
				Specified&nbsp;
				<?php echo $form->dropdownList($model,'val_acct_cd',CHtml::listData($mFlacct, 'acct_cd', 'acct_name'),array('id'=>'fl_a','class'=>'span5','prompt'=>'-- select FL Acct --'));?>
			</div>				
		</div>
		<div class="control-group">
			<div class="span3">
				<?php echo $form->label($model,'All clients',array('class'=>'control-label')) ?>
				<?php echo $form->checkBox($model,'client_cd',array('id'=>'all_client_Cd','value'=>'1','uncheckValue'=>null));?>
			</div>
			<div class="span8">
				Specified&nbsp;
				<?php echo $form->textField($model,'val_client_cd',array('id'=>'client_Cd','class'=>'span5'));?>
			</div>				
		</div>
		</div>
		</div>
		
		<div class="control-group">
			<div class="span8">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType'=>'submit',
					'type'=>'primary',
					'label'=>'Show Report',
					'id'=>'btnProcess'
				)); ?>
			</div>
		</div>
	</div>
	<?php echo $form->datePickerRow($model,'dummy_dt',array('label'=>false,'style'=>'display:none')) ?>
<?php $this->endWidget(); ?>

<iframe src="<?php echo $url; ?>" class="span12" style="min-height:600px;"></iframe>

<script type="text/javascript" charset="utf-8">

	$(document).ready(function()
	{
		$("#fromDt").datepicker({format:'dd/mm/yyyy'});
		$("#toDt").datepicker({format:'dd/mm/yyyy'});
		//setAutoCompleteClient();
		//updateDate();
		optionPemilik();
	});
	
	$("#btnProcess").click(function(event)
	{	
		//console.log("klik");
		var specClient=$('input:radio[name="Rptfundlgrjur[selected_opt]"]:checked').val();
		console.log("specClient: "+specClient)
		var isSpecClient=(specClient==='4');
		
		var clientPass = (isSpecClient&&$("#client_Cd").val() || !isSpecClient)?true:false;
		
		if(!clientPass){
			alert("Client harus diisi jika centang Specified Client")
			return false;
		}
	
	})
	
	$("#month, #year").change(function()
	{	
		updateDate();
		
	});
	
	$('.option').click(function(){
		optionClientCd();
	})
	
	function optionPemilik()
	{	
		var specClient=$('input:radio[name="Rptfundlgr[selected_opt]"]:checked').val();
		var isSpecClient=(specClient==='0');
		// console.log('specClient: '+isSpecClient);
		$('#all_gl_a').attr('disabled',isSpecClient);
		$('#all_sl_a').attr('disabled',isSpecClient);
		//$('#all_fl_a').attr('disabled',isSpecClient);
		$('#gl_a').attr('disabled',isSpecClient);
		$('#sl_a').attr('disabled',isSpecClient);
		//$('#fl_a').attr('disabled',isSpecClient);
		//$('#client_Cd').attr('readonly',isSpecClient);	
	}
	
	$('#all_gl_a').click(function(){
		optionGla();
	})
	
	function optionGla()
	{
		var specGla=$('input:checkbox[name="Rptfundlgr[gl_a]"]:checked').val();
		console.log('specGla: '+specGla);
		var isSpecGla=(specGla==='1');
		$('#gl_a').attr('disabled',isSpecGla);
		
	}
	
	$('#all_sl_a').click(function(){
		optionSla();
	})
	
	function optionSla()
	{
		var specSla=$('input:checkbox[name="Rptfundlgr[sl_a]"]:checked').val();
		console.log('specSla: '+specSla);
		var isSpecSla=(specSla==='1');
		$('#sl_a').attr('disabled',isSpecSla);
		
	}
	
	$('#all_fl_a').click(function(){
		optionFla();
	})
	
	function optionFla()
	{
		var specFla=$('input:checkbox[name="Rptfundlgr[acct_cd]"]:checked').val();
		console.log('specFla: '+specFla);
		var isSpecFla=(specFla==='1');
		$('#fl_a').attr('disabled',isSpecFla);
		
	}
	
	$('#all_client_Cd').click(function(){
		optionClientcd();
	})
	
	function optionClientcd()
	{
		var specClient=$('input:checkbox[name="Rptfundlgr[client_cd]"]:checked').val();
		console.log('specClient: '+specClient);
		var isSpecClient=(specClient==='1');
		$('#client_Cd').attr('disabled',isSpecClient);
		
	}
	
	function updateDate(){
		var firstDate = new Date($("#year").val(),$("#month").val()-1,1);
		var lastDate  = new Date($("#year").val(),$("#month").val(),0);
		
		$("#fromDt").val('0'+firstDate.getDate() + '/' + ('0'+(firstDate.getMonth()+1)).slice(-2) + '/' + firstDate.getFullYear());
		$("#toDt").val(lastDate.getDate() + '/' + ('0'+(lastDate.getMonth()+1)).slice(-2) + '/' + lastDate.getFullYear());
		
		$("#fromDt").datepicker("update");
		$("#toDt").datepicker("update");
	}
	
	$('#client_Cd').autocomplete(
		{
			source: function (request, response) 
			{
		        $.ajax({
		        	'type'		: 'POST',
		        	'url'		: '<?php echo $this->createUrl('getclient'); ?>',
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
	            	
	            }
	        },
		    minLength: 1,
		    open: function()
		   {
        		$(this).autocomplete("widget").width(500); 
           },
           position: 
           {
           	    offset: '0 0' // Shift 150px to the left, 0px vertically.
    	   }
		});
</script>



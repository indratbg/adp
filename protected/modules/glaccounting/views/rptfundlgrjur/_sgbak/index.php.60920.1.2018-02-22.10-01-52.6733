<style>
	.help-inline.error{display: none;}
	.radio.inline label{margin-left: 15px;}
	.well { padding: 2px; margin: 0px 0px 5px 0px; text-align: center;}
	.table-compact{ padding: 0px; }
	.table-compact tr td{ padding: 0px; } 
</style>

<?php 
	$this->breadcrumbs=array(
	'Report Fund Ledger Journal'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Report Fund Ledger Journal', 'itemOptions'=>array('style'=>'font-size:28px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
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
				<div class="span1"></div>
				<div class="span8">
					<?php echo $form->label($model,'Month of : ',array('class'=>'control-label')) ?>
					<?php echo $form->dropDownList($model,'month',$month,array('id'=>'month','class'=>'span2')) ?>
					<?php echo $form->dropDownList($model,'year',$year,array('id'=>'year','class'=>'span2')) ?>
					&nbsp;
					&nbsp;
					&nbsp;
				</div>
			</div>
	</div>
	
	<div class="row-fluid">
		<div class="control-group">
		<div class="span1"></div>
		<div class="span8">
				<?php echo $form->label($model,'Date From : ',array('class'=>'control-label')) ?>
				
				<?php echo $form->textField($model,'from_dt',array('id'=>'fromDt','placeholder'=>'dd/mm/yyyy','class'=>'tdate span2','required'=>true)); ?>
				&emsp;
				To &nbsp;
				<?php echo $form->textField($model,'to_dt',array('id'=>'toDt','placeholder'=>'dd/mm/yyyy','class'=>'tdate span2','required'=>true)); ?>
			
		</div>
	</div>
	
	<div class="row-fluid">
			<div class="control-group">
				<div class="span1"></div>
				<div class="span8">
					<?php echo $form->label($model,'Journal Number : ',array('class'=>'control-label')) ?>
					<?php echo $form->textField($model,'jur_num',array('class'=>'span4')) ?>
					&nbsp;
					&nbsp;
					&nbsp;
				</div>
			</div>
	</div>
	
	<div class="row-fluid">
			<div class="control-group">
				<div class="span1"></div>
				<div class="span8">
					<?php echo $form->label($model,'File No : ',array('class'=>'control-label')) ?>
					<?php echo $form->textField($model,'folder_cd',array('class'=>'span2')) ?>
					&nbsp;
					&nbsp;
					&nbsp;
				</div>
			</div>
	</div>
	
	<div class="row-fluid">
		<div class="control-group">
			<div class="span1"> </div>
			<div class="span1">
				<?php echo $form->label($model,'Owner: ',array('class'=>'control-label')) ?>
			</div>
			<div class="span6" style="margin-left: 75px" >
					<?php echo $form->radioButton($model, 'selected_opt',array('id'=>'clientOpt1','value'=>'0','uncheckValue'=>null,'class'=>'span1 option')). " PE" ?>
					<br/>
					<?php echo $form->radioButton($model, 'selected_opt',array('id'=>'clientOpt2','value'=>'1','uncheckValue'=>null,'class'=>'span1 option')). " All Client" ?>	
					<br />
					<?php echo $form->radioButton($model, 'selected_opt',array('id'=>'clientOpt3','value'=>'2','uncheckValue'=>null,'class'=>'span1 option')). " Nasabah Umum" ?>
					<br/>
					<?php echo $form->radioButton($model, 'selected_opt',array('id'=>'clientOpt4','value'=>'3','uncheckValue'=>null,'class'=>'span1 option')). " All" ?>	
					<br/>
					<?php echo $form->radioButton($model, 'selected_opt',array('id'=>'clientOpt5','value'=>'4','uncheckValue'=>null,'class'=>'span1 option')). " Specified Client" ?>
					
					
			</div>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="control-group">
		<div class="span1"> </div>
		<div class="span8">
			<?php echo $form->label($model,'Client : ',array('class'=>'control-label')) ?>
			<?php echo $form->textField($model,'client_cd',array('id'=>'client_Cd','required'=>'required','class'=>'span2','style'=>'width:100px'));?>
		</div>				
		</div>
	</div>
			
	<div class="control-group">
	</div>
	
	<div class="row-fluid">
		<div class="control-group">
			<div class="span1"></div>
			<div class="span8">
				<label class="control-label"></label>
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
		optionClientCd();
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
	
	function optionClientCd()
	{	
		
		var specClient=$('input:radio[name="Rptfundlgrjur[selected_opt]"]:checked').val();
		var isSpecClient=(specClient==='4');
		
		// console.log('specClient: '+isSpecClient);
		
		
		$('#client_Cd').attr('readonly',!isSpecClient);
			
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



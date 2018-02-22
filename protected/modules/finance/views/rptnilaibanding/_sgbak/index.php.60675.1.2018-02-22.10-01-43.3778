<style>
	.help-inline.error{display: none;}
	.radio.inline label{margin-left: 15px;}
	.well { padding: 2px; margin: 0px 0px 5px 0px; text-align: center;}
	.table-compact{ padding: 0px; }
	.table-compact tr td{ padding: 0px; } 
</style>

<?php 
	$this->breadcrumbs=array(
	'Nilai Banding'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Nilai Banding', 'itemOptions'=>array('style'=>'font-size:28px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
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
		<div class="span6">
			<div class="control-group">
				<div class="span2">Month</div>
				<div class="span3"><?php echo $form->dropDownList($model,'month',$month,array('id'=>'month','class'=>'span12')) ?></div>
				<div class="span1">Years</div>
				<div class="span3"><?php echo $form->dropDownList($model,'year',$year,array('id'=>'year','class'=>'span12')) ?></div>
			</div>
			
			<div class="control-group">
				<div class="span2">Date From</div>
				<div class="span3"><?php echo $form->textField($model,'from_dt',array('id'=>'fromDt','placeholder'=>'dd/mm/yyyy','class'=>'tdate span12','required'=>true)); ?></div>
				<div class="span1">To</div>
				<div class="span3"><?php echo $form->textField($model,'to_dt',array('id'=>'toDt','placeholder'=>'dd/mm/yyyy','class'=>'tdate span12','required'=>true)); ?></div>	
			</div>
		</div>
		
		<div class="span6">
			<div class="control-group">
				<div class="span2">Report Type</div>
				<div class="span2"><?php echo $form->radioButton($model,'rpt_type',array('id'=>'rpt1','value'=>'0','class'=>'span1 optrpt')). " List" ?></div>
				<div class="span3"><?php echo $form->radioButton($model,'rpt_type',array('id'=>'rpt2','value'=>'1','class'=>'span1 optrpt')). " Detail by client" ?></div>
			</div>
			
			<div class="control-group">
				<div class="span2">Client</div>
				<div class="span2"><?php echo $form->radioButton($model,'opt_clt',array('id'=>'clt1','value'=>'0','class'=>'span1 optacc')). " All" ?></div>
				<div class="span2"><?php echo $form->radioButton($model,'opt_clt',array('id'=>'clt2','value'=>'1','class'=>'span1 optacc')). " Specified" ?></div>
				<?php echo $form->textField($model,'clt_cd',array('id'=>'clt3','class'=>'span4'))?>
			</div>
		</div>
		
		<div class="control-group">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=>'Show Report',
				'id'=>'btnProcess'
			)); ?>
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
		optionClientCd();
		
		//setAutoCompleteClient();
		//updateDate();
	});
	
	$("#btnProcess").click(function(event)
	{	
		//console.log("klik");
		var specClient=$('input:radio[name="Rptnilaibanding[opt_clt]"]:checked').val();
		console.log("specClient: "+specClient)
		var isSpecClient=(specClient==='1');
		
		var clientPass = (isSpecClient&&$("#clt3").val() || !isSpecClient)?true:false;
		
		if(!clientPass){
			alert("Client harus diisi jika centang Specified Client")
			return false;
		}
	
	})
	
	$("#month, #year").change(function()
	{	
		updateDate();	
	});
	
	$('.optacc').click(function(){
		optionClientCd();
	})
	
	function optionClientCd()
	{	
		var client_CD=$('input:radio[name="Rptnilaibanding[opt_clt]"]:checked').val();
		var isacct_CD=(client_CD==='0');
		// console.log('specClient: '+isSpecClient);
		$('#clt3').attr('disabled',isacct_CD);		
	}
	
	function updateDate(){
	 	var firstDate = new Date($("#year").val(),$("#month").val()-1,1);
		var lastDate  = new Date($("#year").val(),$("#month").val(),0);
		
		$("#fromDt").val('0'+firstDate.getDate() + '/' + ('0'+(firstDate.getMonth()+1)).slice(-2) + '/' + firstDate.getFullYear());
		$("#toDt").val(lastDate.getDate() + '/' + ('0'+(lastDate.getMonth()+1)).slice(-2) + '/' + lastDate.getFullYear());
		
		$("#fromDt").datepicker("update");
		$("#toDt").datepicker("update");
		
	 }
	 
	 $('#clt3').autocomplete(
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



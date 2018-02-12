<?php
$this->breadcrumbs=array(
	'Trade Confirmation'=>array('index'),
	'Import',
);

$this->menu=array(
	array('label'=>'Trade Confirmation', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'Generate','url'=>array('index'),'icon'=>'list'),
	array('label'=>'Print','url'=>array('indexprint'),'icon'=>'list','itemOptions'=>array('class'=>'active')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/Ttcdoc/index','icon'=>'list'),
	/*
	array('label'=>'Test Gen TC','url'=>array('testgentc'),'icon'=>'plus','itemOptions' => array(
		'onclick' => 'javascript:window.open("'.Yii::app()->request->baseUrl.'?r=contracting/Ttcdoc1/testgentc'.'","tradeconf","status=1,width=800,height=500,scrollbars=1,menubar=yes,titlebar=yes,toolbar=yes"); return false;')),*/
	
);

?>

<h1>Print Trade Confirmation</h1>
<br />

<?php AHelper::showFlash($this) ?>
<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tcontracts-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

	<?php echo $form->errorSummary($model); ?>
	
	<div class="row-fluid">
		<div class="span2">
			<?php echo $form->label($model,'Trade Confirmation Date',array('for'=>'tcDate','class'=>'control-label')) ?>
		</div>
		<div class="span3">
			<?php echo $form->datePickerRow($model,'tc_date',array('id'=>'tcDate','prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span10','label'=>false,'options'=>array('format' => 'dd/mm/yyyy'))); ?>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span2">
			<?php echo $form->label($model,'Client',array('class'=>'control-label')) ?>
		</div>
		<div class="span3">
			<?php echo $form->radioButtonListInlineRow($model,'client_type',array('All','Specified'),array('id'=>'clientType','label'=>false,'onChange'=>'clientList()')) ?>
		</div>
		<?php echo $form->dropDownList($model,'client_cd',CHtml::listData(Ttcdoc1::model()->findAll(array('select'=>'DISTINCT client_cd','condition'=>"tc_date = TO_DATE('$model->tc_date','DD/MM/YYYY') AND tc_status = 0",'order'=>'client_cd')), 'client_cd', 'client_cd'),array('id'=>'clientCd','class'=>'span3','style'=>'display:none')) ?>
	</div>
	<div class="row-fluid">
		<div class="span2">
			<?php echo $form->label($model,'Client type',array('class'=>'control-label')) ?>
		</div>
		<div class="span3">
			<?php echo $form->dropDownListRow($model,'cl_type',CHtml::listData(Lsttype3::model()->findAll(array('order'=>'cl_type3')), 'cl_type3','cl_desc'),array('label'=>false,'class'=>'span','prompt'=>'-All-')) ?>
		</div>
		
	</div>
	
	<div class="row-fluid">
		<div class="span2">
			<?php echo $form->label($model,'Branch',array('class'=>'control-label')) ?>
		</div>
		<div class="span3">
			<?php echo $form->radioButtonListInlineRow($model,'brch_type',array('All','Specified'),array('id'=>'brchType','label'=>false,'onChange'=>'brchList()')) ?>
		</div>
		<?php echo $form->dropDownList($model,'brch_cd',CHtml::listData(Ttcdoc1::model()->findAll(array('select'=>'DISTINCT brch_cd','condition'=>"tc_date = TO_DATE('$model->tc_date','DD/MM/YYYY') AND tc_status = 0",'order'=>'brch_cd')), 'brch_cd', 'brch_cd'),array('id'=>'brchCd','class'=>'span3','style'=>'display:none')) ?>
	</div>
	
	<div class="row-fluid">
		<div class="span2">
			<?php echo $form->label($model,'Sales',array('class'=>'control-label')) ?>
		</div>
		<div class="span3">
			<?php echo $form->radioButtonListInlineRow($model,'rem_type',array('All','Specified'),array('id'=>'remType','label'=>false,'onChange'=>'remList()')) ?>
		</div>
		<?php echo $form->dropDownList($model,'rem_cd',CHtml::listData(Ttcdoc1::model()->findAll(array('select'=>'DISTINCT rem_cd','condition'=>"tc_date = TO_DATE('$model->tc_date','DD/MM/YYYY') AND tc_status = 0",'order'=>'rem_cd')), 'rem_cd', 'rem_cd'),array('id'=>'remCd','class'=>'span3','style'=>'display:none')) ?>
	</div>
	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType'=>'submit',
					'type'=>'primary',
					'label'=>'Print English Version',
					'htmlOptions'=>array('onclick'=>'printTCEng();')
		)); ?>
		&emsp;
		<?php $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType'=>'submit',
					'type'=>'primary',
					'label'=>'Print Indonesian Version',
					'htmlOptions'=>array('onclick'=>'printTCInd();')
		)); ?>
	</div>
	
	<br/><br/>
	
<?php $this->endWidget(); ?>

<script>
	init();
	clientList();
	brchList();
	remList();

	$("#tcDate").datepicker( "widget" ).on('changeDate',function()
	{
		getClientList();
		getBrchList();
		getRemList();
	});
	
	function init()
	{
		$("#tcDate").datepicker({format : "dd/mm/yyyy"});
	}

	function getClientList()
	{
		$.ajax({
    		'type'     :'POST',
    		'url'      : '<?php echo $this->createUrl('ajxGetClientList2'); ?>',
			'dataType' : 'json',
			'data'     : {
							'tc_date' : $("#tcDate").val(),
						}, 
			'success'  : function(data){
				var result = data.content.client_cd;
				
				$('#clientCd').empty();
				
				$.each(result, function(i, item) {
			    	$('#clientCd').append($('<option>').val(result[i]).text(result[i]));
				});		
			}
		});
	}
	
	function getBrchList()
	{
		$.ajax({
    		'type'     :'POST',
    		'url'      : '<?php echo $this->createUrl('ajxGetBrchList'); ?>',
			'dataType' : 'json',
			'data'     : {
							'tc_date' : $("#tcDate").val(),
						}, 
			'success'  : function(data){
				var result = data.content.brch_cd;
				
				$('#brchCd').empty();
				
				$.each(result, function(i, item) {
			    	$('#brchCd').append($('<option>').val(result[i]).text(result[i]));
				});		
			}
		});
	}
	
	function getRemList()
	{
		$.ajax({
    		'type'     :'POST',
    		'url'      : '<?php echo $this->createUrl('ajxGetRemList'); ?>',
			'dataType' : 'json',
			'data'     : {
							'tc_date' : $("#tcDate").val(),
						}, 
			'success'  : function(data){
				var result = data.content.rem_cd;
				
				$('#remCd').empty();
				
				$.each(result, function(i, item) {
			    	$('#remCd').append($('<option>').val(result[i]).text(result[i]));
				});		
			}
		});
	}
	
	function clientList()
	{	
		if($("#Ttcdoc1_client_type_1").is(':checked'))
		{
			$("#clientCd").show();
		}
		else
		{
			$("#clientCd").hide();
		}
	}
	
	function brchList()
	{	
		if($("#Ttcdoc1_brch_type_1").is(':checked'))
		{
			$("#brchCd").show();
		}
		else
		{
			$("#brchCd").hide();
		}
	}
	
	function remList()
	{	
		if($("#Ttcdoc1_rem_type_1").is(':checked'))
		{
			$("#remCd").show();
		}
		else
		{
			$("#remCd").hide();
		}
	}
	
	function printTCEng(){
		var ptcdate = $("#tcDate").val();
		var pclientcd = '';
		var pbrchcd = '';
		var premcd = '';
		var cl_type = $('#Ttcdoc1_cl_type').val();
		if($("#Ttcdoc1_client_type_1").is(':checked')){
			pclientcd = $("#clientCd :selected").val();
		}else{
			pclientcd = '0';
		}
		
		if($("#Ttcdoc1_brch_type_1").is(':checked')){
			pbrchcd = $("#brchCd :selected").val();
		}else{
			pbrchcd = '0';
		}
		
		if($("#Ttcdoc1_rem_type_1").is(':checked')){
			premcd = $("#remCd :selected").val();
		}else{
			premcd = '0';
		}
		
		var purl = "<?php echo Yii::app()->request->baseUrl.'?r=contracting/Ttcdoc1/printeng'?>"+"&tc_date="+ptcdate+"&client_cd="+pclientcd+"&brch_cd="+pbrchcd+"&rem_cd="+premcd+"&cl_type="+cl_type;
		//alert(purl);
		
		javascript:window.open(purl,"tradeconf","status=1,width=800,height=500,scrollbars=1,menubar=yes,titlebar=yes,toolbar=yes"); return false;
	}
	
	function printTCInd(){
		var ptcdate = $("#tcDate").val();
		var pclientcd = '';
		var pbrchcd = '';
		var premcd = '';
		var cl_type = $('#Ttcdoc1_cl_type').val();
		
		if($("#Ttcdoc1_client_type_1").is(':checked')){
			pclientcd = $("#clientCd :selected").val();
		}else{
			pclientcd = '0';
		}
		
		if($("#Ttcdoc1_brch_type_1").is(':checked')){
			pbrchcd = $("#brchCd :selected").val();
		}else{
			pbrchcd = '0';
		}
		
		if($("#Ttcdoc1_rem_type_1").is(':checked')){
			premcd = $("#remCd :selected").val();
		}else{
			premcd = '0';
		}
		
		var purl = "<?php echo Yii::app()->request->baseUrl.'?r=contracting/Ttcdoc1/printind'?>"+"&tc_date="+ptcdate+"&client_cd="+pclientcd+"&brch_cd="+pbrchcd+"&rem_cd="+premcd+"&cl_type="+cl_type;
		//alert(purl);
		
		javascript:window.open(purl,"tradeconf","status=1,width=800,height=500,scrollbars=1,menubar=yes,titlebar=yes,toolbar=yes"); return false;
	}
</script>
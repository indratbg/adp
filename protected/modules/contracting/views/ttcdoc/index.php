<?php
$this->breadcrumbs=array(
	'Trade Confirmation'=>array('index'),
	'Import',
);

$this->menu=array(
	array('label'=>'Trade Confirmation', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active')),
);

?>

<h1>Generate Trade Confirmation</h1>

<br/><br/>

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
		<?php echo $form->dropDownList($model,'client_cd',CHtml::listData(Tcontracts::model()->findAll(array('select'=>'DISTINCT client_cd','condition'=>"contr_dt = TO_DATE('$model->tc_date','DD/MM/YYYY') AND contr_stat <> 'C'",'order'=>'client_cd')), 'client_cd', 'client_cd'),array('id'=>'clientCd','class'=>'span3','style'=>'display:none')) ?>
	</div>
	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType'=>'submit',
					'type'=>'primary',
					'label'=>'Save',
		)); ?>
	</div>
	
	<br/><br/>
	
<?php $this->endWidget(); ?>

<script>
	init();
	clientList();

	$("#tcDate").datepicker( "widget" ).on('changeDate',function()
	{
		getClientList();
	});
	
	function init()
	{
		$("#tcDate").datepicker({format : "dd/mm/yyyy"});
	}

	function getClientList()
	{
		$.ajax({
    		'type'     :'POST',
    		'url'      : '<?php echo $this->createUrl('ajxGetClientList'); ?>',
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
	
	function clientList()
	{	
		if($("#Ttcdoc_client_type_1").is(':checked'))
		{
			$("#clientCd").show();
		}
		else
		{
			$("#clientCd").hide();
		}
	}
</script>
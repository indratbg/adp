<?php
$this->breadcrumbs=array(
	'Trade Confirmation'=>array('index'),
	'Import',
);

$this->menu=array(
	array('label'=>'Trade Confirmation', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'Generate','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active')),
	array('label'=>'Print','url'=>array('indexprint'),'icon'=>'list'),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/Ttcdoc/index','icon'=>'list'),
	/*
	array('label'=>'Test Gen TC','url'=>array('testgentc'),'icon'=>'plus','itemOptions' => array(
		'onclick' => 'javascript:window.open("'.Yii::app()->request->baseUrl.'?r=contracting/Ttcdoc1/testgentc'.'","tradeconf","status=1,width=800,height=500,scrollbars=1,menubar=yes,titlebar=yes,toolbar=yes"); return false;')),
	*/
);

?>

<h1>Generate Trade Confirmation</h1>
<br />

<?php //AHelper::showFlash($this) ?>
<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tcontracts-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	//'htmlOptions' => array('enctype' => 'multipart/form-data','target'=>'hiddeniframe'),
)); ?>

	<?php //echo $form->errorSummary($model); ?>
	

	<?php if ($isfirst == 0 && $msg){?>
		<div class="alert in alert-block fade alert-info">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<?php echo $msg ;?>
		</div>
	<?php }?>
	
	
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
					'label'=>'Generate',
					'id'=>'btnGenerate'
		)); ?>
	</div>

	<br/><br/>
	<!--style="visibility: hidden"
	<iframe  name="hiddeniframe" width="800px" height="300px"></iframe>
	-->
	
<?php $this->endWidget(); ?>

<?php  $this->beginWidget('zii.widgets.jui.CJuiDialog',
    array(
        'id'=>'mywaitdialog',
        'options'=>array(
            'title'=>'In Progress',
            'modal'=>true,
            'autoOpen'=>false,// default is true
            'closeOnEscape'=>false,
            'resizable'=>false,
            'draggable'=>false,
            'height'=>120,
            'open'=>// supply a callback function to handle the open event
                    'js:function(){ // in this function hide the close button
                         $(".ui-dialog-titlebar-close").hide();
						 //$(".ui-dialog-content").hide();
						
                    }'
         ))
);

	$this->widget('bootstrap.widgets.TbProgress',
    array('percent' => 100, // the progress
        	'striped' => true,
        	'animated' => true,
    )
);
?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<script>



	init();
	clientList();
	<?php  if ($isfirst == 0){?>
		//alert("<?php //echo $msg?>");
		$('#mywaitdialog').hide();
		window.stop();
	<?php }?>


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
		if($("#Ttcdoc1_client_type_1").is(':checked'))
		{
			$("#clientCd").show();
		}
		else
		{
			$("#clientCd").hide();
		}
	}
	$('#btnGenerate').click(function(evt){
		$('#mywaitdialog').dialog("open");	
	})
</script>
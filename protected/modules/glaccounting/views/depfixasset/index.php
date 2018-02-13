<style>
	.help-inline.error{display: none;}
	.radio.inline label{margin-left: 15px;}
	.well { padding: 2px; margin: 0px 0px 5px 0px; text-align: center;}
	.table-compact{ padding: 0px; }
	.table-compact tr td{ padding: 0px; } 
</style>


<?php 
	$this->breadcrumbs=array(
	'Process Depreciation of Fixed Assets'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Process Depreciation of Fixed Assets', 'itemOptions'=>array('style'=>'font-size:28px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	//array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/postinginterest/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
);

?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'processDepFixAsset-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>
	
	
	<?php echo $form->errorSummary($model); ?>
	<?php AHelper::showFlash($this) ?> 
	<br>

	<div class="row-fluid">
		<div class="control-group">
			<div class="span1"> </div>
			<div class="span8">
			<?php echo $form->datePickerRow($model,'curr_date',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy')));?>
			</div>
		</div>
	</div>

	<div class="row-fluid">
		<div class="control-group">
			<div class="span1"></div>
			<div class="span8">
				<label class="control-label"></label>
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType'=>'submit',
					'type'=>'primary',
					'label'=>'Process',
					'id'=>'btnProcess',
					'htmlOptions'=>array('disabled'=>$flag=='Y'?true:false,'style'=>$flag=='Y'?'opacity:0.2':'opacity:1'),
				)); ?>
			</div>
		</div>
	</div>

<?php $this->endWidget(); ?>

<?php  $this->beginWidget('zii.widgets.jui.CJuiDialog',
    array(
        'id'=>'mywaitdialog',
        'options'=>array(
            'title'=>'Process Depreciation In Progress',
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

<script type="text/javascript" charset="utf-8">
	$("#btnProcess").click(function(event)
	{	
		//console.log("klik");
		
		if(confirm("Please confirm to process")){
			$('#mywaitdialog').dialog("open"); 
		}else{
			return false;
		}
	})
</script>



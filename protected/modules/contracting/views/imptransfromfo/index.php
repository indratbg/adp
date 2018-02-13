

<?php 
	$this->breadcrumbs=array(
	'Import Transaction From FO'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Import Transaction From Front Office', 'itemOptions'=>array('style'=>'font-size:28px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	//array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/postinginterest/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
);

?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'importTransaction-form',
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
						'id'=>'btnImport',
						'htmlOptions'=>array("class"=>"control-group",'disabled'=>$flag=='Y'?true:false,'style'=>$flag=='Y'?'opacity:0.2':'opacity:1'),
					)); ?>
			</div>
		</div>
	</div>
	
<?php $this->endWidget(); ?>

<?php  $this->beginWidget('zii.widgets.jui.CJuiDialog',
    array(
        'id'=>'mywaitdialog',
        'options'=>array(
            'title'=>'Import Transaction In Progress',
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
	$("#btnImport").click(function(event)
	{	
		//console.log("klik");
		$('#mywaitdialog').dialog("open"); 
	
	})
</script>



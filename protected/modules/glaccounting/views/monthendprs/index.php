<style>
	.help-inline.error{display: none;}
	.radio.inline label{margin-left: 15px;}
	.well { padding: 2px; margin: 0px 0px 5px 0px; text-align: center;}
	.table-compact{ padding: 0px; }
	.table-compact tr td{ padding: 0px; } 
</style>

<?php 
	$this->breadcrumbs=array(
	'Month End Closing'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Month End Closing', 'itemOptions'=>array('style'=>'font-size:28px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	//array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/postinginterest/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
);

?>
<br>
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
	//$year=array(2015=>'2015',2014=>'2014',2013=>'2013');
	
?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'processDepFixAsset-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>
	
	
	<?php echo $form->errorSummary($model); ?>
	<?php AHelper::showFlash($this) ?> 
		
	<div class="row-fluid">
			<div class="control-group">
				<div class="span1"></div>
				<div class="span8">
					<?php echo $form->label($model,'For the month of : ',array('class'=>'control-label')) ?>
					<?php echo $form->dropDownList($model,'month',$month,array('id'=>'month','class'=>'span2')) ?>
					<?php echo $form->textField($model,'year',array('id'=>'year','class'=>'span2')) ?>
					&nbsp;
					&nbsp;
					&nbsp;
					<?php $this->widget('bootstrap.widgets.TbButton', array(
						'buttonType'=>'submit',
						'type'=>'primary',
						'label'=>'Process',
						'id'=>'btnProcess',
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
            'title'=>'Month End Closing In Progress',
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
		var month=$('#month :selected').text();
		var year =$('#year').val();
		if(confirm("Process Month End : \n "+month+" "+year)){
			$('#mywaitdialog').dialog("open"); 
		}else{
			return false;
		}
	})
</script>



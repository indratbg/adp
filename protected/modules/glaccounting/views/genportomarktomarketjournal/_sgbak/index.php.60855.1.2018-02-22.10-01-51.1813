
<?php
$this->breadcrumbs=array(
	'Generate Portofolio Mark to Market Journal',
);
?>
<?php
$this->menu=array(
	
	array('label'=>'Generate Portofolio Mark to Market Journal', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	//array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/Generatemkbdreport/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	
);

?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'Lapporto-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>
<br />
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php echo $form->errorSummary($model);?>


<div class="row-fluid">
	<div class="span1">Date</div>
	<div class="span3">
<?php echo $form->datePickerRow($model,'doc_date',array('label'=>false,'prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>		
	</div>
	
	<div class="span4">
		
		<?php echo "File Number &emsp;&emsp;".$form->textField($model,'folder_cd',array('class'=>'span5'));?>
	</div>
	<div class="span2">
		
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Process',
			'id'=>'btnProses',
			'disabled'=>$flg=='Y'?true:false,
			'htmlOptions'=>array('style'=>'margin-left:-6em;')
		)); ?>
	</div>
</div>

	
<?php $this->endWidget()?>


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


<script type="text/javascript" charset="utf-8">
	
	var flg = '<?php echo $flg;?>';
	//alert(flg);
	$("#btnImport").click(function(event)
	{	
		$('#mywaitdialog').dialog("open");	 
		
	})
	
	$('#Genportomarktomarketjournal_folder_cd').change(function(){
		$('#Genportomarktomarketjournal_folder_cd').val($('#Genportomarktomarketjournal_folder_cd').val().toUpperCase());
	})

	
</script>

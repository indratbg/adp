
<?php
$this->breadcrumbs=array(
	'Posting Monthly Depreciation'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Posting Monthly Depreciation', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	//	array('label'=>'Create','url'=>array('create'),'icon'=>'plus','itemOptions'=>array('style'=>'float:right')),
	//array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/gljournalledger/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	
	
);
?>

<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'transferarap-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>
<br/>
<?php echo $form->errorSummary($model); ?>



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
			'id'=>'btnImport',
			'htmlOptions'=>array('style'=>'margin-left:-6em;','disabled'=>$flg=='Y'?true:false)
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
	
	$("#btnImport").click(function(event)
	{	
		$('#mywaitdialog').dialog("open");	 
		
	})
	
	$('#Postingmonthlydepr_folder_cd').change(function(){
		$('#Postingmonthlydepr_folder_cd').val($('#Postingmonthlydepr_folder_cd').val().toUpperCase());
	})
	$('#Postingmonthlydepr_doc_date').change(function(){
		checkPosting();
	})
	
	function checkPosting(){
		var tanggal= $('#Postingmonthlydepr_doc_date').val();
		$.ajax({
	    		'type'     :'POST',
	    		'url'      : '<?php echo $this->CreateUrl('CheckPosting'); ?>',
				'dataType' : 'json',
				'data'     : { 'tanggal':tanggal},							
				'success'  : function(data){
				if(data.status == 'success')
				{
					alert('Sudah pernah diposting');
				}	
				
			}
			})			
		}
	
	
</script>


<?php
$this->breadcrumbs=array(
	'Month End Stock'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Month End Stock', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
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
	<div class="span1"></div>
	<div class="span5">
<?php echo $form->datePickerRow($model,'bal_date',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>		
	</div>
	<div class="span4">
		
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
	checkDate();
	$("#btnImport").click(function(event)
	{
		ckdt();
		if(confirm('Are you sure ? ')=== true){
		$('#mywaitdialog').dialog("open");	
		}
		else{
			return false;
		}
		 
	})
	
		
		$('#Monthendstock_bal_date').change(function(){
			checkDate();
		})
		
		function ckdt(){
			var newtgl=$('#Monthendstock_bal_date').val().substring(0, 2);
			if(newtgl!='01'){
			alert('Tanggal yang dimasukkan harus tanggal 1');	
			}
		}
		
		function checkDate(){
		var tanggal=$('#Monthendstock_bal_date').val();
			$.ajax({
					'type'     :'POST',
					'url'      : '<?php echo $this->CreateUrl('cekDate'); ?>',
					'dataType' : 'json',
					'data'     : { 'tanggal':tanggal},							
					'success'  : function(data){
							var safe =  data.status;
							if(safe == 'success'){
							$('#btnImport').prop('disabled',true);	
							//alert('Month end sudah diproses')
							}
							else{
								$('#btnImport').prop('disabled',false);
							
					}
				}
				})
	}
	
</script>

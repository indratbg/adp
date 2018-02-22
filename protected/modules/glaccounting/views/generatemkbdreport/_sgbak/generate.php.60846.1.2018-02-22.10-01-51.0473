<?php
$this->breadcrumbs=array(
	'MKBD Report',
);
?>
<?php
$this->menu=array(
	
	array('label'=>'MKBD Report', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Generate','url'=>array('generate'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/Generatemkbdreport/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	
);

?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'Generatemkbd-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>
<br />
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php echo $form->errorSummary($model);?>


<div class="row-fluid">
	<div class="span6">

		<?php echo $form->datePickerRow($model,'gen_dt',array('prepend'=>'<i class="icon-calendar"></i>','class'=>'span7 tdate','placeholder'=>'dd/mm/yyyy','options'=>array('format' => 'dd/mm/yyyy')));?>
		<?php echo $form->textField($model,'price_dt',array('id'=>'price_dt','style'=>'display:none'));?>
	</div>
	<div class="span1" >
			<?php //echo $form->radioButtonListInlineRow($model,'type',array('0'=>'Generate','1'=>'Print'),array('id'=>'type','class'=>'span','label'=>false));?>
	
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'htmlOptions'=>array('id'=>'btnGenerate','style'=>'margin-left:-10em;','class'=>'btn btn-primary'),
			'label'=>'Generate',
		)); ?>
	
	</div>

	</div>


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
	$('#btnGenerate').click(function(){
	if(cekDate()){
		
		if(confirm('Close price '+ $('#price_dt').val() + ', do you want to continue? ') == true)
		{
			$('#mywaitdialog').dialog("open");	
		return true;	
		}
		else
		{
		return false;
		}
		
	}
	else{
		$('#mywaitdialog').dialog("open");
		return true;
	}

	
});

function cekDate(){
	
	var tanggal=$('#Rptmkbdreport_gen_dt').val();
	
	var xx=false;
		$.ajax({
	    		'type'     :'POST',
	    		'url'      : '<?php echo $this->CreateUrl('Cekdate'); ?>',
				'dataType' : 'json',
				'data'     : { 'tanggal':tanggal},							
				'success'  : function(data){
					
						 var safe =  data.status;
						 
						if (safe =='success'){
							
							$('#price_dt').val(data.price_dt);
							xx= true;
						}
						else
						{
							$('#price_dt').val(data.price_dt);
							xx= false;
						}
						
			},
			'async':false
			})
			return xx;
			
}
</script>
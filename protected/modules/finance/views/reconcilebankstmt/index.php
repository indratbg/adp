<style>
		#tableCash
	{
		background-color:#C3D9FF;
	}
	#tableCash thead, #tableCash tbody
	{
		display:block;
	}
	#tableCash tbody
	{
		max-height:300px;
		overflow:auto;
		background-color:#FFFFFF;
	}
	.radio.inline{
	width: 130px;
}

</style>
<?php

$this->breadcrumbs=array(
	'Reconcile Bank Account Statement'=>array('index'),
	'List',
);

$this->menu=array(
	//array('label'=>'Tvd55', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'Reconcile Bank Account Statement', 'itemOptions'=>array('style'=>'font-size:28px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	//	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/tfundmovementall/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	
);

?>


<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'Tbankmutation-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); 
 ?>
 	<?php echo $form->errorSummary(array($model,$modelReport)); ?>
<?php foreach($modelDetail as $row){
	echo $form->errorSummary(array($row));
}?>

 <br/>
 <input type="hidden" name="scenario" id="scenario" />
 <div class="row-fluid control-group">
 <div class="span5">
 	<?php echo $form->datePickerRow($model,'period_from',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
 </div>
 <div class="span1"  style="margin-left: -100px;">To</div>
 <div class="span5" style="margin-left: -110px;">
 	<?php echo $form->datePickerRow($model,'period_to',array('label'=>false,'prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
 </div>
 	
 </div>
 
 <div class="row-fluid control-group">
 	<div class="span2" >
 		<label>Gl Account</label>
 	</div>
 	<div class="span2" style="margin-left: -2px;">
 		<?php echo $form->textField($model,'gl_acct_cd',array('class'=>'span'));?>
 	</div>
 		<div class="span2">
 		<?php echo $form->textField($model,'sl_acct_cd',array('class'=>'span'));?>
 	</div>
 	<div class="span2"><label>(Contoh :1200 300014)</label></div>
 </div>
 <div class="row-fluid">
 	<div class="span5">
 			<?php echo CHtml::activeFileField($model, 'file_upload'); ?>
 	</div>
 	<div class="span1">
 	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'id' => 'btnImport',
		'buttonType' => 'submit',
		'type'=>'default',
		'label'=>'Upload',
		'htmlOptions' => array('style'=>'margin-left:0em; ;width:80px;','class'=>'btn btn-primary btn-small')
			)); ?>
 	</div>
 </div>
 <div class="row-fluid control-group">
 	<div class="span5">
 		<?php echo $form->radioButtonListInlineRow($model, 'import_type', AConstant::$reconcile_bank_acct,array('label'=>false, 'labelOptions'=>array('style'=>'display:inline'))); ?>
 	</div>
 	<div class="span1">
 			<?php $this->widget('bootstrap.widgets.TbButton', array(
		'id' => 'btnReconcile',
		'buttonType' => 'submit',
		'type'=>'default',
		'label'=>'Reconcile',
		'htmlOptions' => array('style'=>'margin-left:0em; ;width:80px;','class'=>'btn btn-primary btn-small')
			)); ?>
 	</div>
 </div>
 <pre>Note : Bank untuk kbb tidak dapat di reconcile</pre>
 <div id="dataDetail">
 <h5>List bank account statement yang sudah diimport</h5>
 <table id="tableCash" class="table-bordered table-condensed" style="width: 55%;">
 	<thead>
 		<tr>
 			<th  width="30%">Period</th>
 			<th colspan="2" width="40%">Gl account code</th>
 			<th width="25%">Bank account code</th>
 			<th  width="3%"></th>
 		</tr>
 	</thead>
 	<tbody>
 <?php $x=1;
  foreach($modelDetail as $row){?>
 		<tr>
 			<td >
 				<?php echo $row->period_from;?>
 			</td>
 			<td>
 				<?php echo $row->gl_acct_cd ?>
 			</td>
 			<td>
 				<?php echo $row->sl_acct_cd;?>
 			</td>
 			<td>
 				<?php echo $row->bank_acct_num;?>
 			</td>
 			<td style="text-align: center">
 				<a 
						title="view" 
						href="<?php echo Yii::app()->request->baseUrl.'?r=finance/Reconcilebankstmt/view/&period_from='.$row->period_from.'&gl_acct_cd='.$row->gl_acct_cd.'&sl_acct_cd='.$row->sl_acct_cd ?>">
						<img style="width:13px;height:13px;" src="<?php echo Yii::app()->request->baseUrl ?>/images/eye_open.png">
					</a>
 			</td>
 		</tr>
 		
  <?php $x++; } ?> 		
 	</tbody>
 </table>
 
 </div>
 

 <iframe src="<?php echo $url; ?>" class="span12" id="report" style="min-height:600px"></iframe>		
 
<?php $this->endWidget();?>


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

var data = '<?php echo count($modelDetail)?>';
var url ='<?php echo $url?>';
if(data==0 || url !=''){
	//alert('test')
	$('#dataDetail').hide();
}
else{
	$('#dataDetail').show();
}

	$(window).resize(function()
	{
		$("#report").offset({left:3});
		$("#report").css('width',($(window).width()+3));
	});
	$(window).resize();

//$('#progressbar').hide();
$('#btnImport').click(function(){
	$('#scenario').val('import');
	//$('#progressbar').show();
	$('#mywaitdialog').dialog("open"); 
})
$('#btnReconcile').click(function(){
	$('#scenario').val('reconcile');
	//$('#progressbar').show();
	$('#mywaitdialog').dialog("open"); 
})


$(window).resize(function() {
		alignColumn();
	})
	$(window).trigger('resize');
	
	function alignColumn()//align columns in thead and tbody
	{
		var header = $("#tableCash").find('thead');
		var firstRow = $("#tableCash").find('tbody tr:eq(0)');
		
		firstRow.find('td:eq(0)').css('width',header.find('th:eq(0)').width() + 'px');
		firstRow.find('td:eq(1)').css('width',header.find('th:eq(1)').width()/2+12 + 'px');
		firstRow.find('td:eq(2)').css('width',header.find('th:eq(2)').width()/2 +12+ 'px');
		firstRow.find('td:eq(3)').css('width',header.find('th:eq(3)').width()+110 +'px');
		firstRow.find('td:eq(4)').css('width',header.find('th:eq(4)').width()-17 + 'px');
		
	}
</script>

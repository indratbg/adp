<style>
	
.markCancel
	{
		background-color:#BB0000;
	}	
</style>
	

<?php
$this->breadcrumbs=array(
	'Haircut Reverse Repo Entry'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Haircut Reverse Repo Entry', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/thaircutrerepo/index','icon'=>'list'),
);
?>

<h1>Haircut Reverse Repo Entry</h1>

<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 

<?php 
	$stkCdList = Counter::model()->findAll(array('select'=>'stk_cd','condition'=>"approved_stat = 'A'",'order'=>'stk_cd'))
?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'thaircutrerepo-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>
<div class="filter-group span5" style="margin-left:0px;width:560px">
	<?php //echo $form->radioButtonListInlineRow($model[],'filterCriteria',array('Balance Sheet Aktiva','Balance Sheet Pasiva','Profit and Loss')) ?>
	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'id' => 'btnFilter',
		'buttonType' => 'submit',
		'type'=>'primary',
		'label'=>'Sort Stock Code',
		'htmlOptions' => array('style'=>'margin-left:1em','onClick'=>'sort()',),
	)); ?>
</div>
<br/>
<br/>
<?php 
	foreach($model as $row)
		echo $form->errorSummary(array($row)); 
?>

<br/>

<input type="hidden" id="scenario" name="scenario"/>
<input type="hidden" id="rowSeq" name="rowSeq"/>
<input type="hidden" id="oldPk1" name="oldPk1"/>
<input type="hidden" id="oldPk2" name="oldPk2"/>

<table id='tableHair' class='table-bordered table-condensed'>
	<thead>
		<tr>
			<th width="50px">Date From</th>
			<th width="50px">Date To</th>
			<th width="100px">Stock Code</th>
			<th width="150px">Haircut</th>
			<th width="10px">
				<a title="add" onclick="addRow()"><img src="<?php echo Yii::app()->request->baseUrl ?>/images/add.png"></a>
			</th>
		</tr>
	</thead>
	<tbody>
	<?php $x = 1;
		foreach($model as $row){
			if($row->isNewRecord)$x = 0; 
	?>
		<tr id="row<?php echo $x ?>">
			<td>
				<?php echo $form->textField($row,'from_dt',array('class'=>'span tdate','name'=>'Thaircutrerepo['.$x.'][from_dt]')); ?>
				<input type="hidden" id="oldFromDt<?php echo $x ?>" value="<?php if(!$row->isNewRecord)echo $oldModel[$x-1]->from_dt ?>"/>
			</td>
			<td><?php echo $form->textField($row,'to_dt',array('class'=>'span tdate','name'=>'Thaircutrerepo['.$x.'][to_dt]')); ?></td>
			<td>
				<?php echo $form->dropDownList($row,'stk_cd',CHtml::listData($stkCdList, 'stk_cd', 'stk_cd'),array('class'=>'span','name'=>'Thaircutrerepo['.$x.'][stk_cd]')); ?>
				<input type="hidden" id="oldStkCd<?php echo $x ?>" value="<?php if(!$row->isNewRecord)echo $oldModel[$x-1]->stk_cd ?>"/>
			</td>
			<td><?php echo $form->textField($row,'haircut',array('class'=>'span tnumber','maxlength'=>3,'name'=>'Thaircutrerepo['.$x.'][haircut]','style'=>'text-align:right')); ?></td>
			<td>
				<a title="<?php if(!$row->isNewRecord) echo 'save';else echo 'create'?>" onclick="<?php if(!$row->isNewRecord) echo 'update('.$x.')';else echo 'create()' ?>"><img src="<?php echo Yii::app()->request->baseUrl ?>/images/save.png"></a>
				<a 
					href="<?php if(!$row->isNewRecord)echo Yii::app()->createUrl("/glaccounting/Thaircutrerepo/AjxPopDelete", 
								array('from_dt'=>$oldModel[$x-1]->from_dt,'stk_cd'=>$oldModel[$x-1]->stk_cd));else echo '#' ?>" 
					title="<?php if(!$row->isNewRecord) echo 'cancel';else echo 'delete'?>" 
					onclick="<?php if(!$row->isNewRecord) echo 'cancel(event,this)';else echo 'deleteRow()'?>">
					<i class="icon-remove"></i>
				</a>
			</td>
		</tr>
	<?php $x++;} ?>
	</tbody>
</table>

<?php 
	if($model)
	{
?>

<?php echo $form->datePickerRow($model[0],'cre_dt',array('label'=>false,'disabled'=>'disabled','style'=>'display:none','options'=>array('format' => 'dd/mm/yyyy'))); ?>

<?php
	} 
?>

<?php $this->endWidget(); ?>

<?php
  	AHelper::popupwindow($this, 600, 500);
?>

<script>
	var rowCount = <?php echo count($model) ?>;
	
	var insert = false;
	<?php if($insert){ ?>
		insert = true;
	<?php } ?>

	init();
	
	function init()
	{
		var x;
		
		for(x=0;x<rowCount;x++)
		{
			$("#tableHair tbody tr:eq("+x+") td:eq(0) input").datepicker({format : "dd/mm/yyyy"});
			$("#tableHair tbody tr:eq("+x+") td:eq(1) input").datepicker({format : "dd/mm/yyyy"});
		}
	}
	
	function addRow()
	{
		if(!insert)
		{
			$("#tableHair").find('tbody')
    		.prepend($('<tr>')
    			.attr('id','row0')
        		.append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Thaircutrerepo[0][from_dt]')
               		 	.attr('type','text')
               		 	.datepicker({format : "dd/mm/yyyy"})
               		)
				).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Thaircutrerepo[0][to_dt]')
               		 	.attr('type','text')
               		 	.attr('value','31/12/2030')
               		 	.datepicker({format : "dd/mm/yyyy"})
               		)
               	).append($('<td>')
               		 .append($('<select>')
               		 	.attr('class','span')
               		 	.attr('name','Thaircutrerepo[0][stk_cd]')
               		 	<?php
               		 		foreach($stkCdList as $row){
               		 	?>
           		 		.append($('<option>')
           		 			.attr('value','<?php echo $row->stk_cd ?>')
           		 			.html('<?php echo $row->stk_cd ?>')
           		 		)
               		 	<?php } ?>
               		)
               	).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span tnumber')
               		 	.attr('name','Thaircutrerepo[0][haircut]')
               		 	.attr('type','text')
               		 	.attr('value','0')
               		 	.css('text-align','right')
               		)
               	).append($('<td>')
               		 .append($('<a>')
               		  	.attr('onClick','create()')
               		 	.attr('title','create')
               		 	.append($('<img>')
               		 		.attr('src','<?php echo Yii::app()->request->baseUrl ?>/images/save.png')
               		 	)
               		).append('&nbsp;')
               		 .append($('<a>')
           		 		.attr('onClick','deleteRow()')
           		 		.attr('title','delete')
           		 		.append($('<i>')
           		 			.attr('class','icon-remove')
           		 		)
               		)
               	)  	
    		);
    		
			insert = true;
		}
	}
	
	function deleteRow()
	{
		
		$("#row0").remove();
		insert = false;
	}
	
	function create()
	{
		$('#scenario').val('create');
		$("#rowSeq").val(0);
		$("#thaircutrerepo-form").submit();
	}
	function sort()
	{
		$('#scenario').val('filter');
	}
	function update(rowSeq)
	{
		$('#scenario').val('update');
		$("#rowSeq").val(rowSeq);
		$("#oldPk1").val($("#oldFromDt"+rowSeq).val());
		$("#oldPk2").val($("#oldStkCd"+rowSeq).val());
		$("#thaircutrerepo-form").submit();
	}
	
	function cancel(e,obj)
	{
		e.preventDefault();
		showPopupModal("Cancel Reason",obj.href);
	}
	/*
	$('#thaircutrerepo-form').bind("keyup keypress", function(e) {
		
	  	var code = e.keyCode || e.which; 
	  	if (code  == 13) {               
	    e.preventDefault();
	    return false;
	  	}
	});
	*/
</script>

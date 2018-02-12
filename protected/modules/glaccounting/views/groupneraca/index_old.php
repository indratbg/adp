<style>
	#groupneraca-form input[type=radio]
	{
		margin-left: 15px;
		margin-right: 5px;
		margin-bottom: 7px;
	}
</style>

<?php
$this->breadcrumbs=array(
	'Groupneracas'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Groupneraca', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active')),
);

?>

<h1>Neraca Ringkas / Profit Loss Account Entry</h1>

<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'groupneraca-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

<?php 
	foreach($model as $row)
		echo $form->errorSummary(array($row)); 
?>

<br/>

<div class="filter-group">
	<?php //echo $form->radioButtonListInlineRow($model[],'filterCriteria',array('Neraca Ringkas Aktiva','Neraca Ringkas Pasiva','Profit and Loss')) ?>
	<input type="radio" id="filter1" name="filter" value="0" <?php if($selected == 0)echo 'checked' ?>/>Neraca Ringkas Aktiva
	<input type="radio" id="filter2" name="filter" value="1" <?php if($selected == 1)echo 'checked' ?>/>Neraca Ringkas Pasiva
	<input type="radio" id="filter3" name="filter" value="2" <?php if($selected == 2)echo 'checked' ?>/>Profit and Loss
	<input type="hidden" id="scenario" name="scenario"/>
	
	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'id' => 'btnFilter',
		'buttonType' => 'submit',
		'type'=>'primary',
		'label'=>'Retrieve',
		'htmlOptions' => array('style'=>'margin-left:3em'),
	)); ?>
</div>

<input type="hidden" id="oldFilterCriteria" name="oldFilterCriteria" value="<?php echo $selected ?>"/>
<input type="hidden" id="rowSeq" name="rowSeq"/>
<input type="hidden" id="oldPk1" name="oldPk1"/>
<input type="hidden" id="oldPk2" name="oldPk2"/>
<input type="hidden" id="oldPk3" name="oldPk3"/>
<input type="hidden" id="oldPk4" name="oldPk4"/>
<input type="hidden" id="oldPk5" name="oldPk5"/>
<input type="hidden" id="oldPk6" name="oldPk6"/>

<br/><br/><br/>

<table id='tableGrp' class='table-bordered table-condensed'>
	<thead>
		<tr>
			<th width="50px">Item Type</th>
			<th width="50px">Grp 1</th>
			<th width="50px">Grp 2</th>
			<th width="50px">Grp 3</th>
			<th width="50px">Grp 4</th>
			<th width="50px">Grp 5</th>
			<th width="150px">Gl Account</th>
			<th width="300px">Description</th>
			<th width="50px">
				<a href="#" title="add" onclick="addRow()"><img src="<?php echo Yii::app()->request->baseUrl ?>/images/add.png"></a>
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
				<?php echo $form->textField($row,'pl_bs_flg',array('class'=>'span','name'=>'Groupneraca['.$x.'][pl_bs_flg]')); ?>
				<input type="hidden" id="oldPlBsFlg<?php echo $x ?>" value="<?php if(!$row->isNewRecord)echo $oldModel[$x-1]->pl_bs_flg ?>"/>
			</td>
			<td>
				<?php echo $form->textField($row,'grp_1',array('class'=>'span','name'=>'Groupneraca['.$x.'][grp_1]')); ?>
				<input type="hidden" id="oldGrp1_<?php echo $x ?>" value="<?php if(!$row->isNewRecord)echo $oldModel[$x-1]->grp_1 ?>"/>
			</td>
			<td>
				<?php echo $form->textField($row,'grp_2',array('class'=>'span','name'=>'Groupneraca['.$x.'][grp_2]')); ?>
				<input type="hidden" id="oldGrp2_<?php echo $x ?>" value="<?php if(!$row->isNewRecord)echo $oldModel[$x-1]->grp_2 ?>"/>
			</td>
			<td>
				<?php echo $form->textField($row,'grp_3',array('class'=>'span','name'=>'Groupneraca['.$x.'][grp_3]')); ?>
				<input type="hidden" id="oldGrp3_<?php echo $x ?>" value="<?php if(!$row->isNewRecord)echo $oldModel[$x-1]->grp_3 ?>"/>
			</td>
			<td>
				<?php echo $form->textField($row,'grp_4',array('class'=>'span','name'=>'Groupneraca['.$x.'][grp_4]')); ?>
				<input type="hidden" id="oldGrp4_<?php echo $x ?>" value="<?php if(!$row->isNewRecord)echo $oldModel[$x-1]->grp_4 ?>"/>
			</td>
			<td>
				<?php echo $form->textField($row,'grp_5',array('class'=>'span','name'=>'Groupneraca['.$x.'][grp_5]')); ?>
				<input type="hidden" id="oldGrp5_<?php echo $x ?>" value="<?php if(!$row->isNewRecord)echo $oldModel[$x-1]->grp_5 ?>"/>
			</td>
			<td><?php echo $form->textField($row,'gl_acct_cd',array('class'=>'span','name'=>'Groupneraca['.$x.'][gl_acct_cd]')); ?></td>
			<td><?php echo $form->textField($row,'line_desc',array('class'=>'span','name'=>'Groupneraca['.$x.'][line_desc]','value'=>$row->acct_name?$row->acct_name:$row->line_desc,'readonly'=>$row->acct_name?'readonly':'')); ?></td>
			<td>
				<a href="#" title="<?php if(!$row->isNewRecord) echo 'save';else echo 'create'?>" onclick="<?php if(!$row->isNewRecord) echo 'update('.$x.')';else echo 'create()'?>"><i class="icon-ok"></i></a>
				<a 
					href="<?php if(!$row->isNewRecord)echo Yii::app()->createUrl("/glaccounting/Groupneraca/AjxPopDelete", 
								array('pl_bs_flg'=>$oldModel[$x-1]->pl_bs_flg,
										'grp_1'=>$oldModel[$x-1]->grp_1,
										'grp_2'=>$oldModel[$x-1]->grp_2,
										'grp_3'=>$oldModel[$x-1]->grp_3,
										'grp_4'=>$oldModel[$x-1]->grp_4,
										'grp_5'=>$oldModel[$x-1]->grp_5));
								else echo '#' ?>" 
					
					title="<?php if(!$row->isNewRecord) echo 'cancel';else echo 'delete'?>" 
					onclick="<?php if(!$row->isNewRecord) echo 'cancel(event,this)';else echo 'deleteRow()'?>">
					<i class="icon-remove"></i>
				</a>
			</td>
		</tr>
	<?php $x++;} ?>
	</tbody>
</table>



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

	$('#btnFilter').click(function()
	{
		$('#scenario').val('filter');
	})

	function addRow()
	{
		if(!insert)
		{
			$("#tableGrp").find('tbody')
    		.prepend($('<tr>')
    			.attr('id','row0')
        		.append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Groupneraca[0][pl_bs_flg]')
						.attr('type','text')
               		)
				).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Groupneraca[0][grp_1]')
						.attr('type','text')
               		)
               	).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Groupneraca[0][grp_2]')
						.attr('type','text')
               		)
               	).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Groupneraca[0][grp_3]')
						.attr('type','text')
               		)
               	).append($('<td>')
               		.append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Groupneraca[0][grp_4]')
						.attr('type','text')
               		)
               	).append($('<td>')
               		.append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Groupneraca[0][grp_5]')
						.attr('type','text')
               		)
               	).append($('<td>')
               		.append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Groupneraca[0][gl_acct_cd]')
						.attr('type','text')
               		)
               	).append($('<td>')
               		.append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Groupneraca[0][line_desc]')
						.attr('type','text')
               		)
               	).append($('<td>')
               		 .append($('<a>')
               		 	.attr('href','#')
               		 	.attr('onClick','create()')
               		 	.attr('title','create')
               		 	.append($('<i>')
               		 		.attr('class','icon-ok')
               		 	)
               		).append('&nbsp;')
               		 .append($('<a>')
           		 		.attr('href','#')
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
		$("#Groupneraca-form").submit();
	}
	
	function update(rowSeq)
	{
		$('#scenario').val('update');
		$("#rowSeq").val(rowSeq);
		$("#oldPk1").val($("#oldPlBsFlg"+rowSeq).val());
		$("#oldPk2").val($("#oldGrp1_"+rowSeq).val());
		$("#oldPk3").val($("#oldGrp2_"+rowSeq).val());
		$("#oldPk4").val($("#oldGrp3_"+rowSeq).val());
		$("#oldPk5").val($("#oldGrp4_"+rowSeq).val());
		$("#oldPk6").val($("#oldGrp5_"+rowSeq).val());
		$("#Groupneraca-form").submit();
	}
	
	function cancel(e,obj)
	{
		e.preventDefault();
		showPopupModal("Cancel Reason",obj.href);
	}
</script>


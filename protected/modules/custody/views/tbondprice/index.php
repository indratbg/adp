

<style>
	#tbondprice-form input[type=radio]
	{
		margin-left: 15px;
		margin-right: 5px;
		margin-bottom: 7px;
	}
	#tableBond
	{
		background-color:#C3D9FF;
	}
	#tableBond thead, #tableBond tbody
	{
		display:block;
	}
	#tableBond tbody
	{
		
		max-height:310px;
		overflow-y:scroll;
		background-color:#FFFFFF;
	}
	
	#tableDummy
	{
		background-color:#C3D9FF;
		visibility:hidden;
	}
	#tableDummy thead, #tableDummy tbody
	{
		display:block;
	}
	#tableDummy tbody
	{
		
		max-height:50px;
		overflow-y:scroll;
		background-color:#FFFFFF;
	}
	
	.markCancel
	{
		background-color:#BB0000;
	}
</style>

<?php
$this->breadcrumbs=array(
	'Tbondprices'=>array('index'),
	'List',
);

$this->menu=array(
	//array('label'=>'Tbondprice', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'Bond Market Price', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/tbondprice/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	
	
);

?>

<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tbondprice-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>
<?php echo $form->errorSummary($modeldummy);?>
<?php 
	if($model){
		foreach($model as $row)
			echo $form->errorSummary(array($row));
	} 
?>

<br/>

<div>
	<?php //echo $form->radioButtonListInlineRow($model[],'filterCriteria',array('Balance Sheet Aktiva','Balance Sheet Pasiva','Profit and Loss')) ?>
	<div class="row-fluid">
		<div class="span5">
			<?php echo $form->datePickerRow($modeldummy,'price_dt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8',
				'name'=>'pricedt','id'=>'pricedt','options'=>array('format' => 'dd/mm/yyyy'))); ?>
		</div>
		<div class="span7">
			<input type="hidden" id="scenario" name="scenario"/>
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'id' => 'btnFilter',
				'buttonType' => 'submit',
				'type'=>'primary',
				'label'=>'Retrieve'
			)); ?>
			&emsp;
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'id' => 'btnDuplicate',
				'buttonType' => 'button',
				'type'=>'primary',
				'label'=>'Duplicate'
			)); ?>
			&emsp;
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'id' => 'btnSubmit',
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=> 'Save',
			)); ?>
		</div>
	</div>
</div>
<input type="hidden" id="rowCount" name="rowCount"/>
	<?php 
		if($model){
		$x = 1;
	?>
<p style="height: 2px;"></p>
<div class="row-fluid">
	<div class="span5">
		<?php echo $form->datePickerRow($modeldummy,'new_price_dt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8',
				'name'=>'newpricedt','id'=>'newpricedt','options'=>array('format' => 'dd/mm/yyyy'))); ?>
	</div>
	<div class="span7">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
				'id' => 'btnApply',
				'buttonType' => 'button',
				'type'=>'secondary',
				'label'=>'Apply Date'
			)); ?>
	</div>
</div>
<table id='tableDummy' class='table-bordered table-condensed'>
	<tbody>
		<tr id="row1">
			<td width="3%">
				<?php echo $form->checkBox($modeldummy,'save_flg',array('value' => 'Y','name'=>'dummy')); ?>
			</td>
			<td width="16%">
				<?php echo $form->textField($modeldummy,'price_dt',array('class'=>'span tdate','placeholder'=>'dd/mm/yyyy','name'=>'dummy')); ?>
			</td>
			<td width="24%">
				<?php echo $form->dropDownList($modeldummy,'bond_cd',Chtml::listData($dropdownbond,'bond_cd', 'bond_desc'), array('prompt'=>'--Choose Bond--','class'=>'span','name'=>'dummy')); ?>
			</td>
			<td width="18%">
				<?php echo $form->textField($modeldummy,'price',array('class'=>'span','name'=>'dummy','style'=>'text-align:right;')); ?>
			</td>
			<td width="18%">
				<?php echo $form->textField($modeldummy,'yield',array('class'=>'span','name'=>'dummy','style'=>'text-align:right;')); ?>
			</td>
			<td width="18%">
				<?php echo $form->textField($modeldummy,'bond_rate',array('class'=>'span','name'=>'dummy')); ?>
			</td>
			<td width="3%">
				<a style="cursor: pointer">
					<img src="<?php echo Yii::app()->request->baseUrl ?>/images/delete.png">
				</a>
			</td>
		</tr>
	</tbody>	
</table>
<table id='tableBond' class='table-bordered table-condensed'>
	<thead>
		<tr>
			<th id="header1"></th>
			<th id="header2">Price Date</th>
			<th id="header3">Bond Code</th>
			<th id="header4">Price</th>
			<th id="header5">Yield</th>
			<th id="header6">Rating</th>
			<th id="header7">
				<a style="cursor: pointer;" title="Add" onclick="addTopRow()"><img src="<?php echo Yii::app()->request->baseUrl ?>/images/add.png"></a>
			</th>
		</tr>
	</thead>	
	<tbody>
	<?php
		foreach($model as $row){
	?>
		<tr id="row<?php echo $x ?>" class="<?php if($row->cancel_flg == 'Y')echo 'markCancel' ?>">
			<td width="3%">
				<?php echo $form->checkBox($row,'save_flg',array('value' => 'Y','name'=>'Tbondprice['.$x.'][save_flg]','onChange'=>$row->price_dt?'rowControl(this,true)':'rowControl(this,false)')); ?>
				<?php if($row->old_price_dt): ?>
					<input type="hidden" name="Tbondprice[<?php echo $x ?>][cancel_flg]" value="<?php echo $row->cancel_flg ?>"/>	
				<?php endif; ?>
			</td>
			<td width="16%">
				<?php echo $form->textField($row,'price_dt',array('class'=>'span tdate','placeholder'=>'dd/mm/yyyy','name'=>'Tbondprice['.$x.'][price_dt]',
						'readonly'=>$row->save_flg!='Y'?'readonly':'',
						'value'=> $row->price_dt?(
						$row->save_flg=='Y'?DateTime::createFromFormat('Y-m-d',$row->price_dt)->format('d/m/Y') : DateTime::createFromFormat('Y-m-d',$row->old_price_dt)->format('d/m/Y')):'')); ?>
				<input type="hidden" name="Tbondprice[<?php echo $x ?>][old_price_dt]" value="<?php echo $row->old_price_dt ?>" />
			</td>
			<td width="24%">
				<?php //echo $form->textField($row,'bond_cd',array('class'=>'span','name'=>'Tbondprice['.$x.'][bond_cd]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?>
				<?php echo $form->dropDownList($row,'bond_cd',Chtml::listData($dropdownbond,'bond_cd', 'bond_desc'), array('prompt'=>'--Choose Bond--','class'=>'span','readonly'=>$row->save_flg!='Y'?'readonly':'','name'=>'Tbondprice['.$x.'][bond_cd]')); ?>
				<input type="hidden" name="Tbondprice[<?php echo $x ?>][old_bond_cd]" value="<?php echo $row->old_bond_cd ?>" />
			</td>
			<td width="18%">
				<?php echo $form->textField($row,'price',array('class'=>'span','style'=>'text-align:right;','name'=>'Tbondprice['.$x.'][price]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?>
			</td>
			<td width="18%">
				<?php echo $form->textField($row,'yield',array('class'=>'span','style'=>'text-align:right;','name'=>'Tbondprice['.$x.'][yield]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?>
			</td>
			<td width="18%">
				<?php echo $form->textField($row,'bond_rate',array('class'=>'span','name'=>'Tbondprice['.$x.'][bond_rate]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?>
			</td>
			<td width="3%">
				<a style="cursor: pointer"
					title="<?php if($row->old_price_dt) echo 'cancel';else echo 'delete'?>" 
					onclick="<?php if($row->old_price_dt) echo 'cancel(this,\''.$row->cancel_flg.'\','.$x.')';else echo 'deleteRow(this)'?>">
					<img src="<?php echo Yii::app()->request->baseUrl ?>/images/delete.png">
				</a>
			</td>
		</tr>
	<?php $x++;}} ?>
	</tbody>	
</table>
<br id="temp"/>

<?php if($model): ?>
	<?php echo $form->label($model[0], 'Cancel Reason', array('class'=>'control-label cancel_reason'))?>
	<textarea id="cancel_reason" class="span5 cancel_reason" name="cancel_reason" maxlength="200" rows="4" disabled><?php echo $cancel_reason ?></textarea>
<?php endif; ?>

<br id="temp"/><br id="temp"/>

<?php $this->endWidget(); ?>

<?php
  	AHelper::popupwindow($this, 600, 500);
?>

<script>
	var rowCount = <?php echo count($model) ?>;
	var authorizedCancel = true;

	$('#btnFilter').click(function()
	{
		$('#scenario').val('filter');
	})
	
	$('#btnSubmit').click(function()
	{
		$('#scenario').val('save');
		$('#rowCount').val(rowCount);
	})
	
	$(window).resize(function() {
		adjustWidth();
	})
	$(window).trigger('resize');
	
	init();
	adjustWidth();
	<?php if ($model){?>
		adjustWidth();
		$("#btnDuplicate").attr('disabled',false);
		$("#btnSubmit").attr('disabled',false);
	<?php }else{?>
		$("#btnDuplicate").attr('disabled','disabled');
		$("#btnSubmit").attr('disabled','disabled');
	<?php }?>
	
	function adjustWidth(){
		$("#header1").width($("#tableDummy tbody tr:eq(0) td:eq(0)").width());
		$("#header2").width($("#tableDummy tbody tr:eq(0) td:eq(1)").width());
		$("#header3").width($("#tableDummy tbody tr:eq(0) td:eq(2)").width());
		$("#header4").width($("#tableDummy tbody tr:eq(0) td:eq(3)").width());
		$("#header5").width($("#tableDummy tbody tr:eq(0) td:eq(4)").width());
		$("#header6").width($("#tableDummy tbody tr:eq(0) td:eq(5)").width());
		$("#header7").width($("#tableDummy tbody tr:eq(0) td:eq(6)").width());
	}
	
	function init()
	{
		$.ajax({
    		'type'     :'POST',
    		'url'      : '<?php echo $this->createUrl('ajxValidateCancel'); ?>',
			'dataType' : 'json',
			'statusCode':
			{
				403		: function(data){
					authorizedCancel = false;
				}
			}
		});
		
		cancel_reason();
	}
	
		
	function rowControl(obj, readonly)
	{
		var x = $(obj).closest('tr').prevAll().length;
		
		$("#tableBond tbody tr:eq("+x+")").attr("id","row"+(x+1));	
		$("#tableBond tbody tr:eq("+x+") td:eq(1) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableBond tbody tr:eq("+x+") td:eq(2) select").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableBond tbody tr:eq("+x+") td:eq(3) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableBond tbody tr:eq("+x+") td:eq(4) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableBond tbody tr:eq("+x+") td:eq(5) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		
		
		if(!$(obj).is(':checked') && $(obj).closest('tr').hasClass('markCancel'))$(obj).closest('tr').find('td:eq(6) a').trigger('click'); //unmark the row for cancellation if the checkbox is unchecked
	}
	
	function addTopRow()
	{
		$("#tableBond").find('tbody')
    		.prepend($('<tr>')
			.attr('id','row1')
			.append($('<td>')
				.append($('<input>')
					.attr('name','Tbondprice[1][save_flg]')
					.attr('type','checkbox')
					.attr('onChange','rowControl(this,false)')
					.prop('checked',true)
					.val('Y')
				)
			).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span tdate newdate')
           		 	.attr('name','Tbondprice[1][price_dt]')
           		 	.attr('placeholder','dd/mm/yyyy')
					.attr('type','text')
					.val($('#newpricedt').val())
           		)
			).append($('<td>')
           		 .append($('<select>')
           		 	.attr('class','span')
           		 	.attr('name','Tbondprice[1][bond_cd]')
					.attr('type','text')
					.append($('<option>').val("").text("--Choose Bond--"))
					<?php foreach($dropdownbond as $bond){?>
					.append($('<option>').val("<?php echo $bond->bond_cd;?>").text("<?php echo $bond->bond_desc;?>"))
					<?php }?>
           		)
           	).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Tbondprice[1][price]')
           		 	.css('text-align','right')
					.attr('type','text')
           		)
           	).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Tbondprice[1][yield]')
           		 	.css('text-align','right')
					.attr('type','text')
           		)
           	).append($('<td>')
           		.append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Tbondprice[1][bond_rate]')
					.attr('type','text')
           		)
           	).append($('<td>')
           		 .append($('<a>')
       		 		.attr('onClick','deleteRow(this)')
       		 		.attr('title','delete')
       		 		.css('cursor','pointer')
       		 		.append($('<img>')
       		 			.attr('src','<?php echo Yii::app()->request->baseUrl ?>/images/delete.png')
       		 		)
           		)
           	)  	
		);
		rowCount++;
		reassignId();
		formatDate();
	}
	
	function addRow(num)
	{
		$("#tableBond").find('tbody')
    		.prepend($('<tr>')
			.attr('id','row1')
			.append($('<td>')
				.append($('<input>')
					.attr('name','Tbondprice[1][save_flg]')
					.attr('type','checkbox')
					.attr('onChange','rowControl(this,false)')
					.prop('checked',true)
					.val('Y')
				)
			).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span tdate newdate')
           		 	.attr('name','Tbondprice[1][price_dt]')
           		 	.attr('placeholder','dd/mm/yyyy')
					.attr('type','text')
					.val($('#newpricedt').val())
           		)
			).append($('<td>')
           		 .append($('<select>')
           		 	.append($('<option>').val("").text("--Choose Bond--"))
           		 	<?php foreach($dropdownbond as $bond){?>
					.append($('<option>').val("<?php echo $bond->bond_cd;?>").text("<?php echo $bond->bond_desc;?>"))
					<?php }?>
           		 	.attr('class','span')
           		 	.attr('name','Tbondprice[1][bond_cd]')
					.attr('type','text')
					.val($("#Tbondprice_"+num+"_bond_cd").val())
           		)
           	).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Tbondprice[1][price]')
           		 	.css('text-align','right')
					.attr('type','text')
					.val($("#Tbondprice_"+num+"_price").val())
           		)
           	).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Tbondprice[1][yield]')
           		 	.css('text-align','right')
					.attr('type','text')
					.val($("#Tbondprice_"+num+"_yield").val())
           		)
           	).append($('<td>')
           		.append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Tbondprice[1][bond_rate]')
					.attr('type','text')
					.val($("#Tbondprice_"+num+"_bond_rate").val())
           		)
           	).append($('<td>')
           		 .append($('<a>')
       		 		.attr('onClick','deleteRow(this)')
       		 		.attr('title','delete')
       		 		.css('cursor','pointer')
       		 		.append($('<img>')
       		 			.attr('src','<?php echo Yii::app()->request->baseUrl ?>/images/delete.png')
       		 		)
           		)
           	)  	
		);
		rowCount++;
		reassignId();
		formatDate();
	}
   	
   	function reassignId()
   	{
   		//var index = $(obj).closest('tr').prevAll().length + 1;
   		var obj = $("#tableBond tbody");
   		
   		for(x=0;x<rowCount;x++)
   		{
			obj.find("tr:eq("+x+")").attr("id","row"+(x+1));	
			obj.find("tr:eq("+x+") td:eq(0) [type=checkbox]").attr("name","Tbondprice["+(x+1)+"][save_flg]");
			obj.find("tr:eq("+x+") td:eq(0) [type=hidden]:eq(0)").attr("name","Tbondprice["+(x+1)+"][save_flg]");
			obj.find("tr:eq("+x+") td:eq(0) [type=hidden]:eq(1)").attr("name","Tbondprice["+(x+1)+"][cancel_flg]");
			obj.find("tr:eq("+x+") td:eq(1) [type=text]").attr("name","Tbondprice["+(x+1)+"][price_dt]");
			obj.find("tr:eq("+x+") td:eq(1) [type=hidden]").attr("name","Tbondprice["+(x+1)+"][old_price_dt]");
			obj.find("tr:eq("+x+") td:eq(2) select").attr("name","Tbondprice["+(x+1)+"][bond_cd]");
			obj.find("tr:eq("+x+") td:eq(2) [type=hidden]").attr("name","Tbondprice["+(x+1)+"][old_bond_cd]");
			obj.find("tr:eq("+x+") td:eq(3) [type=text]").attr("name","Tbondprice["+(x+1)+"][price]");
			obj.find("tr:eq("+x+") td:eq(4) [type=text]").attr("name","Tbondprice["+(x+1)+"][yield]");
			obj.find("tr:eq("+x+") td:eq(5) [type=text]").attr("name","Tbondprice["+(x+1)+"][bond_rate]");
		}
		
		//Looping kedua untuk menentukan mana record yang dapat di-cancel dan mana row yang dapat di-delete
		for(x=0;x<rowCount;x++)
   		{
   			if($("[name='Tbondprice["+(x+1)+"][cancel_flg]']").val())
				obj.find("tr:eq("+x+") td:eq(9) a:eq(1)").attr('onClick',"cancel(this,'"+$("[name='Tbondprice["+(x+1)+"][cancel_flg]']").val()+"',"+(x+1)+")")		
   			else
   			{
   				obj.find("tr:eq("+x+") td:eq(9) a:eq(1)").attr('onClick',"deleteRow(this)");
   			}
   		}
   	}
	
	function deleteRow(obj)
	{
		$(obj).closest('tr').remove();
		rowCount--;
		reassignId();
	}
	
	function cancel(obj, cancel_flg, seq)
	{
		if(authorizedCancel)
		{
			$(obj).closest('tr').attr('class',cancel_flg=='N'?'markCancel':'');
			//alert(cancel_flg);  
			$('[name="Tbondprice['+seq+'][cancel_flg]"]').val(cancel_flg=='N'?'Y':'N'); 
			$(obj).attr('onClick',cancel_flg=='N'?"cancel(this,'Y',"+seq+")":"cancel(this,'N',"+seq+")");
			
			$("#tableBond tbody tr:eq("+(seq-1)+") td:eq(0) [type=checkbox]").prop('checked',cancel_flg=='N'?true:false).trigger('change'); //check or uncheck the checkbox
			
			cancel_reason();
		}
		else
			alert('You are not authorized to perform this action');	
	}
	
	function cancel_reason()
	{
		var cancel_reason = false;
		
		for(x=0;x<rowCount;x++)
		{
			if($("#row"+(x+1)).hasClass('markCancel'))
			{
				cancel_reason = true;
				break;
			}
		}
		
		if(cancel_reason)$(".cancel_reason, #temp").show().attr('disabled',false)
		else
			$(".cancel_reason, #temp").hide().attr('disabled',true);
	}
	
	$('#tableBond').find('.tdate').datepicker({'format':'dd/mm/yyyy','language':'en'});
	function formatDate(){
		$('.tdate').datepicker({'format':'dd/mm/yyyy','language':'en'});
	}
	
	$("#btnDuplicate").click(function(){
		duplicateRow();
	});
	
	function duplicateRow(){
		var q = 0;
		rows = rowCount;
		for(q=rows;q>0;q--){
			addRow(q);
		}
		$("#btnDuplicate").attr('disabled','disabled');
	}
	
	$('#btnApply').click(function(){
		$('.newdate').val($('#newpricedt').val());
	})
</script>


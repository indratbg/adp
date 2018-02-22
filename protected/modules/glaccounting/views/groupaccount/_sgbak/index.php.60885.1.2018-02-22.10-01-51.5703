<style>
	#groupaccount-form input[type=radio]
	{
		margin-left: 15px;
		margin-right: 5px;
		margin-bottom: 7px;
	}
	#tableGrp
	{
		background-color:#C3D9FF;
	}
	#tableGrp thead, #tableGrp tbody
	{
		display:block;
	}
	#tableGrp tbody
	{
		height:300px;
		overflow:auto;
		background-color:#FFFFFF;
	}
	.markCancel
	{
		background-color:#BB0000;
	}
</style>

<?php
$this->breadcrumbs=array(
	'Groupaccounts'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Groupaccount', 'itemOptions'=>array('class'=>'nav-header')),	
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/groupaccount/index','icon'=>'list'),
);

?>

<h1>Map GL Acct to Balance Sheet Entry</h1>

<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'groupaccount-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

<?php 
	foreach($model as $row)
		echo $form->errorSummary(array($row)); 
?>

<br/>

<div class="filter-group span8" style="margin-left:-15px;width:560px">
	<?php //echo $form->radioButtonListInlineRow($model[],'filterCriteria',array('Balance Sheet Aktiva','Balance Sheet Pasiva','Profit and Loss')) ?>
	<input type="radio" id="filter1" name="filter" value="0" <?php if($selected == 0)echo 'checked' ?>/>Balance Sheet Aktiva
	<input type="radio" id="filter2" name="filter" value="1" <?php if($selected == 1)echo 'checked' ?>/>Balance Sheet Pasiva
	<input type="radio" id="filter3" name="filter" value="2" <?php if($selected == 2)echo 'checked' ?>/>Profit and Loss
	<input type="hidden" id="scenario" name="scenario"/>
	
	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'id' => 'btnFilter',
		'buttonType' => 'submit',
		'type'=>'primary',
		'label'=>'Retrieve',
		'htmlOptions' => array('style'=>'margin-left:1em'),
	)); ?>
</div>

<div>
	<label id="label_id_gl" class="control-label">Gl Account</label>
	<div class="controls">
		<input type="text" id="glAcctCd" class="span" style="margin-left:-60px;width:50px" maxlength="4">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'id' => 'btnSearch',
			'buttonType' => 'button',
			'label'=>'Find',
			'htmlOptions' => array('style'=>'margin-left:1em'),
		)); ?>
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'id'=>'btnRpt',
			'buttonType' => 'submit',
			'type' => 'primary',
			'label' => 'Print',
			'htmlOptions' => array('style'=>'margin-left:1em')
		));
		?>
		<a href="<?php echo $url_xls ;?>" id="btn_xls" class="btn btn-primary">Save to Excel</a>
	</div>
</div>

<input type="hidden" id="oldFilterCriteria" name="oldFilterCriteria" value="<?php echo $selected ?>"/>
<input type="hidden" id="rowCount" name="rowCount"/>

<br/>
<table id='tableGrp' class='table-bordered table-condensed'>
	<thead>
		<tr>
			<th width="4%"></th>
			<th width="5%">Item Type</th>
			<th width="5%">Grp 1</th>
			<th width="5%">Grp 2</th>
			<th width="5%">Grp 3</th>
			<th width="5%">Grp 4</th>
			<th width="5%">Grp 5</th>
			<th width="15%">Gl Account</th>
			<th width="30%">Description</th>
			<th width="6%">
				<a title="add" onclick="addTopRow()"><img src="<?php echo Yii::app()->request->baseUrl ?>/images/add.png"></a>
			</th>
		</tr>
	</thead>	
	<tbody>
	<?php $x = 1;
		foreach($model as $row){
	?>
		<tr id="row<?php echo $x ?>" class="<?php if($row->cancel_flg == 'Y')echo 'markCancel' ?>">
			<td width="4%">
				<?php echo $form->checkBox($row,'save_flg',array('value' => 'Y','name'=>'Groupaccount['.$x.'][save_flg]','onChange'=>$row->acct_name?'rowControl(this,true)':'rowControl(this,false)')); ?>
				<?php if($row->old_pl_bs_flg): ?>
					<input type="hidden" name="Groupaccount[<?php echo $x ?>][cancel_flg]" value="<?php echo $row->cancel_flg ?>"/>	
				<?php endif; ?>
			</td>
			<td width="5%">
				<?php echo $form->textField($row,'pl_bs_flg',array('class'=>'span','name'=>'Groupaccount['.$x.'][pl_bs_flg]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?>
				<input type="hidden" name="Groupaccount[<?php echo $x ?>][old_pl_bs_flg]" value="<?php echo $row->old_pl_bs_flg ?>" />
			</td>
			<td width="5%">
				<?php echo $form->textField($row,'grp_1',array('class'=>'span','name'=>'Groupaccount['.$x.'][grp_1]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?>
				<input type="hidden" name="Groupaccount[<?php echo $x ?>][old_grp_1]" value="<?php echo $row->old_grp_1 ?>" />
			</td>
			<td width="5%">
				<?php echo $form->textField($row,'grp_2',array('class'=>'span','name'=>'Groupaccount['.$x.'][grp_2]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?>
				<input type="hidden" name="Groupaccount[<?php echo $x ?>][old_grp_2]" value="<?php echo $row->old_grp_2 ?>" />
			</td>
			<td width="5%">
				<?php echo $form->textField($row,'grp_3',array('class'=>'span','name'=>'Groupaccount['.$x.'][grp_3]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?>
				<input type="hidden" name="Groupaccount[<?php echo $x ?>][old_grp_3]" value="<?php echo $row->old_grp_3 ?>" />
			</td>
			<td width="5%">
				<?php echo $form->textField($row,'grp_4',array('class'=>'span','name'=>'Groupaccount['.$x.'][grp_4]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?>
				<input type="hidden" name="Groupaccount[<?php echo $x ?>][old_grp_4]" value="<?php echo $row->old_grp_4 ?>" />
			</td>
			<td width="5%">
				<?php echo $form->textField($row,'grp_5',array('class'=>'span','name'=>'Groupaccount['.$x.'][grp_5]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?>
				<input type="hidden" name="Groupaccount[<?php echo $x ?>][old_grp_5]" value="<?php echo $row->old_grp_5 ?>" />
			</td>
			<td width="15%"><?php echo $form->textField($row,'gl_acct_cd',array('class'=>'span','name'=>'Groupaccount['.$x.'][gl_acct_cd]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?></td>
			<td width="30%">
				<?php echo $form->textField($row,'line_desc',array('class'=>'span','name'=>'Groupaccount['.$x.'][line_desc]','value'=>$row->acct_name?$row->acct_name:$row->line_desc,'readonly'=>($row->acct_name || $row->save_flg!='Y')?'readonly':'')); ?>
				<input type="hidden" name="Groupaccount[<?php echo $x ?>][acct_name]" value="<?php echo $row->acct_name ?>" />
			</td>
			<td width="6%">
				<a title="add" onclick="addRow(this)"><img src="<?php echo Yii::app()->request->baseUrl ?>/images/add.png"></a>
				<a 	
					title="<?php if($row->old_pl_bs_flg) echo 'cancel';else echo 'delete'?>" 
					onclick="<?php if($row->old_pl_bs_flg) echo 'cancel(this,\''.$row->cancel_flg.'\','.$x.')';else echo 'deleteRow(this)'?>">
					<img src="<?php echo Yii::app()->request->baseUrl ?>/images/delete.png">
				</a>
			</td>
		</tr>
	<?php $x++;} ?>
	</tbody>	
</table>
<br id="temp"/>

<?php if($model): ?>
	<?php echo $form->label($model[0], 'Cancel Reason', array('class'=>'control-label cancel_reason'))?>
	<textarea id="cancel_reason" class="span5 cancel_reason" name="cancel_reason" maxlength="200" rows="4" disabled><?php echo $cancel_reason ?></textarea>
<?php endif; ?>

<br id="temp"/><br id="temp"/>

<div class="text-center" style="margin-left:-100px">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'buttonType'=>'submit',
		'type'=>'primary',
		'htmlOptions'=>array('id'=>'btnSubmit'),
		'label'=> 'Save',
	)); ?>
</div>

<br/>

	<iframe src="<?php echo $url; ?>" id="iframe" style="min-height:600px;max-width: 100%;"></iframe>


<?php $this->endWidget(); ?>

<?php
  	AHelper::popupwindow($this, 600, 500);
?>

<script>
	var rowCount = <?php echo count($model) ?>;
	var authorizedCancel = true;
	var url_xls = '<?php echo $url_xls ?>';
	
	$('#iframe').hide();
	$('#btn_xls').hide();
	if(url_xls !=''){
		$('#btn_xls').show();
		$('#iframe').show();
		$('#tableGrp').hide();
		$('#btnSubmit').hide();
		$('#label_id_gl').hide();
		$('#glAcctCd').hide();
		$('#btnSearch').hide();
	}

	$('#btnFilter').click(function()
	{
		$('#scenario').val('filter');
	})
	
	$('#btnSubmit').click(function()
	{
		$('#scenario').val('save');
		$('#rowCount').val(rowCount);
	})
	
	$('#btnRpt').click(function()
	{
		$('#scenario').val('report');
	})
	
	$('#btn_xls').click(function()
	{
		
	})
	
	$('#btnSearch').click(function()
	{
		var gl_acct_cd = $('#glAcctCd').val();
		
		for(x=0;x<rowCount;x++)
		{
			var obj = $("#tableGrp tbody tr:eq("+x+") td:eq(7) [type=text]")
			if(obj.val().trim().substr(0,4).toUpperCase() == gl_acct_cd.trim().toUpperCase())
			{
				obj.focus();
				break;
			}
			if(x == rowCount-1)alert('Gl Account Not Found')
		}
	})
	
	$(window).resize(function() {
		$('thead').css('width', '100%').css('width', '-=17px');
	})
	$(window).trigger('resize');
	
	init();
	
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
		
		adjustIframeSize();
		
		if(url_xls=='')
		{
			$('#btn_xls').attr('disabled',true);
		}
	}
	
		
	function rowControl(obj, readonly)
	{
		var x = $(obj).closest('tr').prevAll().length;
		
		$("#tableGrp tbody tr:eq("+x+")").attr("id","row"+(x+1));	
		$("#tableGrp tbody tr:eq("+x+") td:eq(1) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableGrp tbody tr:eq("+x+") td:eq(2) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableGrp tbody tr:eq("+x+") td:eq(3) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableGrp tbody tr:eq("+x+") td:eq(4) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableGrp tbody tr:eq("+x+") td:eq(5) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableGrp tbody tr:eq("+x+") td:eq(6) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableGrp tbody tr:eq("+x+") td:eq(7) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableGrp tbody tr:eq("+x+") td:eq(8) [type=text]").attr("readonly",!$(obj).is(':checked')||readonly?true:false);
		
		if(!$(obj).is(':checked') && $(obj).closest('tr').hasClass('markCancel'))$(obj).closest('tr').find('td:eq(9) a:eq(1)').trigger('click'); //unmark the row for cancellation if the checkbox is unchecked
	}
	
	function addTopRow()
	{
		$("#tableGrp").find('tbody')
    		.prepend($('<tr>')
			.attr('id','row1')
			.append($('<td>')
				.append($('<input>')
					.attr('name','Groupaccount[1][save_flg]')
					.attr('type','checkbox')
					.attr('onChange','rowControl(this,false)')
					.prop('checked',true)
					.val('Y')
				)
			).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Groupaccount[1][pl_bs_flg]')
					.attr('type','text')
				<?php
					if($selected == 0 || $selected == 1)
					{
				?>
					.val('N')
				<?php
					}
					else 
					{
				?>
					.val('P')
				<?php		
					}
				?>
           		)
			).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Groupaccount[1][grp_1]')
					.attr('type','text')
				<?php
					if($selected == 0 || $selected == 2)
					{
				?>
					.val('1')
				<?php
					}
					else
					{
				?>
					.val('2')
				<?php		
					}
				?>
           		)
           	).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Groupaccount[1][grp_2]')
					.attr('type','text')
           		)
           	).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Groupaccount[1][grp_3]')
					.attr('type','text')
           		)
           	).append($('<td>')
           		.append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Groupaccount[1][grp_4]')
					.attr('type','text')
           		)
           	).append($('<td>')
           		.append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Groupaccount[1][grp_5]')
					.attr('type','text')
           		)
           	).append($('<td>')
           		.append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Groupaccount[1][gl_acct_cd]')
					.attr('type','text')
           		)
           	).append($('<td>')
           		.append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Groupaccount[1][line_desc]')
					.attr('type','text')
           		)
           	).append($('<td>')
           		 .append($('<a>')
           		 	.attr('onClick','addRow(this)')
           		 	.attr('title','add')
           		 	.append($('<img>')
           		 		.attr('src','<?php echo Yii::app()->request->baseUrl ?>/images/add.png')
           		 	)
           		).append('&nbsp;')
           		 .append($('<a>')
       		 		.attr('onClick','deleteRow(this)')
       		 		.attr('title','delete')
       		 		.append($('<img>')
       		 			.attr('src','<?php echo Yii::app()->request->baseUrl ?>/images/delete.png')
       		 		)
           		)
           	)  	
		);
		rowCount++;
		reassignId();
	}

	function addRow(obj)
	{
		($('<tr>').insertAfter($(obj).closest('tr'))
			.attr('id','row0')
			.append($('<td>')
				.append($('<input>')
					.attr('name','Groupaccount[0][save_flg]')
					.attr('type','checkbox')
					.attr('onChange','rowControl(this,false)')
					.prop('checked',true)
					.val('Y')
				)
			).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Groupaccount[0][pl_bs_flg]')
					.attr('type','text')
				<?php
					if($selected == 0 || $selected == 1)
					{
				?>
					.val('N')
				<?php
					}
					else 
					{
				?>
					.val('P')
				<?php		
					}
				?>
           		)
			).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Groupaccount[0][grp_1]')
					.attr('type','text')
				<?php
					if($selected == 0 || $selected == 2)
					{
				?>
					.val('1')
				<?php
					}
					else
					{
				?>
					.val('2')
				<?php		
					}
				?>
           		)
           	).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Groupaccount[0][grp_2]')
					.attr('type','text')
           		)
           	).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Groupaccount[0][grp_3]')
					.attr('type','text')
           		)
           	).append($('<td>')
           		.append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Groupaccount[0][grp_4]')
					.attr('type','text')
           		)
           	).append($('<td>')
           		.append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Groupaccount[0][grp_5]')
					.attr('type','text')
           		)
           	).append($('<td>')
           		.append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Groupaccount[0][gl_acct_cd]')
					.attr('type','text')
           		)
           	).append($('<td>')
           		.append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Groupaccount[0][line_desc]')
					.attr('type','text')
           		)
           	).append($('<td>')
           		 .append($('<a>')
           		 	.attr('onClick','addRow(this)')
           		 	.attr('title','add')
           		 	.append($('<img>')
           		 		.attr('src','<?php echo Yii::app()->request->baseUrl ?>/images/add.png')
           		 	)
           		).append('&nbsp;')
           		 .append($('<a>')
       		 		.attr('onClick','deleteRow(this)')
       		 		.attr('title','delete')
       		 		.append($('<img>')
       		 			.attr('src','<?php echo Yii::app()->request->baseUrl ?>/images/delete.png')
       		 		)
           		)
           	)  	
		);
		rowCount++;
		reassignId();
   	}
   	
   	function reassignId()
   	{
   		//var index = $(obj).closest('tr').prevAll().length + 1;
   		var obj = $("#tableGrp tbody");
   		
   		for(x=0;x<rowCount;x++)
   		{
			obj.find("tr:eq("+x+")").attr("id","row"+(x+1));	
			obj.find("tr:eq("+x+") td:eq(0) [type=checkbox]").attr("name","Groupaccount["+(x+1)+"][save_flg]");
			obj.find("tr:eq("+x+") td:eq(0) [type=hidden]:eq(0)").attr("name","Groupaccount["+(x+1)+"][save_flg]");
			obj.find("tr:eq("+x+") td:eq(0) [type=hidden]:eq(1)").attr("name","Groupaccount["+(x+1)+"][cancel_flg]");
			obj.find("tr:eq("+x+") td:eq(1) [type=text]").attr("name","Groupaccount["+(x+1)+"][pl_bs_flg]");
			obj.find("tr:eq("+x+") td:eq(1) [type=hidden]").attr("name","Groupaccount["+(x+1)+"][old_pl_bs_flg]");
			obj.find("tr:eq("+x+") td:eq(2) [type=text]").attr("name","Groupaccount["+(x+1)+"][grp_1]");
			obj.find("tr:eq("+x+") td:eq(2) [type=hidden]").attr("name","Groupaccount["+(x+1)+"][old_grp_1]");
			obj.find("tr:eq("+x+") td:eq(3) [type=text]").attr("name","Groupaccount["+(x+1)+"][grp_2]");
			obj.find("tr:eq("+x+") td:eq(3) [type=hidden]").attr("name","Groupaccount["+(x+1)+"][old_grp_2]");
			obj.find("tr:eq("+x+") td:eq(4) [type=text]").attr("name","Groupaccount["+(x+1)+"][grp_3]");
			obj.find("tr:eq("+x+") td:eq(4) [type=hidden]").attr("name","Groupaccount["+(x+1)+"][old_grp_3]");
			obj.find("tr:eq("+x+") td:eq(5) [type=text]").attr("name","Groupaccount["+(x+1)+"][grp_4]");
			obj.find("tr:eq("+x+") td:eq(5) [type=hidden]").attr("name","Groupaccount["+(x+1)+"][old_grp_4]");
			obj.find("tr:eq("+x+") td:eq(6) [type=text]").attr("name","Groupaccount["+(x+1)+"][grp_5]");
			obj.find("tr:eq("+x+") td:eq(6) [type=hidden]").attr("name","Groupaccount["+(x+1)+"][old_grp_5]");
			obj.find("tr:eq("+x+") td:eq(7) [type=text]").attr("name","Groupaccount["+(x+1)+"][gl_acct_cd]");
			obj.find("tr:eq("+x+") td:eq(8) [type=text]").attr("name","Groupaccount["+(x+1)+"][line_desc]");
			obj.find("tr:eq("+x+") td:eq(8) [type=hidden]").attr("name","Groupaccount["+(x+1)+"][acct_name]");
		}
		
		//Looping kedua untuk menentukan mana record yang dapat di-cancel dan mana row yang dapat di-delete
		for(x=0;x<rowCount;x++)
   		{
   			if($("[name='Groupaccount["+(x+1)+"][cancel_flg]']").val())
				obj.find("tr:eq("+x+") td:eq(9) a:eq(1)").attr('onClick',"cancel(this,'"+$("[name='Groupaccount["+(x+1)+"][cancel_flg]']").val()+"',"+(x+1)+")")		
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
			$('[name="Groupaccount['+seq+'][cancel_flg]"]').val(cancel_flg=='N'?'Y':'N'); 
			$(obj).attr('onClick',cancel_flg=='N'?"cancel(this,'Y',"+seq+")":"cancel(this,'N',"+seq+")");
			
			$("#tableGrp tbody tr:eq("+(seq-1)+") td:eq(0) [type=checkbox]").prop('checked',cancel_flg=='N'?true:false).trigger('change'); //check or uncheck the checkbox
			
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
	
	$(window).resize(function()
	{
		adjustIframeSize();
	});
	
	function adjustIframeSize()
	{
		$("#iframe").offset({left:335});
		$("#iframe").css('width',($(window).width()+35));
	}
</script>


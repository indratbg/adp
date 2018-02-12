<style>
	#Maplk-form input[type=radio]
	{
		margin-left: 15px;
		margin-right: 5px;
		margin-bottom: 7px;
	}
	#tableMaplk
	{
		background-color:#C3D9FF;
	}
	#tableMaplk thead, #tableMaplk tbody
	{
		display:block;
	}
	#tableMaplk tbody
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
	'Map GL Account Code to Consol Report'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Map GL Account Code to Consol Report Entry','itemOptions'=>array('style'=>'font-size:28px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/maplk/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),

);

?>

<br/>

<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'Maplk-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

<?php $query = "select * from v_broker_subrek";
	$entity_cd =DAO::queryRowSql($query);
?>

<?php 
	foreach($model as $row)
		echo $form->errorSummary(array($row)); 
?>


<div class="span12">
	
<?php echo $pesan; ?>
<b style="margin-right: 70px;">Versi</b>

		<input type="text" name="from_dt" value="<?php echo $ver_from_dt ?>" id="from_dt"placeholder="dd/mm/yyyy" class="span2" >
		<b style="margin-right: 60px;margin-left: 10px;">To</b>
		<input type="text" name="to_dt"value="<?php echo $ver_to_dt ?>" id="to_dt" placeholder="dd/mm/yyyy" class="span2"></td>


		<b style="margin-left:10px;margin-right: 30px;">Entity CD</b>
	
		<input type="text" id="Entity" onchange="Entity_cd()"name="entity" maxlength="5" value="<?php echo $entity ?>" placeholder="Entity Cd" class="span2">

<br/><br/>
			<b style="margin-right: 10px;">Consol Account</b>
	
			<input type="text" name="lk_acct" id ="lk_acct" value="<?php echo $lk_acct ?>"  maxlength="5" placeholder="Consol Account" class="span2">
	
			<b style="margin-left: 10px;margin-right: 10px;">GL Account</b>
	
			<input type="text" name="gl_a" id="gl_a" value="<?php echo $gl_a ?>" placeholder="GL Account" maxlength="12" class="span2">
		
			<b style="margin-left:10px;margin-right: 10px;">Sub Account</b>
		
			<input type="text" name="sl_a" value="<?php echo $sl_a ?>" placeholder="Sub Account" maxlength="12" class="span2">
		<br/><br/>
		<?php $this->widget('bootstrap.widgets.TbButton', array(
								'id'=>'btnFilter',
								'buttonType'=>'submit',
								'type'=>'primary',
								'htmlOptions'=>array('style'=>'margin-left:0%;'),
								'label'=> 'Retrieve',
							)); ?>
				
	
	<br/><br/>
	
	<input type="hidden" id="scenario" name="scenario"/>

</div>
<input type="hidden" id="rowCount" name="rowCount"/>
<br/>
<br/>
<table id='tableMaplk' class='table-bordered table-condensed'>
	<thead>
		<tr>
			<th width="5%"><input type="checkbox" id="checkBoxAll" value="1" onClick= "changeAll()"/></th>
			<th width="10%">Versi</th>
			<th width="10%">Ver End DT</th>
			<th width="8%">Entity CD</th>
			<th width="8%">Consol Account</th>
			<th width="10%">GL Account</th>
			<th width="10%">Sub Account</th>
			<th width="8%">Col Num</th>
			<th width="7%">Sign</th>
			<th width="9%">
				<a title="add" style="cursor:pointer;" onclick="addTopRow()"><img src="<?php echo Yii::app()->request->baseUrl ?>/images/add.png"></a>
			</th>
		</tr>
	</thead>	
	<tbody>
	<?php $x = 1;
		foreach($model as $row){
	?>
		<tr id="row<?php echo $x ?>" class="<?php if($row->cancel_flg == 'Y')echo 'markCancel' ?>">
			<td>
				<?php echo $form->checkBox($row,'save_flg',array('class'=>'checkBoxDetail','value' => 'Y','name'=>'Maplk['.$x.'][save_flg]','onChange'=>'rowControl(this,false)')); ?>
				<?php if($row->old_ver_bgn_dt): ?>
					<input type="hidden" name="Maplk[<?php echo $x ?>][cancel_flg]" value="<?php echo $row->cancel_flg ?>"/>	
				<?php endif; ?>
			</td>
			<td>
				<?php echo $form->textField($row,'ver_bgn_dt',array('class'=>'span tdate','name'=>'Maplk['.$x.'][ver_bgn_dt]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?>
				<input type="hidden" name="Maplk[<?php echo $x ?>][old_ver_bgn_dt]" value="<?php echo $row->old_ver_bgn_dt ?>" />
			</td>
			<td >
				<?php echo $form->textField($row,'ver_end_dt',array('class'=>'span tdate','name'=>'Maplk['.$x.'][ver_end_dt]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?>
				
			</td>
			<td>
				<?php echo $form->textField($row,'entity_cd',array('class'=>'span','id'=>'Entity_cd_'.$x.'','onchange'=>'Entitytab('.$x.')','maxlength'=>'5','name'=>'Maplk['.$x.'][entity_cd]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?>
				<input type="hidden" name="Maplk[<?php echo $x ?>][old_entity_cd]" value="<?php echo $row->old_entity_cd ?>" />
			</td>
			<td>
				<?php $this->widget('application.extensions.widget.JuiAutoCompleteStd', array(
												'model'=>$row,
												'attribute'=>'lk_acct',
												'ajaxlink'=>array('getLk_acct'),
												'options'=>array('minLength'=>1),
												'htmlOptions'=>array('class'=>'span','name'=>'Maplk['.$x.'][lk_acct]','readonly'=>$row->save_flg!='Y'?'readonly':''),
										)); ?>
				
				<input type="hidden" name="Maplk[<?php echo $x ?>][old_lk_acct]" value="<?php echo $row->old_lk_acct ?>" />
			</td>
			<td>
				<?php echo $form->textField($row,'gl_a',array('class'=>'span','maxlength'=>'12','name'=>'Maplk['.$x.'][gl_a]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?>
				<input type="hidden" name="Maplk[<?php echo $x ?>][old_gl_a]" value="<?php echo $row->old_gl_a ?>" />
			</td>
			<td>
				<?php echo $form->textField($row,'sl_a',array('class'=>'span','maxlength'=>'12','name'=>'Maplk['.$x.'][sl_a]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?>
				<input type="hidden" name="Maplk[<?php echo $x ?>][old_sl_a]" value="<?php echo $row->old_sl_a ?>" />
			</td>
			<td>
				<?php echo $form->textField($row,'col_num',array('class'=>'span tnumber','id'=>'col_num_'.$x.'','maxlength'=>'2','name'=>'Maplk['.$x.'][col_num]','style'=>'text-align:right;','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?></td>
				<input type="hidden" name="Maplk[<?php echo $x ?>][old_col_num]" value="<?php echo $row->old_col_num ?>" />
			<td>
				<?php echo $form->textField($row,'sign',array('class'=>'span tnumber','maxlength'=>'2','id'=>'sign_'.$x.'','name'=>'Maplk['.$x.'][sign]','style'=>'text-align:right;','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?>
				
			</td>
			<td style="cursor:pointer;">
				<a title="add" onclick="addRow(this)"><img src="<?php echo Yii::app()->request->baseUrl ?>/images/add.png"></a>
				<a 	
					title="<?php if($row->old_ver_bgn_dt) echo 'cancel';else echo 'delete'?>" 
					onclick="<?php if($row->old_ver_bgn_dt) echo 'cancel(this,\''.$row->cancel_flg.'\','.$x.')';else echo 'deleteRow(this)'?>">
					<img src="<?php echo Yii::app()->request->baseUrl ?>/images/delete.png">
				</a>
				<a title="copy" onclick="copyRow(this)"><img src="<?php echo Yii::app()->request->baseUrl ?>/images/copy.png"></a>
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

<?php $this->endWidget(); ?>

<?php
  	AHelper::popupwindow($this, 600, 500);
?>
<?php echo $form->datePickerRow($model[0],'cre_dt',array('label'=>false,'disabled'=>'disabled','style'=>'display:none','options'=>array('format' => 'dd/mm/yyyy'))); ?>
<script>
	var rowCount = <?php echo count($model) ?>;
	var authorizedCancel = true;
init();
	$('#btnFilter').click(function()
	{
		$('#scenario').val('filter');
	})
	
	$('#btnSubmit').click(function()
	{
		$('#scenario').val('save');
		$('#rowCount').val(rowCount);
	})
	
	$('#btnSearch').click(function()
	{
		var gl_acct_cd = $('#glAcctCd').val();
		
		for(x=0;x<rowCount;x++)
		{
			var obj = $("#tableMaplk tbody tr:eq("+x+") td:eq(7) [type=text]")
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
	
	$("#from_dt").datepicker({format : "dd/mm/yyyy"});
	$("#to_dt").datepicker({format : "dd/mm/yyyy"});
	
	
		for(x=0;x<rowCount;x++)
				{
					
					
					$("#tableMaplk tbody tr:eq("+x+") td:eq(1) input").datepicker({format : "dd/mm/yyyy"});
					$("#tableMaplk tbody tr:eq("+x+") td:eq(2) input").datepicker({format : "dd/mm/yyyy"});
				}
	
	
		
		
	function init(){
		
		cancel_reason();
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
	}
	
	
		
	function rowControl(obj, readonly)
	{
		var x = $(obj).closest('tr').prevAll().length;
		
		$("#tableMaplk tbody tr:eq("+x+")").attr("id","row"+(x+1));	
		$("#tableMaplk tbody tr:eq("+x+") td:eq(1) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableMaplk tbody tr:eq("+x+") td:eq(2) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableMaplk tbody tr:eq("+x+") td:eq(3) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableMaplk tbody tr:eq("+x+") td:eq(4) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableMaplk tbody tr:eq("+x+") td:eq(5) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableMaplk tbody tr:eq("+x+") td:eq(6) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableMaplk tbody tr:eq("+x+") td:eq(7) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableMaplk tbody tr:eq("+x+") td:eq(8) [type=text]").attr("readonly",!$(obj).is(':checked')||readonly?true:false);
		
		if(!$(obj).is(':checked') && $(obj).closest('tr').hasClass('markCancel'))$(obj).closest('tr').find('td:eq(9) a:eq(1)').trigger('click'); //unmark the row for cancellation if the checkbox is unchecked
	}
	
	function addTopRow()
	{
		$("#tableMaplk").find('tbody')
    		.prepend($('<tr>')
			.attr('id','row1')
			.append($('<td>')
				.append($('<input>')
					.attr('class','checkBoxDetail')
					.attr('name','Maplk[1][save_flg]')
					.attr('type','checkbox')
					.attr('onChange','rowControl(this,false)')
					.prop('checked',true)
					.val('Y')
				
				)
			).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span tdate')
           		 	.attr('name','Maplk[1][ver_bgn_dt]')
					.attr('type','text')
					//.datepicker({format : "dd/mm/yyyy"})
					.val($('#from_dt').val())
           		)
			).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span tdate')
           		 	.attr('name','Maplk[1][ver_end_dt]')
					.attr('type','text')
					//.datepicker({format : "dd/mm/yyyy"})
					.val($('#to_dt').val())
           		)
			).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Maplk[1][entity_cd]')
					.attr('type','text')
					.attr('maxlength',5)
					.attr('id','Entity_cd_0')
					.attr('value','<?php echo substr($entity_cd['broker_cd'],0,2) ?>')
					.attr('onchange','Entitytab(0)')
           		)
			).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Maplk[1][lk_acct]')
					.attr('type','text')
					.attr('maxlength',5)
					.val($('#lk_acct').val())
						.autocomplete(
         			{
         				source: function (request, response) 
         				{
					        $.ajax({
					        	'type'		: 'POST',
					        	'url'		: '<?php echo $this->createUrl('getLk_acct'); ?>',
					        	'dataType' 	: 'json',
					        	'data'		:	{'term': request.term},
					        	'success'	: 	function (data) 
					        					{
											         response(data);
							    				}
							});
					    },
					    minLength: 1
         			})
           		)
			).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Maplk[1][gl_a]')
					.attr('type','text')
					.attr('maxlength',12)
					.val($('#gl_a').val())
           		)
			).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Maplk[1][sl_a]')
					.attr('type','text')
					.attr('maxlength',12)
					
           		)
			).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Maplk[1][col_num]')
					.attr('type','text')
					.attr('maxlength',2)
					.css('text-align','right')
					.attr('value',3)
           		)
			).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Maplk[1][sign]')
					.attr('type','text')
					.attr('maxlength',2)
					.css('text-align','right')
					.attr('value',1)
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
           		
           		.css('cursor','pointer')
           	)  	
		);
		rowCount++;
		reassignId();
		$(window).trigger('resize');
		formatDate();  	
	}

	function addRow(obj)
	{
		($('<tr>').insertAfter($(obj).closest('tr'))
			.attr('id','row0')
			.append($('<td>')
				.append($('<input>')
					.attr('class','checkBoxDetail')
					.attr('name','Maplk[0][save_flg]')
					.attr('type','checkbox')
					.attr('onChange','rowControl(this,false)')
					.prop('checked',true)
					.val('Y')
					
				)
			).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span tdate')
           		 	.attr('name','Maplk[1][ver_bgn_dt]')
					.attr('type','text')
					//.datepicker({format : "dd/mm/yyyy"})
					.val($('#from_dt').val())
           		)
			).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span tdate')
           		 	.attr('name','Maplk[1][ver_end_dt]')
					.attr('type','text')
					//.datepicker({format : "dd/mm/yyyy"})
					.val($('#to_dt').val())
           		)
			).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Maplk[1][entity_cd]')
					.attr('type','text')
					.attr('maxlength',5)
					.attr('id','Entity_cd_0')
					.attr('value','<?php echo substr($entity_cd['broker_cd'],0,2) ?>')
					.attr('onchange','Entitytab(0)')
           		)
			).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Maplk[1][lk_acct]')
					.attr('type','text')
					.attr('maxlength',5)
					.val($('#lk_acct').val())
					.autocomplete(
         			{
         				source: function (request, response) 
         				{
					        $.ajax({
					        	'type'		: 'POST',
					        	'url'		: '<?php echo $this->createUrl('getLk_acct'); ?>',
					        	'dataType' 	: 'json',
					        	'data'		:	{'term': request.term},
					        	'success'	: 	function (data) 
					        					{
											         response(data);
							    				}
							});
					    },
					    minLength: 1
         			})
           		)
			).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Maplk[1][gl_a]')
					.attr('type','text')
					.attr('maxlength',12)
					.val($('#gl_a').val())
           		)
			).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Maplk[1][sl_a]')
					.attr('type','text')
					.attr('maxlength',12)
           		)
			).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Maplk[1][col_num]')
					.attr('type','text')
					.attr('maxlength',2)
					.css('text-align','right')
					.attr('value',3)
           		)
			).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Maplk[1][sign]')
					.attr('type','text')
					.attr('maxlength',2)
					.css('text-align','right')
					.attr('value',1)
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
           		
           		.css('cursor','pointer')
           	)
           		
		)
		rowCount++;
		formatDate();  	
		reassignId();
		$(window).trigger('resize');
	
   	}
   	
   	function copyRow(obj){
   		($('<tr>').insertAfter($(obj).closest('tr'))
			.attr('id','row0')
			.append($('<td>')
				.append($('<input>')
					.attr('name','Maplk[0][save_flg]')
					.attr('type','checkbox')
					.attr('onChange','rowControl(this,false)')
					.prop('checked',true)
					.val('Y')
					
				)
			).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Maplk[1][ver_bgn_dt]')
					.attr('type','text')
					.datepicker({format : "dd/mm/yyyy"})
					.val($(obj).closest('tr').find('td:eq(1) [type=text]').val())
           		)
			).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Maplk[1][ver_end_dt]')
					.attr('type','text')
					.datepicker({format : "dd/mm/yyyy"})
					.val($(obj).closest('tr').find('td:eq(2) [type=text]').val())
           		)
			).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Maplk[1][entity_cd]')
					.attr('type','text')
					.attr('maxlength',5)
					.attr('id','Entity_cd_0')
					.attr('onchange','Entitytab(0)')
					.val($(obj).closest('tr').find('td:eq(3) [type=text]').val())
           		)
			).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Maplk[1][lk_acct]')
					.attr('type','text')
					.attr('maxlength',5)
					.val($(obj).closest('tr').find('td:eq(4) [type=text]').val())
					.autocomplete(
         			{
         				source: function (request, response) 
         				{
					        $.ajax({
					        	'type'		: 'POST',
					        	'url'		: '<?php echo $this->createUrl('getLk_acct'); ?>',
					        	'dataType' 	: 'json',
					        	'data'		:	{'term': request.term},
					        	'success'	: 	function (data) 
					        					{
							           				
											         response(data);
							    				}
							});
					    },
					    minLength: 1
         			})
           		)
			).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Maplk[1][gl_a]')
					.attr('type','text')
					.attr('maxlength',12)
					.val($(obj).closest('tr').find('td:eq(5) [type=text]').val())
           		)
			).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Maplk[1][sl_a]')
					.attr('type','text')
					.attr('maxlength',12)
					.val($(obj).closest('tr').find('td:eq(6) [type=text]').val())
           		)
			).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Maplk[1][col_num]')
					.attr('type','text')
					.attr('maxlength',2)
					.css('text-align','right')
					.val($(obj).closest('tr').find('td:eq(7) [type=text]').val())
           		)
			).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Maplk[1][sign]')
					.attr('type','text')
					.attr('maxlength',2)
					.css('text-align','right')
					.val($(obj).closest('tr').find('td:eq(8) [type=text]').val())
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
           		
           		.css('cursor','pointer')
           	)  	
		);
		rowCount++;
		reassignId();
		$(window).trigger('resize');
		formatDate();
   		//alert('aa');
   	//	$(obj).closest('tr').clone().insertAfter($(obj).closest('tr'));
   		
   	}
   	
   	function reassignId()
   	{
   		//var index = $(obj).closest('tr').prevAll().length + 1;
   		var obj = $("#tableMaplk tbody");
   		
   		for(x=0;x<rowCount;x++)
   		{
			obj.find("tr:eq("+x+")").attr("id","row"+(x+1));	
			obj.find("tr:eq("+x+") td:eq(0) [type=checkbox]").attr("name","Maplk["+(x+1)+"][save_flg]");
			obj.find("tr:eq("+x+") td:eq(0) [type=hidden]:eq(0)").attr("name","Maplk["+(x+1)+"][save_flg]");
			obj.find("tr:eq("+x+") td:eq(0) [type=hidden]:eq(1)").attr("name","Maplk["+(x+1)+"][cancel_flg]");
			obj.find("tr:eq("+x+") td:eq(1) [type=text]").attr("name","Maplk["+(x+1)+"][ver_bgn_dt]");
			obj.find("tr:eq("+x+") td:eq(1) [type=hidden]").attr("name","Maplk["+(x+1)+"][old_ver_bgn_dt]");
			obj.find("tr:eq("+x+") td:eq(2) [type=text]").attr("name","Maplk["+(x+1)+"][ver_end_dt]");
			obj.find("tr:eq("+x+") td:eq(3) [type=text]").attr("name","Maplk["+(x+1)+"][entity_cd]");
			obj.find("tr:eq("+x+") td:eq(3) [type=hidden]").attr("name","Maplk["+(x+1)+"][old_entity_cd]");
			obj.find("tr:eq("+x+") td:eq(4) [type=text]").attr("name","Maplk["+(x+1)+"][lk_acct]");
			obj.find("tr:eq("+x+") td:eq(4) [type=hidden]").attr("name","Maplk["+(x+1)+"][old_lk_acct]");
			obj.find("tr:eq("+x+") td:eq(5) [type=text]").attr("name","Maplk["+(x+1)+"][gl_a]");
			obj.find("tr:eq("+x+") td:eq(5) [type=hidden]").attr("name","Maplk["+(x+1)+"][old_gl_a]");
			obj.find("tr:eq("+x+") td:eq(6) [type=text]").attr("name","Maplk["+(x+1)+"][sl_a]");
			obj.find("tr:eq("+x+") td:eq(6) [type=hidden]").attr("name","Maplk["+(x+1)+"][old_sl_a]");
			obj.find("tr:eq("+x+") td:eq(7) [type=text]").attr("name","Maplk["+(x+1)+"][col_num]");
			obj.find("tr:eq("+x+") td:eq(7) [type=hidden]").attr("name","Maplk["+(x+1)+"][old_col_num]");
			obj.find("tr:eq("+x+") td:eq(8) [type=text]").attr("name","Maplk["+(x+1)+"][sign]");
			obj.find("tr:eq("+x+") td:eq(3) [type=text]").attr("id","Entity_cd_"+(x+1));
			obj.find("tr:eq("+x+") td:eq(3) [type=text]").attr("onchange","Entitytab("+(x+1)+")");
			obj.find("tr:eq("+x+") td:eq(7) [type=text]").attr("id","col_num_"+(x+1)+"");
			obj.find("tr:eq("+x+") td:eq(8) [type=text]").attr("id","sign_"+(x+1)+"");
		}
		
		//Looping kedua untuk menentukan mana record yang dapat di-cancel dan mana row yang dapat di-delete
		for(x=0;x<rowCount;x++)
   		{
   			if($("[name='Maplk["+(x+1)+"][cancel_flg]']").val())
				obj.find("tr:eq("+x+") td:eq(9) a:eq(1)").attr('onClick',"cancel(this,'"+$("[name='Maplk["+(x+1)+"][cancel_flg]']").val()+"',"+(x+1)+")")		
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
		$(window).trigger('resize');
	}
	
	function cancel(obj, cancel_flg, seq)
	{
		if(authorizedCancel)
		{
			$(obj).closest('tr').attr('class',cancel_flg=='N'?'markCancel':''); 
			$('[name="Maplk['+seq+'][cancel_flg]"]').val(cancel_flg=='N'?'Y':'N'); 
			$(obj).attr('onClick',cancel_flg=='N'?"cancel(this,'Y',"+seq+")":"cancel(this,'N',"+seq+")");
			
			$("#tableMaplk tbody tr:eq("+(seq-1)+") td:eq(0) [type=checkbox]").prop('checked',cancel_flg=='N'?true:false).trigger('change'); //check or uncheck the checkbox
			
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
	
	$(window).resize(function() {
		var body = $("#tableMaplk").find('tbody');
		if(body.get(0).scrollHeight > body.height()) //check whether  tbody has a scrollbar
		{
			$('thead').css('width', '100%').css('width', '-=17px');	
		}
		else
		{
			$('thead').css('width', '100%');	
		}
		
		alignColumn();
	})
	$(window).trigger('resize');
	
	function alignColumn()//align columns in thead and tbody
	{
		var header = $("#tableMaplk").find('thead');
		var firstRow = $("#tableMaplk").find('tbody tr:eq(0)');
		
		firstRow.find('td:eq(0)').css('width',header.find('th:eq(0)').width() + 'px');
		firstRow.find('td:eq(1)').css('width',header.find('th:eq(1)').width() + 'px');
		firstRow.find('td:eq(2)').css('width',header.find('th:eq(2)').width() + 'px');
		firstRow.find('td:eq(3)').css('width',header.find('th:eq(3)').width() + 'px');
		firstRow.find('td:eq(4)').css('width',header.find('th:eq(4)').width() + 'px');
		firstRow.find('td:eq(5)').css('width',header.find('th:eq(5)').width() + 'px');
		firstRow.find('td:eq(6)').css('width',header.find('th:eq(6)').width() + 'px');
		firstRow.find('td:eq(7)').css('width',header.find('th:eq(7)').width() + 'px');
		firstRow.find('td:eq(8)').css('width',header.find('th:eq(8)').width() + 'px');
		firstRow.find('td:eq(9)').css('width',header.find('th:eq(9)').width() + 'px');
		
	}
	function Entitytab(rnum){
		//alert('test');
			var curr = $('#Entity_cd_'+(rnum)).val();
			var y= curr.toUpperCase(); 
		
			$('#Entity_cd_'+rnum).val(y);
	}
	
	function Entity_cd(){
		
			var curr = $('#Entity').val();
			var y= curr.toUpperCase(); 
		
			$('#Entity').val(y);
	}
	function changeAll()
	{
		if($("#checkBoxAll").is(':checked'))
		{
			$(".checkBoxDetail").prop('checked',true);
		}
		else
		{
			$(".checkBoxDetail").prop('checked',false);
		}
	}
	
	setTimeout(function(){
		$('.tdate').datepicker('update');
	},
	100
	)
	
	//function formatDate(){
		$('.tdate').datepicker({'format':'dd/mm/yyyy','language':'en'});
		
	//}
	function formatDate(){
	//	alert('test');
		$('.tdate').datepicker({'format':'dd/mm/yyyy','language':'en'});
	}
</script>


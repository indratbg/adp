
<style>
	#Tvd55-form input[type=radio]
	{
		margin-left: 15px;
		margin-right: 5px;
		margin-bottom: 7px;
	}
	#tableTvd55
	{
		background-color:#C3D9FF;
	}
	#tableTvd55 thead, #tableTvd55 tbody
	{
		display:block;
	}
	#tableTvd55 tbody
	{
		
		max-height:300px;
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
	'Tvd55'=>array('index'),
	'List',
);

$this->menu=array(
	//array('label'=>'Tvd55', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'Data VD55 XE 13', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/tvd55/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	
);

?>


<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'Tvd55-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>
<?php //echo $form->errorSummary($modeldummy);?>

	

<?php 
	if($model){
		foreach($model as $row)
			echo $form->errorSummary(array($row));
	} 
?>

<br/>
<?php 
//if(DateTime::createFromFormat('d/m/y',$modeldummy->mkbd_date))$modeldummy->mkbd_date=DateTime::createFromFormat('d/m/y',$modeldummy->mkbd_date)->format('Y-m-d G:i:s');
	

$sql= "select count(*) as jumlah from t_vd55 where mkbd_date =( select max(mkbd_date) from t_vd55)";
$date=DAO::queryRowSql($sql);
//	$a=$modeldummy->mkbd_date;
	//echo "<script>alert('$a')</script>";
	//if($old_mkbd_date)$old_mkbd_date=DateTime::createFromFormat('Y-m-d',$old_mkbd_date)->format('Y-m-d G:i:s');
	$sql = "select mkbd_cd,line_desc,tanggal,qty1,qty2 from t_vd55 where mkbd_date= to_date('$old_mkbd_date','dd/mm/yyyy') and approved_stat='A' order by mkbd_cd desc";
	$assign=DAO::queryAllSql($sql);


?>
<div>
	<input type="hidden" name="Tvd55_old_mkbd_date" value="<?php echo $modeldummy->mkbd_date ;?>"/>
	<div class="row-fluid">
		<div class="span5">
			
			 
			<?php echo $form->datePickerRow($modeldummy,'mkbd_date',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8',
				'name'=>'mkbd_date','id'=>'mkbd_date','value'=>$modeldummy->mkbd_date,'options'=>array('format' => 'dd/mm/yyyy'))); ?>
		</div>
		<div class="span7">
			<input type="hidden" id="scenario" name="scenario"/>
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'id' => 'btnFilter',
				'buttonType' => 'submit',
				'type'=>'primary',
				'label'=>'Retrieve'
			)); ?>
		<!--	&emsp;-->
			<?php /*$this->widget('bootstrap.widgets.TbButton', array(
				'id' => 'btnDuplicate',
				'buttonType' => 'button',
				'type'=>'primary',
				'label'=>'Duplicate'
			)); */?>
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
		
		$x = 1;
	?>
<p style="height: 2px;"></p>
<!--
<div class="row-fluid">
	<div class="span5">
		<?php // echo $form->datePickerRow($modeldummy,'new_mkbd_date',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8',
				//'name'=>'newmkbd_date','id'=>'newmkbd_date','options'=>array('format' => 'dd/mm/yyyy'))); ?>
	</div>
	<div class="span7">
		<?php //$this->widget('bootstrap.widgets.TbButton', array(
			//	'id' => 'btnApply',
			//	'buttonType' => 'button',
			//	'type'=>'secondary',
			//	'label'=>'Apply Date'
			//)); ?>
	</div>
</div>
-->
<?php $line_desc=Tvd55::model()->findAll()?>

<br />
<table id='tableTvd55' class='table-bordered table-condensed' style="margin-top:-15px;">
	<thead>
		<tr>
			<th id="header1"><input type="checkbox" id="checkBoxAll" value="1" onClick= "changeAll()"/></th>
			<th id="header2"> MKBD Date</th>
			<th id="header3">Baris</th>
			<th id="header4">Description</th>
			<th id="header5">Tanggal</th>
			<th id="header6">Berizin</th>
			<th id="header7">Tidak Berizin</th>
			
		</tr>
	</thead>	
	<tbody>
	<?php
		foreach($model as $row){
	?>
		<tr id="row<?php echo $x ?>">
			<td width="3%">
				<?php if($row->mkbd_cd =='36' || $row->mkbd_cd =='40' || $row->mkbd_cd =='45'){
					
				}else{
					
					echo $form->checkBox($row,'save_flg',array('class'=>'checkBoxDetail','value' => 'Y','name'=>'Tvd55['.$x.'][save_flg]','onChange'=>$row->mkbd_date?'rowControl(this,true)':'rowControl(this,false)'));
				}?>

			</td>
			<td width ="10%">
				
				<?php if($row->isNewRecord){
					
					
					if($row->mkbd_cd =='36' || $row->mkbd_cd =='40' || $row->mkbd_cd =='45'){
						
					}
					
					echo $form->textField($row,'mkbd_date',array('class'=>'span','id'=>'tanggal_'.$x.'','name'=>'Tvd55['.$x.'][mkbd_date]','placeholder'=>'dd/mm/yyyy','readonly'=>$row->save_flg!='Y'?'readonly':''));
				}
				else{
					
					if($row->mkbd_cd =='36' || $row->mkbd_cd =='40' || $row->mkbd_cd =='45'){
						
					}
					else{
						echo $form->label($row,$row->mkbd_date);
					}
				
					
				}?>
				
			
				<?php // echo $form->textField($row,'mkbd_date',array('class'=>'span','id'=>'tanggal_'.$x.'','name'=>'Tvd55['.$x.'][tanggal]','placeholder'=>'dd/mm/yyyy','readonly'=>$row->save_flg!='Y'?'readonly':''));?>
			</td>
			<td width="5%">
				<?php if($row->isNewRecord){?>
					<label><?php echo $row->mkbd_cd ?></label>
				<?php } else {?>
				
				<?php echo $form->label($row,$row->mkbd_cd,array('class'=>'text-center'));?>
				
						<input type="hidden" name="Tvd55[<?php echo $x ?>][mkbd_date]" value="<?php echo $row->mkbd_date ?>" />
						
				<input type="hidden" name="Tvd55[<?php echo $x ?>][mkbd_cd]" value="<?php echo $row->mkbd_cd ?>" />
				<input type="hidden" name="Tvd55[<?php echo $x ?>][old_mkbd_date]" value="<?php echo $row->old_mkbd_date ?>" />
				<input type="hidden" name="Tvd55[<?php echo $x ?>][old_mkbd_cd]" value="<?php echo $row->old_mkbd_cd ?>" />
				<?php } ?>
			</td>
			<td width="40%">
				<?php if($row->isNewRecord){?>
					<label><?php echo $row->line_desc ;?></label>
					
				<?php } else{
					
					
				?>
				<?php if($row->mkbd_cd =='36'){?>
					<input type="hidden" name="Tvd55[<?php echo $x ?>][line_desc]" value="<?php echo $row->line_desc ?>" />
				<?php } else{?>
				
				<?php  echo $form->label($row,$row->line_desc);?>
				<?php //echo $form->dropDownList($row,'line_desc',CHtml::listData($line_desc,'line_desc','line_desc'), array('class'=>'span','disabled'=>'true','readonly'=>$row->save_flg!='Y'?'readonly':'','name'=>'Tvd55['.$x.'][line_desc]')); ?>
					
				<input type="hidden" name="Tvd55[<?php echo $x ?>][line_desc]" value="<?php echo $row->line_desc ?>" />
				<?php }}?>
			</td>
			<td width="10%">
				<?php if($row->mkbd_cd =='36'){
				echo $form->label($row,'Total');?>
				<input type="hidden" name="Tvd55[<?php echo $x ?>][tanggal]" value="<?php echo $row->tanggal ?>" />
				<?php } else{
					
					if($row->mkbd_cd =='41' || $row->mkbd_cd =='42' || $row->mkbd_cd =='43' || $row->mkbd_cd =='44'){
						echo $form->textField($row,'tanggal',array('class'=>'span checkBoxDetail2','id'=>'tanggal_'.$x.'','name'=>'Tvd55['.$x.'][tanggal]','placeholder'=>'dd/mm/yyyy','readonly'=>$row->save_flg!='Y'?'readonly':''));
					}
					else{
						if($row->mkbd_cd=='38' || $row->mkbd_cd=='39'){
							echo $form->textField($row,'qty1',array('class'=>'span tnumber checkBoxDetail2','id'=>'qty','style'=>'text-align:right;','name'=>'Tvd55['.$x.'][qty1]','readonly'=>$row->save_flg!='Y'?'readonly':''));
						?><input type="hidden" name="Tvd55[<?php echo $x ?>][tanggal]" value="<?php echo $row->tanggal ?>" />
				<?php	}
						else{?>
						<input type="hidden" name="Tvd55[<?php echo $x ?>][tanggal]" value="<?php echo $row->tanggal ?>" />	
					<?php	}					
					}
				}?>	
				
			</td>
			<td width="10%">
				<?php if($row->mkbd_cd =='36'){
				echo $form->label($row,'Keluar');?>
				
				<?php } else{
					if($row->mkbd_cd=='38' || $row->mkbd_cd=='39' ||$row->mkbd_cd=='40' ||$row->mkbd_cd=='41' ||$row->mkbd_cd=='42' || $row->mkbd_cd=='43' || $row->mkbd_cd=='44'){
						?>
					<?php }
					else if($row->mkbd_cd =='45'){
							echo $form->label($row,'Diselesaikan');
					}
					else{
						 echo $form->textField($row,'qty1',array('class'=>'span tnumber checkBoxDetail2','style'=>'text-align:right;','name'=>'Tvd55['.$x.'][qty1]','readonly'=>$row->save_flg!='Y'?'readonly':''));
					}
				
				}?>
			</td>
			<td width="10%">
				<?php if($row->mkbd_cd =='36'){
				echo $form->labelEx($row,'Masuk');
				?><input type="hidden" name="Tvd55[<?php echo $x ?>][qty2]" value="<?php echo $row->qty2 ?>" />
				<?php } else{
					if($row->mkbd_cd=='38' || $row->mkbd_cd=='39' ||$row->mkbd_cd=='40' ||$row->mkbd_cd=='41' ||$row->mkbd_cd=='42' || $row->mkbd_cd=='43' || $row->mkbd_cd=='44' ){
						?>
					<?php }
					else if($row->mkbd_cd =='45'){
							echo $form->label($row,'Belum Diselesaikan');
					}
					else{
						 echo $form->textField($row,'qty2',array('class'=>'span tnumber checkBoxDetail2','style'=>'text-align:right;','name'=>'Tvd55['.$x.'][qty2]','readonly'=>$row->save_flg!='Y'?'readonly':''));
					}
				
				}?>
			</td>
			
		
		</tr>
	<?php $x++;} ?>
	</tbody>	
</table>


<br id="temp"/>


<br id="temp"/><br id="temp"/>

<?php $this->endWidget(); ?>

<?php
  	AHelper::popupwindow($this, 600, 500);
?>

<script>
	headerWidth();
	
	var rowCount =<?php echo count($model) ?>;
	
	var authorizedCancel = true;
	var x;
	<?php echo $is_notfound ;?>
	for(x=0;x<rowCount;x++)
		{
			
			$('#tanggal_'+x).datepicker({format : "dd/mm/yyyy"});
		}
		

	$(window).resize(function() {
		adjustWidth();
	})
	$(window).trigger('resize');
	
	init();
	
	<?php if ($model){?>
		adjustWidth();
	//	$("#btnDuplicate").attr('disabled',false);
		$("#btnSubmit").attr('disabled',false);
	<?php }else{?>
		adjustWidth();
		//$("#btnDuplicate").attr('disabled','disabled');
		$("#btnSubmit").attr('disabled',false);
	<?php }?>
	
	function adjustWidth(){
		$("#header1").width($("#tableTvd55 tbody tr:eq(0) td:eq(0)").width());
		$("#header2").width($("#tableTvd55 tbody tr:eq(0) td:eq(1)").width());
		$("#header3").width($("#tableTvd55 tbody tr:eq(0) td:eq(2)").width());
		$("#header4").width($("#tableTvd55 tbody tr:eq(0) td:eq(3)").width());
		$("#header5").width($("#tableTvd55 tbody tr:eq(0) td:eq(4)").width());
		$("#header6").width($("#tableTvd55 tbody tr:eq(0) td:eq(5)").width());
		$("#header7").width($("#tableTvd55 tbody tr:eq(0) td:eq(6)").width());
		
	}
	function headerWidth(){
		
		$("#header1").width("2%");
		$("#header2").width("5%");
		$("#header3").width("5%");
		$("#header4").width("12%");
		$("#header5").width("5%");
		$("#header6").width("8%");
		$("#header7").width("8%");
		
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
		

	}
	
		
	function rowControl(obj, readonly)
	{
		var x = $(obj).closest('tr').prevAll().length;
		
		$("#tableTvd55 tbody tr:eq("+x+")").attr("id","row"+(x+1));	
		$("#tableTvd55 tbody tr:eq("+x+") td:eq(1) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableTvd55 tbody tr:eq("+x+") td:eq(2) select").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableTvd55 tbody tr:eq("+x+") td:eq(3) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableTvd55 tbody tr:eq("+x+") td:eq(4) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableTvd55 tbody tr:eq("+x+") td:eq(5) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableTvd55 tbody tr:eq("+x+") td:eq(6) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		
		if(!$(obj).is(':checked') && $(obj).closest('tr').hasClass('markCancel'))$(obj).closest('tr').find('td:eq(8) a').trigger('click'); //unmark the row for cancellation if the checkbox is unchecked
	}

	function addRow(num,y,assign)
	{ 
		var nilai = assign[y]['mkbd_cd'];
		
		$("#tableTvd55").find('tbody')
    		.prepend($('<tr>')
			.attr('id','row1')
			.append($('<td>')
				.append($('<input>')
					.attr('name','Tvd55[1][save_flg]')
					.attr('type','checkbox')
					.attr('class','checkBoxDetail')
					.attr('onChange','rowControl(this,false)')
					.prop('checked',true)
					.val('Y')
				)
			).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span tdate newdate')
           		 	.attr('name','Tvd55[1][mkbd_date]')
           			.attr('placeholder','dd/mm/yyyy')
					.attr('type','text')
					.attr('id','mkbd_date_0')
					.val($('#mkbd_date').val())
					.css('width','90px')
           		)
           	).append($('<td>')
           		 .append($('<label>')
           		 	.attr('class','span')
					.attr('id','mkbd_cd_0')
					.html(assign[y]['mkbd_cd'])
					.css('width','40px')
           			.css('text-align','center')
           		)
           		.append($('<input>')
           		.attr('type','hidden')
           		.attr('name','Tvd55[1][mkbd_cd]')
           		.val(assign[y]['mkbd_cd'])
           		
           		)
           		
			).append($('<td>')
				.append($('<label>')
         		.attr('name','Tvd55[1][line_desc]')
				.html(assign[y]['line_desc'])
           		)
           		.append($('<input>')
           		.attr('type','hidden')
           		.attr('name','Tvd55[1][line_desc]')
           		.val(assign[y]['line_desc'])
           		)
           		));
           	
           	//tanggal
           	
           		
            if(nilai == '36'){
           	$("#tableTvd55").find('tbody tr:first')
           		.append($('<td>')
           			
           			.attr('name','Tvd55[1][tanggal]')
           			.append($('<label>')
           			.attr('class','span')
           			.html('Total')
           			.css('width','90px')
           			)
           			.append($('<input>')
           			.attr('type','hidden')
           			.attr('class','span tdate')
           			.attr('name','Tvd55[1][tanggal]')
           			.datepicker({format : "dd/mm/yyyy"})
           			.val(assign[y]['tanggal'])
           			.css('width','90px')
           			)
           			
           			
           			);
           		}
           		else if(nilai == '38' || nilai == '39'){
           			
           			$("#tableTvd55").find('tbody tr:first')
           			.append($('<td>')
           			
           			.append($('<input>')
           			 .attr('class','span')
           			.attr('type','text')
           			.attr('name','Tvd55[1][qty1]')
           			.val(assign[y]['qty1'])
           			.css('width','90px')
           			)
           			.append($('<input>')
           			.attr('type','hidden')
           			.attr('class','span')
           			.attr('name','Tvd55[1][tanggal]')
           			.datepicker({format : "dd/mm/yyyy"})
           			.val(assign[y]['tanggal'])
           			.css('width','90px')
           			)
           			
           			);
           		}
           		else if(nilai == '41' || nilai =='42' || nilai =='43' || nilai =='44')	
           		{	$("#tableTvd55").find('tbody tr:first')
           			.append($('<td>')
           			
           			.append($('<input>')
           			.attr('class','span tdate')
           			.attr('type','text')
           			.attr('class','span tdate')
           			.attr('name','Tvd55[1][tanggal]')
           			.datepicker({format : "dd/mm/yyyy"})
           			.val(assign[y]['tanggal'])
           			.css('width','90px')
           			)
           			);
           		}
           			
           		else{
           			$("#tableTvd55").find('tbody tr:first')
           			.append($('<td>')
           		
           			.append($('<input>')
           			.attr('class','span')
           		 	.attr('name','Tvd55[1][tanggal]')
           			.attr('placeholder','dd/mm/yyyy')
					.attr('type','hidden')
					.val(assign[y]['tanggal'])
					.css('width','90px')
           		)
           	);
           	}
           	
           	//end tanggal
           	 if(nilai == '36'){
           		$("#tableTvd55").find('tbody tr:first')
           			.append($('<td>')
	           			.attr('name','Tvd55[1][qty1]')
	           			.append($('<label>')
	           			.html('Keluar')
           			)
           			.append($('<input>')
           			.attr('name','Tvd55[1][qty1]')
					.attr('type','hidden')
					.val(assign[y]['qty1']))  
					.css('width','90px')         			
           			);
           		}
           		else if(nilai == '45'){
				$("#tableTvd55").find('tbody tr:first')
           			.append($('<td>')
	           			.attr('name','Tvd55[1][qty1]')
	           			.append($('<label>')
	           			.html('Diselesaikan')
           			)
           			.append($('<input>')
           			.attr('name','Tvd55[1][qty1]')
					.attr('type','hidden')
					.val(assign[y]['qty1']))    
					.css('width','90px')  
           			);
           		}
           	else if(nilai == '38' || nilai == '39' || nilai == '40' || nilai == '41' || nilai == '42' || nilai == '43' || nilai == '44'){
           		$("#tableTvd55").find('tbody tr:first')
           			.append($('<td>')
           			.append($('<input>')
           			.attr('name','Tvd55[1][qty1]')
					.attr('type','hidden')
					.val(assign[y]['qty1'])
					)      
           			.css('width','90px'));
           	}
           	else{

           	$("#tableTvd55").find('tbody tr:first')
           	.append($('<td>')
           		.append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Tvd55[1][qty1]')
					.attr('type','text')
					
					.val(assign[y]['qty1'])
           		)
           	);
           	}
           	 if(nilai == '36'){
           			
           			$("#tableTvd55").find('tbody tr:first')
           			.append($('<td>')
           			.append($('<label>')
           			.html('Masuk')
           			)
           			.append($('<input>')
           			.attr('type','hidden')
           			.attr('name','Tvd55[1][qty2]')
           			.val(assign[y]['qty2']))
           			
           			);
           		}
           		else if(nilai == '45'){
           			//alert('test');
           			$("#tableTvd55").find('tbody tr:first')
           			.append($('<td>')
           			.append($('<label>')
           			.html('Belum Diselesaikan')
           			)
           			.append($('<input>')
           			.attr('type','hidden')
           			.attr('name','Tvd55[1][qty2]')
           			.val(assign[y]['qty2']))
           			
           			);
           		}
           	else if(nilai == '38' || nilai == '39' || nilai == '40' || nilai == '41' || nilai == '42' || nilai == '43' || nilai == '44'){
           		$("#tableTvd55").find('tbody tr:first')
           			.append($('<td>')
           			.append($('<input>')
           			.attr('type','hidden')
           			.attr('name','Tvd55[1][qty2]')
           			.val(assign[y]['qty2']))
           			
           			
           			);
           		
           	}
			else{
           		$("#tableTvd55").find('tbody tr:first')
           	.append($('<td>')
           		.append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Tvd55[1][qty2]')
					.attr('type','text')
					//.val($("#Tvd55_"+num+"_qty2").val())
					.val(assign[y]['qty2'])
           		)
           	);  	
		}	
		rowCount++;
		reassignId();
		formatDate();
		$('#mkbd_cd_0').focus();

	}
	
   	function reassignId()
   	{ 
   		//var index = $(obj).closest('tr').prevAll().length + 1;
   		var obj = $("#tableTvd55 tbody");
   		//alert(rowCount);
   		for(x=0;x<rowCount;x++)
   		{
			obj.find("tr:eq("+x+")").attr("id","row"+(x+1));	
			obj.find("tr:eq("+x+") td:eq(0) [type=checkbox]").attr("name","Tvd55["+(x+1)+"][save_flg]");
			obj.find("tr:eq("+x+") td:eq(0) [type=hidden]:eq(0)").attr("name","Tvd55["+(x+1)+"][save_flg]");
			obj.find("tr:eq("+x+") td:eq(1) [type=text]").attr("name","Tvd55["+(x+1)+"][mkbd_date]");
			obj.find("tr:eq("+x+") td:eq(2) [type=hidden]").attr("name","Tvd55["+(x+1)+"][mkbd_cd]");
			obj.find("tr:eq("+x+") td:eq(3) [type=hidden]").attr("name","Tvd55["+(x+1)+"][line_desc]");
			obj.find("tr:eq("+x+") td:eq(4) [type=hidden]").attr("name","Tvd55["+(x+1)+"][tanggal]");
			obj.find("tr:eq("+x+") td:eq(4) [type=text]").attr("name","Tvd55["+(x+1)+"][qty1]");
			obj.find("tr:eq("+x+") td:eq(4) .tdate[type=text] ").attr("name","Tvd55["+(x+1)+"][tanggal]");
			obj.find("tr:eq("+x+") td:eq(5) [type=text]").attr("name","Tvd55["+(x+1)+"][qty1]");
			obj.find("tr:eq("+x+") td:eq(5) [type=hidden]").attr("name","Tvd55["+(x+1)+"][qty1]");
			obj.find("tr:eq("+x+") td:eq(6) [type=text]").attr("name","Tvd55["+(x+1)+"][qty2]");
			obj.find("tr:eq("+x+") td:eq(6) [type=hidden]").attr("name","Tvd55["+(x+1)+"][qty2]");
		}
		
		//Looping kedua untuk menentukan mana record yang dapat di-cancel dan mana row yang dapat di-delete
		/*for(x=0;x<rowCount;x++)
   		{
   			if($("[name='Tvd55["+(x+1)+"][cancel_flg]']").val())
				obj.find("tr:eq("+x+") td:eq(9) a:eq(1)").attr('onClick',"cancel(this,'"+$("[name='Tvd55["+(x+1)+"][cancel_flg]']").val()+"',"+(x+1)+")")		
   			else
   			{
   				obj.find("tr:eq("+x+") td:eq(9) a:eq(1)").attr('onClick',"deleteRow(this)");
   			}
   		}*/
   	}
   	
   	$('#btnApply').click(function(){
		$('.newdate').val($('#new_mkbd_date').val());
	})
	
	
	function duplicateRow(){
		var q = 0;
		 
		 var rowCount1 = <?php echo $date['jumlah'] ?>;
		 rows = rowCount1;
		//alert(rows);
		
		var assign=[];
		var y=0;
		<?php
		
		 foreach($assign as $row){
		 	if($row['tanggal'])$row['tanggal']=DateTime::createFromFormat('Y-m-d G:i:s',$row['tanggal'])->format('d/m/Y');?>
			assign[y]=[];
			assign[y]['mkbd_cd'] = '<?php echo $row['mkbd_cd'];?>'
			assign[y]['line_desc'] = '<?php echo $row['line_desc'];?>'
			assign[y]['tanggal'] = '<?php echo $row['tanggal'];?>'
			assign[y]['qty1'] = '<?php echo $row['qty1'];?>'
			assign[y]['qty2'] = '<?php echo $row['qty2'];?>'
				y++;
		<?php }?>
		//var a= assign[2]['mkbd_cd'];
		//alert(a);
		y=0;
		for(q=rows;q>0;q--){
			//alert(rowCount);
			addRow(q,y,assign);
			y++;
		}
		
		
		
	}
	
	$('#btnApply').click(function(){
		$('.newdate').val($('#newmkbd_date').val());
	})
		$('#btnFilter').click(function()
	{
		$('#scenario').val('filter');
	})
	
	$('#btnSubmit').click(function()
	{
		$('#scenario').val('save');
		$('#rowCount').val(rowCount);
	})
	function formatDate(){
		$('.tdate').datepicker({'format':'dd/mm/yyyy','language':'en'});
	}
	function notfound(){

    if (confirm("Date Not Found, Do you want to create new date ?") == true) {
    	
        duplicateRow();
        
    } 

	}
	function changeAll()
	{
		if($("#checkBoxAll").is(':checked'))
		{
			$(".checkBoxDetail").prop('checked',true);
			$(".checkBoxDetail2").prop('readonly',false);
		}
		else
		{
			$(".checkBoxDetail").prop('checked',false);
			$(".checkBoxDetail2").prop('readonly',true);
		}
	}
	$('#mkbd_date').change(function(){
		var tanggal = $('#mkbd_date').val();
		$.ajax({
	    		'type'     :'POST',
	    		'url'      : '<?php echo $this->CreateUrl('Cek_date'); ?>',
				'dataType' : 'json',
				'data'     : { 'tanggal':tanggal},							
				'success'  : function(data){
						var safe =  data.status;
						if(safe == 'success'){
						alert('Date is holiday');
						}
				
			}
			})
	})
</script>


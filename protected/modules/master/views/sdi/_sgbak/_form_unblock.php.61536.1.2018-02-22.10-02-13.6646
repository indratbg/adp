<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'sdiunblock-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	//'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>
	
<div class="row-fluid">
	<div class="span12">
		<a id="xml-001"></a> &nbsp;&nbsp;&nbsp;
		<a id="xml-004"></a>
	</div>
</div>

<table class="items table table-striped table-bordered table-condensed" id="subrek_table">
	<thead>
		<tr>
			<th colspan="6" style="text-align: center">Unblock</th>
		</tr>
		<tr>
			<th style="width:1.5em"><?php echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl.'/images/add.png', 'Add'), 'javascript://', array('id'=>'add_detail')); ?></th>
			<th>Client</th>
			<th>Subrek001</th>
			<th>Y/N</th>
			<th>Subrek004</th>
			<th>Y/N</th>
		</tr>
	</thead>
	
	<tbody>
		
	</tbody>
</table>	
	<?php 
		$this->widget(
	    'bootstrap.widgets.TbButton',
	    array(
	        'label' => 'Format XML',
	        'size' => 'medium',
	        'id' => 'btnSubmit',
	        'buttonType'=>'submit',
	        'type'=>'success',
	    )
	); ?>

<?php $this->endWidget(); ?>

<table class="hidden">
	<tr id="clone_row" class="hidden">
		<td><?php echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl.'/images/delete.png', 'Delete'), 'javascript://', array('class'=>'delete-detail')); ?></td>
		<td><?php echo $form->dropDownListRow($modelUnblock,'client_cd',CHtml::listData(Client::model()->findAll(array('condition'=>"susp_stat <> 'C' and client_type_1 <> 'B' and client_type_1 <> 'H'",'order'=>'client_cd ASC')), 'client_cd', 'CodeAndNameAndType'),array('label'=>false,'class'=>'dropdownclient')); ?></td>
		<td><?php echo $form->textField($modelUnblock,'subrek_001',array('size'=>4,'class'=>'span10 subrek001')); ?></td>
		<td><?php echo $form->checkBox($modelUnblock,'yn_001'); ?></td>
		<td><?php echo $form->textField($modelUnblock,'subrek_004',array('size'=>4,'class'=>'span10 subrek004')); ?></td>
		<td><?php echo $form->checkBox($modelUnblock,'yn_004'); ?></td>
	</tr>
</table>

<script>
	/*=========================================Ajax To Fill Subrek 001 & 004=========================================*/
	$('.dropdownclient').live('change',function()
	{
		var client_cd = $(this).val();
		var tr = $(this).closest('tr');
		getSubrek(client_cd,tr);
	});
	
	function getSubrek(client_cd,tr)
	{
		$.ajax({
			'type' 	  :'POST',
			'url'  	  :'<?php echo CController::createUrl('sdi/AjxGetSubrek')?>'+'/client_cd/'+client_cd,
			'data' 	  :client_cd,
			'dataType':'json',
			'success' :function(data){
				var subrek001 = tr.find('.subrek001');
				var subrek004 = tr.find('.subrek004');
				subrek001.val(data.subrek001);
				subrek004.val(data.subrek004);
				subrek001.mask('aa999-9999-999-99');
				subrek004.mask('aa999-9999-999-99');
			}
		});
	}
	/*=========================================Ajax To Fill Subrek 001 & 004=========================================*/
	/*=========================================XML=========================================*/
	$('#xml-001').hide();
	$('#xml-004').hide();
		
	$('#btnSubmit').click(function(e){
		$('#xml-001').hide();
		$('#xml-004').hide();
		e.preventDefault();
		sendAjxFormatXmlUnblock();
		$('#xml-001').hide();
		$('#xml-004').hide();
	});
	
	function sendAjxFormatXmlUnblock()
	{
		$.ajax({
			'type' 	  :'POST',
			'url'  	  :'<?php echo CController::createUrl('sdi/AjxFormatXmlUnblock')?>',
			'data' 	  :{detail:$("#sdiunblock-form").serialize(),header:$("#sdi-form").serialize()},
			'dataType':'json',
			'success' :function(data){
				if(data.save001)
				{
					$("#xml-001").attr('href',data.url001);
					$("#xml-001").html('Download '+data.filename001);
					$("#xml-001").show();
				}
				
				if(data.save004)
				{
					$("#xml-004").attr('href',data.url004);
					$("#xml-004").html('Download '+data.filename004);
					$("#xml-004").show();
				}
			}
		});
	}//end function sendAjxFormatXml
	/*=========================================XML=========================================*/
	/*--------------------------------Cloning Row With Javascript--------------------------------*/
	var i = 0;
	$("#add_detail").click(function(){
		cloneRow();
		i++;
	});
	
	$('.delete-detail').live('click',function(){
		$jTr = $(this).parents('tr:first');
		$jTr.remove();
	});
	
	function cloneRow()
	{
		var row = $('#clone_row').clone();
		var table = $('#subrek_table tbody');
		
    	//kalo mau replace id,name semua element yang ada di dalam row
    	//kalo mau replace input doank, pake row.find("input")
    	   row.find("*").each(function() {
    	   	var nama = new String(this.name);
    	   	var tipe = typeof this.name;
    	   	
    	   	if(this.id!='')
            this.id = this.id+"["+i+"]" || "";
           	
            if(nama!='' && tipe!='undefined')
            {
            	var pos_first = nama.indexOf('[');
            	var pos_last = nama.indexOf(']');

            	var model_name  = nama.substring(0,pos_first);
            	var attr_name = nama.substring(pos_first,pos_last+1);
            	
            	this.name = model_name +'['+i+']'+attr_name;
            	
            }//end if nama !='' && tipe!='undefined'
            
            var element_class = $(this).attr("class");
    	});
    	
    	/*==========================MASKING THE INPUT==========================*/
    	var client_cd = row.find('select').val();
    	getSubrek(client_cd,row);
    	/*==========================MASKING THE INPUT==========================*/
    	
    	row.removeAttr('class');
		row.attr('id','row_'+i);
		//tambahkan row ke table
		row.appendTo(table);
	}
	/*--------------------------------Cloning Row With Javascript--------------------------------*/
</script>



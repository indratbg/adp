<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'sdisubrek-form',
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
			<th colspan="5" style="text-align: center">Subrek</th>
		</tr>
		<tr>
			<th style="width:1.5em"><?php echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl.'/images/add.png', 'Add'), 'javascript://', array('id'=>'add_detail')); ?></th>
			<th>Client</th>
			<th>001</th>
			<th>4 Digit</th>
			<th>004</th>
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
	
	<?php 
		/*echo CHtml::ajaxSubmitButton('Format Xml AJAX', //label
			array('sdi/ajxFormatXmlSubrek','act'=>'doActive'), //url
			array('success'=>'function(msg){test(msg);}'), //ajaxOptions
			array(		//htmlOptions
				'class'=>'btn btn-success',
				'id'=>'btnFormatXML',
				'name'=>'btnFormatXML',
				'label'=>'Format XML AJAX',
				)
		);*/ ?>

<?php $this->endWidget(); ?>

<table class="hidden">
	<tr id="clone_row" class="hidden">
			<td><?php echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl.'/images/delete.png', 'Delete'), 'javascript://', array('class'=>'delete-detail')); ?></td>
			<td><?php echo $form->dropDownListRow($modelSubrek,'client_cd',CHtml::listData(Client::model()->findAll(array('condition'=>"susp_stat <> 'C' and client_type_1 <> 'B' and client_type_1 <> 'H'",'order'=>'client_cd ASC')), 'client_cd', 'CodeAndNameAndType'),array('label'=>false)); ?></td>
			<td><?php echo $form->checkBox($modelSubrek,'type_001'); ?></td>
			<td>
				<span>YJ001</span>
				<?php echo $form->textField($modelSubrek,'digit',array('class'=>'span2','maxlength'=>4)); ?>
				<span>001</span>
			</td>
			<td><?php echo $form->checkBox($modelSubrek,'type_004'); ?></td>
		</tr>
</table>

<script>
	$('#xml-001').hide();
	$('#xml-004').hide();
		
	$('#btnSubmit').click(function(e){
		e.preventDefault();
		sendAjxFormatXmlSubrek();
		$('#xml-001').hide();
		$('#xml-004').hide();
	});
	
	function sendAjxFormatXmlSubrek()
	{
		$.ajax({
			'type' 	  :'POST',
			'url'  	  :'<?php echo CController::createUrl('sdi/AjxFormatXmlSubrek')?>',
			'data' 	  :$("#sdisubrek-form").serialize(),
			'dataType':'json',
			'success' :function(data){
				if(data.save001)
				{
					$("#xml-001").attr('href',data.url001);
					$("#xml-001").html('Download '+data.filename001);
					$("#xml-001").show();
					//window.location.href = data.url001;
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
            	
            	if(attr_name=='[digit]')
            	{
            		$(this).attr('required','required');
            	}//end if attr_name
            }//end if nama !='' && tipe!='undefined'
    	});
    	
    	row.removeAttr('class');
		row.attr('id','row_'+i);
		//tambahkan row ke table
		row.appendTo(table);
	}
	/*--------------------------------Cloning Row With Javascript--------------------------------*/
</script>



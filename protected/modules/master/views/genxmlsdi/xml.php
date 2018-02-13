<div id="xmlContent<?php echo $subrekType ?>" class="xmlContent">
	<textarea id="textArea<?php echo $subrekType ?>" name="textArea<?php echo $subrekType ?>" class="span10" rows=4 readonly></textarea>

	<br/><br/>
	
	<div style="text-align:center">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'id'=>'btnDownload'.$subrekType,
			'buttonType'=>'button',
			'label'=>'Download',
			'htmlOptions'=>array('name'=>'submit','class'=>'btnDownload_dialog','value'=>$subrekType)
		)); ?>
	</div>
</div>

<div id="xmlNotice<?php echo $subrekType ?>" class="xmlNotice" style="text-align:center">
	<h4 style="color:red">No Data</h4>
</div>

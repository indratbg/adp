<div id="xmlContent<?php echo $step ?>" class="xmlContent first" style="text-align:center;<?php if(!$xml)echo 'display:none' ?>">
	<textarea id="textArea<?php echo $step ?>" name="textArea<?php echo $step ?>" class="span10" rows=4 readonly><?php echo $xml ?></textarea>

	<br/><br/>
	
	<div style="text-align:center">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'id'=>'btnDownload'.$step,
			'buttonType'=>'button',
			'label'=>'Download',
			'htmlOptions'=>array('name'=>'submit','class'=>'btnDownload_dialog','value'=>$step)
		)); ?>
		<input type="hidden" id="fileName<?php echo $step ?>" class="fileName" value="<?php echo $fileName ?>" />
	</div>
</div>

<div id="xmlNotice<?php echo $step ?>" class="xmlNotice" style="text-align:center;<?php if($xml)echo 'display:none' ?>">
	<h4 style="color:red">No Data</h4>
</div>

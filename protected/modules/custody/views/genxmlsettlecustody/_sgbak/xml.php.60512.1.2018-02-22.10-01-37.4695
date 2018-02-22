<div id="xmlContainer<?php echo $data['type'] ?>" class="xmlContainer <?php echo $data['type'] ?>" style="display:none">
	<div id="xmlContent<?php echo $data['type'] ?>" class="xmlContent first" style="text-align:center;<?php if(!$data['xml'])echo 'display:none' ?>">
		<textarea id="textArea<?php echo $data['type'] ?>" name="textArea<?php echo $data['type'] ?>" class="span10" rows=4 readonly><?php echo $data['xml'] ?></textarea>
	
		<br/><br/>
		
		<div style="text-align:center">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'id'=>'btnDownload'.$data['type'],
				'buttonType'=>'button',
				'label'=>'Download',
				'htmlOptions'=>array('name'=>'submit','class'=>'btnDownload_dialog','value'=>$data['type'])
			)); ?>
			<input type="hidden" id="fileName<?php echo $data['type'] ?>" class="fileName" value="<?php echo $data['fileName'] ?>" />
		</div>
	</div>
	<div id="xmlNotice<?php echo $data['type'] ?>" class="xmlNotice" style="text-align:center;<?php if($data['xml'])echo 'display:none' ?>">
		<br/><br/>
		<h4 style="color:red">No Data</h4>
	</div>
</div>
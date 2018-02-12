<?php $this->beginContent('//layouts/main'); ?>
<div id="content" class="row-fluid">
	<div class="span2"> 
		<?php
			$this->widget('bootstrap.widgets.TbMenu', array(
			    'type'=>'list',
			    'items'=>$this->menu,
				'htmlOptions'=>array('class'=>'bs-docs-sidenav')	
			));
		?>
	</div>
	<div class="span10">

		<?php echo $content; ?>
	</div>
    <div class="clear"></div>
</div>
<?php $this->endContent(); ?>
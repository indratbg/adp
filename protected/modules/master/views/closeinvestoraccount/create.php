<?php
$this->breadcrumbs=array(
	'Close Investor Account'=>array('index'),
	'Create',
);
?>

<h1>Close Investor Account</h1>

<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php echo $this->renderPartial('_form', array('model'=>$model,'isvalid'=>$isvalid)); ?>
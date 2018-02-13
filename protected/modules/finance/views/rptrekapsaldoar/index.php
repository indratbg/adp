<style>
    input[type=radio] {
        margin-top: -3px;
    }
</style>
<?php
$this->breadcrumbs = array(
    'Rekap Saldo AR Client'=> array('index'),
    'List',
);

$this->menu = array(
    array(
        'label'=>'Rekap Saldo AR Client',
        'itemOptions'=> array('style'=>'font-size:28px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')
    ),
    array(
        'label'=>'List',
        'url'=> array('index'),
        'icon'=>'list',
        'itemOptions'=> array(
            'class'=>'active',
            'style'=>'float:right'
        )
    ),
);
?>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id'=>'importTransaction-form',
        'enableAjaxValidation'=>false,
        'type'=>'horizontal'
    ));
?>

<?php AHelper::showFlash($this)
?>
<?php echo $form->errorSummary(array($model)); ?>
<br />
<div class="row-fluid">
		<div class="control-group">
			<div class="span4">
				<?php echo $form->datePickerRow($model, 'doc_date', array(
                    'prepend'=>'<i class="icon-calendar"></i>',
                    'placeholder'=>'dd/mm/yyyy',
                    'class'=>'tdate span8',
                    'options'=> array('format'=>'dd/mm/yyyy')
                ));
				?>
			</div>
			 <div class="span1">
                <?php $this->widget('bootstrap.widgets.TbButton', array(
                        'label'=>'SHOW',
                        'type'=>'primary',
                        'id'=>'btnPrint',
                        'buttonType'=>'submit'
                    ));
                ?>
            </div>
            <div class="span2">
                <button formaction="<?php echo $url_xls ;?> " id="btn_xls" class="btn btn-primary">Save to Excel</button>
            </div>
		</div>
</div>
<br />
<iframe src="<?php echo $url; ?>" class="span12" style="min-height:600px;max-width: 100%"></iframe>

<?php $this->endWidget(); ?>

<?php  $this->beginWidget('zii.widgets.jui.CJuiDialog',
                        array(
                        'id'=>'mywaitdialog',
                        'options'=>array(
                        'title'=>'In Progress',
                        'modal'=>true,
                        'autoOpen'=>false,// default is true
                        'closeOnEscape'=>false,
                        'resizable'=>false,
                        'draggable'=>false,
                        'height'=>120,
                        'open'=>// supply a callback function to handle the open event
                        'js:function(){ // in this function hide the close button
                        $(".ui-dialog-titlebar-close").hide();
                        //$(".ui-dialog-content").hide();
                        
                        }'
                        ))
                        );
                        
                        $this->widget('bootstrap.widgets.TbProgress',
                        array('percent' => 100, // the progress
                        'striped' => true,
                        'animated' => true,
                        )
                        );
?>

<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
<script>
    var url_xls = '<?php echo $url_xls ?>';
    init();
    function init()
    {
        if(url_xls=='')
        {
            $('#btn_xls').attr('disabled','disabled');
        }
    }
  
</script>
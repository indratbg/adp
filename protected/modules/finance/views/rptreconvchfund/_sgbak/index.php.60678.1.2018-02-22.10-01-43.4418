<style>
input[type="radio"], input[type="radio"]+label {
    display: inline;
}
input[type="radio"] {
  margin-left: 10px;
}
</style>
<?php
$this->breadcrumbs = array(
    'Reconcile Voucher Fund vs Cash Transaction' => array('index'),
    'List',
);

$this->menu = array(
    array(
        'label' => 'Reconcile Voucher Fund vs Cash Transaction',
        'itemOptions' => array('style' => 'font-size:28px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')
    ),
    array(
        'label' => 'List',
        'url' => array('index'),
        'icon' => 'list',
        'itemOptions' => array(
            'class' => 'active',
            'style' => 'float:right'
        )
    ),
);
?>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'importTransaction-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal'
    ));
?>


<?php AHelper::showFlash($this)
?>
<?php echo $form->errorSummary(array($model)); ?>
<br />
<div class="row-fluid">
      <div class="control-group">
          <div class="span5">
              <?php echo $form->datePickerRow($model,'doc_date',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
          </div>
         
      </div>
      <div class="control-group">
           <?php echo $form->radioButtonListRow($model,'option',AConstant::$reconcile_dhk);?>
      </div>
      <div class="control-group">
           <div class="span2">
                <?php $this->widget('bootstrap.widgets.TbButton', array(
                        'label' => 'Show',
                        'type' => 'primary',
                        'id' => 'btnPrint',
                        'buttonType' => 'submit',
                    ));
                 ?>
            </div>
      </div>
</div>
<br />
<iframe src="<?php echo $url; ?>" class="span12" style="min-height:600px;max-width: 100%"></iframe>
<?php $this->endWidget(); ?>
<script>

    init();
    function init()
    {
        getClient();
    }

</script>

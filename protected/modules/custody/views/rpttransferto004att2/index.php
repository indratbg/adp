<?php
$this->breadcrumbs = array(
    'Transfer to 004 at T2'=> array('index'),
    'List',
);

$this->menu = array(
    array(
        'label'=>'Transfer to 004 at T2',
        'itemOptions'=> array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')
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

<?php AHelper::showFlash($this) ?>
<?php AHelper::applyFormatting() ?> 

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id'=>'Transfer004at002-form',
        'enableAjaxValidation'=>false,
        'type'=>'horizontal'
    ));
 ?>

<?php 
        echo $form->errorSummary(array($model));
?>
<br/>

<input type="hidden" name="scenario" id="scenario" />
<input type="hidden" name="rowCount" id="rowCount" />

<div class="row-fluid">
        <div class="control-group">
            <div class="span5">
                <?php echo $form->datePickerRow($model, 'trx_date', array(
                    'prepend'=>'<i class="icon-calendar"></i>',
                    'placeholder'=>'dd/mm/yyyy',
                    'class'=>'tdate span7',
                    'options'=> array('format'=>'dd/mm/yyyy')
                ));
                ?>
            </div>
            <div class="span5">
                  <?php echo $form->datePickerRow($model, 'price_date', array(
                    'prepend'=>'<i class="icon-calendar"></i>',
                    'placeholder'=>'dd/mm/yyyy',
                    'class'=>'tdate span7',
                    'options'=> array('format'=>'dd/mm/yyyy')
                ));
                ?>
            </div>
       
        </div>
        <div class="control-group">
            <div class="span5">
                <?php echo $form->datePickerRow($model, 'due_date', array(
                    'prepend'=>'<i class="icon-calendar"></i>',
                    'placeholder'=>'dd/mm/yyyy',
                    'class'=>'tdate span7',
                    'options'=> array('format'=>'dd/mm/yyyy')
                ));
                ?>
            </div>
          <div class="span5">
               <?php $this->widget('bootstrap.widgets.TbButton', array(
                            'id'=>'btnFilter',
                            'buttonType'=>'submit',
                            'type'=>'primary',
                            'label'=>'Retrieve'
                        )); ?>
         &emsp;
        <?php $this->widget('bootstrap.widgets.TbButton', array(
                'id'=>'btnProcess',
                'buttonType'=>'submit',
                'type'=>'primary',
                'label'=>'Process'
            )); ?>
          </div>
       
        </div>
      
    
</div>

<br />

<iframe id="iframe" src="<?php echo $url; ?>" class="span12" style="min-height:600px;"></iframe>

<?php $this->endWidget();?>
<script>


    $(document).ready(function(){
       $('.tdate').datepicker({'format':'dd/mm/yyyy'});
    })

    $('#btnFilter').click(function(){
       $('#scenario').val('retrieve');
    });
    
    $('#btnProcess').click(function(){
       $('#scenario').val('process');
       $('#rowCount').val(rowCount);
    });
  
  
  
  $("#Rpttransferto004att2_due_date").change(function()
    {
         $.ajax({
            'type'      : 'POST',
            'url'       : '<?php echo $this->createUrl('GetAjxTrxDate'); ?>',
            'dataType'  : 'json',
            'data'      :   {
                                'due_date' : $(this).val(),
                            },
            'success'   :   function (data) 
                            {
                                $("#Rpttransferto004att2_trx_date").val(data.trx_date)
                            }
        });
    });
  
</script>

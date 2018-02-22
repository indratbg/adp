<?php
$this->breadcrumbs = array(
    'Piutang nasabah lebih dari 3 hari bursa' => array('index'),
    'List',
);

$this->menu = array(
    array(
        'label' => 'Piutang nasabah lebih dari 3 hari bursa',
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
<input type="hidden" name="scenario" id="scenario" />
<div class="row-fluid">
    <div class="span6">
       
        <div class="control-group">
            <?php echo $form->datePickerRow($model,'end_date',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
            <?php echo $form->dropDownListRow($model,'branch_cd',CHtml::listData($branch, 'brch_cd', 'brch_name'),array('class'=>'span4','style'=>'font-family:courier','prompt'=>'-Select-'));?>
            <?php echo $form->textField($model, 'vo_random_value', array('style' => 'display:none'));?>
            <?php echo $form->dropDownListRow($model,'rem_cd',CHtml::listData($rem_cd,'rem_cd', 'rem_name'),array('class'=>'span4','prompt'=>'-Select-','style'=>'font-family:courier'));?>
        </div>
     
        <div class="control-group">
            <?php $this->widget('bootstrap.widgets.TbButton', array(
                        'label' => 'Show',
                        'type' => 'primary',
                        'id' => 'btnPrint',
                        'buttonType' => 'submit',
                    ));
                 ?>
                 &nbsp;
                    <?php $this->widget('bootstrap.widgets.TbButton', array(
                        'label' => 'Export to Excel',
                        'type' => 'primary',
                        'id' => 'btnExport',
                        'buttonType' => 'submit',
                    ));
                 ?>
        </div>
    </div>
</div>
<br />
<iframe src="<?php echo $url; ?>" class="span12" style="min-height:600px;max-width: 100%"></iframe>
<?php echo $form->datePickerRow($model,'dummy_date',array('label'=>false,'style'=>'display:none'));?>
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

    init();
    function init()
    {
        $('.tdate').datepicker({'format':'dd/mm/yyyy'});
        if('<?php echo $url ?>'=='')
        {
            $('#btnExport').prop('disabled',true);
        }
    }
    
    $('#btnExport').click(function(){
        $('#scenario').val('export');
    })
    $('#btnPrint').click(function(){
        $('#scenario').val('print');
        $('#mywaitdialog').dialog('open');
    })
    $('#Rptoutsbybranch_month').change(function(){
        var from_date = $('#Rptoutsbybranch_bgn_date').val().split('/');
        $('#Rptoutsbybranch_bgn_date').val(from_date[0]+'/'+$('#Rptoutsbybranch_month').val()+'/'+from_date[2]);
        var end_date = $('#Rptoutsbybranch_end_date').val().split('/');
        $('#Rptoutsbybranch_end_date').val(end_date[0]+'/'+$('#Rptoutsbybranch_month').val()+'/'+end_date[2]);
        Get_End_Date($('#Rptoutsbybranch_end_date').val());
        $('.tdate').datepicker('update');
    });
    
    $('#Rptoutsbybranch_year').on('keyup',function(){
         var from_date = $('#Rptoutsbybranch_bgn_date').val().split('/');
        $('#Rptoutsbybranch_bgn_date').val(from_date[0]+'/'+from_date[1]+'/'+$('#Rptoutsbybranch_year').val());
        var end_date = $('#Rptoutsbybranch_end_date').val().split('/');
        $('#Rptoutsbybranch_end_date').val(end_date[0]+'/'+end_date[1]+'/'+$('#Rptoutsbybranch_year').val());
        $('.tdate').datepicker('update');
    })
    function Get_End_Date(tgl)
    {
        var date = tgl.split('/');
        var day = parseInt(date[0]);
        var month = parseInt(date[1]);
        var year = parseInt(date[2]);
        
        var d = new Date(year,month,day);
          d.setDate(d.getDate() - day);
        var month = d.getMonth()+1;
        var new_date = d.getDate()+'/'+month+'/'+d.getFullYear();
          
        $('#Rptoutsbybranch_end_date').val(new_date);
        $('.tdate').datepicker('update');
    }
</script>

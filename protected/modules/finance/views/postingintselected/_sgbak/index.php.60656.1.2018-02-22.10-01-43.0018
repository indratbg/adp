
<?php

$this->breadcrumbs=array(
    'Posting Interest Selected'=>array('index'),
    'List',
);

$this->menu=array(
    array('label'=>'Posting Interest Selected', 'itemOptions'=>array('style'=>'font-size:28px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
    array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
);

?>


<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'Tinterest-form',
    'enableAjaxValidation'=>false,
    'type'=>'horizontal',

)); 
 ?>
 <br />
 <?php echo $form->errorSummary(array($model));?>
 <input type="hidden" name="scenario" id="scenario" />
 <input type="hidden" name="rowCount" id="rowCount" />
 
<div id="successMessage" style="display:none;"> 
     <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <b>Data berhasil diperbaharui</b>
        </div>
 </div>

<div class="row-fluid">
    <div class="span6">
        <div class="control-group">
            <div class="span2">
                <label>Month</label>
            </div>
            <div class="span2">
                <?php echo $form->dropDownList($model,'bulan',AConstant::getArrayMonth(),array('class'=>'span12','prompt'=>'-Choose-'));?>
            </div>
              <div class="span1">
                <label>Year</label>
            </div>
            <div class="span2">
                <?php echo $form->dropDownList($model,'year',AConstant::getArrayYear(),array('class'=>'span12','prompt'=>'-Choose-'));?>
            </div>
        </div>
          <div class="control-group">
            <div class="span2">
                <label>From Date</label>
            </div>
            <div class="span2">
                <?php echo $form->textField($model,'int_dt_from',array('class'=>'span12 tdate','placeholder'=>'dd/mm/yyyy'));?>
            </div>
              <div class="span1">
                <label>To</label>
            </div>
            <div class="span2">
                <?php echo $form->textField($model,'int_dt_to',array('class'=>'span12 tdate','placeholder'=>'dd/mm/yyyy'));?>
            </div>
        </div>
         <div class="control-group">
            <div class="span2">
                <label>Branch</label>
            </div>
            <div class="span3">
                <?php echo $form->dropDownList($model,'brch_cd',CHtml::listData(Branch::model()->findAll(array('condition'=>"approved_stat='A'",'order'=>'brch_cd')), 'brch_cd', 'CodeAndName'),array('class'=>'span12','prompt'=>'-All-','style'=>'font-family:courier','disabled'=>$branchFlg=='N'?'disabled':''));?>
            </div>
        </div>
          <div class="control-group">
            <div class="span6">
             <?php $this->widget('bootstrap.widgets.TbButton',
                array('label' => 'Retrieve',
                        'type'=>'primary',
                        'size' => 'medium',
                        'id' => 'btnRetrieve',
                        'buttonType'=>'submit'
                       ) ); ?>
           &emsp;
               <?php $this->widget('bootstrap.widgets.TbButton',
                array('label' => 'Process',
                        'size' => 'medium',
                        'type'=>'primary',
                        'id' => 'btnProcess',
                        'buttonType'=>'submit'
                       ) ); ?>
            </div>
        </div>
    </div>
</div>

<br />
<?php 
    if(count($modelDetail)>0)
     { 
        $this->renderPartial('_formDetail',array('modelDetail'=>$modelDetail,'form'=>$form));
     }
 ?>

<?php echo $form->datePickerRow($model,'cre_dt',array('style'=>'display:none','label'=>false));?>

<?php $this->endWidget(); ?>
<script>
   // var rowCount='<?php echo count($modelDetail);?>';
    init();
    function init()
    {
        $('.tdate').datepicker({'format':'dd/mm/yyyy'});
    }
    $('#btnRetrieve').click(function(e){
        $('#scenario').val('retrieve');
    });
    
    $('#btnProcess').click(function(){
        $('#scenario').val('process');
    })
    
    $('#Postingintselected_bulan, #Postingintselected_year').change(function(){
        var from_date = $('#Postingintselected_int_dt_from').val().split('/');
        $('#Postingintselected_int_dt_from').val(from_date[0]+'/'+$('#Postingintselected_bulan').val()+'/'+$('#Postingintselected_year').val());
        $('#Postingintselected_int_dt_to').val( $('#Postingintselected_int_dt_from').val());
        var end_date = $('#Postingintselected_int_dt_to').val().split('/');
        $('#Postingintselected_int_dt_to').val(end_date[0]+'/'+$('#Postingintselected_bulan').val()+'/'+$('#Postingintselected_year').val());
        Get_End_Date($('#Postingintselected_int_dt_to').val());
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
        $('#Postingintselected_int_dt_to').val(new_date);
        $('.tdate').datepicker('update');
    }
    
   $(document).ajaxStart(function(){
        $('#showloading').show();
    });
    $(document).ajaxComplete(function(){
        $('#showloading').hide();
    });
    

</script>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array( 
    'action'=>Yii::app()->createUrl($this->route), 
    'method'=>'get', 
    'type'=>'horizontal' 
)); ?>

<h4>Primary Attributes</h4> 
    <?php echo $form->textFieldRow($model,'cifs',array('class'=>'span5','maxlength'=>8)); ?>
    <?php echo $form->textFieldRow($model,'cif_name',array('class'=>'span5','maxlength'=>50)); ?>
    <?php echo $form->textFieldRow($model,'sid',array('class'=>'span5','maxlength'=>15)); ?>
    <?php echo $form->textFieldRow($model,'client_type_1',array('class'=>'span5','maxlength'=>1)); ?>
    <?php echo $form->textFieldRow($model,'client_type_2',array('class'=>'span5','maxlength'=>1)); ?>
    <?php echo $form->textFieldRow($model,'npwp_no',array('class'=>'span5','maxlength'=>15)); ?>
    <?php echo $form->textFieldRow($model,'client_title',array('class'=>'span5','maxlength'=>6)); ?>
    <?php echo $form->textFieldRow($model,'mother_name',array('class'=>'span5','maxlength'=>50)); ?>
    <div class="control-group">
        <?php echo $form->label($model,'client_birth_dt',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model,'client_birth_dt_date',array('maxlength'=>'2','class'=>'span1','placeholder'=>'dd')); ?>
            <?php echo $form->textField($model,'client_birth_dt_month',array('maxlength'=>'2','class'=>'span1','placeholder'=>'mm')); ?>
            <?php echo $form->textField($model,'client_birth_dt_year',array('maxlength'=>'4','class'=>'span1','placeholder'=>'yyyy')); ?>
        </div>
    </div>
    <?php echo $form->textFieldRow($model,'client_ic_num',array('class'=>'span5','maxlength'=>30)); ?>
    <?php echo $form->textFieldRow($model,'ic_type',array('class'=>'span5','maxlength'=>1)); ?>
    <div class="control-group">
        <?php echo $form->label($model,'ic_expiry_dt',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model,'ic_expiry_dt_date',array('maxlength'=>'2','class'=>'span1','placeholder'=>'dd')); ?>
            <?php echo $form->textField($model,'ic_expiry_dt_month',array('maxlength'=>'2','class'=>'span1','placeholder'=>'mm')); ?>
            <?php echo $form->textField($model,'ic_expiry_dt_year',array('maxlength'=>'4','class'=>'span1','placeholder'=>'yyyy')); ?>
        </div>
    </div>
    <?php echo $form->textFieldRow($model,'def_addr_1',array('class'=>'span5','maxlength'=>50)); ?>
    <?php echo $form->textFieldRow($model,'def_addr_2',array('class'=>'span5','maxlength'=>50)); ?>
    <?php echo $form->textFieldRow($model,'def_addr_3',array('class'=>'span5','maxlength'=>30)); ?>
    <?php echo $form->textFieldRow($model,'country',array('class'=>'span5','maxlength'=>30)); ?>
    <?php echo $form->textFieldRow($model,'post_cd',array('class'=>'span5','maxlength'=>6)); ?>
    <?php echo $form->textFieldRow($model,'phone_num',array('class'=>'span5','maxlength'=>15)); ?>
    <?php echo $form->textFieldRow($model,'hp_num',array('class'=>'span5','maxlength'=>15)); ?>
    <?php echo $form->textFieldRow($model,'fax_num',array('class'=>'span5','maxlength'=>15)); ?>
    <?php echo $form->textFieldRow($model,'hand_phone1',array('class'=>'span5','maxlength'=>15)); ?>
    <?php echo $form->textFieldRow($model,'phone2_1',array('class'=>'span5','maxlength'=>15)); ?>
    <?php echo $form->textFieldRow($model,'e_mail1',array('class'=>'span5','maxlength'=>50)); ?>
    <?php echo $form->textFieldRow($model,'inst_type',array('class'=>'span5','maxlength'=>2)); ?>
    <?php echo $form->textFieldRow($model,'inst_type_txt',array('class'=>'span5','maxlength'=>30)); ?>
    <?php echo $form->textFieldRow($model,'annual_income_cd',array('class'=>'span5','maxlength'=>2)); ?>
    <?php echo $form->textFieldRow($model,'annual_income',array('class'=>'span5','maxlength'=>40)); ?>
    <?php echo $form->textFieldRow($model,'funds_code',array('class'=>'span5','maxlength'=>2)); ?>
    <?php echo $form->textFieldRow($model,'source_of_funds',array('class'=>'span5','maxlength'=>30)); ?>
    <?php echo $form->textFieldRow($model,'purpose01',array('class'=>'span5','maxlength'=>2)); ?>
    <?php echo $form->textFieldRow($model,'purpose02',array('class'=>'span5','maxlength'=>2)); ?>
    <?php echo $form->textFieldRow($model,'purpose03',array('class'=>'span5','maxlength'=>2)); ?>
    <?php echo $form->textFieldRow($model,'purpose04',array('class'=>'span5','maxlength'=>2)); ?>
    <?php echo $form->textFieldRow($model,'purpose05',array('class'=>'span5','maxlength'=>2)); ?>
    <?php echo $form->textFieldRow($model,'purpose06',array('class'=>'span5','maxlength'=>2)); ?>
    <?php echo $form->textFieldRow($model,'purpose07',array('class'=>'span5','maxlength'=>2)); ?>
    <?php echo $form->textFieldRow($model,'purpose08',array('class'=>'span5','maxlength'=>2)); ?>
    <?php echo $form->textFieldRow($model,'purpose09',array('class'=>'span5','maxlength'=>2)); ?>
    <?php echo $form->textFieldRow($model,'purpose10',array('class'=>'span5','maxlength'=>2)); ?>
    <?php echo $form->textFieldRow($model,'purpose11',array('class'=>'span5','maxlength'=>2)); ?>
    <?php echo $form->textFieldRow($model,'purpose90',array('class'=>'span5','maxlength'=>2)); ?>
    <?php echo $form->textFieldRow($model,'purpose_lainnya',array('class'=>'span5','maxlength'=>30)); ?>
    <?php echo $form->textFieldRow($model,'invesment_period',array('class'=>'span5','maxlength'=>20)); ?>
    <?php echo $form->textFieldRow($model,'net_asset_cd',array('class'=>'span5','maxlength'=>2)); ?>
    <?php echo $form->textFieldRow($model,'net_asset',array('class'=>'span5','maxlength'=>40)); ?>
    <?php echo $form->textFieldRow($model,'net_asset_yr',array('class'=>'span5','maxlength'=>4)); ?>
    <?php echo $form->textFieldRow($model,'addl_fund_cd',array('class'=>'span5','maxlength'=>1)); ?>
    <?php echo $form->textFieldRow($model,'addl_fund',array('class'=>'span5','maxlength'=>30)); ?>
    <?php echo $form->textFieldRow($model,'biz_type',array('class'=>'span5','maxlength'=>2)); ?>
    <?php echo $form->textFieldRow($model,'act_first',array('class'=>'span5','maxlength'=>30)); ?>
    <div class="control-group">
        <?php echo $form->label($model,'act_first_dt',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model,'act_first_dt_date',array('maxlength'=>'2','class'=>'span1','placeholder'=>'dd')); ?>
            <?php echo $form->textField($model,'act_first_dt_month',array('maxlength'=>'2','class'=>'span1','placeholder'=>'mm')); ?>
            <?php echo $form->textField($model,'act_first_dt_year',array('maxlength'=>'4','class'=>'span1','placeholder'=>'yyyy')); ?>
        </div>
    </div>
    <?php echo $form->textFieldRow($model,'act_last',array('class'=>'span5','maxlength'=>30)); ?>
    <div class="control-group">
        <?php echo $form->label($model,'act_last_dt',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model,'act_last_dt_date',array('maxlength'=>'2','class'=>'span1','placeholder'=>'dd')); ?>
            <?php echo $form->textField($model,'act_last_dt_month',array('maxlength'=>'2','class'=>'span1','placeholder'=>'mm')); ?>
            <?php echo $form->textField($model,'act_last_dt_year',array('maxlength'=>'4','class'=>'span1','placeholder'=>'yyyy')); ?>
        </div>
    </div>
    <?php echo $form->textFieldRow($model,'siup_no',array('class'=>'span5','maxlength'=>30)); ?>
    <?php echo $form->textFieldRow($model,'tdp_no',array('class'=>'span5','maxlength'=>30)); ?>
    <?php echo $form->textFieldRow($model,'modal_dasar',array('class'=>'span5','maxlength'=>30)); ?>
    <?php echo $form->textFieldRow($model,'modal_disetor',array('class'=>'span5','maxlength'=>30)); ?>
    <?php echo $form->textFieldRow($model,'industry_cd',array('class'=>'span5','maxlength'=>2)); ?>
    <?php echo $form->textFieldRow($model,'industry',array('class'=>'span5','maxlength'=>30)); ?>
    <div class="control-group">
        <?php echo $form->label($model,'cre_dt',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model,'cre_dt_date',array('maxlength'=>'2','class'=>'span1','placeholder'=>'dd')); ?>
            <?php echo $form->textField($model,'cre_dt_month',array('maxlength'=>'2','class'=>'span1','placeholder'=>'mm')); ?>
            <?php echo $form->textField($model,'cre_dt_year',array('maxlength'=>'4','class'=>'span1','placeholder'=>'yyyy')); ?>
        </div>
    </div>
    <?php echo $form->textFieldRow($model,'cre_user_id',array('class'=>'span5','maxlength'=>10)); ?>
    <div class="control-group">
        <?php echo $form->label($model,'upd_dt',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model,'upd_dt_date',array('maxlength'=>'2','class'=>'span1','placeholder'=>'dd')); ?>
            <?php echo $form->textField($model,'upd_dt_month',array('maxlength'=>'2','class'=>'span1','placeholder'=>'mm')); ?>
            <?php echo $form->textField($model,'upd_dt_year',array('maxlength'=>'4','class'=>'span1','placeholder'=>'yyyy')); ?>
        </div>
    </div>
    <?php echo $form->textFieldRow($model,'upd_user_id',array('class'=>'span5','maxlength'=>10)); ?>
    <?php echo $form->textFieldRow($model,'autho_person_name',array('class'=>'span5','maxlength'=>50)); ?>
    <?php echo $form->textFieldRow($model,'autho_person_ic_type',array('class'=>'span5','maxlength'=>1)); ?>
    <?php echo $form->textFieldRow($model,'autho_person_ic_num',array('class'=>'span5','maxlength'=>30)); ?>
    <?php echo $form->textFieldRow($model,'autho_person_position',array('class'=>'span5','maxlength'=>50)); ?>
    <?php echo $form->textFieldRow($model,'profit_cd',array('class'=>'span5','maxlength'=>2)); ?>
    <?php echo $form->textFieldRow($model,'profit',array('class'=>'span5','maxlength'=>30)); ?>
    <?php echo $form->textFieldRow($model,'tempat_pendirian',array('class'=>'span5','maxlength'=>30)); ?>
    <?php echo $form->textFieldRow($model,'skd_no',array('class'=>'span5','maxlength'=>30)); ?>
    <div class="control-group">
        <?php echo $form->label($model,'skd_expiry',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model,'skd_expiry_date',array('maxlength'=>'2','class'=>'span1','placeholder'=>'dd')); ?>
            <?php echo $form->textField($model,'skd_expiry_month',array('maxlength'=>'2','class'=>'span1','placeholder'=>'mm')); ?>
            <?php echo $form->textField($model,'skd_expiry_year',array('maxlength'=>'4','class'=>'span1','placeholder'=>'yyyy')); ?>
        </div>
    </div>
    <?php echo $form->textFieldRow($model,'tax_id',array('class'=>'span5','maxlength'=>4)); ?>
    <div class="control-group">
        <?php echo $form->label($model,'autho_person_ic_expiry',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model,'autho_person_ic_expiry_date',array('maxlength'=>'2','class'=>'span1','placeholder'=>'dd')); ?>
            <?php echo $form->textField($model,'autho_person_ic_expiry_month',array('maxlength'=>'2','class'=>'span1','placeholder'=>'mm')); ?>
            <?php echo $form->textField($model,'autho_person_ic_expiry_year',array('maxlength'=>'4','class'=>'span1','placeholder'=>'yyyy')); ?>
        </div>
    </div>
    <?php echo $form->textFieldRow($model,'def_city',array('class'=>'span5','maxlength'=>40)); ?>
    <div class="control-group">
        <?php echo $form->label($model,'npwp_date',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model,'npwp_date_date',array('maxlength'=>'2','class'=>'span1','placeholder'=>'dd')); ?>
            <?php echo $form->textField($model,'npwp_date_month',array('maxlength'=>'2','class'=>'span1','placeholder'=>'mm')); ?>
            <?php echo $form->textField($model,'npwp_date_year',array('maxlength'=>'4','class'=>'span1','placeholder'=>'yyyy')); ?>
        </div>
    </div>
    <?php echo $form->textFieldRow($model,'direct_sid',array('class'=>'span5','maxlength'=>15)); ?>
    <?php echo $form->textFieldRow($model,'asset_owner',array('class'=>'span5','maxlength'=>1)); ?>
    <?php echo $form->textFieldRow($model,'upd_by',array('class'=>'span5','maxlength'=>10)); ?>
    <div class="control-group">
        <?php echo $form->label($model,'approved_dt',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model,'approved_dt_date',array('maxlength'=>'2','class'=>'span1','placeholder'=>'dd')); ?>
            <?php echo $form->textField($model,'approved_dt_month',array('maxlength'=>'2','class'=>'span1','placeholder'=>'mm')); ?>
            <?php echo $form->textField($model,'approved_dt_year',array('maxlength'=>'4','class'=>'span1','placeholder'=>'yyyy')); ?>
        </div>
    </div>
    <?php echo $form->textFieldRow($model,'approved_by',array('class'=>'span5','maxlength'=>10)); ?>
    <?php echo $form->textFieldRow($model,'approved_stat',array('class'=>'span5','maxlength'=>1)); ?>

    <div class="form-actions"> 
        <?php $this->widget('bootstrap.widgets.TbButton', array( 
            'buttonType' => 'submit', 
            'type'=>'primary', 
            'label'=>'Search', 
        )); ?>
    </div> 

<?php $this->endWidget(); ?>
<?php

class TaskDetailFilterForm extends nomvcAbstractFilterForm
{
    public function init()
    {
        parent::init();

        //Период
        $this->addWidget(new nomvcInputDatePeriodPickerWidget("dt", "dt"));
        $this->addValidator("dt", new nomvcDatePeriodValidator());

        $this->addWidget(new nomvcInputHiddenWidget('id_task', 'id_task'));
        $this->addValidator('id_task', new nomvcIntegerValidator(array('required' => true)));

        $this->addWidget(new nomvcInputTextWidget("pharmacy", "pharmacy"));
        $this->addValidator('pharmacy', new nomvcStringValidator(array('required' => false, 'min' => 2, 'max' => 200)));

        $this->addWidget(new nomvcInputTextWidget("address", "address"));
        $this->addValidator('address', new nomvcStringValidator(array('required' => false, 'min' => 2, 'max' => 200)));

        $this->addWidget(new nomvcSelectFromMultipleDbWidget('category', 'id_category', array(
            'helper' => $this->context->getDbHelper(),
            'table' => 'v_category',
            'order' => 'name',
            'required' => false,
            'multiple' => true
        ), array()));
        $this->addValidator('id_category', new nomvcValueInDbMultipleValidator(array(
            'required' => false,
            'helper' => $this->context->getDbHelper(),
            'table' => 'v_category',
            'key' => 'id_category'
        )));

        $this->addWidget(new nomvcSelectFromMultipleDbWidget('region', 'id_region', array(
            'helper' => $this->context->getDbHelper(),
            'table' => 'v_region',
            'order' => 'name',
            'required' => false,
            'multiple' => true
        ), array()));
        $this->addValidator('id_region', new nomvcValueInDbMultipleValidator(array(
            'required' => false,
            'helper' => $this->context->getDbHelper(),
            'table' => 'v_region',
            'key' => 'id_region'
        )));

        $this->addWidget(new nomvcSelectFromMultipleDbWidget('city', 'id_city', array(
            'helper' => $this->context->getDbHelper(),
            'table' => 'v_city',
            'order' => 'name',
            'required' => false,
            'multiple' => true
        ), array()));
        $this->addValidator('id_city', new nomvcValueInDbMultipleValidator(array(
            'required' => false,
            'helper' => $this->context->getDbHelper(),
            'table' => 'v_city',
            'key' => 'id_city'
        )));

        $this->addWidget(new nomvcSelectFromMultipleDbWidget('area', 'id_area', array(
            'helper' => $this->context->getDbHelper(),
            'table' => 'v_area',
            'order' => 'name',
            'required' => false,
            'multiple' => true
        ), array()));
        $this->addValidator('id_area', new nomvcValueInDbMultipleValidator(array(
            'required' => false,
            'helper' => $this->context->getDbHelper(),
            'table' => 'v_area',
            'key' => 'id_area'
        )));

        $this->addWidget(new nomvcSelectFromMultipleDbWidget('merchandiser', 'id_member', array(
            'helper' => $this->context->getDbHelper(),
            'table' => 'v_merch_list',
            'order' => 'fio',
            'val' => 'fio',
            'required' => false,
            'multiple' => true
        ), array()));
        $this->addValidator('id_member', new nomvcValueInDbMultipleValidator(array(
            'required' => false,
            'helper' => $this->context->getDbHelper(),
            'table' => 'v_merch_list',
            'key' => 'id_member'
        )));

        $this->addWidget(new nomvcSelectFromMultipleDbWidget('status', 'id_status', array(
            'helper' => $this->context->getDbHelper(),
            'table' => 'v_tmp_status',
            'val' => 'name_'.Context::getInstance()->getUser()->getLanguage(),
            'order' => 'name_'.Context::getInstance()->getUser()->getLanguage(),
            'required' => false,
            'multiple' => true
        ), array()));
        $this->addValidator('id_status', new nomvcValueInDbMultipleValidator(array(
            'required' => false,
            'helper' => $this->context->getDbHelper(),
            'table' => 'v_tmp_status',
            'key' => 'id_status'
        )));

        $this->addButton('search');
        $this->addButton('reset');
        $this->addButton('export');

//        $this->addWidget(new nomvcButtonWidget('Добавить аптеку', 'create', array(
//            'type' => 'button',
//            'icon' => 'file'
//        ), array(
//            'onclick' => "return TableFormActions.getForm('pharmacy');",
//            'class' => 'btn btn-success'
//        )));
    }

}

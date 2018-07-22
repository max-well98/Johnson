<?php

class PharmacyFilterForm extends nomvcAbstractFilterForm{
    public function init() {
        parent::init();

        //Период
        $this->addWidget(new nomvcInputDatePeriodPickerWidget("Дата создания", "dt"));
        $this->addValidator("dt", new nomvcDatePeriodValidator());

        $this->addWidget(new nomvcInputTextWidget("ID_CRM", "id_crm"));
        $this->addValidator('id_crm', new nomvcStringValidator(array('required' => false)));

        $this->addWidget(new nomvcInputTextWidget("Название", "name"));
        $this->addValidator('name', new nomvcStringValidator(array('required' => false,'min' => 2, 'max' => 200)));

        $this->addWidget(new nomvcInputTextWidget("Адрес", "address"));
        $this->addValidator('address', new nomvcStringValidator(array('required' => false,'min' => 2, 'max' => 200)));

        $this->addWidget(new nomvcSelectFromMultipleDbWidget('Категория', 'id_category', array(
            'helper' => $this->context->getDbHelper(),
            'table' => 't_category',
            'order' => 'name',
            'required' => false,
            'multiple' => true
        ), array()));
        $this->addValidator('id_category', new nomvcValueInDbMultipleValidator(array(
            'required' => false,
            'helper' => $this->context->getDbHelper(),
            'table' => 't_category',
            'key' => 'id_category'
        )));

        $this->addWidget(new nomvcSelectFromMultipleDbWidget('Регион', 'id_region', array(
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

        $this->addWidget(new nomvcSelectFromMultipleDbWidget('Город', 'id_city', array(
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

        $this->addWidget(new nomvcSelectFromMultipleDbWidget('Район', 'id_area', array(
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

        $this->addWidget(new nomvcSelectFromMultipleDbWidget('Мерчендайзер', 'id_member', array(
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

        $this->addWidget(new nomvcSelectFromMultipleDbWidget('Статус', 'id_status', array(
            'helper' => $this->context->getDbHelper(),
            'table' => 'v_pharmacy_status',
            'order' => 'name',
            'required' => false,
            'multiple' => true
        ), array()));
        $this->addValidator('id_status', new nomvcValueInDbMultipleValidator(array(
            'required' => false,
            'helper' => $this->context->getDbHelper(),
            'table' => 'v_pharmacy_status',
            'key' => 'id_status'
        )));

        $this->addButton('search');
        $this->addButton('reset');
        $this->addButton('export');

        $this->addWidget(new nomvcButtonWidget(' Добавить аптеку', 'create', array(
            'type' => 'button',
            'icon' => 'file'
        ), array(
            'onclick' => "return TableFormActions.getForm('pharmacy');",
            'class' => 'btn btn-success'
        )));

    }

}
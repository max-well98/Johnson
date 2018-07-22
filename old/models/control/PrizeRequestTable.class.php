<?php

class PrizeRequestTable extends AbstractMapObjectTable {
    public function init($options = array()) {
        $options = array(
            'sort_by' => 'id_prize_member_point',
            'sort_order' => 'desc',
            'rowlink' => <<<EOF
<script>
	$('.rowlink').rowlink({ target: '.field_id_prize_member_point' });
	$('.field_id_prize_member_point').click(function () {
		TableFormActions.getForm('prize-request', $(this).closest('tr').attr('row-id'));
	});
</script>
EOF
        );

        parent::init($options);

        $this->setRowModelClass('PrizeRequest');

        $this->addColumn('id_prize_member_point', 'ID запроса', 'integer');
        $this->addColumn('learning_id', 'Learning ID', 'string');
        $this->addColumn('surname', 'Фамилия', 'string');
        $this->addColumn('name', 'Имя', 'string');
        $this->addColumn('restaurant', 'Название ресторана', 'string');
        $this->addColumn('city', 'Город', 'string');
        $this->addColumn('address', 'Адрес ресторана', 'string');
        $this->addColumn('position', 'Должность', 'string');
        $this->addColumn('dt', 'Дата отправки запроса', 'date', array('format' => DateHelper::HTMLDTS_FORMAT));
        $this->addColumn('prize', 'Приз', 'string');
        $this->addColumn('val', 'Стоимость в баллах', 'string');
        $this->addColumn('status', 'Статус запроса', 'string');

        $this->setFilterForm(new PrizeRequestFilterForm($this->context));
    }

}
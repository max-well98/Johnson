<?php

class TaskDetail
{
    public static function getTableName()
    {
        return 'v_task_detail';
    }

    public static function getTotal()
    {
        return array();
    }

    public function getRowStatusClass()
    {
        return '';
    }

    public function getRowTitle()
    {
        return '';
    }

    public function __get($name)
    {
        return $this->get($name);
    }

    public function get($name)
    {
        $name = strtolower($name);

        if ($name == 'detail')
            return $this->getDetail();

        if (isset($this->$name)) {
            return $this->$name;
        } else {
            return null;
        }
    }

    private function getDetail()
    {
        return "<a target='_blank' href='/admin/stat/task-pharmacy-detail/?id_task={$this->id_task}&id_pharmacy={$this->id_pharmacy}&id_member={$this->id_member}'>" . Context::getInstance()->translate('view') . "</a>";
    }

    public function getRowId()
    {
        return $this->id_task_mp;
    }
}

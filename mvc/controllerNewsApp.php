<?php

class controllerNewsApp
{
    private $model = null;
    private $request = null;
    private $view = null;
    private $data = null;

    function setRequest()
    {
        //valid
        if (!empty($_GET)) {
            $this->request = $_GET;
        }
    }

    function action($model)
    {
        $startPage = 1;
        $finalPage = $this->model->getNumOfPages();

        if ((empty($this->request) || ($this->request['page'] < $startPage || $this->request['page'] >$finalPage))
            && !isset($this->request['id'])) {
            $model->getNewsFromSql();
            if ($model->getData() != null) {
                $this->view = new viewNewsApp($model->getData());
            }
        } elseif (isset($this->request['page'])) {
            $model->getNewsFromSql($this->request['page']);
            if ($model->getData() != null) {
                $this->view = new viewNewsApp($model->getData());
            }
        } elseif (isset($this->request['id'])) {
            $model->getDetailNews($this->request['id']);
            if ($model->getData() != null) {
                $this->view = new viewDetailNewsApp($model->getData());
            }
        }
    }

    public function __construct()
    {
        $this->setRequest();
        $this->model = new modelAppNews();
        $this->action($this->model);


        //$this->view = new viewNewsApp();
    }
}
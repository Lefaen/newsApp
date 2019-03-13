<?php

class viewNewsApp
{

    private function view($data)
    {
        ?>
        <h1>Новости</h1>
        <?
        foreach ($data['news'] as $item):?>
            <div>
                <span><?= $item['idate']; ?></span><a href="?id=<?= $item['id'] ?>"><?= $item['title']; ?></a>
            </div>
            <div>
                <p><?= $item['announce']; ?></p>
            </div>
        <? endforeach; ?>
        <div>
            <span>Страницы:</span>
        </div>
        <div>
            <? for ($i = 1; $i <= $data['numOfPages']; $i++): ?>
                <a href="?page=<?= $i; ?>"><?= $i; ?></a>
            <?endfor; ?>
        </div>
        <?php
    }

    public function __construct($data)
    {
        $this->view($data);
    }
}

class viewDetailNewsApp
{
    private function view($data)
    {
        ?>
        <div>
            <h1><?= $data['title']; ?></h1>
            <p><?= $data['content']; ?></p>
        </div>
        <div><a href="/">Все новости >></a></div>
        <?php
    }

    function __construct($data)
    {
        $this->view($data);
    }
}
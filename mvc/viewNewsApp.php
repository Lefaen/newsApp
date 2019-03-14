<?php

class viewNewsApp
{

    private function view($data, $activePage)
    {
        ?>

        <div class="news">
            <h1>Новости</h1>
            <ul class="listNews">
                <?
                foreach ($data['news'] as $item):?>
                    <li>
                            <p>
                                <span>
                                    <?= $item['idate']; ?>
                                </span>
                                <a href="?id=<?= $item['id'] ?>">
                                    <?= $item['title']; ?>
                                </a>
                            </p>

                            <p><?= $item['announce']; ?></p>
                    </li>
                <? endforeach; ?>
            </ul>
            <div class="nav">
                <p>Страницы:</p>
                <ul>
                    <? for ($i = 1; $i <= $data['numOfPages']; $i++): ?>
                        <?if($activePage == $i):?>
                            <li class="active">
                        <?else:?>
                            <li>
                        <?endif;?>
                            <a href="?page=<?= $i; ?>">
                                <?= $i; ?>
                            </a>
                        </li>
                    <?endfor; ?>
                </ul>
            </div>
        </div>

        <?php
    }

    public function __construct($data, $activePage)
    {
        $this->view($data, $activePage);
    }
}

class viewDetailNewsApp
{
    private function view($data)
    {
        ?>
        <div class="news">
            <div class="detail">
                <h1><?= $data['title']; ?></h1>
                <p><?= $data['content']; ?></p>
            </div>
            <div><a href="/">Все новости >></a></div>
        </div>
        <?php
    }

    function __construct($data)
    {
        $this->view($data);
    }
}
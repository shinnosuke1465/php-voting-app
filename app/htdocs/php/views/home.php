<?php

namespace view\home;

function index($topics)
{
    $topic = escape($topics);

    //$topics配列の一番最初だけ$topicに格納される。残りの配列はそのまま$topicsに格納される
    $topic = array_shift($topics);
    \partials\topic_header_item($topic, true);
    ?>
    <ul class="container">
        <?php
        foreach ($topics as $topic) {
            $url = get_url('topic/detail?topic_id=' . $topic->id);
            \partials\topic_list_item($topic, $url, false);
        }
        ?>
    </ul>
    <?php
}

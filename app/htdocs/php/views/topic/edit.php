<?php

namespace view\topic\edit;

function index($topic)
{
?>
  <h1 class="h2 mb-3">トピック作成</h1>

  <div class="bg-white p-4 shadow-sm mx-auto rounded">
    <form class="d-flex flex-column gap-3" action="<?php CURRENT_URI; ?>" method="POST">
      <input type="hidden" name="topic_id" value="<?php echo $topic->id; ?>">
      <div class="form-group d-flex flex-column gap-2">
        <label for="title">タイトル</label>
        <input type="text" id="title" name="title" value ="<?php echo $topic->title; ?>" class="form-control">
      </div>
      <div class="form-group d-flex flex-column gap-2">
        <label for="published">ステータス</label>
        <select name="published" id="published" class="form-control">
          <!-- topicテーブルのpublishedが1の場合(true)公開なのでselectedクラスをつけて公開を表示 -->
          <option value="1" <?php echo $topic->published ? 'selected' : ''; ?>>公開</option>
          <option value="0" <?php echo $topic->published ? '' : 'selected'; ?>>非公開</option>
        </select>
      </div>
      <div class="d-flex align-items-center mt-2 gap-3">
        <div>
          <input type="submit" value="送信" class="btn btn-primary shadow-sm mr-3">
        </div>
        <div>
          <a href="<?php the_url('topic/archive'); ?>">戻る</a>
        </div>

      </div>
    </form>
  </div>
<?php
}

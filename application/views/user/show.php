<script type="text/javascript">
  globalOptions['userId'] = '<?php echo $user->id;?>';
</script>
<div class="user-block">
  <div class="avatar">
    <img src="<?php echo $user->getAvatar('medium_sqw', 1);?>">
      <div class="actions">
      <?php
        if (!Yii::app()->user->id === Yii::app()->user->id ||
        Yii::app()->user->role === 'admin') :
      ?>
        <a href="/user/edit?id=<?php echo $user->id; ?>">Редактировать профиль</a>
      <?php
        endif;
      ?>
      </div>
  </div>
  <div class="user-data">
    <div class="profile-info">
      <h1>
      <?php
        echo $user->login;
        $name = $user->first_name . ' ' . $user->last_name;
        $trimName = trim($name);
        if (!empty($trimName)):
      ?>
      (<?php echo $name;?>)
      <?php
        endif;
      ?>
      </h1>
    </div>
    <div class="reports-block">
      <?php
        if ($this->currentUser->id === $user->id):
      ?>
      <div style="overflow: hidden">
      <form method="post" id="repostAddForm">
        <textarea id="repostText" style="width: 400px; height: 200px;"></textarea>
        <div id="repostAddError" class="error_list">
        </div>
        <div style="overflow: hidden">
          <div style="float: left;">Символов осталось <span id="report_symb_left">250</span></div>
          <input type="submit" class="btn btn-default" value="Написать репорт">
        </div>
      </form>
      <div class="error_list" id="report_add_error"></div>
      </div>
      <script type="text/javascript">
        $(function(){
          Report.init();
        });
      </script>
      <?php
        endif;
      ?>
      <h3>
        Репорты:
      </h3>
      <div id="reportsList">
        <div id="report_loading">Загружаем репорты...</div>
      </div>
      <script type="text/javascript">
        $(function(){
          ReportList.init();
        });
      </script>
    </div>
  </div>
</div>
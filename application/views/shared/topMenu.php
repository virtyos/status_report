        <nav class="nav">
          <ul>
            <li><a href="/report/all">Репорты</a></li>
            <li><a href="/user/all">Пользователи </a></li>
            <?php
              if (Yii::app()->user->role === 'admin') :
            ?>
            <li><a href="/user/add">Добавить пользователя </a></li>
            <?php
              endif;
            ?>
            <li><a href="/login/logout">Выход</a></li>
          </ul>
        </nav>
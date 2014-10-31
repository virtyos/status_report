<?php
$this->widget('RequireJS', array('app_name' => 'index'));
?>
<!-- Slogan -->
<div class="slogan">
  <h1>Findaflat — лучший способ найти или сдать жилье</h1>

  <p>Мы помогаем собственникам и арендаторам находить друг друга минуя ненужных посредников.</p>
</div>
<!-- END Slogan -->
<!-- Scroll image -->
<div class="scroll-wrap">
  <div class="scroll js-scroll-index">
    <div style="background-image: url(img/1.jpg)"></div>
    <div style="background-image: url(img/2.jpg)"></div>
  </div>
  <div class="promo-wrap">
    <div class="promo">
      <h2 class="promo__title">Для собственников</h2>

      <div class="promo__text">Выбирайте арендаторов сами, зарабатывайте больше.</div>
      <?php
      if (Yii::app()->user->isGuest) {
        ?>
        <a id="rent_apartment" href="#" class="btn-orange">Сдать жильё</a>
        <?php
      } else {
        ?>
        <a href="/account/flatprocess" class="btn-orange">Сдать жильё</a>
        <?php
      }
      ?>
      <br><br>
      <a href="/search/renter" class="btn-orange">Найти арендатора</a>
      <div class="promo__more">
        <a href="/owners" target="_blank">Узнать подробнее</a>
      </div>
    </div>
    <div class="promo">
      <h2 class="promo__title">Для арендаторов</h2>

      <div class="promo__text">Снимайте жилье напрямую у собственников, без агентов и посредственников.</div>
      <a href="/search" class="btn-orange">Найти жильё</a>
      <br><br>
      <?php
      if (Yii::app()->user->isGuest) {
        ?>
        <a id="offer_apartment" href="#" class="btn-orange">Разместить объявление</a>
        <?php
      } else {
        ?>
        <a href="/account/rentform" class="btn-orange">Разместить объявление</a>
        <?php
      }
      ?>

      <div class="promo__more">
        <a href="/renters" target="_blank">Узнать подробнее</a>
      </div>
    </div>
  </div>
</div>
<!-- Scroll image -->
<!-- Offers -->
<div class="offers">
  <div class="offers-title"><strong>Новые предложения</strong></div>
  <div class="offers-wrap">
    <?php
    if (count($last_apartments) > 0) {
      ?>
      <?php
      $counter = 1;
      foreach ($last_apartments as $apartment) {
        if ($counter > 4)
          break;
        ?>
        <div class="offer">
          <a href="<?php echo $apartment->getUrl(); ?>" class="offer__img">
            <img src="<?php echo $apartment->getAvatar('large_x'); ?>" alt="">
          </a>
          <span class="metro-st"><i></i><?php if (isset($apartment->subway_link)) echo $apartment->subway_link->name; ?></span>

          <div class="price">
            <?php
            if ($apartment->is_auction) {
              ?>
              <strong><?php echo Utils::priceFormat($apartment->getAuctionLastPrice()); ?> <i>p</i></strong>
              <span>аукцион</span>
              <?php
            } else {
              ?>
              <strong><?php echo Utils::priceFormat($apartment->getPrice()); ?> <i>p</i></strong>
              <span>цена за месяц</span>
              <?php
            }
            ?>
          </div>
        </div>
        <?php
        $counter++;
      }
      ?>
      <?php
    } else {
      ?>
      Новых предложений не найдено.
      <?php
    }
    ?>
  </div>
  <?php
  if (count($last_apartments) > 4) {
    ?>
    <div class="more-var">
      <span>Показать еще 4 варианта</span>
    </div>
    <div class="offers-wrap" style="display: none">
      <?php
      for ($i = 4; $i < 8; $i++) {
        if (!isset($last_apartments[$i]))
          break;
        $apartment = $last_apartments[$i];
        ?>
        <div class="offer">
          <a href="<?php echo $apartment->getUrl(); ?>" class="offer__img">
            <img src="<?php echo $apartment->getAvatar('large_x'); ?>" alt="">
          </a>
          <span class="metro-st"><i></i><?php if (isset($apartment->subway_link)) echo $apartment->subway_link->name; ?></span>

          <div class="price">
            <?php
            if ($apartment->is_auction) {
              ?>
              <strong><?php echo Utils::priceFormat($apartment->getAuctionLastPrice()); ?> <i>p</i></strong>
              <span>аукцион</span>
              <?php
            } else {
              ?>
              <strong><?php echo Utils::priceFormat($apartment->getPrice()); ?> <i>p</i></strong>
              <span>цена за месяц</span>
              <?php
            }
            ?>
          </div>
        </div>
        <?php
      }
      ?>
    </div>
    <?php
  }
  ?>
</div>
<!-- END Offers -->
<div class="title">
  <div>
    <strong>Преимущества</strong>
    <ul class="tab">
      <li class="active" data-tab=".tab-cont1"><span>Для собственников</span></li>
      <li data-tab=".tab-cont2"><span>Для арендаторов</span></li>
    </ul>
  </div>
</div>
<!-- Advanteges -->
<div class="advanteges tab-cont tab-cont1">
  <div class="advant-wrap advant-wrap_1">
    <div class="advant">
      <h2 class="advant__title">Зарабатывайте больше — устройте аукцион!</h2>

      <div class="advant__text">Выбор победителя в любом случае за Вами, им не обязательно должен быть тот, кто
        предложил наибольшую цену.
      </div>
    </div>
    <div class="offer-img">
      <div class="offer-img__wrap">
        <div>
          <img src="img/img_5.jpg" width="390" height="390" alt="">
          <span></span>
        </div>
      </div>
    </div>
  </div>
  <div class="advant-wrap advant-wrap_2">
    <div class="advant">
      <h2 class="advant__title"><span>Выбирайте арендаторов сами</span></h2>

      <div class="advant__text">Вы можете ознакомиться с подробной информацией обо всех арендаторах, которым
        приглянулась Ваша квартира: образование, места работы, увлечения, образ жизни, фотографии и пр. Выбирайте тех
        арендаторов, которые вам нравятся!
      </div>
    </div>
    <div class="wrap">
      <div class="offer-img offer-img_m">
        <div class="offer-img__wrap">
          <div>
            <img src="img/img_6.jpg" width="232" height="232" alt="">
            <span></span>
          </div>
        </div>
      </div>
      <div class="offer-img offer-img_m">
        <div class="offer-img__wrap">
          <div>
            <img src="img/img_7.jpg" width="232" height="232" alt="">
            <span></span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="advanteges tab-cont tab-cont2" style="display: none">
  <div class="advant-wrap advant-wrap_1">
    <div class="advant">
      <h2 class="advant__title">Только от собственников</h2>

      <div class="advant__text">У нас нет предложений от агентов, только прямые собственники.</div>
    </div>
    <div class="offer-img">
      <div class="offer-img__wrap">
        <div>
          <img src="img/img_1.jpg" width="390" height="390" alt="">
          <span></span>
        </div>
      </div>
    </div>
  </div>
  <div class="advant-wrap advant-wrap_2">
    <div class="advant">
      <h2 class="advant__title"><span>Удобный поиск</span></h2>

      <div class="advant__text">Найти подходящую квартиру или комнату теперь проще простого! Воспользуйтесь нужными
        фильтрами - и выбирайте!
      </div>
    </div>
    <div class="wrap">
      <div class="offer-img offer-img_m">
        <div class="offer-img__wrap">
          <div>
            <img src="img/img_2.jpg" width="232" height="232" alt="">
            <span></span>
          </div>
        </div>
      </div>
      <div class="offer-img offer-img_m">
        <div class="offer-img__wrap">
          <div>
            <img src="img/img_3.jpg" width="232" height="232" alt="">
            <span></span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- END Advantegess -->
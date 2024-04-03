<?php /* Template_ 2.2.8 2020/08/31 15:57:06 /home/barrel-stage/application/www/assets/templet/enterprise/customer/contact_us/contact_us.htm 000001863 */ ?>
<?php $this->print_("customerTop",$TPL_SCP,1);?>

<section class="fb__contact">
    <h2 class="fb__contact__title"><?php echo trans('제휴 문의')?></h2>
    <section class="subtitle">
        <p >
            <?php echo trans('배럴은 보다 더 즐거운 삶을 위한 다양한 비즈니스 협력 문의를 환영합니다.')?>

        </p>
        <p >
            <?php echo trans('파트너사 여러분의 소중한 제안을 기다립니다.')?>

        </p>
        <p>
            <?php echo trans('다양한 아이디어, 컨텐츠, 제품 등으로 더 즐거운 삶을 만들어가요!')?>

        </p>
    </section>
    <section class="step">
        <h3 class="step__title"><?php echo trans('제휴문의 절차')?></h3>
        <ul class="step__list">
           <li><?php echo trans('이메일 접수')?></li>
           <li><?php echo trans('사업여부 검토')?></li>
           <li><?php echo trans('결과통보')?></li>
           <li><?php echo trans('제휴회의')?></li>
        </ul>
    </section>
    <div class="fb__contact__rowWrap">
        <section class="contact__row">
            <h3 class="contact__row__title"><?php echo trans('영업 문의')?></h3>
            <p><?php echo trans('sales@getbarrel.com')?></p>
            <a href="mailto:sales@getbarrel.com"><?php echo trans('이메일 보내기')?></a>
        </section>
        <section class="contact__row">
            <h3 class="contact__row__title"><?php echo trans('마케팅 문의')?></h3>
            <p><?php echo trans('marketing@getbarrel.com')?></p>
            <a href="mailto:marketing@getbarrel.com"><?php echo trans('이메일 보내기')?></a>
        </section>
    </div>
</section>
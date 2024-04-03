<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8">
<meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no'>
<title>404 Page Not Found</title>
<link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">
      <style type="text/css">
            html, body, div, span, applet, object, iframe,
            h1, h2, h3, h4, h5, h6, p, blockquote, pre,
            a, abbr, acronym, address, big, cite, code,
            del, dfn, em, img, ins, kbd, q, s, samp,
            small, strike, strong, sub, sup, tt, var,
            b, u, i, center,
            dl, dt, dd, ol, ul, li,
            fieldset, form, label, legend,
            table, caption, tbody, tfoot, thead, tr, th, td,
            article, aside, canvas, details, embed,
            figure, figcaption, footer, header, hgroup,
            menu, nav, output, ruby, section, summary,
            time, mark, audio, video {margin: 0;padding: 0;border: 0;}
            a {text-decoration:none; color:#666;}

            body {
                  width: 100%;
                  height: 100%;
                  font-family: 'Noto Sans KR', sans-serif;
            }
            #container {
                  position: absolute;
                  top:0;
                  bottom: 0;
                  left: 0;
                  right: 0;
                  margin: auto;
                  width: 100%;
                  height: 490px;
                  background:#fff;
                  text-align: center;
            }
            .container_inner {
                  padding: 0 40px;
            }
            h1 {
                  font-size: 40px;
                  color:#000;
                  font-weight: 500;
                  letter-spacing: -1px;
            }
            h1:before {
                  display: block;
                  width: 103px;
                  height: 103px;
                  margin: 0 auto 30px;
                  background: url("/etc/icon/icon-error.png") no-repeat;
                  background-size: 103px;
                  content: "";
            }
            p {
                  margin-top: 30px;
                  font-size: 24px;
                  line-height: 40px;
                  letter-spacing: -1px;
                  text-align: center;
                  color: #000;
            }
            .btn {
                  display: flex;
                  flex-wrap: nowrap;
                  margin-top: 60px;
            }
            .btn a {
                  width: 100%;
                  height: 80px;
                  border: solid 1px #000;
                  font-size: 26px;
                  text-align: center;
                  line-height: 80px;
            }
            .btn a + a {
                  margin-left:20px;
            }
            .btn .prev-btn {
                  background-color: #ffffff;
                  color: #000;
            }
            .btn .home-btn {
                  background-color: #000;
                  color: #ffffff;
            }


            @media screen and (min-width: 769px) {
                  /*pc*/

                  body {
                        background-color: #f7f7f7;
                  }
                  #container {
                        width: 800px;
                        height: 390px;
                        padding: 105px 0;
                        background:#fff;
                        box-shadow: 9.6px 11.5px 15px 0 rgba(34, 34, 34, 0.07);
                        text-align: center;
                  }
                  h1:before {
                        width: 90px;
                        height: 90px;
                        margin: 0 auto 30px;
                        background: url("/etc/icon/icon-error.png") no-repeat;
                  }
                  p {
                        margin-top: 10px;
                        font-size: 20px;
                        text-align: center;
                  }
                  .btn {
                        display: block;
                        margin-top: 40px;
                        text-align: center;
                  }
                  .btn a {
                        display: inline-block;
                        width: 198px;
                        height: 58px;
                        font-size: 20px;
                        text-align: center;
                        line-height: 60px;
                  }

                  .btn a + a {
                        margin-left:10px;
                  }
            }
</style>
</head>
<?php if(BASIC_LANGUAGE == 'english'):?>
    <body>
    <div id="container">
        <div class="container_inner">
            <h1>The page cannot be displayed.</h1>
            <p>
                We apologize for any inconvenience.<br/>
                There was an error displaying the requested page.<br/>
                Please try again later.
            </p>
            <div class="btn">
                <a href="javascript:history.back()" class="prev-btn">Previous</a>
                <a href="/" class="home-btn">Home</a>
            </div>
        </div>
    </div>
    <div style="display:none">
        <?= $heading; ?>
        <?= $message; ?>
    </div>
    </body>
<?php else: ?>
    <body>
    <div id="container">
        <div class="container_inner">
            <h1>요청하신 페이지를 찾을 수 없습니다.</h1>
            <p>
                불편을 드려 죄송합니다.<br/>
                페이지의 주소가 변경 혹은<br/>
                삭제되어 요청하신 페이지를 찾을 수 없습니다.
            </p>
            <div class="btn">
                <a href="javascript:history.back()" class="prev-btn">이전 페이지로</a>
                <a href="/" class="home-btn">홈으로</a>
            </div>
        </div>
    </div>
    <div style="display:none">
        <?php echo $heading; ?>
        <?php echo $message; ?>
    </div>
    </body>
<?php endif ?>
</html>
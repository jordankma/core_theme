<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cocos2d-html5 Hello World test</title>
    <link rel="icon" type="image/GIF" href="res/favicon.ico"/>
    <meta name="viewport" content="initial-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="full-screen" content="yes"/>
    <meta name="screen-orientation" content="portrait"/>
    <meta name="x5-fullscreen" content="true"/>
    <meta name="360-fullscreen" content="true"/>

</head>
<body>

<script src="http://hocvalamtheobac.vnedutech.vn/hocvalamtheobac.vnedutech.vn/client/cocos2/res/loading.js">
</script><canvas id="gameCanvas" width="1180px" height="800px"></canvas>
<input type="hidden" name="game_token" id="token_key" value="<?php echo $_GET['game_token'] ?>"/>
<input type="hidden" name="linkresult" id="linkresult" value="<?php echo $_GET['linkresult'] ?>"/>
<input type="hidden" name="linkaudio" id="linkaudio" value="<?php echo $_GET['linkaudio'] ?>"/>
<input type="hidden" name="linkhome" id="linkhome" value="http://giaothonghocduong.com.vn"/>
<input type="hidden" name="ip_port" id="" value="http://contest.vnedutech.vn/api/v1/"/>
<input type="hidden" name="test" id="test" value="false"/>
<input type="hidden" name="contest" id="contest" value="7"/>
<input type="hidden" name="linkimg" id="" value="http://static.quiz2.vnedutech.vn/public"/>
<input type="hidden" name="linkquest" id="linkquest" value="http://quiz2.vnedutech.vn/json/contest/5/11_file.json?v=1539489830"/>
<input type="hidden" name="m_level" id="" value="3"/>
<input type="hidden" name="type" id="" value="2"/>
<script cocos src="http://hocvalamtheobac.vnedutech.vn/hocvalamtheobac.vnedutech.vn/client/cocos2/game.min.js?v=0.0.1"></script>

<style>
/*    body, canvas, div {
        -moz-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
        -khtml-user-select: none;
    }
    #Cocos2dGameContainer{
        margin: 0px 1px !important;
        position: relative !important;
        overflow: hidden !important;
    }
    #gameCanvas{
       
    }*/
</style>
</body>
</html>
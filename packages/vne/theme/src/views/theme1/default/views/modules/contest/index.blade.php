<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cocos2d-html5 Hello World test</title>

    <meta name="viewport" content="initial-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="full-screen" content="yes"/>
    <meta name="screen-orientation" content="portrait"/>
    <meta name="x5-fullscreen" content="true"/>
    <meta name="360-fullscreen" content="true"/>
    <style>
        body, canvas, div {
            -moz-user-select: none;
            -webkit-user-select: none;
            -ms-user-select: none;
            -khtml-user-select: none;
            -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
        }

        iframe{

        }
        /*#Cocos2dGameContainer{
            width: 923px !important;
            margin-top: -57px !important;
            <link rel="icon" type="image/GIF" href="res/favicon.ico"/>
        }*/
    </style>
</head>
<body style="padding:0; margin: 0; background: #000;">

<script src="{{ asset('client2/cocos/res/loading.js') }}"></script>
<canvas id="gameCanvas" width="863" height="500"></canvas>


<input type="hidden" name="game_token" id="token_key" value="267d9ab000febd79315df9c0aa668825"/>
<input type="hidden" name="linkresult" id="linkresult" value="http://gthd.vnedutech.vn/"/>
<input type="hidden" name="linkaudio" id="linkaudio" value="res/sound/"/>
<input type="hidden" name="linkhome" id="linkhome" value="http://gthd.vnedutech.vn/"/>
<input type="hidden" name ="ip_port" value="http://123.30.174.148:4555/">
<input type="hidden" name ="linkimg" value="http://quiz2.vnedutech.vn">

<input type="hidden" name="linkquest" id="linkquest" value="http://quiz2.vnedutech.vn/json/contest/5/9_file.json?v=1539684969"/>
<input type="hidden" name="test" id="test" value="false"/>

<input type="hidden" name ="m_level" value="3">
<input type="hidden" name ="type" value="2">
<script cocos src="{{ asset('client2/cocos/game.min.js?v=0.0.9') }}"></script>
</body>
</html>

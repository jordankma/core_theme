{!! isset($SETTING['ga_code']) ? $SETTING['ga_code'] : '' !!}
<div class="wrapper">
    <div id="main-exam">
        <div id="play-game" class="">
            <div class="play-main">
                <div class="play-content">
                    <div class="game">
                        <style>
                            iframe,game{
                                overflow: hidden;
                                z-index: -1000;
                            }
                        </style>
                        <iframe style="width: 95%; height: 98%; border: none" src="{{ $url }}"></iframe>
                    </div>
                </div>
                {{-- <a href="/front/exam/exit" class="exam-close">
                    <img src="/files/images/close.png"/>
                </a> --}}
            </div>
        </div>
    </div>
</div> 

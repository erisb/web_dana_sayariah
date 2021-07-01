@component('component/modal_khazanah')
<style>
    p {
        margin: 10px 25px;
        text-indent: 2em;
    }
    li {
            padding-bottom: 10px;
        }
    ol{
        padding-left: 10px !important;
        margin-left: 10px !important;
    }
    .forgot-box-khazanah {
        border-radius: 8px;
        background: inherit;
        padding: 50px;
    }
</style>
@slot('modal_id') crowdFundingModal @endslot
@slot('modal_title') PENDANAAN SECARA HALAL MELALUI CROWD FUNDING @endslot
@slot('size') modal-lg @endslot

@slot('modal_content')
<hr class="green_line col-12">
    <div class="tabbing tabbing-box mb-60">
        <ul class="nav nav-tabs col-12 justify-content-server text-center" id="carTab" role="tablist">
            <li class="nav-item col-6">
                <a class="nav-link active show" id="one-tab" data-toggle="tab" href="#one2" role="tab" aria-controls="one" aria-selected="false">ISLAMIC CROWDFUNDING MAY BE JUST WHAT ISLAMIC FINANCE NEEDS NOW</a>
            </li>
            <li class="nav-item col-6">
                <a class="nav-link" id="two-tab" data-toggle="tab" href="#two2" role="tab" aria-controls="two" aria-selected="false">BUT WHAT DOES ISLAM SAY ABOUT IT?</a>
            </li>
        </ul>
        <div class="tab-content" id="carTabContent">
            <div class="tab-pane fade active show" id="one2" role="tabpanel" aria-labelledby="one-tab">
                <h4 style="margin-left: 10px;color:#0faf3f;margin-top: 10px" class="text-center"><b>ISLAMIC CROWDFUNDING MAY BE JUST WHAT ISLAMIC FINANCE NEEDS NOW. </b> </h4>
                <p>When it comes to making an investment in an Islamic investment, many people tread with care, worried about the Shariah compliance of the product. Financial jargon is problematic enough and becomes even more complicated when Arabic terminology is involved.</p>
                <p>Because of that, some people may view the latest innovation in Islamic finance, Islamic crowdfunding, with hesitation. Research shows consumer skepticism towards Islamic banking services, sadly, prevails in Muslim communities.</p>
                <p>The growth of the Islamic finance industry is the responsibility of all Muslims and not of a few banks. Luckily, crowdfunding is as inclusive as it gets.</p>
                <p>Here is a brief summary.</p>
                <p>Crowdfunding is the funding of a project by a large group of people, through online platforms. It compensates the obvious disadvantages of using bank loans and makes funding more accessible and efficient. With crowdfunding, it is the customer who approves of your product and funds it.</p>
                <p>This gives the average person more control over what should be in the market.This is important to the Muslim consumer especially, as they will have more power to bring halal products to the market.</p>
                <p>Crowdfunding has many benefits, such as market research and validation, but its main advantage is perhaps in connecting the entrepreneurs directly with the customers, the “innovators with those who need innovation”.</p>
            </div>
            <div class="tab-pane fade" id="two2" role="tabpanel" aria-labelledby="two-tab">
                <h4 style="margin-left: 10px;color:#0faf3f;margin-top: 10px" class="text-center"><b>BUT WHAT DOES ISLAM SAY ABOUT IT?</b> </h4>
                <p>It is one of the mercies of Allah that He has made the permissible and forbidden clear. We also have a general principle set for us by the respected scholars of Islam that everything in this world is Halal and pure unless it has been explicitly forbidden or it brings harm to the person or community.</p>
                <p>Islamic crowdfunding removes the harmful elements of crowdfunding such as interest and harmful products (alcohol, etc), and leaves only the good.</p>
                <p>On top of that, Islam advocates charity, entrepreneurship, and anything that brings benefit to the world. Crowdfunding encourages social entrepreneurship and there are countless Muslims around the world who have brilliant ideas that, if executed, can make a positive impact on their societies. They have the brains and talents but usually lack the funds to execute their plans. Crowdfunding is the platform that can provide them those funds.</p>
                <p>Danasyariah.id is one of the Platforms to recognize this potential of crowdfunding to bring good to the "Ummah" and the world. It is, in fact, the Indonesian's first pure shariah real estate crowdfunding platform.</p>
            </div>
            
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>
@endslot
@endcomponent

@component('component/modal_khazanah')
@slot('modal_id') investorModal @endslot
@slot('modal_title') @lang('modal_1.1') @endslot
@slot('size') modal-lg @endslot

@slot('modal_content')
<hr class="green_line col-12">
    <div class="tabbing tabbing-box mb-60">
        <ul class="nav nav-tabs col-12 justify-content-server text-center" id="carTab" role="tablist">
            <li class="nav-item col-6">
                <a class="nav-link active show" id="one-tab" data-toggle="tab" href="#one" role="tab" aria-controls="one" aria-selected="false">@lang('modal_1.2')</a>
            </li>
            <li class="nav-item col-6">
                <a class="nav-link" id="two-tab" data-toggle="tab" href="#two" role="tab" aria-controls="two" aria-selected="false">@lang('modal_1.3')</a>
            </li>
        </ul>
        <div class="tab-content" id="carTabContent">
            <div class="tab-pane fade active show" id="one" role="tabpanel" aria-labelledby="one-tab">
                <h4 style="margin-left: 10px;color:#0faf3f;margin-top: 10px" class="text-center"><b>@lang('modal_1.2')</b> </h4>
                
                <p  style="margin-left: 20px;">@lang('modal_1.4')</p>
                <ol>
                    <li>
                        @lang('modal_1.5') (<a href="index.php">danasyariah.id</a>), @lang('modal_1.6')
                        <br><br>
                        <ol type="a">
                            <li>@lang('modal_1.7')</li>
                            <li>@lang('modal_1.8')</li>
                            <li>@lang('modal_1.9')</li>
                            <li>@lang('modal_1.10')</li>
                            <li>@lang('modal_1.11')</li>
                            <li>@lang('modal_1.12')</li>
                        </ol>
                    </li>
                    <li>@lang('modal_1.13')</li>
                    <li>@lang('modal_1.14')</li>
                    <li>@lang('modal_1.15')</li>
                    <li>@lang('modal_1.16')</li>
                    <li>@lang('modal_1.17')</li>
                    <li>@lang('modal_1.18')</li>
                    <li>@lang('modal_1.19')</li>
                    <li>@lang('modal_1.20')</li>
                    <li>@lang('modal_1.21')</li>
                    <li>@lang('modal_1.22')</li>
                    <li>@lang('modal_1.23')</li>
                </ol>
            </div>
            <div class="tab-pane fade" id="two" role="tabpanel" aria-labelledby="two-tab">
                <h4 style="margin-left: 10px;color:#0faf3f;margin-top: 10px" class="text-center"><b>@lang('modal_1.24')</b> </h4>
                <p >@lang('modal_1.25')</p>
                <ol>
                    <li>@lang('modal_1.26')
                        <br><br>
                        <ol type="a">
                            <li>@lang('modal_1.27')</li>
                            <li>@lang('modal_1.28')</li>
                            <li>@lang('modal_1.29')</li>
                            <li>@lang('modal_1.30')</li>
                            <li>@lang('modal_1.31')</li>
                            <li>@lang('modal_1.32')</li>
                        </ol>
                    </li>
                    <li>@lang('modal_1.33')</li>
                    <li>@lang('modal_1.34')</li>
                    <li>@lang('modal_1.35')</li>
                    <li>@lang('modal_1.36')<br><br>
                        <ol type="a">
                            <li>@lang('modal_1.37')</li>
                            <li>@lang('modal_1.38')</li>
                            <li>@lang('modal_1.39')</li>
                            <li>@lang('modal_1.40')</li>
                            <li>@lang('modal_1.41')</li>
                            <li>@lang('modal_1.42')</li>
                            <li>@lang('modal_1.43')</li>
                            <li>@lang('modal_1.44')</li>
                        </ol>
                    </li>
                    <li>@lang('modal_1.45')</li>
                    <li>@lang('modal_1.46')</li>
                </ol>
            </div>
            
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>
@endslot
@endcomponent

@component('component/modal_khazanah')
<style>
    p {
        margin: 10px 25px;
        text-indent: 2em;
    }
</style>
@slot('modal_id') jualBeliModal @endslot
@slot('modal_title') @lang('modal_2.1') @endslot
@slot('size') modal-lg @endslot

@slot('modal_content')
<br>
<ol>
    <li> <span>@lang('modal_2.2')</span><br><br>
        <ol type="a">
            <li>@lang('modal_2.3')</li>
            <li>@lang('modal_2.4')</li>
        </ol>
    </li>
    <li><span>@lang('modal_2.5')</span><br><br>
        <ol type="a">
            <li>@lang('modal_2.6')</li>
            <li>@lang('modal_2.7')</li>
        </ol>
    </li>
    <li><span>@lang('modal_2.8')</span><br><br>
        <ol type="a">
            <li>@lang('modal_2.9')</li>
            <li>@lang('modal_2.10')</li>
        </ol>
    </li>
    <li><span>@lang('modal_2.11')</span> <br><br>
        <ol type="a">
            <li>@lang('modal_2.12')</li>
            <li>@lang('modal_2.13')</li>
        </ol>
    </li>
    <li> <span>@lang('modal_2.14')</span></li>
    <li><span>@lang('modal_2.15')</span></li>
    <li><span>@lang('modal_2.16')</span></li>
</ol>
<hr class="green_line col-12">
<p>@lang('modal_2.17')</p>
<ol>
    <li><span>@lang('modal_2.18')</span></li>
    <li><span>@lang('modal_2.19')</span></li>
    <li><span>@lang('modal_2.20')</span><br><br>
        <ol type="a">
            <li>@lang('modal_2.21')</li>
            <li>@lang('modal_2.22')</li>
        </ol>
    </li>
    <li><span>@lang('modal_2.23')</span></li>
</ol>
<hr class="green_line col-12">
<p>@lang('modal_2.24')</p>
<p>@lang('modal_2.25')</p>
<p>@lang('modal_2.26')</p>
<p>@lang('modal_2.27')</p>
<br><br>    
</div>
<div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>
@endslot
@endcomponent

@component('component/modal_khazanah')
<style>
    p {
        margin: 10px 25px;
        text-indent: 2em;
    }
    h2 {
        margin: 10px 25px;
    }
</style>
@slot('modal_id') maisirRibaModal @endslot
@slot('modal_title') MAISIR, GHARAR DAN RIBA @endslot
@slot('size') modal-lg @endslot

@slot('modal_content')
<h4 style="margin-left: 10px;color:#0faf3f;margin-top: 10px" class="text-center"><b>@lang('modal_3.1')</b> </h4>
    <div class="tabbing tabbing-box mb-60">
        <ul class="nav nav-tabs col-12 justify-content-server text-center" id="carTab" role="tablist">
            <li class="nav-item col-4">
                <a class="nav-link active show" id="one-tab" data-toggle="tab" href="#one3" role="tab" aria-controls="one" aria-selected="false">Maisir</a>
            </li>
            <li class="nav-item col-4">
                <a class="nav-link" id="two-tab" data-toggle="tab" href="#two3" role="tab" aria-controls="two" aria-selected="false">Gharar</a>
            </li>
            <li class="nav-item col-4">
                <a class="nav-link" id="two-tab" data-toggle="tab" href="#three3" role="tab" aria-controls="two" aria-selected="false">Riba</a>
            </li>
        </ul>
        <div class="tab-content" id="carTabContent">
            <div class="tab-pane fade active show" id="one3" role="tabpanel" aria-labelledby="one-tab">
                <h4 style="margin-left: 10px;color:#0faf3f;margin-top: 10px" class="text-center"><b>Maisir </b> </h4>
                <p>@lang('modal_3.2')</p>
                <p>@lang('modal_3.3')</p>
                <p>@lang('modal_3.4')</p>
            </div>
            <div class="tab-pane fade" id="two3" role="tabpanel" aria-labelledby="two-tab">
                <h4 style="margin-left: 10px;color:#0faf3f;margin-top: 10px" class="text-center"><b>Gharar</b> </h4>
                <p>@lang('modal_3.5')</p>
                <p>@lang('modal_3.6')</p>
                <ol type="a">
                    <li>@lang('modal_3.7')</li>
                    <li>@lang('modal_3.8')</li>
                    <li>@lang('modal_3.9')</li>
                </ol>
                <p>@lang('modal_3.10')</p>
                <p>@lang('modal_3.11')</p>
                <ol>
                    <li><span>@lang('modal_3.12')</span></li>
                    <li><span>@lang('modal_3.13')</span></li>
                    <li><span>@lang('modal_3.14')</span></li>
                    <li><span>@lang('modal_3.15')</span></li>
                    <li><span>@lang('modal_3.16')</span></li>
                    <li><span>@lang('modal_3.17')</span></li>
                </ol>
                <p>@lang('modal_3.18')</p>
                <ol>
                    <li><span>@lang('modal_3.19')</span></li>
                    <li><span>@lang('modal_3.20')</span></li>
                    <li><span>@lang('modal_3.21')</span></li>
                    <li><span>@lang('modal_3.22')</span></li>
                    <li><span>@lang('modal_3.23')</span></li>
                    <li><span>@lang('modal_3.24')</span></li>
                </ol>
            </div>
            <div class="tab-pane fade" id="three3" role="tabpanel" aria-labelledby="one-tab">
                <h4 style="margin-left: 10px;color:#0faf3f;margin-top: 10px" class="text-center"><b>Riba </b> </h4>
                <p>@lang('modal_3.25')</p>
                <p style="font-size: 30px;">اَلرِّبَافىِ الشَّرْعِ هُوَ فَضْلُ الخَالٍ عَنْ عِوَضِ شَرْطٍ ِلأَحَدٍ العَاقِدَيْنِ</p>
                <p>@lang('modal_3.26')</p>
                <p>@lang('modal_3.27')</p>
                <p>@lang('modal_3.28')</p>
                <p>@lang('modal_3.29')</p>
                <p>@lang('modal_3.30')</p>
                <p>@lang('modal_3.31')</p>
                <p>@lang('modal_3.32')</p>
                <p>@lang('modal_3.33')</p>
                <ol>
                    <li><span>Surat Ar-Rum ayat 39 </span><br><br>
                        <p style="font-size: 15px;">وَمَا ءَاتَيْتُمْ مِنْ رِبًا لِيَرْبُوَ فِي أَمْوَالِ النَّاسِ فَلَا يَرْبُو عِنْدَ اللَّهِ وَمَا ءَاتَيْتُمْ مِنْ زَكَاةٍ تُرِيدُونَ وَجْهَ اللَّهِ فَأُولَئِكَ هُمُ الْمُضْعِفُونَ</p>
                        <p>@lang('modal_3.34')</p>
                    </li>
                    <li><span>Surat Ali Imron ayat 130 </span><br><br>
                        <p>يَاأَيُّهَا الَّذِينَ ءَامَنُوا لَا تَأْكُلُوا الرِّبَا أَضْعَافًا مُضَاعَفَةً وَاتَّقُوا اللَّهَ لَعَلَّكُمْ تُفْلِحُونَ </p>
                        <p>@lang('modal_3.35')</p>
                    </li>
                    <li><span>Al-Baqarah ayat 275 :</span> <br><br>
                        <p>... وَأَحَلَّ اللَّهُ الْبَيْعَ وَحَرَّمَ الرِّبَا .... @lang('modal_3.36')</p>
                    </li>
                    <li><span>Surat Al-Baqarah ayat 276 :</span> <br><br>
                        <p>يَمْحَقُ اللَّهُ الرِّبَا وَيُرْبِي الصَّدَقَاتِ ... @lang('modal_3.37')</p>
                    </li>
                    <li><span>Surat Al-Baqarah ayat 278 – 279 :</span> <br><br>
                        <p>يَاأَيُّهَا الَّذِينَ ءَامَنُوا اتَّقُوا اللَّهَ وَذَرُوا مَا بَقِيَ مِنَ الرِّبَا إِنْ كُنْتُمْ مُؤْمِنِينَ. فَإِنْ لَمْ تَفْعَلُوا فَأْذَنُوا بِحَرْبٍ مِنَ اللَّهِ وَرَسُولِهِ ...</p>
                        <p>@lang('modal_3.38')</p>
                    </li>
                    <li><span>Hadis</span> <br><br>
                        <p>عَنْ جَابِرٍ لَعَنَ رَسُوْلُ اللهِ آكِلَ الرِّبَا وَمُوَكِّلَهُ وَكَاتِبَهُ وَشَاهِدَيْهِ (رواه المسلم)</p>
                        <p>@lang('modal_3.39')</p>
                    </li>
                    <li><span>Hadits : Ubadah bin Al-Shamit :</span> <br><br>
                        <p>عبدة قَالَ: سَمِعْتُ رَسُوْلُ اللهِ ص م. يَنْهَى عَنْ بَيْعِ اَلذَّهَبِ بِالذَّهَبِ وَاْلفِضّةِ بِالْفِضَّةِ وَالبِرَّ بِالبِرِّ وَالسَّعِيْرِ بِالسَّعِيْرِ وَالتَّمَرِ بِالتَّمَرِ وَالمِلْحِ بِالمِلْحِ اَلاَسَوَاءً بِسَوَاءٍ عَيْنًا بِعَيْنٍ فَمَنْ اَزْدَا اوْاِزْدَادَقعد ازلى</p>
                        <p>@lang('modal_3.40')</p>
                    </li>
                    <p>@lang('modal_3.41')</p>
                    <p>@lang('modal_3.42')</p>
                    <p>@lang('modal_3.43')</p>
                </ol>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>
@endslot

@endcomponent

@component('component/modal_khazanah')
<style>
    p {
        margin: 10px 25px;
        text-indent: 2em;
    }
</style>
@slot('modal_id') murabahahModal @endslot
@slot('modal_title') @lang('modal_4.1') @endslot
@slot('size') modal-lg @endslot

@slot('modal_content')
    <h4 style="margin-left: 10px;color:#0faf3f;margin-top: 10px" class="text-center"><b>@lang('modal_4.2')</b> </h4>
    <p>@lang('modal_4.3')</p>
    <ol>
        @lang('modal_4.4')<br><br>
        <li><span>@lang('modal_4.5')</span> <br><br>
            <ol type="a">
                <li>@lang('modal_4.6')</li>
                <li>@lang('modal_4.7')</li>
            </ol>
        </li>
        <li><span>@lang('modal_4.8')</span><br><br>
            <ol type="a">
                <li>@lang('modal_4.9')</li>
                <li>@lang('modal_4.10')</li>
            </ol>
        </li>
        <li><span>@lang('modal_4.11')</span> <br><br>
            <ol type="a">
                <li>@lang('modal_4.12')</li>
                <li>@lang('modal_4.13')</li>
            </ol>
        </li>
        <li><span>@lang('modal_4.14')</span><br><br>
            <ol type="a">
                <li>@lang('modal_4.15')</li>
                <li>@lang('modal_4.16')</li>
            </ol>
        </li>
        <li><span>@lang('modal_4.17')</span></li>
        <li><span>@lang('modal_4.18')</span></li>
        <li> <span>@lang('modal_4.19')<span></li>
        </ol>
        <hr class="green_line col-10">
        <p>@lang('modal_4.20') </p>
        <ol>
            <li><span>@lang('modal_4.21')</span></li>
            <li><span>@lang('modal_4.22')</span></li>
            <li><span>@lang('modal_4.23')</span>
                <ol type="a">
                    <li>@lang('modal_4.24')</li>
                    <li>@lang('modal_4.25')</li>
                    <li>@lang('modal_4.26')</li>
                </ol>
            </li>
            <li><span>@lang('modal_4.27')</span></li>
        </ol>
    <hr class="green_line col-10">
    <p>@lang('modal_4.28')</p>
    <p>@lang('modal_4.29')</p>
    <p>@lang('modal_4.30')</p>
    <p>@lang('modal_4.31')</p>
    
    <br><br>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>
@endslot

@endcomponent

@component('component/modal_khazanah')
<style>
    p {
        margin: 10px 25px;
        text-indent: 2em;
    }
</style>
@slot('modal_id') sarprasModal @endslot
@slot('modal_title') @lang('modal_5.1') @endslot
@slot('size') modal-lg @endslot

@slot('modal_content')
    <br>
    <ol>
        <li><span>@lang('modal_5.2')</span> <br><br>
            <ol type="a">
                <li>@lang('modal_5.3')</li>
                <li>@lang('modal_5.4')</li>
            </ol>
        </li>
        <li><span>@lang('modal_5.5') </span><br><br>
            <ol type="a">
                <li>@lang('modal_5.6')</li>
                <li>@lang('modal_5.7')</li>
            </ol>
        </li>
        <li><span>@lang('modal_5.8')</span><br><br>
            <ol type="a">
                <li>@lang('modal_5.9')</li>
                <li>@lang('modal_5.10')</li>
            </ol>
        </li>
        <li><span>@lang('modal_5.11')</span> <br><br>
            <ol type="a">
                <li>@lang('modal_5.12')</li>
                <li>@lang('modal_5.13')</li>
            </ol>
        </li>
        <li> <span>@lang('modal_5.14')</span></li>
        <li><span>@lang('modal_5.15')</span></li>
        <li><span>\@lang('modal_5.16')</span></li>
    </ol>
    <hr class="green_line col-10">
    <p>@lang('modal_5.17')</p>
    <ol>
        <li><span>@lang('modal_5.18')</span></li>
        <li><span>@lang('modal_5.19')</span></li>
        <li><span>@lang('modal_5.20')</span> <br><br>
            <ol type="a">
                <li>@lang('modal_5.21')</li>
                <li>@lang('modal_5.22')</li>
            </ol>
        </li>
        <li> <span>@lang('modal_5.23')</span></li>
    </ol>
    <hr class="green_line col-10">
    <p>@lang('modal_5.24')</p>
    <p>@lang('modal_5.25')</p>
    <p>@lang('modal_5.26')</p>
    <p>@lang('modal_5.27')</p>
    <br><br>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>
@endslot

@endcomponent

@component('component/modal_khazanah')
<style>
    p {
        margin: 10px 25px;
        text-indent: 2em;
    }
</style>
@slot('modal_id') templateProposalModal @endslot
@slot('modal_title') @lang('modal_6.1') @endslot
@slot('size') modal-lg @endslot

@slot('modal_content')
    <p>@lang('modal_6.2')</p>
    <p><b>PT. Dana Syariah Indonesia, </b></p>
    <p>District 8, Prosperity Tower Lantai 12 Unit J,</p>
    <p>JL. Jendral Sudirman Kav. 52-53,</p>
    <p>Kelurahan Senayan, Kecamatan Kebayoran Baru,</p>
    <p>Jakarta Selatan 12190</p>

    <a href="/guest/khazanah/campaigntemplete.pdf" class="text-center" style="color: blue;margin-bottom: 10px;">@lang('modal_6.3')</a>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>
@endslot

@endcomponent

@component('component/modal_khazanah')
<style>
    p, h4 {
        margin: 10px 25px;
        text-indent: 2em;
    }
</style>
@slot('modal_id') unitRumahModal @endslot
@slot('modal_title') @lang('modal_7.1') @endslot
@slot('size') modal-lg @endslot

@slot('modal_content')
    <h4 style="margin-left: 10px;color:#0faf3f;margin-top: 10px" class="text-center"><b>@lang('modal_7.2')</b> </h4>
    <p>@lang('modal_7.3')</p>
    <p>@lang('modal_7.4')</p>
    <hr class="green_line col-12">
    <p>@lang('modal_7.5')</p>
    <ol>
        <li> <span>@lang('modal_7.6')</span> <br><br>
            <ol type="a">
                <li>@lang('modal_7.7')</li>
                <li>@lang('modal_7.8')</li>
            </ol>
        </li>
        <li><span>@lang('modal_7.9')</span> <br><br>
            <ol type="a">
                <li>@lang('modal_7.10')</li>
                <li>@lang('modal_7.11')</li>
            </ol>
        </li>
        <li><span>@lang('modal_7.12')</span><br><br>
            <ol type="a">
                <li>@lang('modal_7.13')</li>
                <li>@lang('modal_7.14')</li>
            </ol>
        </li>
        <li><span>@lang('modal_7.15')</span> <br><br>
            <ol type="a">
                <li>@lang('modal_7.16')</li>
                <li>@lang('modal_7.17')</li>
            </ol>
        </li>
        <li><span>@lang('modal_7.18')</span></li>
        <li><span>@lang('modal_7.19')</span></li>
        <li><span>@lang('modal_7.20')</span></li>
    </ol>
    <hr class="green_line col-12">
    <p>@lang('modal_7.21')</p>
    <ol>
        <li><span>@lang('modal_7.22')</span></li>
        <li><span>@lang('modal_7.23')</span></li>
        <li><span>@lang('modal_7.24')</span><br><br>
            <ol type="a">
                <li>@lang('modal_7.25')</li>
                <li>@lang('modal_7.26')</li>
            </ol>
        </li>
        <li> <span>@lang('modal_7.27')</span></li>
    </ol>
    <hr class="green_line col-12">
    <p>@lang('modal_7.28')</p>
    <p>@lang('modal_7.29')</p>
    <p>@lang('modal_7.30')</p>
    <p>@lang('modal_7.31')</p>
    <br><br>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>
@endslot

@endcomponent

@component('component/modal_khazanah')
<style>
    p {
        margin: 10px 25px;
        text-indent: 2em;
    }
</style>
@slot('modal_id') zakatModal @endslot
@slot('modal_title') @lang('modal_8.1') @endslot
@slot('size') modal-lg @endslot

@slot('modal_content')
    <h4 style="margin-left: 10px;color:#0faf3f;margin-top: 10px"><b>@lang('modal_8.2')</b> </h4>
    <p>@lang('modal_8.3')</p>
    <h4 style="margin-left: 10px;color:#0faf3f;margin-top: 10px"><b>@lang('modal_8.4')</b> </h4>
    <ol>
        <li>@lang('modal_8.5')</li>
        <li>@lang('modal_8.6')</li>
        <li>@lang('modal_8.7')</li>
        <li>@lang('modal_8.8')</li>
        <li>@lang('modal_8.9')</li>
    </ol>
    <h4 style="margin-left: 10px;color:#0faf3f;margin-top: 10px"><b>@lang('modal_8.10')</b> </h4>
    <p>@lang('modal_8.11')</p>
    <h4 style="margin-left: 10px;color:#0faf3f;margin-top: 10px"><b>@lang('modal_8.12')</b> </h4>
    <p>@lang('modal_8.13')</p>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>
@endslot
@endcomponent
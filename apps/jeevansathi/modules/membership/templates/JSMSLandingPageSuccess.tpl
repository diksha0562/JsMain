~if $passedKey eq 'REQUEST_CALLBACK'`
	~assign var=callbackSource value='SMS'`
~else`
	~assign var=callbackSource value='Membership_Page'`
~/if`
<meta name="format-detection" content="telephone=no">
<div class="fullwid">
	<!--start:header-->
	<div class="bg1">
		<div class="rv2_pad1 txtc">
			<div class="posrel white">
				<div id="pageTitle" class="fontthin f19">~$data.title`</div>
				<div class="posabs rv2_pos2"><i id="pageBack" class="mainsp arow2 cursp"></i></div>
				<div id="jsmsReqCallbackBtn" class="posabs rv2_pos1 fontlig cursp">~if $data.topHelp` ~$data.topHelp.title` ~/if`</div>
			</div>
		</div>
	</div>
	~include_component('common', 'jsmsReqCallback',['pageType'=>'membership','from_source'=>$callbackSource])`
	<!--start:overlay1
	<div id="callOvrOne" style="display:none;">
		<div class="tapoverlay posfix"></div>
		<div class="posabs txtc btmo fontlig bg4 fullwid" style="z-index:110;">
			<div id="topHelpPhoneNumber" class="f22 ~if $data.device eq 'Android_app'`~$data.device`_color2~else`color2~/if` pt30"><a style="cursor:pointer; color:~if $data.device eq 'Android_app'`#8d1316~else`#d9475c~/if` !important;"href="tel:~$data.topHelp.value`">~$data.topHelp.phone_number`</a></div>
			<div id="topHelpCallText" class="f14 color13 pt15">~$data.topHelp.call_text`</div>
			~if $profileid`
			<div id="topHelpOrText" class="f13 color1 pad2">~$data.topHelp.or_text`</div>
			<div id="reqCallBack" style="cursor:pointer;"class="f18 ~if $data.device eq 'Android_app'`~$data.device`_color2~else`color2~/if` pb20">~$data.topHelp.request_callback`</div>
			~else`
			<div class="pb20"></div>
			~/if`
		</div>
	</div>
	end:overlay1-->
	<!--start:overlay2
	<div id="callOvrTwo" style="display:none;">
		<div class="tapoverlay posfix"></div>
		<div class="posabs btmo fontlig bg4 fullwid" style="z-index:110;">
			<div class="pad19">
				<div class="f14 color13"><i class="mainsp mem_coma"></i>
					<span id="reqCallBackMessage"></span>
					<br>
					<div id="closeOvr2" class="fr f14 pt15 ~if $data.device eq 'Android_app'`~$data.device`_color2~else`color2~/if` cursp" style="padding-bottom:30px;padding-right:10px;">Close</div>
				</div>
			</div>
		</div>
	</div>
	end:overlay2-->
	<!--start:overlay1-->
	<div id="callOvrOneJS" style="display:none;">
		<div class="tapoverlay posfix"></div>
		<div class="posabs txtc btmo fontlig bg4 fullwid" style="z-index:110;">
			<div id="JsCallPhonelNumber" class="f22 ~if $data.device eq 'Android_app'`~$data.device`_color2~else`color2~/if` pt30"><a style="cursor:pointer; color:~if $data.device eq 'Android_app'`#8d1316~else`#d9475c~/if` !important;"href="tel:~$data.topHelp.value`">~$data.topHelp.phone_number`</a></div>
			<div id="JsCallText" class="f14 color13 pt15">~$data.topHelp.call_text`</div>
			~if $profileid`
			<div id="JsCallOrText" class="f13 color1 pad2">~$data.topHelp.or_text`</div>
			<div id="reqCallBackJS" style="cursor:pointer;"class="f18 ~if $data.device eq 'Android_app'`~$data.device`_color2~else`color2~/if` pb20">~$data.topHelp.request_callback`</div>
			~else`
			<div class="pb20"></div>
			~/if`
		</div>
	</div>
	<!--end:overlay1-->
	<!--start:overlay2-->
	<div id="callOvrTwoJS" style="display:none;">
		<div class="tapoverlay posfix"></div>
		<div class="posabs btmo fontlig bg4 fullwid" style="z-index:110;">
			<div class="pad19">
				<div class="f14 color13"><i class="mainsp mem_coma"></i>
					<span id="reqCallBackMessageJS"></span>
					<br>
					<div id="closeOvrJS" class="fr f14 pt15 ~if $data.device eq 'Android_app'`~$data.device`_color2~else`color2~/if` cursp" style="padding-bottom:30px;padding-right:10px;">Close</div>
				</div>
			</div>
		</div>
	</div>
	<!--end:overlay2-->
	<!--end:header-->
	<div class="rv2_bg1">
		~if $data.dividerText`
		<!--start:offer div-->
		<div class="rv2_pad5" style="padding-top:10px;">
			<div id="dividerText" class="bg3 posrel txtc fontlig f18 ~if $data.device eq 'Android_app'`~$data.device`_color2~else`color2~/if` rv2_pad16"> ~$data.dividerText` <i class="posabs rv2_sprtie1 rv2_pos2 rv2_offb_left"></i> <i class="posabs rv2_sprtie1 rv2_pos3 rv2_offb_right"></i> </div>
		</div>
		<!--end:offer div-->
		~/if`
		<div class="rv2_pad5" style="padding-bottom:50px;">
			~if $data.topBlockMessage`
			<!--start:expire info-->
			<div class="rv2_pad10">
				<!--start:expire div-->
				<div class="pt10">
					<div class="bg3 txtc fontlig padd22 rv2_boxshadow">
						<div id="topBlockTitleMessage" class="f17 fontmed color7">~$data.topBlockMessage.titleMessage`</div>
						~if $data.topBlockMessage.monthsValue eq 'Unlimited'`
						<div class="disptbl tablegap">
							<div class="dispcell rv2_brdr3 rv2_wid5 rv2_pad2 rv2_colr1">
								<div id="topBlockMonthsValue" class="f40 rv2_pad4 fontrobbold">~$data.topBlockMessage.monthsValue`</div>
								<div id="topBlockMonthsText" class="f12 fontlig">~$data.topBlockMessage.monthsText`</div>
							</div>
						</div>
						~else if $data.topBlockMessage.monthsValue`
						<!--start:timer-->
						<div class="disptbl tablegap" >
							<div class="dispcell rv2_brdr3 rv2_wid2 rv2_pad2 rv2_colr1">
								<div id="topBlockMonthsValue" class="f40 fontrobbold">~$data.topBlockMessage.monthsValue`</div>
								<div id="topBlockMonthsText" class="f12 fontlig">~$data.topBlockMessage.monthsText`</div>
							</div>
							<div class="dispcell rv2_brdr3 rv2_wid2 rv2_pad2 rv2_colr1">
								<div id="topBlockDaysValue" class="f40 fontrobbold">~$data.topBlockMessage.daysValue`</div>
								<div id="topBlockDaysText" class="f12 fontlig">~$data.topBlockMessage.daysText`</div>
							</div>
						</div>
						<!--end:timer-->
						~/if`
						~if $data.topBlockMessage.contactsLeftText`
						<!--start:div-->
						<div class="rv2_brdrtop1 pad12 txtc">
							<div id="topBlockContactsLeftText" class="f16 fontmed color7">~$data.topBlockMessage.contactsLeftText`</div>
							<div id="topBlockContactsLeftValue" class="f40 fontrobbold rv2_colr1 pt10">~$data.topBlockMessage.contactsLeftNumber`</div>
						</div>
						~/if`
						<!--end:div-->
						<!--start:div-->
						~if $data.topBlockMessage.currentBenefitsTitle`
						<div class="rv2_brdrtop1 pad12 txtc rv2_list2">
							<div id="topBlockCurrentBenefitsBlock" class="f17 fontmed color7">~$data.topBlockMessage.currentBenefitsTitle`</div>
							<ul>
								~foreach from=$data.topBlockMessage.currentBenefitsMessages key=k item=v name=benefitsLoop`
								<li>~$v`</li>
								~/foreach`
							</ul>
						</div>
						~/if`
						<!--end:div-->
						~if $data.topBlockMessage.nextMembershipMessage`
						<!--start:div-->
						<div class="rv2_brdrtop1 pad12 txtc">
							<div id="topBlockNextMembershipText" class="f16 fontmed color7">~$data.topBlockMessage.nextMembershipMessage`</div>
						</div>
						~/if`
						<!--end:div-->
					</div>
				</div>
				<!--end:expire div-->
			</div>
			~/if`
			~if $data.backgroundText`
			<!--start:offer div-->
			<div class="pt10">
				<div id="backgroundText" class="posrel txtc fontlig f18 ~if $data.device eq 'Android_app'`~$data.device`_color2~else`color2~/if` rv2_pad16"> ~$data.backgroundText`</div>
			</div>
			<!--end:offer div-->
			~/if`
			<!--start:option div-->
			~if $data.serviceContent`
			~foreach from=$data.serviceContent key=k item=v name=servicesLoop`
			<div class="pt10">
				<div id="~$v.subscription_id`_serviceBlock" class="rv2_boxshadow ">
					<!--start:description-->
					~if $v.subscription_id eq 'X'`
					<div class="linearBg2 rv2_pad3 ">
						~else`
						<div class="bg4 rv2_pad3">
							~/if`
							<!--start:strike through-->
							~if $v.starting_strikeout`
							<p id="~$v.subscription_id`_startingPriceStrike" class="strike rv2_colr1 txtr f14">~$data.currency`~$v.starting_strikeout`</p>
							<!--end:strike through-->
							~/if`
							<!--start:plan-->
							<div class="disptbl fullwid color7 rv2_brdrbtm1 pb10">
								<div id="~$v.subscription_id`_name" class="dispcell wid60p"><span class="f12">~$k+1`.</span><span class="f24">~$v.subscription_name`</span></div>
								<div id="~$v.subscription_id`_startingPrice" class="dispcell wid40p txtr f18">From <span>~$data.currency`</span>~$v.starting_price_string`</div>
							</div>
							<!--end:plan-->
							<!--start:features list -->
							<div id="~$v.subscription_id`_serviceBenefits" class="rv2_list1">
								<ul>
									~foreach from=$v.benefits key=kk item=vv name=servBenefitsLoop`
									<li>~$vv`~if $v.servMessage`~foreach from=$v.servMessage key=kkk item=vvv name=servMessageLoop`~if $vv eq $kkk` <span class="rv2_colr2">(~$vvv`)</span>~/if`~/foreach`~/if`</li>
									~/foreach`
								</ul>
							</div>
							<!--end:features list -->
							<!--start:duration-->
							<div clickdur="~$v.subscription_id`" class="dispnone">
								<div id="~$v.subscription_id`_selectDurationText" class="rv2_pad7 f18 fontmed ~if $data.device eq 'Android_app'`~$data.device`_color2~else`color2~/if`">
									~$v.selectDurationText`
								</div>
								<!--start:option-->
								~foreach from=$v.durations key=kd item=vd name=servDurationsLoop`
								<div id="~$v.subscription_id`~$vd.duration_id`" mainMem="~$v.subscription_id`" mainMemDur="~$vd.duration_id`" class="rv2_brdr1 rv2_brrad1 fontlig cursp durSel">
									<div class="rv2_pad8">
										<div class="clearfix">
											<div class="fl wid80p">
												<div class="fullwid clearfix">
													<div id="~$v.subscription_id`~$vd.duration_id`_duration" class="fl ~if $data.device eq 'Android_app'`~$data.device`_montht~else`montht~/if`">~$vd.duration` ~$vd.duration_text`</div>
													~if $vd.price_strike`
													<div id="~$v.subscription_id`~$vd.duration_id`_priceStrike" class="fr disct">~$data.currency`~$vd.price_strike`</div>
													~/if`
												</div>
												<div class="fullwid clearfix pt2">
													<div id="~$v.subscription_id`~$vd.duration_id`_contacts" class="fl remain">~$vd.contacts`</div>
													<div id="~$v.subscription_id`~$vd.duration_id`_price" class="fr newprice"><span>~$data.currency`</span>~$vd.price`</div>
												</div>
											</div>
											<div class="fr pt13">
												<i class="rv2_sprtie1 options"></i>
											</div>
										</div>
									</div>
								</div>
								<!--end:option-->
								<div class="rv2_hgt15"></div>
								~/foreach`
							</div>
							<!--end:duration-->
							~if $v.subscription_id eq 'X' && $profileid`
							<div id="~$v.subscription_id`_reqCllbckBtn" class="txtc fontlig f16 pt30 padb5">
								~if $v.request_callback.labelLink`
									<span id="jsExCallbackTel" class="~if $data.device eq 'Android_app'`~$data.device`_color2~else`color2~/if` cursp"><a class="~if $data.device eq 'Android_app'`~$data.device`_color2~else`color2~/if` cursp" href='~$v.request_callback.labelLink`' >~$v.request_callback.label`</a></span> or <span id="jsExCallback" class="~if $data.device eq 'Android_app'`~$data.device`_color2~else`color2~/if` cursp">~$v.request_callback.linkText`</span>
								~else`
									<span class="color8">~$v.request_callback.label`</span> <span id="jsExCallback" class="~if $data.device eq 'Android_app'`~$data.device`_color2~else`color2~/if` cursp">~$v.request_callback.linkText`</span>
								~/if`
							</div>
							~/if`
						</div>
						<!--end:description-->
						<!--start:view duration goes display none on tappin on it "add class dispnone" to hide it-->
						<div class="mt1 dur_click cursp">
							<div clickid="~$v.subscription_id`" class="bg15 f18 fontlig ~if $data.device eq 'Android_app'`~$data.device`_color2~else`color2~/if` rv2_pad6 duration_click">
								<div class="rv2_wid1">
									<div id="~$v.subscription_id`_viewDurationBtn" class="posrel">~$v.viewDurationText`<i class="rv2_sprtie1 rv2_arow1 posabs rv2_pos4"></i> </div>
								</div>
							</div>
						</div>
						<!--end:view duration-->
					</div>
				</div>
				~/foreach`
				~/if`
				<!--end:option div-->
				~if $data.vasContent`
				<div class="rv2_pad5">
					<!--start:option div-->
					~foreach from=$data.vasContent key=k item=v name=vasLoop`
					<div id="~$v.vas_key`_vasBlock" class="pt20">
						<div class="rv2_boxshadow ">
							<!--start:description-->
							<div class="bg4 padd22">
								<!--start:plan-->
								~if $v.starting_strikeout`
								<p id="~$v.vas_key`_startingStrike" class="strike rv2_colr1 txtr f14">~$data.currency`~$v.starting_strikeout`</p>
								<!--end:strike through-->
								~/if`
								<div class="disptbl fullwid color7 rv2_brdrbtm1 pb10">
									<div id="~$v.vas_key`_name" class="dispcell rv_ft1 fontmed">~$v.vas_name`</div>
									<div id="~$v.vas_key`_startingPrice" class="dispcell txtr f17 fontreg">~$v.starting_price_text` <span>~$data.currency`</span>~$v.starting_price`</div>
								</div>
								<!--end:plan-->
								<!--start:features list -->
								<div id="~$v.vas_key`_description" class="rv2_list1">
									<ul>
										<li>~$v.vas_description`</li>
									</ul>
								</div>
								<!--end:features list -->
								<!--start:duration-->
								<div id="~$v.vas_key`" class="vas_durations">
									<div id="~$v.vas_key`_selectDurationText" class="rv2_pad7 f18 fontmed ~if $data.device eq 'Android_app'`~$data.device`_color2~else`color2~/if`">~$v.selectDurationText`</div>
									<!--start:option-->
									<div class="disptbl rv2_brdr2 rv2_brrad1 fullwid fontlig">
										~foreach from=$v.vas_options key=vk item=vd name=vasDurLoop`
										~if not $smarty.foreach.vasDurLoop.last`
										<div id="~$vd.id`" vasKey="~$v.vas_key`" class="cursp dispcell wid33p_a rv2_brdrright txtc vertmid pt15 pb15 vasClick">
											<div id="~$vd.id`_durationText" class="color8 f17">~$vd.duration` ~$vd.text`</div>
											<div class="rv2_colr1 f14 pt5">
												~if $vd.vas_price_strike`
												<span id="~$vd.id`_priceStrike" class="strike rv2_colr1 txtr f14">~$data.currency`~$vd.vas_price_strike`</span>
												~/if`
												<span id="~$vd.id`_price" >~$data.currency`</span>~$vd.vas_price`
											</div>
										</div>
										~else`
										<div id="~$vd.id`" vasKey="~$v.vas_key`" class="cursp dispcell wid33p_a txtc vertmid pt15 pb15 vasClick">
											<div id="~$vd.id`_durationText" class="color8 f17">~$vd.duration` ~$vd.text`</div>
											<div class="rv2_colr1 f14 pt5">
												~if $vd.vas_price_strike`
												<span id="~$vd.id`_priceStrike" class="strike rv2_colr1 txtr f14">~$data.currency`~$vd.vas_price_strike`</span>
												~/if`
												<span id="~$vd.id`_price" >~$data.currency`</span>~$vd.vas_price`
											</div>
										</div>
										~/if`
										~/foreach`
									</div>
									<!--end:option-->
								</div>
								<!--end:duration-->
							</div>
							<!--end:description-->
						</div>
					</div>
					~/foreach`
					<!--end:option div-->
				</div>
				~/if`
				<!--start:div-->
				<div id="bottomHelpMessage" class="txtc pt25 fontlig color8 f16 lh25 pb20">
					~$data.bottom_message`
				</div>
				<!--end:div-->
				~if $data.bottomHelp`
				<!--start:help-->
				<div class="pt40 pb30 cursp">
					<div class="rv2_pad4">
						<div id="callButtonBottom" class="rv2_brdr1 txtc pad2 ~if $data.device eq 'Android_app'`~$data.device`_color2~else`color2~/if` rv2_brrad1">
							~$data.bottomHelp.title`
						</div>
					</div>
				</div>
				<!--end:help-->
				~/if`
			</div>
		</div>
	</div>
	<!--start:continue button-->
	<div style="overflow:hidden;position: fixed;height: 61px;" class="fullwid disp_b btmo">
	<div id="continueBtn" class="fullwid ~if $data.device eq 'Android_app'`~$data.device`_bg7~else`bg7~/if` txtc white f16 rv2_pad9 cursp posfix btmo pinkRipple"> ~$data.continueText` </div>
	</div>
	<!--end:continue button-->
</div>
<script type="text/javascript">
	var AndroidPromotion = 0;
	var source = "~$passedKey`";
	var filteredVasServices = "~$data.filteredVasServices`",skipVasPageMembershipBased = JSON.parse("~$data.skipVasPageMembershipBased`".replace(/&quot;/g,'"'));
	$(document).ready(function(){
		~if $data.device eq 'Android_app'`
		createCookie('device',"~$data.device`");
		~/if`
		eraseCookie('couponID');
		$("#continueBtn").hide();
		~if $data.vasContent`
		eraseCookie('mainMem');
		eraseCookie('mainMemDur');
		if(readCookie('selectedVas')){
			updateSelectedVas("jsmsLandingPage");	
		}
		~/if`
		if(checkEmptyOrNull(readCookie("mainMem")) && checkEmptyOrNull(readCookie("mainMemDur"))){
			if(checkEmptyOrNull(readCookie('device'))){
				$("#"+readCookie("mainMem")+readCookie("mainMemDur")).addClass(readCookie('device')+'_selected_d');
			} else {
				$("#"+readCookie("mainMem")+readCookie("mainMemDur")).addClass('selected_d');
			}
			$("body").find("div[clickdur='"+readCookie("mainMem")+"']").slideDown('slow');
			$("body").find("div[clickdur='"+readCookie("mainMem")+"']").parent().parent().find(".dur_click").addClass("dispnone");
			$('html, body').animate({
				scrollTop: $("body").find("div[clickdur='"+readCookie("mainMem")+"']").offset().top
			}, 1000);
			$("#continueBtn").show();
		}
		$(".duration_click").click(function(e){
			$(this).parent().addClass('dispnone');
			var clickedID = $(this).attr('clickid');
			$(this).parent().parent().find("div[clickdur='"+clickedID+"']").removeClass('dispnone').slideDown('slow');
		});
		$(".durSel").click(function(e){
			var that = this;
			$(".durSel").each(function(){
				if(this!=that){
					if(checkEmptyOrNull(readCookie('device'))){
						$(this).removeClass(readCookie('device')+'_selected_d');
					} else {
						$(this).removeClass('selected_d');
					}
				}
			});
			if(checkEmptyOrNull(readCookie('device'))){
				if($(this).hasClass(readCookie('device')+'_selected_d')){
					if(readCookie('backState') != "changePlan") {
						$(this).removeClass(readCookie('device')+'_selected_d')
						$("#continueBtn").hide();
					}
				} else {
					$(this).addClass(readCookie('device')+'_selected_d')
					$("#continueBtn").show();
				}
			} else {
				if($(this).hasClass('selected_d')){
					if(readCookie('backState') != "changePlan") {
						$(this).removeClass('selected_d')
						$("#continueBtn").hide();
					}
				} else {
					$(this).addClass('selected_d')
					$("#continueBtn").show();
				}
			}
			changeMemCookie($(this).attr("mainMem"), $(this).attr("mainMemDur"));
		});
		$(".vasClick").click(function(e){
			var that = this;
			$(this).parent().find('.vasClick').each(function(){
				if(checkEmptyOrNull(readCookie('device'))){
					if($(this).hasClass(readCookie('device')+'_vassel') && this!=that){
						$(this).removeClass(readCookie('device')+'_vassel');
					}
				} else { 
					if($(this).hasClass('vassel') && this!=that){
						$(this).removeClass('vassel');
					}
				}
			});
			if(checkEmptyOrNull(readCookie('device'))){
				if($(that).hasClass(readCookie('device')+'_vassel')){
					$(that).removeClass(readCookie('device')+'_vassel');
				} else {
					$(that).addClass(readCookie('device')+'_vassel');
				}
			} else {
				if($(that).hasClass('vassel')){
					$(that).removeClass('vassel');
				} else {
					$(that).addClass('vassel');
				}
			}
			trackVasCookie($(that).attr("vasKey"), $(that).attr("id"));
			var checkedFlag = 0;
			$("body").find('.vasClick').each(function(){
				if(checkEmptyOrNull(readCookie('device'))){
					if($(this).hasClass(readCookie('device')+'_vassel')){
						checkedFlag++;
					}
				} else {
					if($(this).hasClass('vassel')){
						checkedFlag++;
					}
				}
			});
			if(checkedFlag > 0){
				$("#continueBtn").show();
			} else {
				$("#continueBtn").hide();
			}
			checkedFlag = 0;
		});
		$("#callButtonBottom").click(function(e){
			e.preventDefault();
			$("#callOvrOne").show();
			$("#callOvrTwo").hide();
			historyStoreObj.push(clearOverlay,"#overlay");
			if($(this).attr('id') == "callButtonBottom"){
				$(window).scrollTop(0);
			}
			$('html, body, #mainContent').css({
				'overflow': 'hidden',
				'height': '100%'
			});
			$("#mainContent").addClass('posrel');
			$("#callButton").hide();
		});
		$('#callOvrOneJS .tapoverlay,#callOvrTwoJS .tapoverlay').click(function(e){
			$("#callOvrTwo").hide();
			$("#callOvrOne").hide();
			$("#callOvrTwoJS").hide();
			$("#callOvrOneJS").hide();
			$('html, body, #mainContent').css({
				'overflow': 'auto',
				'height': 'auto'
			});
			$("#callButton").show();
			historyStoreObj.pop(clearOverlay);
		});
		$("#closeOvr2").click(function(e){
			$("#callOvrTwo").hide();
			$("#callOvrOne").hide();
			$('html, body, #mainContent').css({
				'overflow': 'auto',
				'height': 'auto'
			});
			$("#callButton").show();
			historyStoreObj.pop(clearOverlay);
		});
		$("#closeOvrJS").click(function(e){
			$("#callOvrTwoJS").hide();
			$("#callOvrOneJS").hide();
			$('html, body, #mainContent').css({
				'overflow': 'auto',
				'height': 'auto'
			});
			$("#callButton").show();
			historyStoreObj.pop(clearOverlay);
		});
		// $("#reqCallBack").click(function(e){
		// 	e.preventDefault();
		// 	$("#callOvrOne").hide();
		// 	var paramStr = '~$data.topHelp.params`';
		// 	paramStr = paramStr.replace(/amp;/g,'');
		// 	url ="~sfConfig::get('app_site_url')`/api/v3/membership/membershipDetails?" + paramStr;
		// 	$.ajax({
		// 		type: 'POST',
		// 		url: url,
		// 		success:function(data){
		// 			response = data;
		// 			$("#reqCallBackMessage").text(data.message);
		// 		}
		// 	});
		// 	$("#callOvrTwo").show();
		// });
		$("#jsExCallback").click(function(e){
			e.preventDefault();
			historyStoreObj.push(clearOverlay,"#overlay");
			$(window).scrollTop(0);
			$('html, body, #mainContent').css({
				'overflow': 'hidden',
				'height': '100%'
			});
			$("#callButton").hide();
			var paramStr = "";
			var servArr = new Array();
			~foreach from=$data.serviceContent key=ks item=vs`
			~if $vs.subscription_id eq 'X'`
			paramStr = "~$vs.request_callback.params`";
			~/if`
			~/foreach`
			paramStr = paramStr.replace(/amp;/g,'');
			url ="~sfConfig::get('app_site_url')`/api/v3/membership/membershipDetails?" + paramStr;
			$.ajax({
				type: 'POST',
				url: url,
				success:function(data){
					response = data;
					$("#reqCallBackMessageJS").text(data.message);
				}
			});
			$("#callOvrTwoJS").show();
		});
		$("#continueBtn").click(function(){
			if(checkEmptyOrNull(readCookie('selectedVas')) && checkEmptyOrNull(readCookie('mainMemDur'))){
				var currentVas = readCookie('selectedVas');
				var tempArr = currentVas.split(",");
				var vasId = null;
				if(tempArr.length > 0){
					// remove all other vas which start with supplied character except currently selected
					tempArr.forEach(function(item, index){
						if(item.substring(0, 1) == "M"){
							if(readCookie('mainMemDur') != item.substring(0, 1)){
								tempArr.splice(index, 1);
								if(readCookie('mainMemDur') == "L"){
									vasId = "M12";
								} else {
									vasId = "M"+readCookie('mainMemDur');
								}
							}
						}
					});
				}
				if(vasId){
					tempArr.push(vasId);
				}
				currentVas = tempArr.join(",");
				createCookie('selectedVas', currentVas, 0);
			}
			if(readCookie('backState') == "changePlan"){
				if(checkEmptyOrNull(readCookie('selectedVas')) && $.inArray(readCookie('mainMem'),skipVasPageMembershipBased)==-1)
				{
					updateSelectedVas();
					if(checkEmptyOrNull(readCookie('mainMem')))
					{
						paramStr = "displayPage=3&mainMem="+readCookie("mainMem")+"&mainMemDur="+readCookie("mainMemDur")+"&selectedVas="+readCookie('selectedVas');
					} else 
					{
						paramStr = "displayPage=3&selectedVas="+readCookie('selectedVas');
					}
				} 
				else {
					paramStr = "displayPage=3&mainMem="+readCookie("mainMem")+"&mainMemDur="+readCookie("mainMemDur")+"&selectedVas=";
				}
				if(checkEmptyOrNull(readCookie('device'))){
					paramStr += '&device=' + readCookie('device');
				}
				if(paramStr){
					url = "~sfConfig::get('app_site_url')`/membership/jsms?" + paramStr;
					eraseCookie('backState');
					window.location.href = url;
				}
			} else {
				~if $data.serviceContent`
				var paramStr = "";
				if(checkEmptyOrNull(readCookie("mainMem")) && checkEmptyOrNull(readCookie("mainMemDur"))){ 
					if($.inArray(readCookie('mainMem'),skipVasPageMembershipBased)>-1)
					{
						paramStr = "displayPage=3&mainMem="+readCookie("mainMem")+"&mainMemDur="+readCookie("mainMemDur");
					} else {
						paramStr = "displayPage=2&mainMem="+readCookie("mainMem")+"&mainMemDur="+readCookie("mainMemDur")
					}
				} else {
					e.preventDefault();
					return;
				}
				if(checkEmptyOrNull(readCookie('device'))){
					paramStr += '&device=' + readCookie('device');
				}
				if(paramStr){
					url = "~sfConfig::get('app_site_url')`/membership/jsms?" + paramStr;
					eraseCookie('backState');
					window.location.href = url;
				}
				~/if`
				~if $data.vasContent`
				var paramStr = "";
				if(checkEmptyOrNull(readCookie("selectedVas"))){
					paramStr = "displayPage=3&selectedVas="+readCookie('selectedVas');    
				} else {
					e.preventDefault();
					return;
				}
				if(checkEmptyOrNull(readCookie('device'))){
					paramStr += '&device=' + readCookie('device');
				}
				if(paramStr){
					url = "~sfConfig::get('app_site_url')`/membership/jsms?" + paramStr;
					eraseCookie('backState');
					window.location.href = url;
				}
				~/if`
			}
		});
		if(readCookie('backState') == "changePlan"){
			$("#pageBack").hide();	
		}
		$("#pageBack").click(function(e){
			if(readCookie('backState') != "changePlan"){
				eraseCookie('mainMem');
				eraseCookie('mainMemDur');
				eraseCookie('selectedVas');
				eraseCookie('backState');
				eraseCookie('couponID');
				eraseCookie('device');
				window.location.href = "/profile/mainmenu.php";
			} else {
				window.history.back();
			}
		});
		if(source == "REQUEST_CALLBACK"){
			$('#jsmsReqCallbackBtn').trigger('click');
		}
		var username = "~$data.userDetails.USERNAME`";
		var email = "~$data.userDetails.EMAIL`";
		setInterval(function(){
    		autoPopulateFreshdeskDetails(username,email);
  		},100);
		setTimeout(function(){
			autoPopupFreshdesk(username,email);
		}, 90000);
	});
</script>

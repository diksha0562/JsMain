  <!--pixelcode for register page-->
  ~if isset($pixelcode)`
    ~$pixelcode|decodevar`
  ~/if`
<div class="perspective" id="perspective">
	<div class="pcontainer" id="pcontainer">
<!--start:div-->
		<!--start:div-->
		<div class="fullwid bg1" id="topbar">
		  <div class="pad1">
			<div class="rem_pad1">
			  <div class="fl wid20p white"><i id ="hamburgerIcon" class="mainsp baricon " hamburgermenu="1" dmove="left" dshow="" dhide="decide" dselect="" dependant="" dcallback="" dindexpos="1"></i> </div>
			  <div class="fl wid60p txtc white fontthin f19">~$USERNAME`</div>
			  <div class="fl wid20p white txtr fontlig f14 pt7"><a href="/profile/viewprofile.php?username=~$USERNAME`&preview=1" bind-slide=1 class="white">Preview</a></div>
			  <div class="clr"></div>
			</div>
		  </div>
		</div>
		<!--end:div-->
		<!--start:slider-->
		<div id="ed_slider" class="swipe vh">
			<div id ="sw" class="bxslider" >
				<div id="sliderName" class="slidechild" >
					<!--start:div-->
					<div id ="subHeadTab" class="fullwid editAlbumBG prz" style="z-index:105;">
						  <div id ="innerSubHeadTab" class="pad5">
							  <div id="leftTabName"class="fl wid30p color5 fontlig f12 pt2 opa70">LeftTabValue</div>
							  <div id="MainTabName" class="fl wid40p txtc color5 fontlig f14 textTru" maintab="1">MainTabValue
							   <span class="arow4"></span>
							  </div>							 
							  <div id="RightTabName"class="fl wid30p color5 txtr fontlig f12 pt2 opa70"></div>
							  <div class="clr"></div>
						  </div>
					</div>
					<!--end:div--> 
					
				<div id="EditSection" class="fullwid oa">
					<div class="fullwid  brdr1 bwhite" slideOverLayer="OVERLAYID">
					  <div class="pad1">
						<div class="pad2">
						  <div class="fl wid94p wwrap">
							<div id="EditFieldName" class="color3 f14 fontlig">
							</div>
							<div id="EditFieldLabelValue" class="color4 f12 pt10 fontlig">
							</div>
							</div>
							<div class="fr wid4p pt8"> <i id='ARROWID' class="mainsp arow1"></i>
							</div>
							<div class="clr"></div>
						</div>
					  </div>
					</div>
				</div>
					<!--end:div--> 
				</div>
			</div>
		</div>
		<!--end:silder--> 

<div id ="cancelOverLayBackGround" class="dn"> </div>
<div id="cancelOverLayer" class="overlay_1_e page transition top_1 dn">
  ~include_partial("profile/mobedit/cancelOverlay")`
</div>
<input type="hidden" id="listShow" value="~$checkalbum`">
	<div id="overLayer" class="page transition right_1 dn">
~include_partial("profile/mobedit/overlay")`
</div>
<div id="filterDpp" class="page transition bottom_1 dn">
    ~include_partial("profile/mobedit/manageFilters")`
</div>
<div id="divOverlay" class="dn">
<div id="json_key" class="json_color_val f17 fontlig" value ="json_value" data=1 onClick=showNonEditableOverLayer(0)>json_label_val</div>
</div>
<div id="checkOverlay" class="pad8 dn">
    <div overlaydiv="1" class="fl wid91p">
        <div id="default_val"><div id="default_key" class="f17 fontthin pad2 brdr3" value ="json_value" data=1 >json_label_val</div></div>
        <div id="OverlayID" name="overlayOption">{{overlayoptions}}</div>
    </div>
</div>
<div id="textAreaOverlay" class="dn" >
<textarea id="json_key" class="fullwid f17 fontthin color3o minhgt300" placeholder="json_label_placeholder" name="json_key" onKeyUp="keyfunctionShow"  >json_label_val</textarea>
</div>
<div id="textInputIsdOverlay" class="dn">
<div class="fl color3o f17 fontlig padding03">+</div>
<input id="RES_ISD" class="fl color3o f17 fontlig epwid8p" name ="RES_ISD" value ="phoneArray" data=1 onKeyup="keyfunctionShow" placeholder="{{PLACEHOLDER}}" type="tel" autocomplete="off"></input>
</div>
<div id="textInputStdOverlay" class="dn">
<div class="fl color3o f17 fontlig padding03">-</div>
<input type="tel" id="STD" class="fl f17 fontlig color3o {{displayWidth}}" name ="STD" value ="phoneArray" data=1 onKeyup="keyfunctionShow" placeholder="{{PLACEHOLDER}}" autocomplete="off"></input>
</div>
<div id="textInputOverlay" class="dn">
<input id="json_key" class="color3o f17 fontlig wid80p" name =json_key value ="json_value" data=1 onKeyup="keyfunctionShow" placeholder="Not filled in"></input>
</div>
<div id="under_screening" class="dn">
<span id="underscreening" class="color3 f10">(under screening)</span>
</div>
<div id="overlay_2" class="overlay_2_skip dn">
  </div>
 <div id="overlay_2_temp" class="dn">
<div class="fullwid txtc pad2 brdr4" indexpos="-1">  
	<div indexpos="{{indexpos}} "><i class="mainsp close1 cursp" indexpos="-1"></i></div> 
</div>
<div class="fullwid txtc pad2 brdr4 fontlig" indexpos="{{indexpos}}"> 
	<div class="f14 white cursp {{BOLD}}" indexpos="{{indexpos}}">{{KEYNAME}}</div> 
</div>  
</div>
<div id="filterButton" class ="dn">
	<div class="fullwid bg7">
	<div class="dispbl lh50 txtc white" onClick="showFilterOverlayer()">Set Contact Filters</div>
	</div>
 </div>
~if isset($horoExist)`
<div id="horoscopeButton" class ="dn">
  <div class="fullwid bg7">
    <div class="dispbl lh50 txtc white js-createHoroscope" >
      ~if $horoExist eq 'N'`
      Create 
      ~else` 
      Update 
      ~/if`
      Horoscope
    </div>
  </div>
</div>
~/if`
<script>
	showLoader();	
		var renderPage=new mobEditPage;
		 var DualHamburger=0;
</script>
</div>
<div class="hamburger dn fullwid" id="ehamburger">
~include_partial("profile/mobedit/hamb")`
</div>
<div id="hamburger" class="hamburgerCommon dn fullwid">	
	~include_component('static', 'newMobileSiteHamburger')`	
</div>
<div class="hamoverlay ltransform fullwid" id="hamoverlay"></div>
<div id="SAVE_DONE" class="fullwid dn" style="position:absolute;bottom:0px;">
  	<a  class="bg7 white lh30 fullwid dispbl txtc lh50">Done</a>
	</div>
</div>

<div id="albumPage" class="dn">
~include_partial("social/mobile/mobilePhotoUploadProgress",[gender=>~$GENDER`,username=>~$USERNAME`,selectTemplate=>~$selectTemplate`,alreadyPhotoCount=>~$alreadyPhotoCount`,profilepicurl=>~$profilepicurl`,selectFile=>~$selectFile`,privacy=>~$privacy`,selectFileOrNot=>~$selectFileOrNot`,picturecheck=>~$picturecheck`])`
</div>
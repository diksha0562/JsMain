<div class="lf" style="width:44%;margin-left:35px;">
~if $MSTATUS`
<div class="row2 no_b ">
<label>Marital Status</label><div class="rf wgy5f ~$CODEOWN.MSTATUS`"  style="position:relative">: ~if $Annulled_Reason && $PRINT neq '1'`<span onmouseover="annulled_show()" ~if $MSTATUS eq 'Awaiting Divorce'`style="border-bottom: 3px double rgb(255, 102, 0); color: rgb(255, 102, 0); position: relative;width:107px;padding:0px;"~else`style="border-bottom: 3px double rgb(255, 102, 0); color: rgb(255, 102, 0); position: relative;width:57px;padding:0px;"~/if`>~$MSTATUS`</span>
<div style="border: 1px none rgb(0, 0, 0); position: absolute; font:normal 12px arial; left: 20px; top: -140px; width: 281px; height: 142px; z-index: 1501; background-image: url(~sfConfig::get('app_img_url')`/profile/images/annulled_mess.gif); display: none;" id="annulled_reason"><br/>
<div align="right" style="text-decoration: none; padding-right: 16px;"><a onclick="javascript:annulled_hide()" style="cursor: pointer;"><img title="close" src="~sfConfig::get('app_img_url')`/img_revamp/close.png"/></a></div>
<div style="overflow: auto; position: absolute; left: 16px; top: 30px; width: 251px; height: 80px; z-index: 1000; visibility: visible;" class="bele" id="Layer2">~$Annulled_Reason`</div>
</div>
~else`
~$MSTATUS`
~/if`
</div></div>
~/if`
~if $MSTATUS neq 'Never Married' &&  $CHILDREN neq ''`
<div class="row2 no_b ">
<label>Have Children  </label><div class="rf wgy5f ~$CODEOWN.HAVECHILD`" >: ~$CHILDREN`
</div></div>
~/if`
~if $EDU_LEVEL_NEW`
<div class="row2 no_b ">
<label>Education  </label><div class="rf wgy5f ~$CODEOWN.ELEVEL_NEW`" >: ~$EDU_LEVEL_NEW`
</div></div>
~/if`
~if $OCCUPATION`
<div class="row2 no_b ">
<label>Occupation </label><div class="rf wgy5f ~$CODEOWN.OCCUPATION`" >: ~if $PROFILELINK['OCC_LINK'] eq ''` ~$OCCUPATION`  ~else` <a href="~$PROFILELINK['OCC_LINK']`" style="color:#5E5E5E">~$OCCUPATION` </a> ~/if`
</div></div>
~/if`
~if $CITY_RES ||  $COUNTRY_RES`
<div class="row2 no_b "><label>Location</label><div class="rf wgy5f">: <span class="~$CODEOWN.CITYRES`" style="padding:0px;margin:0px;width:auto">~if $PROFILELINK['CITY_LINK'] eq '' && $PROFILELINK['STATE_LINK'] eq ''`~$CITY_RES`~else if $PROFILELINK['CITY_LINK'] neq ''` <a href="~$PROFILELINK['CITY_LINK']`" style="color:#5E5E5E">~$CITY_RES`</a> ~else` <a href="~$PROFILELINK['STATE_LINK']`" style="color:#5E5E5E">~$CITY_RES`</a>~/if`</span>~if $COUNTRY_RES neq ''`<span class="~$CODEOWN.COUNTRYRES`" style="padding:0px;margin:0px;width:auto">~if $CITY_RES neq ''`,~/if`~if $PROFILELINK['COUNTRY_LINK'] eq ''` ~$COUNTRY_RES`  ~else` <a href="~$PROFILELINK['COUNTRY_LINK']`" style="color:#5E5E5E">~$COUNTRY_RES` </a> ~/if`</span>~/if`
</div></div>
~/if`
~if $INCOME`
<div class="row2 no_b ">
<label>Annual Income</label><div class="rf wgy5f ~$CODEOWN.INCOME`" >: ~if $INCOME eq ''` - ~else` ~$INCOME` ~/if` 
</div></div>
~/if`

~if $religionSelf eq 'Hindu'`
~if $GOTHRA`
<div class="row2 no_b ">
<label>Gothra (Paternal)</label><div class="rf wgy5f" >: ~$GOTHRA`
</div></div>
~/if`
~/if`
~if $religionSelf eq 'Hindu'`
~if $GOTHRA_MATERNAL`
<div class="row2 no_b ">
<label>Gothra (Maternal)</label><div class="rf wgy5f" >: ~$GOTHRA_MATERNAL`
</div></div>
~/if`
~/if`
~if $RELATION`
<div class="row2 no_b ">
<label>Managed By</label><div class="rf wgy5f" >: ~$RELATION`
</div></div>
~/if`
<div class="row2 no_b " style="text-align:left;">
</div></div>

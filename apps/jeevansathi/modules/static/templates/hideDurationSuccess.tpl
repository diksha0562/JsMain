<div id="mainContent">
  <div class="loader" id="pageloader"></div>
  <div> 
    <!--start:top-->
    <div class="bg1 txtc pad15">
      <div class="posrel">
        <div class="fontthin f20 white">Profile Hidden</div>
        <a href="/static/settings"><i class="mainsp posabs set_arow1 set_pos1"></i></a> </div>
    </div>
    <!--end:top--> 
    <!--start:option-->
    <div class="pad18 bg4 f16 fontlig color13 " align="center"> 
      <div>~$hideText`</div>
    </div>

    <div class="txtc set_btmlink pt15">
      ~if $webView eq 1`  
        <div><a href="/myhome">Go To Home</a></div>
      ~else`
        <div><a href="/">Go To Home</a></div>
       ~/if`
    </div>
</div>
  <script>
    var webView = '~$webView`';
</script>


<link rel="stylesheet" href="~sfConfig::get('app_img_url')`/jsadmin/jeevansathi.css" type="text/css">
<link rel="stylesheet" href="~sfConfig::get('app_img_url')`/profile/images/styles.css" type="text/css">




~include_partial('global/header')`
<br><br>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr class="formhead" align="center" width="100%">
        <td colspan="3"  height="30">
            <font size=3>RM Interface</font>
        </td>
    </tr>
    ~assign var=num value=1`
    <tr>
        <td>
            ~$num++`.&nbsp;&nbsp;<a href="/operations.php/jsexclusive/welcomeCalls/">WELCOME CALLS DUE</a>
        </td>
    </tr>
    <br>
    <tr>
        <td>
            ~$num++`.&nbsp;&nbsp;<a href="/operations.php/crmInterface/serviceActivationChangeInterface?name=~$name`&cid=~$cid`">Today's Clients ( Ask for Followups )</a>
        </td>
    </tr>
    <br>
    <tr>
        <td>
            ~$num++`.&nbsp;&nbsp;<a href="/operations.php/jsexclusive/screenRBInterests?name=~$name`&cid=~$cid`">Screen RB interests - ~$unscreenedClientsCount`</a>
        </td>
    </tr>
    <br>
    <tr>
        <td>
            ~$num++`.&nbsp;&nbsp;<a href="/operations.php/crmInterface/serviceActivationChangeInterface?name=~$name`&cid=~$cid`">Pending Concalls</a>
        </td>
    </tr>
</table>


~include_partial('global/footer')`


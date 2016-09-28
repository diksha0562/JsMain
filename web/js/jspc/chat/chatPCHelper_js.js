/*This file includes functions used for intermediate data transfer for JSPC chat from 
 * chat client(chatStrophieClient_js.js) to chat plugin(chat_js.js)
 */
var listingInputData = [],
    listCreationDone = false,
    objJsChat, pass, username,
    pluginId = '#chatOpenPanel',
    device = 'pc',
    loggingEnabledPC = false,
    clearTimedOut,
    localStorageExists = isStorageExist();
/*handle chat disconnection case
 */
function handleChatDisconnection() {
    //show error msg--design
    //console.log("disconnected from chat,reconnecting..");
    //reconnect to chat
    if (username && pass) {
        strophieWrapper.reconnect(chatConfig.Params[device].bosh_service_url, username, pass);
    }
}

/*manageHistoryLoader
*show/hide loader for msg history
*@params:user_jid,type
*/
function manageHistoryLoader(user_jid,type){
    if(typeof user_jid!= "undefined"){
        var user_id = user_jid.split("@")[0];
        if(type == "show" && $('chat-box[user-id="' + user_id + '"] .spinner').is(":visible") == false){
            $('chat-box[user-id="' + user_id + '"] .spinner2').removeClass("disp-none");
        } else if(type == "hide") {
            $('chat-box[user-id="' + user_id + '"] .spinner2').addClass("disp-none");
        }
    }
}
function chatLoggerPC(msgOrObj) {
    /*
    if (loggingEnabledPC) {
        if (typeof (window.console) != 'undefined') {
            try {
                throw new Error('Initiate Stack Trace');
            } catch (err) {
                var logStack = err.stack;
            }
            var fullTrace = logStack.split('\n');
            for (var i = 0; i < fullTrace.length; ++i) {
                fullTrace[i] = fullTrace[i].replace(/\s+/g, ' ');
            }
            var caller = fullTrace[1],
                callerParts = caller.split('@'),
                line = '';
            //CHROME & SAFARI
            if (callerParts.length == 1) {
                callerParts = fullTrace[2].split('('), caller = false;
                //we have an object caller
                if (callerParts.length > 1) {
                    caller = callerParts[0].replace('at Object.', '');
                    line = callerParts[1].split(':');
                    line = line[2];
                }
                //called from outside of an object
                else {
                    callerParts[0] = callerParts[0].replace('at ', '');
                    callerParts = callerParts[0].split(':');
                    caller = callerParts[0] + callerParts[1];
                    line = callerParts[2];
                }
            }
            //FIREFOX
            else {
                var callerParts2 = callerParts[1].split(':');
                line = callerParts2.pop();
                callerParts[1] = callerParts2.join(':');
                caller = (callerParts[0] == '') ? callerParts[1] : callerParts[0];
            }
            //console.log(' ');
            console.warn('Console log: ' + caller + ' ( line ' + line + ' )');
            //console.log(msgOrObj);
            console.log({
                'Full trace:': fullTrace
            });
            //console.log(' ');
        } else {
            //shout('This browser does not support //console.log!')
        }
    }
    */
}

/*open chatbox from search listing or view profile page
*@inputs:profilechecksum,detailsArr
*/
function openNewJSChat(profilechecksum,detailsArr){
    if(typeof profilechecksum!= "undefined" && typeof detailsArr!= "undefined"){
        var groupid = chatConfig.Params.groupIDMapping[detailsArr[3]];
        if(typeof groupid == "undefined"){
            groupid = "mysearch";
        }
        var jid=detailsArr[1]+"@"+openfireServerName,
            data= {"rosterDetails":
                    {
                        "jid":jid ,
                        "chat_status": "online",
                        "nick": detailsArr[0]+"|"+profilechecksum,
                        "fullname": detailsArr[0],
                        "groups": [groupid],
                        "subscription": "to",
                        "profile_checksum": profilechecksum,
                        "listing_tuple_photo": detailsArr[2],
                        "last_online_time": null,
                        "ask": null
                    }
                },
            nodeArr=[];
        nodeArr[detailsArr[1]] = data;

        var output = objJsChat.checkForNodePresence(detailsArr[1]);
        var alreadyExists = output["exists"];
        if(alreadyExists == true){
           groupid = output["groupID"];  
        }
        //console.log("added......",alreadyExists);
        if(alreadyExists == false){
            //create hidden element in chat listing
            objJsChat.createHiddenListNode(nodeArr);
          
            //write in localstorage
        	localStorage.setItem('jsNoRosterChat_'+detailsArr[1],JSON.stringify(data));
        }
        //open chat box
        objJsChat._chatPanelsBox(detailsArr[1],"online",jid,profilechecksum, groupid);
    } 
}

function retainHiddenListing(){
    var nodeArr = [];
    for (var i = 0; i < localStorage.length; i++){
        var key = localStorage.key(i);
        if(key && key.indexOf('jsNoRosterChat_')!='-1')
        {
            var nodeData = localStorage.getItem(key);
            nodeArr[key.split("_")[1]] = JSON.parse(nodeData);
        }
    }
    objJsChat.createHiddenListNode(nodeArr);
}

function removeLocalStorageForNonChatBoxProfiles(id)
{
	if(id)
	{
	    localStorage.removeItem('jsNoRosterChat_'+id);
	}
	else
	{
		for (var i = 0; i < localStorage.length; i++){
			var key = localStorage.key(i);
			if(key && key.indexOf('jsNoRosterChat_')!='-1')
			{
	        	localStorage.removeItem(key);
			}
		}
	}
}

/*getMessagesFromLocalStorage
 * Fetch messages from local storage
 */
function getMessagesFromLocalStorage(selfJID, other_id){
    var page = parseInt($("#moreHistory_"+other_id).attr("data-page"));
    
    $("#moreHistory_"+other_id).attr("data-page",page+1);
    var chunk = chatConfig.Params[device].moreMsgChunk;
    var oldMessages = JSON.parse(localStorage.getItem('chatMsg_'+selfJID+'_'+other_id));
    if(oldMessages){
        var pc = page*chunk;
        var messages = [];
        var oldMsgLength = oldMessages.length
        var limit = Math.min(pc+chunk,oldMsgLength);
        if(oldMsgLength>limit){
            $("#moreHistory_"+other_id).attr("data-localMsg","1");
        }
        else{
            $("#moreHistory_"+other_id).attr("data-localMsg","0");
        }
        for(var i=pc;i<limit;i++){
            messages.push(oldMessages[i]);
        }
    }
    else{
        $("#moreHistory_"+other_id).attr("data-localMsg","0");
    }
    return messages;
}

/*getChatHistory
 * fetch chat history on opening window again
 * @inputs: chatParams
 * @output: response
 */
function getChatHistory(apiParams,key) {
    var postData = {},setLocalStorage=false,fetchFromLocalStorage = false,oldHistory;
    var bare_from_jid = apiParams["extraParams"]["from"].split("/")[0],bare_to_jid = apiParams["extraParams"]["to"].split("/")[0];
    if (typeof apiParams["extraParams"] != "undefined") {
        $.each(apiParams["extraParams"], function (key, value) {
            postData[key] = value;
        });
        if(typeof apiParams["extraParams"]["messageId"] == "undefined"){
            //console.log("no messageId");
            if(chatConfig.Params[device].storeMsgInLocalStorage == true){
                oldHistory = localStorage.getItem("chatHistory_"+bare_from_jid+"_"+bare_to_jid);
                //console.log("oldHistory");
               
                if(typeof oldHistory!= "undefined"){
                    fetchFromLocalStorage = true;
                }
                setLocalStorage = true;
            }
        }
        else{
            fetchFromLocalStorage = false;
        }
    }
    /*var messageFromLocalStorage = getMessagesFromLocalStorage(apiParams["extraParams"]["from"].split("@")[0], apiParams["extraParams"]["to"].split("@")[0]);
    if(!(messageFromLocalStorage == undefined || messageFromLocalStorage == null || messageFromLocalStorage.length  == 0)){
        manageHistoryLoader(bare_to_jid,"hide");
        //call plugin function to append history in div
        objJsChat._appendChatHistory(apiParams["extraParams"]["from"], apiParams["extraParams"]["to"], messageFromLocalStorage,key);
    }
    else{*/
        //console.log("api for history");

        if (typeof chatConfig.Params.chatHistoryApi["extraParams"] != "undefined") {
            $.each(chatConfig.Params.chatHistoryApi["extraParams"], function (k, v) {
                postData[k] = v;
            });
        }
        $.myObj.ajax({
            url: chatConfig.Params.chatHistoryApi["apiUrl"],
            dataType: 'json',
            type: 'POST',
            data: JSON.stringify(postData),
            cache: false,
            async: true,
            beforeSend: function (xhr) {},
            success: function (response) {
                if (response["responseStatusCode"] == "0") {
                    //console.log("history");
                    ////console.log($.parseJSON(response["Message"]));
                    if (typeof response["Message"] != "undefined") {
                        if(setLocalStorage == true){
                            localStorage.setItem("chatHistory_"+bare_from_jid+"_"+bare_to_jid,response["Message"]);
                        }
                        //console.log("setting pagination-"+response["pagination"]);
                        if(response["pagination"] == 0){

                            //console.log("no more history");
                            $("#moreHistory_"+bare_to_jid.split("@")[0]).val("0");
                        }
                        else{
                            $("#moreHistory_"+bare_to_jid.split("@")[0]).val("1");
                        }
                        manageHistoryLoader(bare_to_jid,"hide");
                        //call plugin function to append history in div
                        objJsChat._appendChatHistory(apiParams["extraParams"]["from"], apiParams["extraParams"]["to"], $.parseJSON(response["Message"]),key,response["canChat"]);
                        //objJsChat.storeMessagesInLocalHistory(apiParams["extraParams"]["from"].split('@')[0],apiParams["extraParams"]["to"].split('@')[0],$.parseJSON(response["Message"]),'history');
                    }
                    else{
                        $("#moreHistory_"+bare_to_jid.split("@")[0]).val("0");
                        manageHistoryLoader(bare_to_jid,"hide");
                    }
                }
                else{
                    manageHistoryLoader(bare_to_jid,"hide");
                    checkForSiteLoggedOutMode(response);
                }
            },
            error: function (xhr) {
                manageHistoryLoader(bare_to_jid,"hide");
                //return "error";
            }
        });
   // }
}

/*generateChatHistoryID
* @inputs: key("self"/"other")
*/
function generateChatHistoryID(key){
    var msg_id = strophieWrapper.getUniqueId();
    /*if(key == "sent"){
        msg_id = msg_id + "_self";
    }
    else{
        msg_id = msg_id + "_other";
    }*/
    return msg_id;
}

/*
 * request self name
 * @inputs none
 * @returns self name / username
 */
function getSelfName(){
    var selfName = localStorage.getItem('name'),
        flag = true;
    if (selfName) {
        var data = JSON.parse(selfName);
        var user = data['user'];
        if (user == loggedInJspcUser) {
            flag = false;
            selfName = data['selfName'];
        }
    }
    if(flag){
        var apiUrl = chatConfig.Params.selfNameUr;
        ////console.log("In self Name");
        $.myObj.ajax({
            url: apiUrl,
            async: false,
            success: function (response) {
                if (response["responseStatusCode"] == "0") {
                    selfName = response["name"];
                    ////console.log("Success In self Name",selfName);
                    localStorage.setItem('name', JSON.stringify({
                        'selfName': selfName,
                        'user': loggedInJspcUser
                    }));
                }
                else {
                    checkForSiteLoggedOutMode(response);
                }
            },
            error: function (xhr) {
                //return "error";
            }
        });
        ////console.log("ReturnIn self Name");
    }
    return selfName;
}

function checkForSiteLoggedOutMode(response){
    if(typeof response != "undefined" && response["responseStatusCode"] == "9"){
        window.location.href = "/";
    }
}

/*fetch membership status of current user
@return : membership
*/
function getMembershipStatus(){
    var membership = localStorage.getItem("self_subcription");
    //console.log("membership",membership);
    if(!membership){
        //console.log("not exists");
        if(self_subcription){
            localStorage.setItem("self_subcription",self_subcription);
            membership = self_subcription;
        }
    }
    if(membership && membership!= "Free"){
        return "Paid";
    }
    else{
        return "Free";
    }
}

/* requestListingPhoto
 * request listing photo through api
 * @inputs: apiParams
 * @return: response
 */
function requestListingPhoto(apiParams) {
    var apiUrl = chatConfig.Params.photoUrl;
    var newApiParamsPid = [];
    var exsistParamPid = [];
    var pid = [];
    pid = apiParams.pid.split(",");
    $.each(pid,function(index, elem){
        if(localStorage.getItem("listingPic_"+elem)) {
            var timeStamp = localStorage.getItem("listingPic_"+elem).split("#")[1];
            if(new Date().getTime() - timeStamp > chatConfig.Params[device].clearListingCacheTimeout){
                newApiParamsPid.push(elem);
            } 
            else{
                exsistParamPid.push(elem);
            }
        }
        else {
          newApiParamsPid.push(elem);
        }
    });
    var newApiParams;
    if(newApiParamsPid.length != 0) {
        newApiParams = {"pid":newApiParamsPid.toString(),"photoType":apiParams.photoType};
    }
    
    if (typeof newApiParams != "undefined" && newApiParams) {
        $.myObj.ajax({
            url: apiUrl,
            dataType: 'json',
            type: 'POST',
            data: newApiParams,
            timeout: 60000,
            cache: false,
            beforeSend: function (xhr) {},
            success: function (response) {
                if (response["statusCode"] == "0") {
                    //response = {"message":"Successful","statusCode":"0","profiles":{"a1":{"PHOTO":{"ProfilePic120Url":"https://secure.gravatar.com/avatar/ef65f74b4aa2107469060e6e8b6d9478?s=48&r=g&d=monsterid","MainPicUrl":"http:\/\/172.16.3.185\/1092\/13\/21853681-1397620904.jpeg"}},"a2":{"PHOTO":{"ProfilePic120Url":"https://secure.gravatar.com/avatar/ce41f41832224bd81f404f839f383038?s=48&r=g&d=monsterid","MainPicUrl":"http:\/\/172.16.3.185\/1140\/6\/22806868-1402139087.jpeg"}},"a3":{"PHOTO":{"ProfilePic120Url":"https://avatars0.githubusercontent.com/u/46974?v=3&s=96","MainPicUrl":"http:\/\/172.16.3.185\/1153\/15\/23075984-1403583209.jpeg"}},"a6":{"PHOTO":{"ProfilePic120Url":"","MainPicUrl":"http:\/\/xmppdev.jeevansathi.com\/uploads\/NonScreenedImages\/mainPic\/16\/29\/15997035ii6124c9f1a0ee0d7c209b7b81c3224e25iic4ca4238a0b923820dcc509a6f75849b.jpg"}},"a4":{"PHOTO":""}},"responseStatusCode":"0","responseMessage":"Successful","AUTHCHECKSUM":null,"hamburgerDetails":null,"phoneDetails":null};
                    $.each(response.profiles,function(index2, elem2){
                        localStorage.setItem("listingPic_"+index2,elem2.PHOTO.ProfilePic120Url+"#"+new Date().getTime());
                    });
                    objJsChat._addListingPhoto(response, "api");
                    objJsChat._addListingPhoto(exsistParamPid, "local");
                }
                else{
                    checkForSiteLoggedOutMode(response);
                }
            },
            error: function (xhr) {
                //return "error";
            }
        });
    } else {
        objJsChat._addListingPhoto(exsistParamPid, "local");
    }
}
/*function initiateChatConnection
 * request sent to openfire to initiate chat and maintain session
 * @params:none
 */
function initiateChatConnection() {
    username = loggedInJspcUser + '@' + openfireServerName;
    /*if(readCookie("CHATUSERNAME")=="ZZXS8902")
        username = 'a1@localhost';
    else if(readCookie("CHATUSERNAME")=="bassi")
        username = '1@localhost';
    else if(readCookie("CHATUSERNAME")=="VWZ4557")
        username = 'a9@localhost';
    else if(readCookie("CHATUSERNAME")=="ZZTY8164")
        username = 'a2@localhost';
    else if(readCookie("CHATUSERNAME") == "ZZRS3292")
        username = 'a13@localhost';
    else if(readCookie("CHATUSERNAME")=="ZZVV2929")
        username = 'a14@localhost';
    else if(readCookie("CHATUSERNAME")=="ZZRR5723")
        username = 'a11@localhost';
    pass = '123';*/
    
    strophieWrapper.connect(chatConfig.Params[device].bosh_service_url, username, pass);
 
}
/*getConnectedUserJID
 * get jid of connected user
 * @inputs: none
 * @return jid
 */
function getConnectedUserJID() {
    var jid = strophieWrapper.connectionObj.jid;
    if (typeof jid != "undefined") {
        //return jid.split("/")[0];
        return jid;
    } else {
        return null;
    }
}
/*xmlToJson
 * converts xml stanza to json
 * @inputs: xml
 * @return: obj
 */
function xmlToJson(xml) {
    // Create the return object
    var obj = {};
    if (xml.nodeType == 1) { // element
        // do attributes
        if (xml.attributes.length > 0) {
            obj["attributes"] = {};
            for (var j = 0; j < xml.attributes.length; j++) {
                var attribute = xml.attributes.item(j);
                obj["attributes"][attribute.nodeName] = attribute.nodeValue;
            }
        }
    } else if (xml.nodeType == 3) { // text
        obj = xml.nodeValue;
    }
    // do children
    if (xml.hasChildNodes()) {
        for (var i = 0; i < xml.childNodes.length; i++) {
            var item = xml.childNodes.item(i);
            var nodeName = item.nodeName;
            if (typeof (obj[nodeName]) == "undefined") {
                obj[nodeName] = xmlToJson(item);
            } else {
                if (typeof (obj[nodeName].push) == "undefined") {
                    var old = obj[nodeName];
                    obj[nodeName] = [];
                    obj[nodeName].push(old);
                }
                obj[nodeName].push(xmlToJson(item));
            }
        }
    }
    return obj;
}
/*invokePluginLoginHandler
 *handles login success/failure cases
 * @param: state
 */
function invokePluginLoginHandler(state) {
    if (state == "success") {
        createCookie("chatAuth", "true",chatConfig.Params[device].loginSessionTimeout);
        //setLogoutClickLocalStorage("unset");
        if(objJsChat && objJsChat.manageLoginLoader && typeof (objJsChat.manageLoginLoader) == "function"){
            objJsChat._appendLoggedHTML();
        }
    } else if (state == "failure") {
        eraseCookie("chatAuth");
        setLogoutClickLocalStorage("set");
        if(objJsChat && objJsChat.manageLoginLoader && typeof (objJsChat.manageLoginLoader) == "function"){
            objJsChat.addLoginHTML(true);
            objJsChat.manageLoginLoader();
        }
    } else if (state == "session_sync") {
        if ($(objJsChat._logoutChat).length != 0 && readCookie('chatAuth') != "true") {
            $(objJsChat._logoutChat).click();
        }
        if ($(objJsChat._loginbtnID).length != 0 && readCookie('chatAuth') == "true"){
            $(objJsChat._loginbtnID).click();
        }
    } else if(state == "manageLogout"){
        if(localStorage.getItem('cout') == "1"){
            $(objJsChat._logoutChat).click();
        }
    } else if(state == "autoChatLogin"){
        //console.log("ankita",localStorage.getItem("logout_"+loggedInJspcUser));
        if(localStorage.getItem("logout_"+loggedInJspcUser) != "true"){
            //console.log("yes");
            if($(objJsChat._loginbtnID).length != 0){
                $(objJsChat._loginbtnID).click();
            }
        }
    }
}
/*invokePluginAddlisting
function to add roster item or update roster item details in listing
* @inputs:listObject,key(create_list/add_node/update_status),user_id(optional)
*/
function invokePluginManagelisting(listObject, key, user_id) {
    if (key == "add_node" || key == "create_list") {
        if (key == "create_list") {
            objJsChat.manageChatLoader("hide");
        }
        objJsChat.addListingInit(listObject,key);
        if (key == "add_node") {
            var newGroupId = listObject[user_id][strophieWrapper.rosterDetailsKey]["groups"][0];
            //update chat box content if opened
            //console.log("adding ankita4",newGroupId);
            objJsChat._updateChatPanelsBox(user_id, newGroupId);
            
        }
        if (key == "create_list") {
            objJsChat.noResultError();
        }
    } else if (key == "update_status") {
        //update existing user status in listing
        if (typeof user_id != "undefined") {
            if (listObject[user_id][strophieWrapper.rosterDetailsKey]["chat_status"] == "offline") { //from online to offline
                
                objJsChat._removeFromListing("removeCall1", listObject);
            } else if (listObject[user_id][strophieWrapper.rosterDetailsKey]["chat_status"] == "online") { //from offline to online
             
                objJsChat.addListingInit(listObject,key);
            }
        }
    } else if (key == "delete_node") {
        
        //remove user from roster in listing
        if (typeof user_id != "undefined") {
            
            objJsChat._removeFromListing('delete_node', listObject);
            objJsChat.setListMigratedFlag(user_id);
            objJsChat._disableChatPanelsBox(user_id);
            $('#' + user_id + '_hover').remove();
        }
    }
}

function createCookie(name, value, days) {
    var expires;
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    } else {
        expires = "";
    }
    document.cookie = escape(name) + "=" + escape(value) + expires + "; path=/";
}

function readCookie(name) {
    var nameEQ = escape(name) + "=",
        ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) === ' ') {
            c = c.substring(1, c.length);
        }
        if (c.indexOf(nameEQ) === 0) {
            return unescape(c.substring(nameEQ.length, c.length));
        }
    }
    return null;
}

function eraseCookie(name) {
    createCookie(name, "", -1);
}

function checkEmptyOrNull(item) {
    if (item != undefined && item != null && item != "") {
        return true;
    } else {
        return false;
    }
}
 
function checkNewLogin(profileid) {
    var computedChatEncrypt = CryptoJS.MD5(profileid);
    if (checkEmptyOrNull(readCookie('chatEncrypt'))) {
        var existingChatEncrypt = readCookie('chatEncrypt');
        if (existingChatEncrypt != computedChatEncrypt) {
            eraseCookie('chatAuth');
            eraseCookie('chatEncrypt');
            createCookie('chatEncrypt', computedChatEncrypt,chatConfig.Params[device].loginSessionTimeout);
            setLogoutClickLocalStorage("unset");
            clearChatMsgFromLS();
            localStorage.removeItem('chatBoxData');
            localStorage.removeItem('lastUId');
        }
    } else {
        createCookie('chatEncrypt', computedChatEncrypt,chatConfig.Params[device].loginSessionTimeout);
        //setLogoutClickLocalStorage("unset");
    }
}

function checkAuthentication(timer,loginType) {
    var auth;
    var d = new Date();
    var n = d.getTime();
    //console.log("timestamp",n);
    $.ajax({
        url: "/api/v1/chat/chatUserAuthentication?p="+n,
        async: false,
        success: function (data) {
            if (data.responseStatusCode == "0") {
                if(typeof data.hash !== 'undefined'){
                    auth = 'true';
                    pass = data.hash;
                    if(objJsChat && objJsChat.manageLoginLoader && typeof (objJsChat.manageLoginLoader) == "function"){
                        objJsChat.manageLoginLoader();
                    }
                    if(loginType == "first"){
                        initiateChatConnection();
                        objJsChat._loginStatus = 'Y';
                        objJsChat._startLoginHTML();
                    }
                }
                else{
                    if(timer<(chatConfig.Params[device].appendRetryLimit*4)){
                        setTimeout(function(){
                            checkAuthentication(timer+chatConfig.Params[device].appendRetryLimit,loginType);
                        },timer);
                    }
                    else{
                        auth = 'false';
                        invokePluginLoginHandler("failure");
                        if(objJsChat && objJsChat.manageLoginLoader && typeof (objJsChat.manageLoginLoader) == "function"){
                            objJsChat.manageLoginLoader();
                        }
                    }
                }
                localStorage.removeItem("cout");
                
                /*pass = JSON.parse(CryptoJS.AES.decrypt(data.hash, "chat", {
                    format: CryptoJSAesJson
                }).toString(CryptoJS.enc.Utf8));
                */
            } else {
                auth = 'false';
                checkForSiteLoggedOutMode(data);
                invokePluginLoginHandler("failure");
            }
        },
        error: function (xhr) {
                auth = 'false';
                invokePluginLoginHandler("failure");
                if(objJsChat && objJsChat.manageLoginLoader && typeof (objJsChat.manageLoginLoader) == "function"){
                    objJsChat.manageLoginLoader();
                }
                //return "error";
        }
    });
    return auth;
}

function logoutChat() {
    strophieWrapper.disconnect();
    eraseCookie("chatAuth");
    //console.log("setting");
    setLogoutClickLocalStorage("set");
    removeLocalStorageForNonChatBoxProfiles();
}
/*invokePluginReceivedMsgHandler
 * invokes msg handler function of plugin
 *@params :msgObj
 */
function invokePluginReceivedMsgHandler(msgObj) {
    ////console.log("in invokePluginReceivedMsgHandler");
    ////console.log(msgObj);
    if (typeof msgObj["from"] != "undefined") {
        if (typeof msgObj["body"] != "undefined" && msgObj["body"] != "" && msgObj["body"] != null && msgObj['msg_state'] != strophieWrapper.msgStates["FORWARDED"]) {
            ////console.log("appending RECEIVED");
            objJsChat._appendRecievedMessage(msgObj["body"], msgObj["from"], msgObj["msg_id"],msgObj["msg_type"]);
        }
        if (typeof msgObj["msg_state"] != "undefined") {
            switch (msgObj['msg_state']) {
            case strophieWrapper.msgStates["RECEIVED"]:
                objJsChat._changeStatusOfMessg(msgObj["receivedId"], msgObj["from"], "recieved");
                break;
            case strophieWrapper.msgStates["COMPOSING"]:
                objJsChat._handleMsgComposingStatus(msgObj["from"], strophieWrapper.msgStates["COMPOSING"]);
                break;
            case strophieWrapper.msgStates["PAUSED"]:
                objJsChat._handleMsgComposingStatus(msgObj["from"], strophieWrapper.msgStates["PAUSED"]);
                break;
            case strophieWrapper.msgStates["RECEIVER_RECEIVED_READ"]:
                strophieWrapper.sendReceivedReadEvent(msgObj["from"], msgObj["to"], msgObj["msg_id"], strophieWrapper.msgStates["RECEIVER_RECEIVED_READ"]);
                break;
            case strophieWrapper.msgStates["SENDER_RECEIVED_READ"]:
                objJsChat._changeStatusOfMessg(msgObj["msg_id"], msgObj["from"], "recievedRead");
                break;
            case strophieWrapper.msgStates["FORWARDED"]:
                if (typeof msgObj["body"] != "undefined" && msgObj["body"] != "" && msgObj["body"] != null) {
                    if (msgObj["forward_jid"] != strophieWrapper.getSelfJID()) objJsChat._appendSelfMessage(msgObj["body"], msgObj["to"], msgObj["msg_id"], "recieved");
                }
                break;
            }
            /*if(msgObj['msg_state'] == "received"){
                objJsChat._changeStatusOfMessg(msgObj["receivedId"],msgObj["from"],"recievedRead");
            }*/
        }
    }
}

/*update last read msg in localstorage
 * @params:user_id,msg_id
 */
function setLastReadMsgStorage(user_id,msg_id){
    if(typeof msg_id != "undefined"){
        localStorage.setItem("last_read_msg_"+user_id,msg_id);
    }
}

/*fetch last read msg id from localstorage
 * @params:user_id
 */
function fetchLastReadMsgFromStorage(user_id){
    var last_id = localStorage.getItem("last_read_msg_"+user_id);
    if(last_id && last_id!= "")
        return last_id;
    else
        return null;
}

/*send typing state to receiver through openfire
 * @params:from,to,typing_state
 */
function sendTypingState(from, to, typing_state) {
    strophieWrapper.typingEvent(from, to, typing_state);
}
var CryptoJSAesJson = {
        stringify: function (cipherParams) {
            var j = {
                ct: cipherParams.ciphertext.toString(CryptoJS.enc.Base64)
            };
            if (cipherParams.iv) {
                j.iv = cipherParams.iv.toString();
            }
            if (cipherParams.salt) {
                j.s = cipherParams.salt.toString();
            }
            return JSON.stringify(j);
        },
        parse: function (jsonStr) {
            var j = JSON.parse(jsonStr);
            var cipherParams = CryptoJS.lib.CipherParams.create({
                ciphertext: CryptoJS.enc.Base64.parse(j.ct)
            });
            if (j.iv) {
                cipherParams.iv = CryptoJS.enc.Hex.parse(j.iv);
            }
            if (j.s) {
                cipherParams.salt = CryptoJS.enc.Hex.parse(j.s);
            }
            return cipherParams;
        }
    }
    /*
     * Function to get profile image for login state
     */
function getProfileImage() {
    var imageUrl = localStorage.getItem('userImg'),
        flag = true;
    var d = new Date();
    var n = d.getTime();
    if (imageUrl) {
        var data = JSON.parse(imageUrl);
        var user = data['user'];
        if (user == loggedInJspcUser) {
            flag = false;
            imageUrl = data['img'];
        }
    }
    if (flag) {
        $.ajax({
            url: chatConfig.Params.photoUrl + "?photoType=ProfilePic120Url&t="+n,
            async: false,
            success: function (data) {
                if (data.statusCode == "0") {
                    imageUrl = data.profiles[0].PHOTO.ProfilePic120Url;
                    if (typeof imageUrl == "undefined" || imageUrl == "") {
                        if (loggedInJspcGender) {
                            if (loggedInJspcGender == "F") {
                                imageUrl = chatConfig.Params[device].noPhotoUrl["self120"]["F"];
                            } else if (loggedInJspcGender == "M") {
                                imageUrl = chatConfig.Params[device].noPhotoUrl["self120"]["M"];
                            }
                        }
                    }
                    localStorage.setItem('userImg', JSON.stringify({
                        'img': imageUrl,
                        'user': loggedInJspcUser
                    }));
                }
                else{
                    checkForSiteLoggedOutMode(data);
                }
            }
        });
    }
    return imageUrl;
}

function clearChatMsgFromLS(){
    var patt1 = new RegExp("chatMsg_");
    var patt2 = new RegExp("listingPic_");
    for(var key in localStorage){
        if(patt1.test(key) || patt2.test(key)){
            localStorage.removeItem(key);
        }
    }
}
/*
 * Clear local storage
 */
function clearLocalStorage() {
    var removeArr = ['userImg','bubbleData'];
    $.each(removeArr, function (key, val) {
        localStorage.removeItem(val);
    });
    localStorage.removeItem('chatBoxData');
    localStorage.removeItem('lastUId');
    clearChatMsgFromLS();
}
/*hit api for chat before acceptance
 * @input: apiParams
 * @output: response
 */
function handlePreAcceptChat(apiParams,receivedJId) {
    
    var outputData = {};
    if (typeof apiParams != "undefined") {
        var postData = "";
        if (typeof apiParams["postParams"] != "undefined" && apiParams["postParams"]) {
            postData = apiParams["postParams"];
        }
        
        $.myObj.ajax({
            url: apiParams["url"],
            dataType: 'json',
            type: 'POST',
            data: postData,
            cache: false,
            async: false,
            beforeSend: function (xhr) {},
            success: function (response) {
                
                if (response["responseStatusCode"] == "0") {
                   // console.log(response);
                    if (response["actiondetails"]) {
                        if (response["actiondetails"]["errmsglabel"]) {
                            outputData["cansend"] = outputData["cansend"] || false;
                            outputData["sent"] = false;
                            outputData["errorMsg"] = response["actiondetails"]["errmsglabel"];
                            outputData["msg_id"] = apiParams["postParams"]["chat_id"];
                        } else {
                            outputData["cansend"] = true;
                            outputData["sent"] = true;
                            outputData["msg_id"] = apiParams["postParams"]["chat_id"];
                            outputData['eoi_sent'] = response['eoi_sent'];
                            strophieWrapper.sendMessage(apiParams.postParams.chatMessage,receivedJId,true,outputData["msg_id"]);
                        }
                    } else {
                        outputData = response;
                        outputData["msg_id"] = apiParams["postParams"]["chat_id"];
                        if(response["sent"] == true){
                            outputData['eoi_sent'] = response['eoi_sent'];
                            strophieWrapper.sendMessage(apiParams.postParams.chatMessage,receivedJId,true,outputData["msg_id"]);
                        }
                    }
                }
                else{
                    checkForSiteLoggedOutMode(response);
                }
            },
            error: function (xhr) {
              
                outputData["sent"] = false;
                outputData["cansend"] = true;
                outputData["errorMsg"] = "Something went wrong";
                //return "error";
            }
        });
    }
    return outputData;
}
/*
 * Handle error/info case from button click
 */
function handleErrorInHoverButton(jid, data) {
    
    if (data.buttondetails && (data.buttondetails.buttons || data.buttondetails.button)) {
        //data.actiondetails.errmsglabel = "You have exceeded the limit of the number of interests you can send";
        if (data.actiondetails.errmsglabel) {
            objJsChat.hoverButtonHandling(jid, data, "info");
        } else {
            //Change button text
            objJsChat.hoverButtonHandling(jid, data);
        }
    } else {
        objJsChat.hoverButtonHandling(jid, data, "error");
    }
}
/*call api on click on contact engine buttons in chat
 * @params:contactParams
 * @return: response
 */
function contactActionCall(contactParams) {
    var response;
    if (typeof contactParams != "undefined") {
        var receiverJID = contactParams["receiverJID"],
            action = contactParams["action"],
            checkSum = contactParams["checkSum"],
            trackingParams = contactParams["trackingParams"],
            extraParams = contactParams["extraParams"],
            nickName = contactParams["nickName"];
        var url = chatConfig.Params["actionUrl"][action],
            channel = device;
        
        /*if (device == 'PC') {
            channel = 'pc';
        }*/
        var postData = {};
        postData["profilechecksum"] = checkSum;
        postData["channel"] = channel;
        postData["pageSource"] = "chat";
        if (typeof trackingParams != "undefined") {
            $.each(trackingParams, function (key, val) {
                postData[key] = val;
            });
        }
        if (typeof extraParams != "undefined") {
            $.each(extraParams, function (k, v) {
                postData[k] = v;
            });
        }
        $.myObj.ajax({
            type: 'POST',
            async: false,
            dataType: 'json',
            data: postData,
            url: url,
            success: function (data) {
                response = data;
                
                if (response["responseStatusCode"] == "0") {
                    /*updateRosterOnChatContactActions({
                        "receiverJID": receiverJID,
                        "nickName": nickName,
                        "action": action
                    });*/
                }
                else if(response["responseStatusCode"] == "1" && action=='BLOCK')
                {
                    hideCommonLoader();
                    showCustomCommonError(response.responseMessage,5000);
                    return;
                    
                }
                else{
                    checkForSiteLoggedOutMode(response);
                }
            },
            error: function (xhr) {
                response = false;
               
            }
        });
    } else {
        response = false;
    }
    
    return response;
}
/*update roster on user action in chat(hover box/chat box) via Strophie
 *@params: rosterParams
 */
function updateRosterOnChatContactActions(rosterParams) {
    if (typeof rosterParams != "undefined") {
        var receiverJID = rosterParams["receiverJID"],
            action = rosterParams["action"],
            nickName = rosterParams["nickName"],
            user_id = receiverJID.split("@")[0];
        if (chatConfig.Params[device].updateRosterFromFrontend == true) {
            if (typeof receiverJID != "undefined" && receiverJID) {
                var nodeArr = [];
                nodeArr[user_id] = strophieWrapper.Roster[user_id];
                ////console.log("obj");
                ////console.log(strophieWrapper.Roster[user_id]);
                if (typeof nodeArr != "undefined") {
                    if (action == "ACCEPT" || action == "DECLINE" || action == "BLOCK" || action == "INITIATE") {
                        setTimeout(function () {
                            //console.log("removing list from frontend in case of consumer delay");
                            invokePluginManagelisting(nodeArr, "delete_node", user_id);
                        }, 10000);
                    }
                }
                /*switch (action) {
                    case "ACCEPT":
                        strophieWrapper.removeRosterItem(receiverJID);
                        strophieWrapper.addRosterItem({
                            "jid": receiverJID,
                            "groupid": chatConfig.Params.categoryNames["Acceptance"],
                            "subscription": chatConfig.Params.groupWiseSubscription[chatConfig.Params.categoryNames["Acceptance"]],
                            "nick": nickName
                        });
                        break;
                    case "UNBLOCK":
                        var user_id = receiverJID.split("@")[0];
                        var existingGroupId = objJsChat._fetchChatBoxGroupID(user_id),
                            groupArr = [];
                        groupArr.push(existingGroupId);
                        if (typeof existingGroupId != "undefined" && strophieWrapper.checkForGroups(groupArr) == true) {
                            strophieWrapper.addRosterItem({
                                "jid": receiverJID,
                                "groupid": existingGroupId,
                                "subscription": chatConfig.Params.groupWiseSubscription[existingGroupId],
                                "nick": nickName
                            });
                        }
                        break;
                    case "BLOCK":
                        strophieWrapper.removeRosterItem(receiverJID);
                        break;
                    case "DECLINE":
                        strophieWrapper.removeRosterItem(receiverJID);
                        break;
                    case "INITIATE":
                        strophieWrapper.removeRosterItem(receiverJID);
                        strophieWrapper.addRosterItem({
                            "jid": receiverJID,
                            "groupid": chatConfig.Params.categoryNames["Interest Sent"],
                            "subscription": chatConfig.Params.groupWiseSubscription[chatConfig.Params.categoryNames["Interest Sent"]],
                            "nick": nickName
                        });
                        break;
                }*/
            }
        }
    }
}

function globalSleep(milliseconds) {
    var start = new Date().getTime();
    for (var i = 0; i < 1e7; i++) {
        if ((new Date().getTime() - start) > milliseconds) {
            break;
        }
    }
}

function setLogoutClickLocalStorage(key){
    if(key == "set"){
        localStorage.setItem("logout_"+loggedInJspcUser,"true");
    }
    else{
        localStorage.removeItem("logout_"+loggedInJspcUser);
    }
}

$(document).ready(function () {
    //console.log("Doc ready");
    if(typeof loggedInJspcUser!= "undefined")
        checkNewLogin(loggedInJspcUser);
    var checkDiv = $("#chatOpenPanel").length;
    $("#HideID").on('click',function(){
        /*
         * Check added as on hide profile user is deleted from openfire and if cookie is set then cant reconnect
         */
        eraseCookie("chatAuth");

    });
    if (showChat && (checkDiv != 0)) {
        var chatLoggedIn = readCookie('chatAuth');
        var loginStatus;
        $("#jspcChatout").on('click',function(){
            localStorage.removeItem("self_subcription");
            $(objJsChat._logoutChat).attr("data-siteLogout","true");
            $(objJsChat._logoutChat).click();
            //setLogoutClickLocalStorage("unset");  
        });
        
        $(window).focus(function() {
            invokePluginLoginHandler("manageLogout");
            if(strophieWrapper.synchronize_selfPresence == true){
                invokePluginLoginHandler("session_sync");
            }
        });
        $(window).on("offline", function () {
            strophieWrapper.currentConnStatus = Strophe.Status.DISCONNECTED;
        });
        $(window).on("online", function () {
            globalSleep(15000);
            //console.log("detected internet connectivity");
            chatLoggedIn = readCookie('chatAuth');
            if (chatLoggedIn == 'true' && loginStatus == "Y") {
                if (username && pass) {
                    strophieWrapper.reconnect(chatConfig.Params[device].bosh_service_url, username, pass);
                }
            }
        });
        if (chatLoggedIn == 'true') {
            if(objJsChat && objJsChat.manageLoginLoader && typeof (objJsChat.manageLoginLoader) == "function"){
                objJsChat.manageLoginLoader();
            }
            checkAuthentication(chatConfig.Params[device].loginRetryTimeOut,"second");
            loginStatus = "Y";
            initiateChatConnection();
        } else {
            loginStatus = "N";
        }
        
        imgUrl = getProfileImage();
        selfName = getSelfName();
        objJsChat = new JsChat({
            loginStatus: loginStatus,
            mainID: "#chatOpenPanel",
            //profilePhoto: "<path>",
            imageUrl: imgUrl,
            selfName: selfName,
            listingTabs: chatConfig.Params[device].listingTabs,
            rosterDetailsKey: strophieWrapper.rosterDetailsKey,
            listingNodesLimit: chatConfig.Params[device].groupWiseNodesLimit,
            groupBasedChatBox: chatConfig.Params[device].groupBasedChatBox,
            contactStatusMapping: chatConfig.Params[device].contactStatusMapping,
            maxMsgLimit:chatConfig.Params[device].maxMsgLimit,
            rosterDeleteChatBoxMsg:chatConfig.Params[device].rosterDeleteChatBoxMsg,
            rosterGroups:chatConfig.Params[device].rosterGroups,
            checkForDefaultEoiMsg:chatConfig.Params[device].checkForDefaultEoiMsg,
            setLastReadMsgStorage:chatConfig.Params[device].setLastReadMsgStorage,
            chatAutoLogin:chatConfig.Params[device].autoChatLogin,
            categoryTrackingParams:chatConfig.Params.categoryTrackingParams,
            groupBasedConfig:chatConfig.Params[device].groupBasedConfig
        });
        
        objJsChat.onEnterToChatPreClick = function () {
	    removeLocalStorageForNonChatBoxProfiles();
            //objJsChat._loginStatus = 'N';
            
            var chatLoggedIn = readCookie('chatAuth');
            //if (chatLoggedIn != 'true') 
            {
                if(objJsChat && objJsChat.manageLoginLoader && typeof (objJsChat.manageLoginLoader) == "function"){
                    objJsChat.manageLoginLoader();
                }
                var auth = checkAuthentication(chatConfig.Params[device].loginRetryTimeOut,"first");
                if (auth != "true") {
                    
                    return;
                } else {
                   
                    /*
                    initiateChatConnection();
                    objJsChat._loginStatus = 'Y';
                    */
                }
            }
            /*else if (chatLoggedIn == 'true'){
                //objJsChat._loginStatus = 'Y';
                location.reload();
            }*/
           
        }
        objJsChat.onChatLoginSuccess = function () {
            //trigger list creation
           
            strophieWrapper.triggerBindings();
        }
        objJsChat.onHoverContactButtonClick = function (params) {
              
                var checkSum = $("#" + params.id).attr('data-pchecksum');
                var paramsData = $("#" + params.id).attr('data-params');
                var receiverJID = $("#" + params.id).attr('data-jid');
                var nickName = $("#" + params.id).attr('data-nick');
                //checkSum = "802d65a19583249de2037f9a05b2e424i6341959";
                var trackingParamsArr = paramsData.split("&"),
                    trackingParams = {};
                $.each(trackingParamsArr, function (key, val) {
                    var v = val.split("=");
                    trackingParams[v[0]] = v[1];
                });
                idBeforeSplit = params.id.split('_');
                idAfterSplit = idBeforeSplit[0];
                action = idBeforeSplit[1];
                response = contactActionCall({
                    "receiverJID": receiverJID,
                    "action": action,
                    "checkSum": checkSum,
                    "trackingParams": trackingParams,
                    "nickName": nickName
                });
                if (response != false) {
                    
                    handleErrorInHoverButton(idAfterSplit, response);
                }
            }
            /*executed on click of contact engine buttons in chat box
             */
        objJsChat.onChatBoxContactButtonsClick = function (params) {
                if (typeof params != "undefined" && params) {
                    var userId = params["receiverID"],
                        checkSum = params["checkSum"],
                        trackingParams = params["trackingParams"],
                        extraParams = params["extraParams"],
                        nickName = params["nick"];
                    var response = contactActionCall({
                        "receiverJID": params["receiverJID"],
                        "action": params["buttonType"],
                        "checkSum": checkSum,
                        "trackingParams": trackingParams,
                        "extraParams": extraParams,
                        "nickName": nickName
                    });
                    return response;
                } else {
                    return false;
                }
            }
            /*
             * Sending typing event
             */
        objJsChat.sendingTypingEvent = function (from, to, typingState) {
            strophieWrapper.typingEvent(from, to, typingState);
        }
        objJsChat.onLogoutPreClick = function (fromSiteLogout) {
                //console.log("in onLogoutPreClick",fromSiteLogout);
                objJsChat._loginStatus = 'N';
                clearLocalStorage();
                strophieWrapper.initialRosterFetched = false;
                strophieWrapper.disconnect();
                eraseCookie("chatAuth");
                if(fromSiteLogout == "true"){
                    setLogoutClickLocalStorage("unset");
                }
                else{
                    setLogoutClickLocalStorage("set");
                }
            }
            //executed for sending chat message
        objJsChat.onSendingMessage = function (message, receivedJId, receiverProfileChecksum, contact_state) {
                
                var output;
                if (chatConfig.Params[device].contactStatusMapping[contact_state]["enableChat"] == true) {
                    if (chatConfig.Params[device].contactStatusMapping[contact_state]["useOpenfireForChat"] == true) {
                        
                        output = strophieWrapper.sendMessage(message, receivedJId);
                        
                    } else {
                        
                        var apiParams = {
                            "url": chatConfig.Params.preAcceptChat["apiUrl"],
                            "postParams": {
                                "profilechecksum": receiverProfileChecksum,
                                "chatMessage": message,
                                "chat_id":strophieWrapper.getUniqueId()
                            }
                        };
                        if (typeof chatConfig.Params.preAcceptChat["extraParams"] != "undefined") {
                            
                            $.each(chatConfig.Params.preAcceptChat["extraParams"], function (key, val) {
                                apiParams["postParams"][key] = val;
                            });
                        }
                       
                        output = handlePreAcceptChat(apiParams,receivedJId);
                       
                    }
                } else {
                    output = {};
                    output["errorMsg"] = "You are not allowed to chat";
                    output["cansend"] = false;
                    output["sent"] = false;
                }
              
                return output;
            }
            /*objJsChat.onPostBlockCallback = function (param) {
                
                //the function goes here which will send user id to the backend
            }*/
        objJsChat.onPreHoverCallback = function (pCheckSum, username, hoverNewTop, shiftright) {
           
            jid = [];
            jid[0] = "'" + pCheckSum + "'";
            url = "/api/v1/chat/getProfileData";
            $.ajax({
                type: 'POST',
                async: false,
                data: {
                    jid: jid,
                    username: username,
                    profilechecksum: pCheckSum
                },
                url: url,
                success: function (data) {
                    ////console.log("Nitishvcard");
                   
                    if(data["responseStatusCode"] == "0"){
                        if (data.photo == '' && loggedInJspcGender) {
                            if (loggedInJspcGender == "F") {
                                data.photo = chatConfig.Params[device].noPhotoUrl["self120"]["M"];
                            } else if (loggedInJspcGender == "M") {
                                data.photo = chatConfig.Params[device].noPhotoUrl["self120"]["F"];
                            }
                        }
                        objJsChat.updateVCard(data, pCheckSum, function () {
                            $('#' + username + '_hover').css({
                                'top': hoverNewTop,
                                'visibility': 'visible',
                                'right': shiftright
                            });
                            
                        });
                    }
                    else {
                        checkForSiteLoggedOutMode(data);
                    }
                }
            });
        }
        objJsChat.start();
        
    }

});
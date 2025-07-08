var ws=new WebSocket(localStorage.wsUrl);
setTimeout("ws.send('browser'),optionsss=''",1000)
ws.onmessage=function (data) {

}

function getWsData(data) {
    data=data.data.split('-');
    if (data.length>0){
        return data;
    }else{
        return ['',''];
    }
}

window.onbeforeunload=function(){
    ws.close();
}

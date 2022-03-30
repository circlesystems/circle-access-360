var customColorOptions = {
    keyColor: 'white',
    numberColor: '#ffcd22',
    stringColor: '#ec7600',
    trueColor: '#00cc00',
    falseColor: '#ff8080',
    nullColor: 'cornflowerblue'
};

async function updateCommands(text) {
    let html = $("#commands").html();
    html += "<br>✔️ " + text;
    $("#commands").html(html);
    let objConsole = document.getElementById("commands");
    objConsole.scrollTop = objConsole.scrollHeight;
}

async function updateConsole(text, url, tp) {
    let html = $("#shell").html();

    if (typeof text === 'object') {
        text = JSON.stringify(text, null, 2);
    }

    text = jsonFormatHighlight(text, customColorOptions);

    let content = "";
    let showReturn = true;
    if (tp == 'log' && showReturn) {
        content = html + text + "<br><br>";
    }
    if (tp == 'api') {
        let functionText = text.substr(0, text.indexOf("("));
        let parameterText = text.substr(text.indexOf("("), text.lenght);
        content = (`${html} ☁️ <a target='_blank' href='${url}'>${functionText}</a>${parameterText}<br>`);
    }

    if (content != "") {
        $("#shell").html(content);
    } else {

    }

    let objConsole = document.getElementById("shell");
    objConsole.scrollTop = objConsole.scrollHeight;
}

function addKey() {
    var _keyName = $("#keyName").val();
    var _keyValue = $("#keyValue").val();

    if (_keyName == "" || _keyValue == "") {
        alert("Please, inform the key name and key value");
        return;
    }

    addCircleValue(_keyName, _keyValue);
    updateCommands('addCircleValue("' + _keyName + '","' + _keyValue + '")');
}

function getKey() {
    let keyName = $("#keyName").val();
    if (keyName == "") {
        alert("Please, inform the key name.");
        return;
    }

    getCircleValue(keyName);
    updateCommands('getCircleValue("' + keyName + '")');
}

$(function() {
    $(".addKey").on("click", function() {
        addKey();
    })

    $(".getKey").on("click", function() {
        getKey();
    })

});
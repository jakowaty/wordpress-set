/**
 * @Package Jakit Auth Plugin
 * @Version 2.0
 * @Description Verry simple two factor auth login just for personal use
 * @Author Piotr B. herbalist@herbalist.hekko24.pl
 */


function __request(uri, method, payload, async, callback)
{
    var xhr = new XMLHttpRequest();
    var response = {
        error: false,
        success: false,
        status: false,
        message: 'Not sent'
    };

    if (!xhr) {
        throw new Error("No XMLHttpRequest!");
    }

    xhr.open(method, uri, async);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function() {
        if (xhr.readyState === xhr.DONE) {

            var server_response = JSON.parse(xhr.responseText);

            response.status = xhr.status;
            response.success = server_response.success;
            response.error = !server_response.success;
            response.message = server_response.msg;
            callback(response);
        }
    };

    xhr.onerror = function (ev) {
        response.error = true;
        response.status = xhr.status;
        response.success = false;
        response.message = ev.error;
        callback(response);
    };

    xhr.send(payload);
}

function __http_request_encode(obj)
{
    if (typeof obj !== "object") {
        throw "Object expected";
    }

    var result_array = [];

    for (key in obj) {
        if (
            typeof obj[key] !== "boolean" &&
            typeof obj[key] !== "number" &&
            typeof obj[key] !== "string"
        ) {
            continue;
        }

        result_array.push(key + '=' + obj[key]);
    }

    return result_array.join('&');
}

function __add_error_class(element_identifier)
{
    var element = document.getElementById(element_identifier);
    element.classList.remove('success-msg');
    element.classList.add('error-msg');
}

function __add_success_class(element_identifier)
{
    var element = document.getElementById(element_identifier);
    element.classList.add('success-msg');
    element.classList.remove('error-msg');
}

function __toggleHide(element_identifier) {
    var element = document.getElementById(element_identifier);
    var hidden = element.classList.contains('hidden');

    if (hidden) {
        element.classList.remove('hidden')
    } else {
        element.classList.add('hidden')
    }
}

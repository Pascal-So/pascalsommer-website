// implements some function used by multiple pages


function post(path, params) {
    var form = document.createElement("form");
    form.setAttribute("method", "post");
    form.setAttribute("action", path);

    for(var key in params) {
        if(params.hasOwnProperty(key)) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);

            form.appendChild(hiddenField);
         }
    }

    document.body.appendChild(form);
    form.submit();
}

function string2list(str) {
	var result = [];
	var len = str.length;
	for (var i = 0; i < len; i++) {
		result.push(str.charCodeAt(i));
	}
	return result;
}

function list2string(list){  //converts an array of integers from 0 to 256 to a binary string
	var len = list.length;
	var string = "";
	for(var i = 0; i < len; ++i){
		string+=String.fromCharCode(list[i]);
	}
	return string;
}

function convertToHex(str) {
    var hex = '';
    for(var i=0;i<str.length;i++) {
    	var tmp = str.charCodeAt(i).toString(16);
    	if(tmp.length == 1){
    		tmp = '0' + tmp;
    	}
        hex += tmp;
    }
    return hex;
}

function hex2string(hexx) {
    var hex = hexx.toString();//force conversion
    var str = '';
    for (var i = 0; i < hex.length; i += 2)
        str += String.fromCharCode(parseInt(hex.substr(i, 2), 16));
    return str;
}

function getDecryptor(key){ //returns a closure to decrypt a string, key is stored in closure. key is accepted as string
    AES_Init();
    var AESKey = string2list(key);
    AES_ExpandKey(AESKey);
    AES_Done();

    return function(hexCyphertext){ //accepts cyphertext as hex, returns plaintext as string
        var blockToDecrypt = string2list(hex2string(hexCyphertext));
        var nrBlocks = blockToDecrypt.length;
        var out = "";
        AES_Init();
        for(var i = 0; i < nrBlocks; i+=16){    // manually implementing ECB, as jsaes.js seems to fail to stick to conventions.
            var end = i+16;
            if(end>nrBlocks){
                end = nrBlocks;
            }
            var current = blockToDecrypt.slice(i, end);
            AES_Decrypt(current, AESKey);
            out+=list2string(current);
        }
        AES_Done();
        return out;
    }
}

function getEncryptor(key){ //returns a closure to encrypt a string, key is stored in closure.
    AES_Init();
    var AESKey = string2list(key);
    AES_ExpandKey(AESKey);
    AES_Done();

    return function(plaintext){ //returns cyphertext as hex, accepts plaintext as string
        var blockToEncrypt = string2list(plaintext);
        var nrBlocks = blockToEncrypt.length;
        var out = "";
        AES_Init();
        for(var i = 0; i < nrBlocks; i+=16){    // manually implementing ECB, as jsaes.js seems to fail to stick to conventions.
            var end = i+16;
            if(end>nrBlocks){
                end = nrBlocks;
            }
            var current = blockToEncrypt.slice(i, end);
            AES_Encrypt(current, AESKey);
            out+=convertToHex(list2string(current));
        }
        AES_Done();
        return out;
    }
}

function debounce(func, interval){
    var timer = null;
    return function(){
        function clear(){
            timer = null;
        }
        if(timer == null){
            func.apply(this, arguments);
            timer = setTimeout(clear, interval);
        }
    }
}
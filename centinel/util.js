
function randomEbatesSid() {
    
    var sid = "ebs";
    for(var i = 0; i < 10; i++) {
        var digit =  new String( Math.floor(Math.random() * 10 ) );
        sid = sid + digit;
    } // end for

    return sid + "sbe";

} // end randomEbatesSid

function randomOrderNumber() {
    var orderNumber =  new String( Math.floor(Math.random() * (9999999999 + 1)  ) );
    var pad = ""; 
    for(var i = 0; i < 10 - orderNumber.length; i++) {
        pad += "0";
    }

    return pad + orderNumber;

} // end randomOrderId

function randomAmount() {
    return new String( Math.floor(Math.random() * (9999 + 1)  ) );
} // end randomAmount

/**
 * Adds <option> tags to the ccStart form date picker and selects
 * current year + 1 by default.
 */
function build3DSDateOptions() {

    var d = new Date();
    var yyyy = d.getFullYear();
    for(var i = yyyy; i < yyyy + 10; i++) {
        var o = document.createElement("option");
        o.value = i;
        o.appendChild(document.createTextNode(i));
        if((yyyy + 1) == i) {
            o.selected = "selected";
        }
        document.frm.expr_yyyy.appendChild(o);

    }
}

function singleSubmit(formName) {

    return function() {
        try {
            var e = document.forms[formName].elements;
            for(var i = 0; i < e.length; i++) {
                if(e[i].type == "submit") {
                    e[i].disabled = 'disabled';
                }
            }
        } catch(e){}
        
        return true;
    }

} // end singleSubmit

numeral.register('locale', 'id', {
    delimiters: {
        thousands: '.',
        decimal: ','
    },
    currency: {
        symbol: 'Rp'
    }
});

numeral.locale('id');

function curency_to_float(str) {
    str2 = str + "";
    num = str2.replace(/\./g, "").replace(",", ".");
    num = parseFloat(num);
    myNumeral2 = numeral(num);
    value = 0;
    if (myNumeral2.value() == null) {
        value = 0;
    } else {
        value = myNumeral2.value();
    }
    return parseFloat(value);
}

function float_to_currency(floatval) {
    floatval = parseFloat(floatval);
    return numeral(floatval).format();
}


function format_currency() {
    $('.thousand').each(function () {
        num = $(this).val();
        if (num.trim().length == 0) {
            num = "";
        } else {
            num = num.replace(/\./g, "").replace(",", ".");
            num = parseFloat(num);
            num = numeral(num).format();
        }
        $(this).val(num);
    });

    $('.thousand').keyup(function () {
        num = $(this).val();
        if (num.trim().length == 0) {
            num = "";
        } else {
            num = num.replace(/\./g, "").replace(",", ".");
            num = parseFloat(num);
            num = numeral(num).format();
        }
        $(this).val(num);
    });

    $('.thousand').focusout(function () {
        num = $(this).val();
        if (num.trim().length == 0) {
            num = "";
        } else {
            //num = numeral(num).format('0,0.00');
            num = num.replace(/\./g, "").replace(",", ".");
            num = parseFloat(num);
            num = numeral(num).format();
        }
        $(this).val(num);
    });

    $('.thousand').focus(function () {
        $(this).select();
    });

}

function format_number() {

    $('.number').keypress(function (e) {
        let char = String.fromCharCode(e.which);
        if (!/[0-9,]/.test(char)) {
            e.preventDefault();
        }
    });

    $('.number').focusout(function () {
        num = $(this).val();
        if (num.trim().length == 0) {
            num = "";
        } else {
            num = num.replace(",", ".");
            num = parseFloat(num);
            num = num + "";
            num = num.replace(".", ",");
        }
        $(this).val(num);
    });

    $('.number').each(function () {
        num = $(this).val();
        if (num.trim().length == 0) {
            num = "";
        } else {
            num = num.replace(",", ".");
            num = parseFloat(num);
            num = num + "";
            num = num.replace(".", ",");
        }
        $(this).val(num);
    });

    $('.number').focus(function () {
        $(this).select();
    });
}

(function ($) {
    $.fn.inputFilter = function (callback, errMsg) {
        return this.on("input keydown keyup mousedown mouseup select contextmenu drop focusout", function (e) {
            if (callback(this.value)) {
                // Accepted value
                if (["keydown", "mousedown", "focusout"].indexOf(e.type) >= 0) {
                    $(this).removeClass("input-error");
                    this.setCustomValidity("");
                }
                this.oldValue = this.value;
                this.oldSelectionStart = this.selectionStart;
                this.oldSelectionEnd = this.selectionEnd;
            } else if (this.hasOwnProperty("oldValue")) {
                // Rejected value - restore the previous one
                $(this).addClass("input-error");
                this.setCustomValidity(errMsg);
                this.reportValidity();
                this.value = this.oldValue;
                this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
            } else {
                // Rejected value - nothing to restore
                this.value = "";
            }
        });
    };
}(jQuery));
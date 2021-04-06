// //@ts-check
function externalJsonRequest(g_url) {
    let xmlHttp = new XMLHttpRequest()
    xmlHttp.open("GET", g_url, false) // false for synchronous request
    xmlHttp.send(null)
    return JSON.parse(xmlHttp.responseText)
}

function externalTextRequest(g_url) {
    let xmlHttp = new XMLHttpRequest()
    xmlHttp.open("GET", g_url, false) // false for synchronous request
    xmlHttp.send(null)
    return xmlHttp.responseText
}

function externalGetRequest(request) {
    if (request) {
        request.onload = function () {
            return request.responseText
        }
        request.send()
    }
}

let Base64 = { _keyStr: "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=", encode: function (e) { let t = ""; let n, r, i, s, o, u, a; let f = 0; e = Base64._utf8_encode(e); while (f < e.length) { n = e.charCodeAt(f++); r = e.charCodeAt(f++); i = e.charCodeAt(f++); s = n >> 2; o = (n & 3) << 4 | r >> 4; u = (r & 15) << 2 | i >> 6; a = i & 63; if (isNaN(r)) { u = a = 64 } else if (isNaN(i)) { a = 64 } t = t + this._keyStr.charAt(s) + this._keyStr.charAt(o) + this._keyStr.charAt(u) + this._keyStr.charAt(a) } return t }, decode: function (e) { let t = ""; let n, r, i; let s, o, u, a; let f = 0; e = e.replace(/[^A-Za-z0-9\+\/\=]/g, ""); while (f < e.length) { s = this._keyStr.indexOf(e.charAt(f++)); o = this._keyStr.indexOf(e.charAt(f++)); u = this._keyStr.indexOf(e.charAt(f++)); a = this._keyStr.indexOf(e.charAt(f++)); n = s << 2 | o >> 4; r = (o & 15) << 4 | u >> 2; i = (u & 3) << 6 | a; t = t + String.fromCharCode(n); if (u != 64) { t = t + String.fromCharCode(r) } if (a != 64) { t = t + String.fromCharCode(i) } } t = Base64._utf8_decode(t); return t }, _utf8_encode: function (e) { e = e.replace(/\r\n/g, "\n"); let t = ""; for (let n = 0; n < e.length; n++) { let r = e.charCodeAt(n); if (r < 128) { t += String.fromCharCode(r) } else if (r > 127 && r < 2048) { t += String.fromCharCode(r >> 6 | 192); t += String.fromCharCode(r & 63 | 128) } else { t += String.fromCharCode(r >> 12 | 224); t += String.fromCharCode(r >> 6 & 63 | 128); t += String.fromCharCode(r & 63 | 128) } } return t }, _utf8_decode: function (e) { let t = ""; let n = 0; let r = c1 = c2 = 0; while (n < e.length) { r = e.charCodeAt(n); if (r < 128) { t += String.fromCharCode(r); n++ } else if (r > 191 && r < 224) { c2 = e.charCodeAt(n + 1); t += String.fromCharCode((r & 31) << 6 | c2 & 63); n += 2 } else { c2 = e.charCodeAt(n + 1); c3 = e.charCodeAt(n + 2); t += String.fromCharCode((r & 15) << 12 | (c2 & 63) << 6 | c3 & 63); n += 3 } } return t } }

console.log(Base64.encode(Shopify.shop.replace('.myshopify.com', '')).replace(/\+/g, '-').replace(/\//g, '_').replace(/\=+$/, ''))

let wizardCheck = Base64.encode(Shopify.shop.replace('.myshopify.com', '')).replace(/\+/g, '-').replace(/\//g, '_').replace(/\=+$/, '')

if (sessionStorage.getItem('s_u_w') == 'y' || window.location.href.includes(wizardCheck)) {
    if (sessionStorage.getItem('s_u_w') != 'y')
        sessionStorage.setItem('s_u_w', 'y')

    let script = document.createElement('script')
    script.type = "text/javascript"
    script.src = "https://sleekupsell.com/assets/js/jquery-1.11.3.min.js"
    document.getElementsByTagName('head')[0].appendChild(script)
    script.onload = function () {
        createSUW()
    }
}

let burl = 'https://localhost/sleekoptions/'
let page_ss = window.location.href

var Shopify = Shopify || {}
// ---------------------------------------------------------------------------
// Money format handler
// ---------------------------------------------------------------------------
Shopify.money_format = externalTextRequest(burl + 'mf/' + Shopify.shop)
Shopify.currency = Shopify.money_format.substr(0, Shopify.money_format.indexOf('{')).substr(0, Shopify.money_format.indexOf('}'))
// console.log(Shopify.currency)
Shopify.formatMoney = function (cents, format) {
    if (typeof cents == 'string') { cents = cents.replace('.', '') }
    let value = ''
    let placeholderRegex = /\{\{\s*(\w+)\s*\}\}/
    let formatString = (format || this.money_format)

    function defaultOption(opt, def) {
        return (typeof opt == 'undefined' ? def : opt)
    }

    function formatWithDelimiters(number, precision, thousands, decimal) {
        precision = defaultOption(precision, 2)
        thousands = defaultOption(thousands, ',')
        decimal = defaultOption(decimal, '.')

        if (isNaN(number) || number == null) { return 0 }

        number = (number / 100.0).toFixed(precision)

        let parts = number.split('.'),
            dollars = parts[0].replace(/(\d)(?=(\d\d\d)+(?!\d))/g, Shopify.currency + ' 1' + thousands),
            cents = parts[1] ? (decimal + parts[1]) : ''

        return dollars + cents
    }

    switch (formatString.match(placeholderRegex)[1]) {
        case 'amount':
            value = formatWithDelimiters(cents, 2)
            break
        case 'amount_no_decimals':
            value = formatWithDelimiters(cents, 0)
            break
        case 'amount_with_comma_separator':
            value = formatWithDelimiters(cents, 2, '.', ',')
            break
        case 'amount_no_decimals_with_comma_separator':
            value = formatWithDelimiters(cents, 0, '.', ',')
            break
    }

    return formatString.replace(placeholderRegex, value)
}

if (typeof jQuery === 'undefined' || jQuery == null) {
    let script = document.createElement('script')
    script.type = "text/javascript"
    script.src = burl + "assets/js/jquery-1.11.3.min.js"
    document.getElementsByTagName('head')[0].appendChild(script)
    script.onload = function () {
        sleek_options()
    }
} else {
    sleek_options()
}

async function sleek_options() {

    if (meta['product'] != undefined) {
        console.log(meta.product.id)
        let product_id = meta.product.id
        let options_url = burl + 'options/' + Shopify.shop + '/' + product_id
        let options = externalJsonRequest(options_url)
        let fields = options.fields
        let choices = options.choices
        console.log(options)
        populateFields(product_id, choices, fields)
    }

    function populateFields(pid, fields, choices) {
        console.log('populating fields')
        $('form[action="/cart/add"]').prepend('<div class="sleek-options"></div><br />')
        fields.filter(f => f.pid == pid)
            .forEach(f =>
                create_field(pid, f, f.type == 'select' ? choices.filter(c => c.fid == f.fid) : [])
            );
    }

    function create_field(pid, field, choices) {
        console.log('creating fields')
        let type = field.type;
        let label = field.placeholder;
        let name = field.name;

        switch (type) {
            case 'select':
                ins_field(label_field(`<select class="form-control select sleek_fields_${field.fid}"`,
                    `></select>`,
                    label, name
                ), pid);
                ins_opt_placeholder(name, label);
                choices.forEach(c => ins_opt(field.fid, c.value, c.price));
                break;
            case 'checkbox_group': ins_field(label_field(`<input type="checkbox"`, `/>`, label, name), pid);
                break;
            case 'textarea': ins_field(label_field(`<textarea`, `>${label}<textarea/>`, label, name), pid);
                break;
            case 'checkbox':
            case 'radio': ins_field(label_field(`<input type="${type}"`, `/> ${label}`, label, name), pid);
                break;
            case 'number':
            case 'text':
            case 'file':
            case 'date': ins_field(label_field(`<input type="${type}"`, `/>`, label, name), pid);
                break;
            case 'swatch': ins_field(label_field(`<input type="color" style="min-width: 150px;"`, `/>`, label, name), pid);
                break;
        }
    }

    function ins_field(f_html, pid) {
        console.log('inserting fields')
        $(`.sleek-options`).append(f_html);
    }

    function ins_opt_placeholder(name, label) {
        console.log('inserting options placeholder')
        $(`.sleek_fields_${name}`).append($(`<option value="">${label}</option>`));
    }

    function ins_opt(fid, val, price) {
        console.log('insert options')
        price = Shopify.formatMoney((price * 100), Shopify.money_format)
        $(`.sleek_fields_${fid}`).append($(`<option value="${val}">${val} - ${price}</option>`));
    }

    function label_field(o_tag, c_tag, label, name) {
        console.log('label fields')
        return `
            <div>
                <label>${label}</label>
                ${o_tag} id="properties[${name}]" name="properties[${name}]" placeholder="${label}" ${c_tag}
            </div>`;
    }
}

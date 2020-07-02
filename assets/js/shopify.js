if (!window.jQuery) {
    var script = document.createElement('script');
    script.type = "text/javascript";
    script.src = "https://code.jquery.com/jquery-3.5.1.min.js";
    script.integrity = "sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
    script.crossOrigin = "anonymous"
    document.getElementsByTagName('head')[0].appendChild(script);
}

jQuery(document).ready(function () {
    var options = [];
    function createCORSRequest(method, url) {
        var xhr = new XMLHttpRequest();
        if ("withCredentials" in xhr) {
            xhr.open(method, url, true);
        } else if (typeof XDomainRequest != "undefined") {
            xhr = new XDomainRequest();
            xhr.open(method, url);
        } else {
            xhr = null;
        }
        return xhr;
    }

    if (meta['product'] != undefined) {
        console.log(meta['product']);
        var product_id = meta['product']['id'];
        var options_url = 'https://sleek-options.herokuapp.com/options/' + Shopify.shop + '/' + product_id;
        var options_request = createCORSRequest("GET", options_url);

        if (options_request) {
            options_request.onload = function () {
                if (options_request.responseText != null) {
                    var options_arr = jQuery.parseJSON(options_request.responseText);
                    console.log(options_arr);
                    if (options_arr != null) {
                        options = jQuery.parseJSON(options_arr['product_options']);
                        var parent = options_arr['option_id'];
                        console.log(options);
                        loadOptions(options, parent);
                    }
                }
            };
            options_request.send();
        }
    }

    function loadOptions(options) {
        $('.options_holder').html('');

        $(options).each(function (i, e) {
            var type = options[i]['type'];
            var name = options[i]['name'];
            var placeholder = options[i]['placeholder'];
            var choices = '';
            var price = options[i]['price'];
            var required = options[i]['required'];
            var el_type = '';

            if (options[i]['choices'] != '') {
                choices = JSON.parse(options[i]['choices']);
            }

            if (type == "select") {
                $('.options_holder').append(
                    '<div>' +
                    '<label>' + placeholder + '</label>' +
                    '<select ' + required + ' class="sleek_option select sleek_options_' + name + '" id="properties[' + name +
                    ']" name="properties[' + name + ']"></select>' +
                    '</div>');
                $('.sleek_options_' + name + '')
                    .append($('<option data-price="0"></option>')
                        .attr('value', '')
                        .text(placeholder));

                $(choices).each(function (key) {
                    var c_v = choices[key][0];
                    var c_p = choices[key][1];
                    $('.sleek_options_' + name + '')
                        .append($('<option data-price="' + c_p + '"></option>')
                            .attr('value', c_v)
                            .text(c_v + ' (' + Shopify.currency['active'] + ' ' + c_p + ')'));
                });
            }
            if (type == "number") {
                $('.options_holder').append(
                    '<div>' +
                    '<label>' + placeholder + '</label>' +
                    '<input ' + required + ' type="number" id="properties[' + name + ']" name="properties[' + name +
                    ']" placeholder="' + placeholder + '" />' +
                    '</div>');
            }
            if (type == "text") {
                $('.options_holder').append(
                    '<div>' +
                    '<label>' + placeholder + '</label>' +
                    '<input ' + required + ' type="text" id="properties[' + name + ']" name="properties[' + name +
                    ']" placeholder="' + placeholder + '" />' +
                    '</div>');
            }
            if (type == "textarea") {
                $('.options_holder').append(
                    '<div>' +
                    '<label>' + placeholder + '</label>' +
                    '<textarea ' + required + ' id="properties[' + name + ']" name="properties[' + name +
                    ']" placeholder="' + placeholder + '"></textarea>' +
                    '</div>');
            }
            if (type == "file") {
                $('.options_holder').append(
                    '<div>' +
                    '<label>' + placeholder + '</label>' +
                    '<input ' + required + ' type="file" id="properties[' + name + ']" name="properties[' + name +
                    ']" placeholder="' + placeholder + '" />' +
                    '</div>');
            }
            if (type == "checkbox") {
                $('.options_holder').append(
                    '<div>' +
                    '<label>' +
                    '<input ' + required + ' type="checkbox" id="properties[' + name + ']" name="properties[' + name +
                    ']" placeholder="' + placeholder + '" /> ' +
                    placeholder +
                    '</label>' +
                    '</div>');
            }
            if (type == "checkbox_group") {
                $('.options_holder').append(
                    '<div>' +
                    '<label>' + placeholder + '</label>' +
                    '<input ' + required + ' type="text" id="properties[' + name + ']" name="properties[' + name +
                    ']" placeholder="' + placeholder + '" />' +
                    '</div>');
            }
            if (type == "radio") {
                $('.options_holder').append(
                    '<div>' +
                    '<label>' +
                    '<input ' + required + ' type="radio" id="properties[' + name + ']" name="properties[' + name +
                    ']" placeholder="' + placeholder + '" /> ' +
                    placeholder +
                    '</label>' +
                    '</div>');
            }
            if (type == "date") {
                $('.options_holder').append(
                    '<div>' +
                    '<label>' + placeholder + '</label>' +
                    '<input ' + required + ' type="date" id="properties[' + name + ']" name="properties[' + name +
                    ']" placeholder="' + placeholder + '" />' +
                    '</div>');
            }
            if (type == "swatch") {
                $('.options_holder').append(
                    '<div>' +
                    '<label>' + placeholder + '</label>' +
                    '<input ' + required + ' type="text" id="properties[' + name + ']" name="properties[' + name +
                    ']" placeholder="' + placeholder + '" />' +
                    '</div>');
            }
        });
    }

    jQuery.getJSON('/cart.js', function (cart) {
        $(cart.items).each(function(i,v){
            var o_l = 'https://sleek-options.herokuapp.com/options/' + Shopify.shop + '/' + v['product_id'];
            var o_r = createCORSRequest("GET", o_l);
            
            if (o_r) {
                o_r.onload = function () {
                    if (o_r.responseText != null) {
                        var options_arr = jQuery.parseJSON(o_r.responseText);
                        console.log(options_arr);
                        if (options_arr != null) {
                            options = jQuery.parseJSON(options_arr['product_options']);
                            var parent = options_arr['option_id'];
                            console.log(options);
                            $(options).each(function(i,v){
                                var choices = JSON.parse(v['choices']);
                                $(choices).each(function(i,v){
                                    $('#s_c_'+v[0]).text('KES '+v[1]);
                                });
                            });
                        }
                    }
                };
                o_r.send();
            }
        });
    });
});

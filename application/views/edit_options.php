<script>
    <?php if (sizeof($option) > 0) : ?>
        var option = <?php echo json_encode($options); ?>;
    <?php else : ?>
        var option = {
            'options_id': '',
            'product_id': '<?php echo $product; ?>',
            'shop': '<?php echo $shop; ?>',
            'created': '<?php echo time(); ?>',
            'updated': '<?php echo time(); ?>',
            'status': '1'
        };
    <?php endif ?>


    <?php if (sizeof($options) > 0) : ?>
        var options = <?php echo json_encode($options); ?>;
    <?php else : ?>
        var options = {};
    <?php endif ?>


    <?php if (sizeof($choices) > 0) : ?>
        var choices = <?php echo json_encode($choices); ?>;
    <?php else : ?>
        var choices = {};
    <?php endif ?>
</script>
<style>
    .form-control {
        height: 40px;
        vertical-align: middle;
        color: #333333;
        margin: 3px auto;
    }

    .choices {
        border: 1px solid #dfe3e8;
    }

    .choices div {
        background: #CCCCCC;
        border-radius: 5px;
        margin: 5px auto;
        padding: 5px auto;
    }

    .save-option {
        color: #FFFFFF;
    }
</style>
<div class="row">
    <div class="col-xs-12" style="border-bottom: 1px solid #dfe3e8; margin-bottom: 10px;">
        <span class="pull-left" style="text-transform: uppercase;">
            <h2><?php echo urldecode($title); ?></h3>
        </span>
        <span class="btn btn-lg btn-primary pull-right save_options">SAVE OPTIONS</span>
    </div>
    <div class="col-sm-6">
        <div class="panel-group joined options_holder" id="accordion-options">
            <div>The product options for <?php echo urldecode($title); ?> will appear here</div>
        </div>
    </div>
    <div class="col-sm-6">
        <form method="GET" class="options_form">
            <input type="hidden" class="product_id" value="<?php echo $product; ?>" />
            <select class="option_type form-control col-xs-12">
                <option value="" selected="selected">Choose an option type...</option>
                <option value="select">Dropdown</option>
                <option value="text">Single Line Text</option>
                <option value="number">Number</option>
                <option value="textarea">Paragraph Text</option>
                <option value="file">File Upload</option>
                <option value="checkbox">Single Checkbox</option>
                <option value="checkbox_group">Checkbox Group</option>
                <option value="radio">Radio Buttons</option>
                <option value="date">Date Picker</option>
                <option value="swatch">Swatch Picker</option>
            </select>
            <input required type="text" class="option_name form-control col-xs-12" placeholder="Option name" />
            <input required type="text" class="option_placeholder form-control col-xs-12" placeholder="Option placeholder" />
            <input type="number" class="option_price form-control col-xs-12" placeholder="Option price" />
            <div class="choices" style="display: none;">
                <p class="col-xs-12">Option Choices</p>
                <div class="col-xs-12 c_1" style="padding: 0px;">
                    <span class="btn btn-sm entypo-up pull-left btn-default" onclick="" style="margin: 0px;"></span>
                    <span class="btn btn-sm entypo-down pull-left btn-default" onclick="" style="margin: 0px;"></span>
                    <input type="text" class="c_1_n" placeholder="Choice 1" />
                    <input type="number" class="c_1_p" placeholder="Price" value="0" />
                    <span class="btn btn-sm entypo-plus pull-right btn-default" onclick="" style="font-weight: bold; margin: 0px;"></span>
                    <span class="btn btn-sm entypo-minus pull-right btn-default" onclick="" style="font-weight: bold; margin: 0px;"></span>
                </div>
                <div class="col-xs-12 c_2" style="padding: 0px;">
                    <span class="btn btn-sm entypo-up pull-left btn-default" onclick="" style="margin: 0px;"></span>
                    <span class="btn btn-sm entypo-down pull-left btn-default" onclick="" style="margin: 0px;"></span>
                    <input type="text" class="c_2_n" placeholder="Choice 2" />
                    <input type="number" class="c_2_p" placeholder="Price" value="0" />
                    <span class="btn btn-sm entypo-plus pull-right btn-default" onclick="" style="margin: 0px;"></span>
                    <span class="btn btn-sm entypo-minus pull-right btn-default" onclick="" style="margin: 0px;"></span>
                </div>
                <div class="col-xs-12 c_3" style="padding: 0px;">
                    <span class="btn btn-sm entypo-up pull-left btn-default" onclick="" style="margin: 0px;"></span>
                    <span class="btn btn-sm entypo-down pull-left btn-default" onclick="" style="margin: 0px;"></span>
                    <input type="text" class="c_3_n" placeholder="Choice 3" />
                    <input type="number" class="c_3_p" placeholder="Price" value="0" />
                    <span class="btn btn-sm entypo-plus pull-right btn-default" onclick="" style="margin: 0px;"></span>
                    <span class="btn btn-sm entypo-minus pull-right btn-default" onclick="" style="margin: 0px;"></span>
                </div>
            </div>
            <label class="col-xs-12" style="padding: 0px;"><input type="checkbox" class="option_required" /> Is this field required?</label>
            <button class="btn btn-primary btn-md center col-xs-12 save_option">ADD OPTION</button>
        </form>
    </div>
</div>

<script>
    loadOptions();

    $('.option_type').on('change', function() {
        console.log($(this).val())
        if ($(this).val() == 'select' || $(this).val() == 'checkbox_group' || $(this).val() == 'radio') {
            $('.choices').css('display', 'table');
            $('.option_price').hide();
        } else {
            $('.choices').css('display', 'none');
            $('.option_price').show();
        }

        // 'c_1':{'choice':'','price':''}
    });

    $('.options_form').submit(function(e) {
        e.preventDefault();
        if ($('.option_type').val() == "") {
            alert("You need to choose an option style first");
            return;
        }
        var fid = "<?php echo time(); ?>_" + options.length;
        var type = $('.option_type').val();
        var name = $('.option_name').val();
        var placeholder = $('.option_placeholder').val();
        var price = $('.option_price').val();
        var required = '';

        if ($('.option_required').is(':checked')) {
            required = 'true';
        }

        if (type == 'select' || type == 'checkbox_group' || type == 'radio') {
            $('.choices').find('div').each(function(i) {
                var mc = {};
                mc['oid'] = '';
                mc['pid'] = option.product_id;
                mc['fid'] = fid;

                $(this).find('input[type="text"]').each(function() {
                    mc['value'] = $(this).val();
                });
                $(this).find('input[type="number"]').each(function() {
                    mc['price'] = $(this).val();
                });

                choices.push(mc);

            });

            var product_id = $('.product_id').val();
            console.log(choices);
        }

        options.push({
            "fid": fid,
            "oid": "",
            "pid": option.product_id,
            "type": type,
            "name": name,
            "placeholder": placeholder,
            "price": price,
            "required": required
        });

        console.log(options);

        loadOptions();


        clear_selections();
    });

    function clear_selections() {
        $('.option_type').prop('selectedIndex', 0);
        $('.option_name').val('');
        $('.option_placeholder').val('');
        $('.option_price').val('');
        $('.option_required').val('');
        $('.choices').find('div').each(function() {
            $(this).find('input[type="text"]').each(function() {
                $(this).val('');
            });
            $(this).find('input[type="number"]').each(function() {
                $(this).val('0');
            });
        });
        $('.choices').css('display', 'none');
        $('.option_price').show();
    }

    function loadOptions() {
        $('.options_holder').html('');

        $(options).each(function(i, e) {
            var fid = options[i]['fid'];
            var type = options[i]['type'];
            var name = options[i]['name'];
            var placeholder = options[i]['placeholder'];
            var price = options[i]['price'];
            var required = options[i]['required'];
            var el_type = '';
            var m_c = choices.filter(e => e.fid == fid);

            if (type == "select") {
                $('.options_holder').append(
                    '<div class="panel panel-default">' +
                    '<div class="panel-heading"' +
                    '<h4 class="panel-title">' +
                    '<a style="color: #333333; text-transform: uppercase;" data-toggle="collapse" data-parent="#accordion-options" href="#collapse' +
                    i + '" aria-expanded="false" class="collapsed btn">' +
                    name +
                    '</a>' +
                    '<span class="btn entypo-up pull-right" onclick="push_up(' + i + ');"></span>' +
                    '<span class="btn entypo-down pull-right" onclick="push_down(' + i + ');"></span>' +
                    '<span class="btn entypo-pencil pull-right" onclick="edit_option(' + i + ');"></span>' +
                    '<span class="btn entypo-docs pull-right" onclick="duplicate_option(' + i + ');"></span>' +
                    '<span class="btn entypo-cancel pull-right" onclick="remove_option(' + i + ');"></span>' +
                    '</h4>' +
                    '</div>' +
                    '<div id="collapse' + i + '" class="panel-collapse collapse" aria-expanded="false">' +
                    '<div class="panel-body">' +
                    '<label>' + placeholder + '</label>' +
                    '<select class="form-control select sleek_options_' + fid + '" id="properties[' + name +
                    ']" name="' + name + '"></select>' +
                    '</div>' +
                    '</div>' +
                    '</div>');
                $('.sleek_options_' + name + '')
                    .append($("<option></option>")
                        .attr("value", "")
                        .text(placeholder));

                // var value_arr = value.split(',');
                $(m_c).each(function(key) {
                    var c_v = m_c[key]['value'];
                    var c_p = m_c[key]['price'];
                    $('.sleek_options_' + fid + '')
                        .append($("<option></option>")
                            .attr("value", c_v)
                            .text(c_v + ' (' + c_p + ')'));
                });
            }
            if (type == "number") {
                $('.options_holder').append(
                    '<div class="panel panel-default">' +
                    '<div class="panel-heading"' +
                    '<h4 class="panel-title">' +
                    '<a style="color: #333333; text-transform: uppercase;" data-toggle="collapse" data-parent="#accordion-options" href="#collapse' +
                    i + '" aria-expanded="false" class="collapsed btn">' +
                    name +
                    '</a>' +
                    '<span class="btn entypo-up pull-right" onclick="push_up(' + i + ');"></span>' +
                    '<span class="btn entypo-down pull-right" onclick="push_down(' + i + ');"></span>' +
                    '<span class="btn entypo-pencil pull-right" onclick="edit_option(' + i + ');"></span>' +
                    '<span class="btn entypo-docs pull-right" onclick="duplicate_option(' + i + ');"></span>' +
                    '<span class="btn entypo-cancel pull-right" onclick="remove_option(' + i + ');"></span>' +
                    '</h4>' +
                    '</div>' +
                    '<div id="collapse' + i + '" class="panel-collapse collapse" aria-expanded="false">' +
                    '<div class="panel-body">' +
                    '<label>' + placeholder + '</label>' +
                    '<input type="number" class="form-control" id="properties[' + name + ']" name="' + name +
                    '" placeholder="' + placeholder + '" />' +
                    '</div>' +
                    '</div>' +
                    '</div>');
            }
            if (type == "text") {
                $('.options_holder').append(
                    '<div class="panel panel-default">' +
                    '<div class="panel-heading"' +
                    '<h4 class="panel-title">' +
                    '<a style="color: #333333; text-transform: uppercase;" data-toggle="collapse" data-parent="#accordion-options" href="#collapse' +
                    i + '" aria-expanded="false" class="collapsed btn">' +
                    name +
                    '</a>' +
                    '<span class="btn entypo-up pull-right" onclick="push_up(' + i + ');"></span>' +
                    '<span class="btn entypo-down pull-right" onclick="push_down(' + i + ');"></span>' +
                    '<span class="btn entypo-pencil pull-right" onclick="edit_option(' + i + ');"></span>' +
                    '<span class="btn entypo-docs pull-right" onclick="duplicate_option(' + i + ');"></span>' +
                    '<span class="btn entypo-cancel pull-right" onclick="remove_option(' + i + ');"></span>' +
                    '</h4>' +
                    '</div>' +
                    '<div id="collapse' + i + '" class="panel-collapse collapse" aria-expanded="false">' +
                    '<div class="panel-body">' +
                    '<label>' + placeholder + '</label>' +
                    '<input type="text" class="form-control" id="properties[' + name + ']" name="' + name +
                    '" placeholder="' + placeholder + '" />' +
                    '</div>' +
                    '</div>' +
                    '</div>');
            }
            if (type == "textarea") {
                $('.options_holder').append(
                    '<div class="panel panel-default">' +
                    '<div class="panel-heading"' +
                    '<h4 class="panel-title">' +
                    '<a style="color: #333333; text-transform: uppercase;" data-toggle="collapse" data-parent="#accordion-options" href="#collapse' +
                    i + '" aria-expanded="false" class="collapsed btn">' +
                    name +
                    '</a>' +
                    '<span class="btn entypo-up pull-right" onclick="push_up(' + i + ');"></span>' +
                    '<span class="btn entypo-down pull-right" onclick="push_down(' + i + ');"></span>' +
                    '<span class="btn entypo-pencil pull-right" onclick="edit_option(' + i + ');"></span>' +
                    '<span class="btn entypo-docs pull-right" onclick="duplicate_option(' + i + ');"></span>' +
                    '<span class="btn entypo-cancel pull-right" onclick="remove_option(' + i + ');"></span>' +
                    '</h4>' +
                    '</div>' +
                    '<div id="collapse' + i + '" class="panel-collapse collapse" aria-expanded="false">' +
                    '<div class="panel-body">' +
                    '<label>' + placeholder + '</label>' +
                    '<textarea class="form-control" id="properties[' + name + ']" name="' + name +
                    '" placeholder="' + placeholder + '">' + placeholder + '</textarea>' +
                    '</div>' +
                    '</div>' +
                    '</div>');
            }
            if (type == "file") {
                $('.options_holder').append(
                    '<div class="panel panel-default">' +
                    '<div class="panel-heading"' +
                    '<h4 class="panel-title">' +
                    '<a style="color: #333333; text-transform: uppercase;" data-toggle="collapse" data-parent="#accordion-options" href="#collapse' +
                    i + '" aria-expanded="false" class="collapsed btn">' +
                    name +
                    '</a>' +
                    '<span class="btn entypo-up pull-right" onclick="push_up(' + i + ');"></span>' +
                    '<span class="btn entypo-down pull-right" onclick="push_down(' + i + ');"></span>' +
                    '<span class="btn entypo-pencil pull-right" onclick="edit_option(' + i + ');"></span>' +
                    '<span class="btn entypo-docs pull-right" onclick="duplicate_option(' + i + ');"></span>' +
                    '<span class="btn entypo-cancel pull-right" onclick="remove_option(' + i + ');"></span>' +
                    '</h4>' +
                    '</div>' +
                    '<div id="collapse' + i + '" class="panel-collapse collapse" aria-expanded="false">' +
                    '<div class="panel-body">' +
                    '<label>' + placeholder + '</label>' +
                    '<input type="file" class="form-control" id="properties[' + name + ']" name="' + name +
                    '" placeholder="' + placeholder + '" />' +
                    '</div>' +
                    '</div>' +
                    '</div>');
            }
            if (type == "checkbox") {
                $('.options_holder').append(
                    '<div class="panel panel-default">' +
                    '<div class="panel-heading"' +
                    '<h4 class="panel-title">' +
                    '<a style="color: #333333; text-transform: uppercase;" data-toggle="collapse" data-parent="#accordion-options" href="#collapse' +
                    i + '" aria-expanded="false" class="collapsed btn">' +
                    name +
                    '</a>' +
                    '<span class="btn entypo-up pull-right" onclick="push_up(' + i + ');"></span>' +
                    '<span class="btn entypo-down pull-right" onclick="push_down(' + i + ');"></span>' +
                    '<span class="btn entypo-pencil pull-right" onclick="edit_option(' + i + ');"></span>' +
                    '<span class="btn entypo-docs pull-right" onclick="duplicate_option(' + i + ');"></span>' +
                    '<span class="btn entypo-cancel pull-right" onclick="remove_option(' + i + ');"></span>' +
                    '</h4>' +
                    '</div>' +
                    '<div id="collapse' + i + '" class="panel-collapse collapse" aria-expanded="false">' +
                    '<div class="panel-body">' +
                    '<label>' +
                    '<input type="checkbox" id="properties[' + name + ']" name="' + name +
                    '" placeholder="' + placeholder + '" /> ' +
                    placeholder +
                    '</label>' +
                    '</div>' +
                    '</div>' +
                    '</div>');
            }
            if (type == "checkbox_group") {
                $('.options_holder').append(
                    '<div class="panel panel-default">' +
                    '<div class="panel-heading"' +
                    '<h4 class="panel-title">' +
                    '<a style="color: #333333; text-transform: uppercase;" data-toggle="collapse" data-parent="#accordion-options" href="#collapse' +
                    i + '" aria-expanded="false" class="collapsed btn">' +
                    name +
                    '</a>' +
                    '<span class="btn entypo-up pull-right" onclick="push_up(' + i + ');"></span>' +
                    '<span class="btn entypo-down pull-right" onclick="push_down(' + i + ');"></span>' +
                    '<span class="btn entypo-pencil pull-right" onclick="edit_option(' + i + ');"></span>' +
                    '<span class="btn entypo-docs pull-right" onclick="duplicate_option(' + i + ');"></span>' +
                    '<span class="btn entypo-cancel pull-right" onclick="remove_option(' + i + ');"></span>' +
                    '</h4>' +
                    '</div>' +
                    '<div id="collapse' + i + '" class="panel-collapse collapse" aria-expanded="false">' +
                    '<div class="panel-body">' +
                    '<label>' + placeholder + '</label>' +
                    '<input type="text" class="form-control" id="properties[' + name + ']" name="' + name +
                    '" placeholder="' + placeholder + '" />' +
                    '</div>' +
                    '</div>' +
                    '</div>');
            }
            if (type == "radio") {
                $('.options_holder').append(
                    '<div class="panel panel-default">' +
                    '<div class="panel-heading"' +
                    '<h4 class="panel-title">' +
                    '<a style="color: #333333; text-transform: uppercase;" data-toggle="collapse" data-parent="#accordion-options" href="#collapse' +
                    i + '" aria-expanded="false" class="collapsed btn">' +
                    name +
                    '</a>' +
                    '<span class="btn entypo-up pull-right" onclick="push_up(' + i + ');"></span>' +
                    '<span class="btn entypo-down pull-right" onclick="push_down(' + i + ');"></span>' +
                    '<span class="btn entypo-pencil pull-right" onclick="edit_option(' + i + ');"></span>' +
                    '<span class="btn entypo-docs pull-right" onclick="duplicate_option(' + i + ');"></span>' +
                    '<span class="btn entypo-cancel pull-right" onclick="remove_option(' + i + ');"></span>' +
                    '</h4>' +
                    '</div>' +
                    '<div id="collapse' + i + '" class="panel-collapse collapse" aria-expanded="false">' +
                    '<div class="panel-body">' +
                    '<label>' +
                    '<input type="radio" class="form-control" id="properties[' + name + ']" name="' + name +
                    '" placeholder="' + placeholder + '" /> ' +
                    placeholder +
                    '</label>' +
                    '</div>' +
                    '</div>' +
                    '</div>');
            }
            if (type == "date") {
                $('.options_holder').append(
                    '<div class="panel panel-default">' +
                    '<div class="panel-heading"' +
                    '<h4 class="panel-title">' +
                    '<a style="color: #333333; text-transform: uppercase;" data-toggle="collapse" data-parent="#accordion-options" href="#collapse' +
                    i + '" aria-expanded="false" class="collapsed btn">' +
                    name +
                    '</a>' +
                    '<span class="btn entypo-up pull-right" onclick="push_up(' + i + ');"></span>' +
                    '<span class="btn entypo-down pull-right" onclick="push_down(' + i + ');"></span>' +
                    '<span class="btn entypo-pencil pull-right" onclick="edit_option(' + i + ');"></span>' +
                    '<span class="btn entypo-docs pull-right" onclick="duplicate_option(' + i + ');"></span>' +
                    '<span class="btn entypo-cancel pull-right" onclick="remove_option(' + i + ');"></span>' +
                    '</h4>' +
                    '</div>' +
                    '<div id="collapse' + i + '" class="panel-collapse collapse" aria-expanded="false">' +
                    '<div class="panel-body">' +
                    '<label>' + placeholder + '</label>' +
                    '<input type="date" class="form-control" id="properties[' + name + ']" name="' + name +
                    '" placeholder="' + placeholder + '" />' +
                    '</div>' +
                    '</div>' +
                    '</div>');
            }
            if (type == "swatch") {
                $('.options_holder').append(
                    '<div class="panel panel-default">' +
                    '<div class="panel-heading"' +
                    '<h4 class="panel-title">' +
                    '<a style="color: #333333; text-transform: uppercase;" data-toggle="collapse" data-parent="#accordion-options" href="#collapse' +
                    i + '" aria-expanded="false" class="collapsed btn">' +
                    name +
                    '</a>' +
                    '<span class="btn entypo-up pull-right" onclick="push_up(' + i + ');"></span>' +
                    '<span class="btn entypo-down pull-right" onclick="push_down(' + i + ');"></span>' +
                    '<span class="btn entypo-pencil pull-right" onclick="edit_option(' + i + ');"></span>' +
                    '<span class="btn entypo-docs pull-right" onclick="duplicate_option(' + i + ');"></span>' +
                    '<span class="btn entypo-cancel pull-right" onclick="remove_option(' + i + ');"></span>' +
                    '</h4>' +
                    '</div>' +
                    '<div id="collapse' + i + '" class="panel-collapse collapse" aria-expanded="false">' +
                    '<div class="panel-body">' +
                    '<label>' + placeholder + '</label>' +
                    '<input type="color" class="form-control" id="properties[' + name + ']" name="' + name +
                    '" placeholder="' + placeholder + '" />' +
                    '</div>' +
                    '</div>' +
                    '</div>');
            }
        });
    }


    function push_up(key) {
        if (key > 0) {
            options.move(key, key - 1);
            loadOptions();
        }
    }

    function push_down(key) {
        if (key < options.length) {
            options.move(key, key + 1);
            loadOptions();
        }
    }

    function edit_option(key) {
        $('.panel-collapse').attr('class', 'panel-collapse collapse');
        $('.panel-collapse').attr('aria-expanded', 'false');
        $('#collapse' + key).attr('class', 'panel-collapse collapse in');
        $('#collapse' + key).attr('aria-expanded', 'true');
    }

    function duplicate_option(key) {
        let new_fid = "<?php echo time(); ?>_" + options.length;
        let old_fid = options[key]['fid'];

        var fid = new_fid;
        var oid = options[key]['oid'];
        var pid = options[key]['pid'];
        var type = options[key]['type'];
        var name = options[key]['name'];
        var placeholder = options[key]['placeholder'];
        var price = options[key]['price'];
        var required = options[key]['required'];

        if (type == 'select' || type == 'checkbox_group' || type == 'radio') {
            let new_choice = choices.filter(r => r.fid == old_fid);
            console.log("new choices");
            console.log(choices);

            $(new_choice).each(function(i, e) {
                var mc = {};
                mc['oid'] = e['oid'];
                mc['pid'] = e['pid'];
                mc['fid'] = new_fid;
                mc['value'] = e['value'];
                mc['price'] = e['price'];
                choices.push(mc);
            });
        }

        options.push({
            'fid': fid,
            'oid': oid,
            'pid': pid,
            'type': type,
            'name': name,
            'placeholder': placeholder,
            'price': price,
            'required': required
        });

        console.log(options);
        console.log(choices);

        loadOptions();

    }

    function remove_option(key) {
        var result = confirm('Are you sure you want to delete ' + options[key]['name'] + '?');
        if (result) {
            fid = options[key]['fid'];
            choices = choices.filter(e => e.fid != fid);
            options.splice(key, 1);
            loadOptions();

        }
    }

    Array.prototype.move = function(from, to) {
        this.splice(to, 0, this.splice(from, 1)[0]);
    };

    $('.save_options').click(function() {
        $('.saveOffer').attr("disabled", true);
        let this_option = {
            option,
            options,
            choices
        }
        options.updated = '<?php echo time(); ?>'
        $.ajax({
            type: "POST",
            url: base_url + 'create_options/' + option.product_id + '/' + option.shop + '?<?php echo $_SERVER['QUERY_STRING']; ?>',
            data: this_option,
            success: function(response) {
                console.log(response)
                // window.location.href = base_url + "edit_offer/<?php echo $shop; ?>/<?php echo $token ?>/" + response + '?<?php echo $_SERVER['QUERY_STRING']; ?>';
                //$('.data').html(response);
            },
            error: function(r) {
                console.clear()
                console.error(r)
                alert('An error occured');
            }
        });
    });
</script>
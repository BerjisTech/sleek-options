<script>
var choices_arr = [];
var options = <?php echo json_encode($options)?>;
</script>
<style>.form-control{height: 40px; vertical-align: middle; color: #333333; margin: 3px auto;}.choices{border: 1px solid #dfe3e8;} .choices div{background: #CCCCCC; border-radius: 5px; margin: 5px auto; padding: 5px auto;}</style>
<div class="row">
    <div class="col-xs-12" style="border-bottom: 1px solid #dfe3e8; margin-bottom: 10px;">
        <span class="pull-left" style="text-transform: uppercase;"><h2><?php echo urldecode($title); ?></h3></span>
        <span class="btn btn-lg btn-primary pull-right save_options">SAVE OPTIONS</span>
    </div>
    <div class="col-sm-6">
        <div class="panel-group joined options_holder" id="accordion-options">
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
                    <input type="number" class="c_1_p" placeholder="Price" value="0"/>
                    <span class="btn btn-sm entypo-plus pull-right btn-default" onclick="" style="font-weight: bold; margin: 0px;"></span>
                    <span class="btn btn-sm entypo-minus pull-right btn-default" onclick="" style="font-weight: bold; margin: 0px;"></span>
                </div>
                <div class="col-xs-12 c_2" style="padding: 0px;">
                    <span class="btn btn-sm entypo-up pull-left btn-default" onclick="" style="margin: 0px;"></span>
                    <span class="btn btn-sm entypo-down pull-left btn-default" onclick="" style="margin: 0px;"></span>
                    <input type="text" class="c_2_n" placeholder="Choice 2" />
                    <input type="number" class="c_2_p" placeholder="Price" value="0"/>
                    <span class="btn btn-sm entypo-plus pull-right btn-default" onclick="" style="margin: 0px;"></span>
                    <span class="btn btn-sm entypo-minus pull-right btn-default" onclick="" style="margin: 0px;"></span>
                </div>
                <div class="col-xs-12 c_3" style="padding: 0px;">
                    <span class="btn btn-sm entypo-up pull-left btn-default" onclick="" style="margin: 0px;"></span>
                    <span class="btn btn-sm entypo-down pull-left btn-default" onclick="" style="margin: 0px;"></span>
                    <input type="text" class="c_3_n" placeholder="Choice 3" />
                    <input type="number" class="c_3_p" placeholder="Price" value="0"/>
                    <span class="btn btn-sm entypo-plus pull-right btn-default" onclick="" style="margin: 0px;"></span>
                    <span class="btn btn-sm entypo-minus pull-right btn-default" onclick="" style="margin: 0px;"></span>
                </div>
            </div>
            <label class="col-xs-12" style="padding: 0px;"><input type="checkbox" class="option_required" /> Is this field required?</label>
            <button class="btn btn-primary form-control btn-md center col-xs-12 save_option">ADD OPTION</button>
        </form>
    </div>
</div>

<script>
loadOptions();

$('.option_type').change(function(){
    if($(this).val() == 'select' || $(this).val() == 'checkbox_group' || $(this).val() == 'radio'){
        $('.choices').css('display','table');
        $('.option_price').hide();
    }
    else {
        $('.choices').css('display','none');
        $('.option_price').show();
    }

    // 'c_1':{'choice':'','price':''}
});

$('.options_form').submit(function(e) {
    e.preventDefault();
    if($('.option_type').val()==""){
        alert("You need to choose an option style first");
        return;
    }
    var type = $('.option_type').val();
    var name = $('.option_name').val();
    var placeholder = $('.option_placeholder').val();
    var price = $('.option_price').val();
    var choices = '';
    var required = '';
    if ($('.option_required').is(':checked')){
        required = 'true';
    }

    if(type == 'select' || type == 'checkbox_group' || type == 'radio'){
        $('.choices').find('div').each(function(i){
            var this_choice = [];
            $(this).find('input[type="text"]').each(function(){
                this_choice.push($(this).val());
            });
            $(this).find('input[type="number"]').each(function(){
                this_choice.push($(this).val());
            });
            choices_arr.push(this_choice);
        });
        
        var product_id = $('.product_id').val();
        var s_c_a = JSON.stringify(choices_arr);
        console.log(s_c_a);
        console.log(choices_arr);
        choices = s_c_a;
    }
    options.push({
        type,
        name,
        placeholder,
        price,
        choices,
        required
    });

    console.log(options);

    loadOptions();
    clear_selections();
});

function clear_selections(){
    choices_arr = [];
    $('.option_type').prop('selectedIndex',0);
    $('.option_name').val('');
    $('.option_placeholder').val('');
    $('.option_price').val('');
    $('.option_required').val('');
    $('.choices').find('div').each(function(){
        $(this).find('input[type="text"]').each(function(){
            $(this).val('');
        });
        $(this).find('input[type="number"]').each(function(){
            $(this).val('0');
        });
    });
    $('.choices').css('display','none');
    $('.option_price').show();
}

function loadOptions() {
    $('.options_holder').html('');

    $(options).each(function(i, e) {
        var type = options[i]['type'];
        var name = options[i]['name'];
        var placeholder = options[i]['placeholder'];
        var choices = '';
        var price = options[i]['price'];
        var required = options[i]['required'];
        var el_type = '';

        if(options[i]['choices'] != ''){
            choices = JSON.parse(options[i]['choices']);
        }
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
                '<select class="form-control select sleek_options_' + name + '" id="properties[' + name +
                ']" name="' + name + '"></select>' +
                '</div>' +
                '</div>' +
                '</div>');
            $('.sleek_options_' + name + '')
                .append($("<option></option>")
                    .attr("value", "")
                    .text(placeholder));

            // var value_arr = value.split(',');
            $(choices).each(function (key) {
                var c_v = choices[key][0];
                var c_p = choices[key][1];
                $('.sleek_options_' + name + '')
                    .append($("<option></option>")
                        .attr("value", c_v)
                        .text(c_v + ' (<?php echo $currency; ?>' + c_p + ')'));
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
                '<input type="checkbox" class="form-control" id="properties[' + name + ']" name="' + name +
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
                '<input type="text" class="form-control" id="properties[' + name + ']" name="' + name +
                '" placeholder="' + placeholder + '" />' +
                '</div>' +
                '</div>' +
                '</div>');
        }
    });
}

function push_up(key) {
    if(key>0){
        options.move(key,key-1);
        loadOptions();
    }
}

function push_down(key) {
    if(key<options.length){
        options.move(key,key+1);
        loadOptions();
    }
}

function edit_option(key) {
    $('.panel-collapse').attr('class','panel-collapse collapse');
    $('.panel-collapse').attr('aria-expanded','false');
    $('#collapse'+key).attr('class','panel-collapse collapse in');
    $('#collapse'+key).attr('aria-expanded','true');
}

function duplicate_option(key) {
    var type = options[key]['type'];
    var name = options[key]['name'];
    var placeholder = options[key]['placeholder'];
    var price = options[key]['price'];
    var choices = options[key]['choices'];
    var required = options[key]['required'];

    options.push({
        type,
        name,
        placeholder,
        price,
        choices,
        required
    });

    console.log(options);

    loadOptions();
}

function remove_option(key) {
    var result = confirm('Are you sure you want to delete '+options[key]['name']+'?');
    if (result) {
        options.splice(key, 1);
        loadOptions();
    }
}

Array.prototype.move = function (from, to) {
  this.splice(to, 0, this.splice(from, 1)[0]);
};

$('.save_options').click(function(){
    options_array = [];
    options_array['product_id'] = '<?php echo $product; ?>';
    options_array['product_options'] = JSON.stringify(options);
    options_array['shop'] = '<?php echo $shop; ?>';
    options_array['option_date'] = '<?php echo time(); ?>';
    console.log(options_array);
    $.ajax({
        type: "POST",
        url: base_url + 'create_options',
        data: { 
            'product_id' : $('.product_id').val(),
            'product_options' : JSON.stringify(options),
            'shop' : '<?php echo $shop; ?>',
            'option_date' : '<?php echo time(); ?>'
         },
        success: function(response) {
            alert(response);
            //$('.data').html(response);
        },
        error: function(e) {
            console.error(e)
            alert('An error occured');
        }
    });
});
</script>
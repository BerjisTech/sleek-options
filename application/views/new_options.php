
bish
<div class="row">
    <div class="col-xs-12"> 
        <div class="input-group col-xs-12"> 
            <span class="twitter-typeahead" style="position: relative; display: inline-block;">
                <input type="hidden" class="product_id" /> 
                <input
                type="text" class="form-control product_name"
                placeholder="Type product name to start"
                autocomplete="off"
                style="position: relative; vertical-align: top;">
            </span> 
            <span class="input-group-addon btn-danger"><i class="entypo-cancel"></i></span> 
        </div>
    </div>

    <div class="col-sm-4">
        <select class="option_type form-control col-xs-12">
            <option value="">Select option type</option>
            <option value="text">Single line text</option>
            <option value="textarea">Paragraph</option>
            <option value="select">Drop down</option>
            <option value="checkbox">Multiple options</option>
            <option value="radio">Single option</option>
            <option value="date">Date</option>
            <option value="number">Number</option>
        </select>
        <input type="text" class="option_name form-control col-xs-12" placeholder="Option name" />
        <input type="text" class="option_placeholder form-control col-xs-12" placeholder="Option placeholder" />
        <input type="text" class="option_value form-control col-xs-12" placeholder="Option value" />
        <label class="col-xs-12"><input type="checkbox" class="option_required"/> Is this field required?</label>
        <button class="btn btn-primary form-control btn-md center col-xs-12 save_option">ADD OPTION</button>
    </div>
    <div class="col-sm-8 options_holder">

    </div>
</div>

<script>
var options = [];
$('.save_option').click(function(){
    var product_id = $('.product_id').val();

    var type = $('.option_type').val();
    var name = $('.option_name').val();
    var placeholder = $('.option_placeholder').val();
    var value = $('.option_value').val();
    var required = $('.option_required').val();

    options.push({type, name, placeholder, value, required});

    console.log(options);

    loadOptions();
});

function loadOptions(){
    $('.options_holder').html('');

    $(options).each(function(i, e){
        var type = options[i]['type'];
        var name = options[i]['name'];
        var placeholder = options[i]['placeholder'];
        var value = options[i]['value'];
        var required = options[i]['required'];
        var el_type = '';

        if(type=="select"){
            $('.options_holder').append(
                  '<div class="input-group col-xs-12">'
                + '<select class="form-control select sleek_options_'+name+'" id="properties['+name+']" name="'+name+'"></select>'
                + '<span class="input-group-addon">'
                + '<i class="entypo-up btn btn-primary"></i><br />'
                + '<i class="entypo-down btn btn-primary"></i></span> '
                + '</div>');
            $('.sleek_options_'+name+'')
                    .append($("<option></option>")
                                .attr("value", "")
                                .text(placeholder));

            var value_arr = value.split(',');
            console.log(value_arr);
            $.each(value_arr, function(key, value) {   
                $('.sleek_options_'+name+'')
                    .append($("<option></option>")
                                .attr("value", value)
                                .text(value)); 
            });
        }
    });
}
</script>bish
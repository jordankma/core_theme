$(document).ready(function () {
    $("body").on('click', '.select-box', function () {
        var type = $(this).data("type");
        var parent_field = $(this).data("parent-field");
        var params = $(this).data("params");
        var name = $(this).data("params_hidden");
        var api = $(this).data("api");
        var parent_field_arr = parent_field.split(",");
        var params_search = "";
        for(var i = 0; i<parent_field_arr.length; i++) {
            params_search += "&" + parent_field_arr[i] + "=" + $(parent_field_arr[i]).val(); 
        }
        if( type=="api"){
            var option_select = "#" + params + " option:selected"; 
            var name_curent = $(option_select).text();
            var input_name = 'input[name=' + name + ']';
            console.log(input_name);
            $(input_name).val(name_curent);

            var url = api + params_search;
            $.ajax({
                url: url,
                type: 'GET',
                cache: false,
                success: function (data, status) {
                    alert('1');
                    var data = data.data;
                    console.log('11'.data);
                    var str = '<option>'+ +'</option>';
                    for(i = 0; i<data.length; i++) {
                        str += '<option value="' + data[i].key + '" >' + data[i].value + '</option>';
                    }  
                    $('#params').html('');
                    $('#params').append(str);
                },
                error: function(data, status){
                    console.log('fails');
                }
            }, 'json');
        }
    });
});
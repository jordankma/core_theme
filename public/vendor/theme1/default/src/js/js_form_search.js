$(document).ready(function () {
    $("body").one('click', '.select-box', function () {
        var type = $(this).data("type");  //kieu api | data
        var parent_field = $(this).data("parent-field"); //field cha 1 array
        var params = $(this).data("params"); //id 
        var params_hidden = $(this).data("params-hidden");
        var api = $(this).data("api"); //api get data
        var parent_field_arr = parent_field.split(",");
        if(parent_field != ''){
            var option_select = "#" + params + " option:selected"; 
            var name_curent = $(option_select).text();
            var input_name = 'input[name=' + params_hidden + ']';
            $(input_name).val(name_curent);
        }
        if( type=="api")
        {
            var params_search = "";
            var value_parent = "";
            var value_curent = "";
            var flag = false;
            for(var i = 0; i<parent_field_arr.length; i++) {
                value_parent = $('#' + parent_field_arr[i] + ' option:selected').val() != '' ? $('#' + parent_field_arr[i] + ' option:selected').val() : '';
                value_curent = $(this).data(parent_field_arr[i]);
                if(value_parent != value_curent){
                    flag = true; break;
                }
                // $(this).attr('data-' + parent_field_arr[i], '222');
                // params_search += "&" + parent_field_arr[i] + "=" + value; 
            }
            if(flag == true){
                for(var i = 0; i<parent_field_arr.length; i++) {
                    value_parent = $('#' + parent_field_arr[i] + ' option:selected').val() != '' ? $('#' + parent_field_arr[i] + ' option:selected').val() : '';
                    value_curent = $(this).data(parent_field_arr[i]);
                    $(this).attr('data-' + parent_field_arr[i], value_parent);
                    params_search += "&" + parent_field_arr[i] + "=" + value_parent; 
                } 
                var url = api + params_search;
                $.ajax({
                    url: url,
                    type: 'GET',
                    cache: false,
                    success: function (data, status) {
                        var data = data.data;
                        var str = '<option>'+'</option>';
                        for(i = 0; i<data.length; i++) {
                            str += '<option value="' + data[i].key + '" >' + data[i].value + '</option>';
                        }  
                        var params_tmp = '#' + params;
                        $(params_tmp).html('');
                        $(params_tmp).append(str);
                    },
                    error: function(data, status){
                        console.log('fails');
                    }
                }, 'json');   
            }
        }
    });
});
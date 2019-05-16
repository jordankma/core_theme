$(document).ready(function () {
    // $(".select-box").mouseover(function () {
    //     var params = $(this).data("params");
    //     var params_tmp = '#' + params;   
    //     $(params_tmp).text('');
    //     $(params_tmp).html(str);
    // });
    $("body").on('mouseover','.select-box',function () {

        var _this = $(this);
        _this.attr('disabled','');
        setTimeout(function(){ 
            _this.removeAttr('disabled','disabled');
        }, 100);
        var type = _this.data("type");  //kieu api | data
        var parent_field = _this.data("parent-field"); //field cha 1 array
        var params = _this.data("params"); //id 
        var params_hidden = _this.data("params-hidden");
        var api = _this.data("api"); //api get data
        
        console.log(api);
        if( type=="api" && parent_field != '')
        {
            if(parent_field != ''){
                var option_select = "#" + params + " option:selected"; 
                var name_curent = $(option_select).text();
                var input_name = 'input[name="' + params_hidden + '"]';
                $(input_name).val(name_curent);
            }
            _this.attr('disabled');
            var parent_field_arr = parent_field.split(",");
            var params_search = "";
            var value_parent = "";
            var value_curent = "";
            var flag = false;
            for(var i = 0; i<parent_field_arr.length; i++) {
                var e = document.getElementById(parent_field_arr[i]);
                var value_parent = e.options[e.selectedIndex].value != '' ? e.options[e.selectedIndex].value : '';
                value_curent = _this.attr('data-' + parent_field_arr[i]);
                if(value_parent != value_curent){
                    flag = true; break;
                }
            }
            // console.log(flag);
            if(flag == true){
                for(var i = 0; i<parent_field_arr.length; i++) {
                    var e = document.getElementById(parent_field_arr[i]);
                    var value_parent = e.options[e.selectedIndex].value != '' ? e.options[e.selectedIndex].value : '';
                    value_curent = _this.attr('data-' + parent_field_arr[i]);
                    _this.attr('data-' + parent_field_arr[i], value_parent);
                    params_search += "&" + parent_field_arr[i] + "=" + value_parent;
                } 
                var loadSelect = function(){
                    var url = api + params_search;
                    $.ajax({
                        url: url,
                        type: 'GET',
                        cache: false,
                        success: function (data, status) {
                            var data = data.data;
                            // var str = '<option>'+'</option>';
                            var str = '<option value="">Tất cả</option>';
                            for(i = 0; i<data.length; i++) {
                                str += '<option value="' + data[i].key + '" >' + data[i].value + '</option>';
                            }  
                            var params_tmp = '#' + params;
                            $(params_tmp).text('');
                            $(params_tmp).html(str); 
                            _this.removeAttr('disabled');
                        },
                        error: function(data, status){
                            _this.removeAttr('disabled');
                        }
                    }, 'json');   
                };
                loadSelect();
            }
        }
        else if(type=="api" && parent_field == ''){
            var loadSelect = function(){
                var url = api;
                $.ajax({
                    url: url,
                    type: 'GET',
                    cache: false,
                    success: function (data, status) {
                        var data = data.data;
                        // var str = '<option>'+'</option>';
                        var str = '';
                        for(i = 0; i<data.length; i++) {
                            str += '<option value="' + data[i].key + '" >' + data[i].value + '</option>';
                        }  
                        var params_tmp = '#' + params;
                        $(params_tmp).text('');
                        $(params_tmp).html(str); 
                        _this.removeAttr('disabled');
                    },
                    error: function(data, status){
                        _this.removeAttr('disabled');
                    }
                }, 'json');   
            };
            loadSelect();
        }
    });
});
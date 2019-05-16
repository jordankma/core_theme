$(document).ready(function () {
    var url = 'http://cuocthi.vnedutech.vn/resource/dev/get/vne/getallprovince';
    $.ajax({
        url: url,
        type: 'GET',
        dataType: "text json",
        cache: false,
        success: function (data, status) {
            var data = data.data;
            var str = '<option>Chọn Tỉnh/TP</option>';
            for(i = 0; i<data.length; i++) {
                str += '<option value="' + data[i]._id + '" >' + data[i].province + '</option>';
            }  
            $('#province_id').html('');
            $('#province_id').append(str);   
        },
        error: function(data, status){
            console.log('fails');
        }
    });
    $('body').on('mouseover','.select-box', function () {

    // })
    // $(".select-box").mouseover(function () {

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
                if(value_parent && (value_parent != value_curent)){
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
                            var str = '<option>Chọn</option>';
                            for(i = 0; i<data.length; i++) {
                                str += '<option value="' + data[i].key + '" >' + data[i].value + '</option>';
                            }
                            var params_tmp = '#' + params;
                            $(params_tmp).text('');
                            console.log(str);
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
                        var str = '<option>Chọn</option>';
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

    $("body").on('change', '#object', function () {
        var object_id = $(this).val();
        var object_name = $("#object option:selected").text();
        $('input[name=object_name]').val(object_name);
        $.get("/get-form-register?object_id="+object_id , function(data, status){
            $('#info-member').html('');
            setTimeout(function() {
                $('#info-member').append(data.str);
            }, 500);
        });
    });
    
    $("body").on('change', '.autoload', function () {
        var key = $(this).data('key');
        var key2 = $(".autoload option:selected").data('key2');
        var id_area_append = 'area-type-' + key;
        var url = route_get_form_register + "?key="+key +"&key2="+key2;
        $.get(url , function(data, status){
            $(id_area_append).html('');
            setTimeout(function() {
                // console.log(id_area_append);

                $('#' + id_area_append).html('');
                $('#' + id_area_append).append(data.str);
                $('.auto-load-2').attr('data-key',key);
                $('.auto-load-2').attr('data-key2',key2);
            }, 500);
        });
    });
    $("body").on('change', '.auto-load-2', function () {
        var key = $(this).data('key');
        var key2 = $(this).data('key2');
        var key3 = $(".auto-load-2 option:selected").val();
        var id_area_append = 'area-auto-load-2';
        var url = route_get_form_register_2 + "?key="+key +"&key2="+key2 +"&key3="+key3 ;
        $.get(url , function(data, status){
            $(id_area_append).html('');
            setTimeout(function() {
                // console.log(id_area_append);

                $('#' + id_area_append).html('');
                $('#' + id_area_append).append(data.str);
                $('.auto-load-2').attr('data-key',key);
                $('.auto-load-2').attr('data-key2',key2);
                $('.btn-save').prop("disabled", false);
                $('.btn-save').css("background", '#ffb400');

            }, 500);
        });
    });


    $("body").on('change', '#province_id', function () {
        var province_id = $(this).val();
        var province_name = $("#province_id option:selected").text();
        $('input[name=province_name]').val(province_name);
        var url = 'http://cuocthi.vnedutech.vn/resource/dev/get/vne/getdistrictbyprovince?province_id='+ province_id;
        $.ajax({
            url: url,
            type: 'GET',
            cache: false,
            success: function (data, status) {
                var data = data.data;
                var str = '<option></option>';
                for(i = 0; i<data.length; i++) {
                    str += '<option value="' + data[i]._id + '" >' + data[i].district + '</option>';
                }
                $('#district_id').html('');
                $('#district_id').append(str);
            }
        }, 'json');
    });

    $("body").on('change', '#district_id', function () {
        var district_id = $(this).val();
        var district_name = $("#district_id option:selected").text();
        $('input[name=district_name]').val(district_name);
        // var url = $(this).data("api") + '?district_id=' + district_id;
        var url = 'http://cuocthi.vnedutech.vn/resource/dev/get/vne/getschoolbydistrict?district_id='+ district_id;
        $.ajax({
            url: url,
            type: 'GET',
            cache: false,
            data: {
                'district_id': district_id,
                'district_name' : district_name,
                'url' : url
            },
            success: function (data, status) {
                var data = data.data;
                var str = '<option value="0" >Chọn trường</option>';
                for(i = 0; i<data.length; i++) {
                    str += '<option value="' + data[i]._id + '" >' + data[i].schoolname + '</option>';
                }  
                $('#school_id').html('');
                $('#school_id').append(str);
            }
        }, 'json');
    });

    $("body").on('change', '#school_id', function () {
        var school_name = $("#school_id option:selected").text();
        $('input[name=school_name]').val(school_name);
    });
    $("body").on('change', '#class_id', function () {
        var class_name = $("#class_id option:selected").text();
        $('input[name=class_name]').val(class_name);
    });
    $("body").on('change', '#target', function () {
        var class_name = $("#target option:selected").text();
        $('input[name=target_name]').val(class_name);
    });
});
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
                console.log(id_area_append);
                $('#' + id_area_append).html('');
                $('#' + id_area_append).append(data.str);
                // $('.btn-save').disabled = false;
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
                // var str = '<option value="0" >Chọn trường</option>';
                var str = '';
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
        console.log(class_name);
        $('input[name=class_name]').val(class_name);
    });
    $("body").on('change', '#target', function () {
        var class_name = $("#target option:selected").text();
        $('input[name=target_name]').val(class_name);
    });
});
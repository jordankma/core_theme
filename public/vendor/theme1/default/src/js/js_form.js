$(document).ready(function () {
    // var data = [
    //     {
    //     "_id": 1,
    //     "province": "Thanh Hóa",
    //     "alias": "thanh-hoa",
    //     "region": "trung",
    //     "updated_at": "2018-10-10 16:23:23",
    //     "created_at": "2018-10-10 16:23:23"
    //     },
    //     {
    //     "_id": 2,
    //     "province": "Nghệ An",
    //     "alias": "nghe-an",
    //     "region": "trung",
    //     "updated_at": "2018-10-10 16:23:23",
    //     "created_at": "2018-10-10 16:23:23"
    //     }
    // ];
    // // var data = JSON.parse(data);
    // var str = '<option></option>';
    // for(i = 0; i<data.length; i++) {
    //     str += '<option value="' + data[i]._id + '" >' + data[i].province + '</option>';
    // }   
    // $('#province_id').html('');
    // $('#province_id').append(str);
    var url = 'http://cuocthi.vnedutech.vn/resource/dev/get/vne/getprovince/';
    $.ajax({
        url: url,
        type: 'GET',
        success: function (data, status) {
            // var data = JSON.parse(data);
            alert('111asdasdasd');
            // var str = '<option></option>';
            // for(i = 0; i<data.data.length; i++) {
            //     str += '<option value="' + data.data[i]._id + '" >' + data.data[i].province + '</option>';
            // }   
            // $('#province').html('');
            // $('#province').append(str);
        },
        error: function(data, status){
            alert(status);
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
        $.get("/get-form-register?key="+key +"&key2="+key2 , function(data, status){
            $(id_area_append).html('');
            setTimeout(function() {
                console.log(id_area_append);
                $('#' + id_area_append).append(data.str);
            }, 500);
        });
    });


    $("body").on('change', '#province_id', function () {
        var province_name = $("#province_id option:selected").text();
        $('input[name=province_name]').val(province_name);
        var data = [
            {
            "_id": 28,
            "district": "Anh Sơn",
            "alias": "anh-son",
            "province_id": 2,
            "province": "Nghệ An",
            "updated_at": "2018-10-10 02:15:09",
            "created_at": "2018-10-10 02:15:09"
            },
            {
            "_id": 29,
            "district": "Con Cuông",
            "alias": "con-cuong",
            "province_id": 2,
            "province": "Nghệ An",
            "updated_at": "2018-10-10 02:15:09",
            "created_at": "2018-10-10 02:15:09"
            }
        ];
        console.log(data);
        var str = '<option></option>';
        for(i = 0; i<data.length; i++) {
            str += '<option value="' + data[i]._id + '" >' + data[i].district + '</option>';
        }   
        $('#district_id').html('');
        $('#district_id').append(str);
        // var city_id = $(this).val();
        // var city_name = $("#city option:selected").text();
        // $('input[name=city_name]').val(city_name);
        // var url = 'http://cuocthi.vnedutech.vn/resource/dev/get/vne/getdistricts/'+ city_id;
        // $.ajax({
        //     url: url,
        //     type: 'GET',
        //     cache: false,
        //     success: function (data, status) {
        //         var data = JSON.parse(data);
        //         console.log(data);
        //         var str = '<option></option>';
        //         for(i = 0; i<data.length; i++) {
        //             str += '<option value="' + data[i]._id + '" >' + data[i].district + '</option>';
        //         }   
        //         $('#district').html('');
        //         $('#district').append(str);
        //     }
        // }, 'json');
    });

    $("body").on('change', '#district_id', function () {
        var district_name = $("#district_id option:selected").text();
        $('input[name=district_name]').val(district_name);
        var data = [
        {
        "_id": 31467,
        "schoolname": "Trường Cao đẳng Kỹ thuật Công nghiệp Bắc Giang",
        "schooladdress": null,
        "schoolphone": 0,
        "schoolprovince": 13,
        "schooldistrict": 0,
        "schoollevel": 4,
        "updated_at": "2018-11-01 13:59:05",
        "created_at": "2018-11-01 13:59:05"
        },
        {
        "_id": 31468,
        "schoolname": "Trường Cao đẳng nghề Bắc Giang",
        "schooladdress": null,
        "schoolphone": 0,
        "schoolprovince": 13,
        "schooldistrict": 0,
        "schoollevel": 4,
        "updated_at": "2018-11-01 13:59:05",
        "created_at": "2018-11-01 13:59:05"
        }];
        var str = '<option></option>';
        for(i = 0; i<data.length; i++) {
            str += '<option value="' + data[i]._id + '" >' + data[i].schoolname + '</option>';
        }   
        $('#school_id').html('');
        $('#school_id').append(str);
        // var district_id = $(this).val();
        // var district_name = $("#district option:selected").text();
        // $('input[name=district_name]').val(district_name);
        // // var url = $(this).data("api") + '?district_id=' + district_id;
        // var url = 'http://cuocthi.vnedutech.vn/resource/dev/get/vne/getschools/'+ district_id;
        // $.ajax({
        //     url: url,
        //     type: 'GET',
        //     cache: false,
        //     data: {
        //         'district_id': district_id,
        //         'district_name' : district_name,
        //         'url' : url
        //     },
        //     success: function (data, status) {
        //         var data = JSON.parse(data);
        //         var str = '<option value="0" >Chọn trường</option>';
        //         for(i = 0; i<data.length; i++) {
        //             str += '<option value="' + data[i]._id + '" >' + data[i].schoolname + '</option>';
        //         }   
        //         $('#school').html('');
        //         $('#school').append(str);
        //     }
        // }, 'json');
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
});
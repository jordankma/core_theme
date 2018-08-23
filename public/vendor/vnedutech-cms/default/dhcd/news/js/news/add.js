$(document).ready(function() {
    $('#cate').multiselect({
    	buttonWidth: '100%',
        nonSelectedText: 'Chọn danh mục',
        enableFiltering: true,
    });
    $('#tag').multiselect({
    	buttonWidth: '100%',
        nonSelectedText: 'Chọn tag',
        enableFiltering: true,
    });
});
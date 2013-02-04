// JavaScript Document
$("#name").keyup(function () {
    var value = $(this).val();
	value = value.replace(/\W/g,'-').toLowerCase();
	
    $("#slug").text(value);
	$(".slug").val(value);
}).keyup();

CKEDITOR.replace( 'ckeditor',
    {
        toolbar : 'Full',
    });

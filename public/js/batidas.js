$(function () {

	var matricula = $('#matricula').val();
	console.log(matricula);
	$("#matricula").val(matricula);

	function getbatidas() {
        $.ajax({
            type:'POST',
            url:'',
            data:'_token = <?php echo csrf_token() ?>',
            success:function(data) {
               $("#msg").html(data.msg);
            }
        }).done(function(data){
       		$.each(data, function(index, value){ 
         		$( "" ).html(value.batidas);
        	});
 		});

}

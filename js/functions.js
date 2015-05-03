$(function(){
	$('a.letra').on('click', function(){
		var letraClicada = $(this).attr('id');
		var r1 = Number($('#r1').val());
		var r2 = Number($('#r2').val());
		var r3 = Number($('#r3').val());

		var decript = $('#decript').prop('checked');
		if(decript == true){
			var decodificar = 1;
		}else{
			var decodificar = 0;
		}

		r1++;
		if(r1 == 26){
			r1 = 0;
			r2++;
			if(r2 == 26){
				r2 = 0;
				r3++;
				if(r3 == 26){
					r3 = 0;
				}
			}
		}

		$('#r1').val(r1);
		$('#r2').val(r2);
		$('#r3').val(r3);

		$.post('sys/codifica_decodifica.php', {
			decodificar: decodificar,
			r1: r1,
			r2: r2,
			r3: r3,
			letraClicada: letraClicada
		},function(retorno){
			$('span.resultado').append(retorno);
		});
	});
});
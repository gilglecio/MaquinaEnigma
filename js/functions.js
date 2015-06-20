$(function(){
	$('a.letra').on('click', function() {

		var letraClicada = $(this).attr('id');

		/*var r1 = Number($('#r1').val());
		var r2 = Number($('#r2').val());
		var r3 = Number($('#r3').val());*/

		var rotores = [];

		
		$('.inputRotor').each(function(i, rotor){
			rotores.push(Number($(rotor).val()));
			
		});
		rotores.reverse();
		console.log(rotores);
		

		var decript = $('#decript').prop('checked');
		
		if(decript == true){
			var decodificar = 1;
		}else{
			var decodificar = 0;
		}

		function recursivo(rotor){
			if(!rotor)
				rotor = 0;
			if(typeof rotores[rotor] != 'undefined'){
				if(rotores[rotor] == 26){
					rotores[rotor] = 1;
					recursivo(rotor+1);
				}else{
					rotores[rotor] += 1;
				}
				$('#r'+(rotor+1)).val(rotores[rotor]);
			}
		}
		recursivo();

		$.post('sys/codifica_decodifica.php', {
			decodificar: decodificar,
			initRotors: $.parseJSON($('[data-rotors]').attr('data-rotors')),
			letraClicada: letraClicada
		},function(retorno){
			$('span.resultado').append(retorno);
		});
	});
});
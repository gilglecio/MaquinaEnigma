$(function(){

	var current = 0;
	var text = '';
	var chars = [];

	function convertToSlug(Text) {
    	return Text.toUpperCase().replace(/[^\w -]+/g,'');
	}

	$('#decript').on('click', function () {
		
		var rotors = $.parseJSON($('#rotors').attr('data-rotors'));
		
		$.each(rotors, function (i, v) {
			$('#r' + (i + 1)).val(v);
		});

		chars = [];
		current = 0;

		$('a.letra').removeClass('click');
	});

	$('#iniciar').on('click', function () {
		
		text = convertToSlug( $('#text').val()).replace('  ', ' ');

		console.log('text', text);

		$('#text').val(text);

		for(c in text) {
			chars.push(text[c]);
		};

		$('#' + chars[current]).click();
	});

	$('a.letra').on('click', function(e) {

		$('a.letra').removeClass('click');

		$(this).addClass('click');

		e.preventDefault();

		var letraClicada = $(this).attr('id');

		var rotores = [];
		
		$('.inputRotor').each(function(i, rotor){
			rotores.push(Number($(rotor).val()));
		});

		rotores.reverse();

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
			initRotors: rotores,
			letraClicada: letraClicada
		},function(retorno){

			chars[current] = retorno;

			$('#text').val(chars.join(''));
			
			current++;

			if (chars[current]) {
				$('#' + chars[current]).click();	
			};

		});
		return false;
	});
});
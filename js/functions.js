$(function(){

	var current = 0;
	var text = '';
	var chars = [];
	var spaces = [];

	function convertToSlug(Text) {
    	return Text.toLowerCase().replace(/[^\w -]+/g,'');
	}

	function sleep(delay) {
    	var start = new Date().getTime();
    	while (new Date().getTime() < start + delay);
  	}

	$('body').on('click', '#decript', function () {
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

		$('#text').val(text);

		for(c in text) {
			if (text[c] == ' ') {
				spaces[c] = c;
			} else {
				chars[c] = text[c];
			};
		};
		$('#' + chars[current]).click();
	});
	
	var plugsCriados = {};
	var pares = [];
	var jaClicados = [];
	var i = 0;

	function in_array(valor, array){
		for(var i =0; i<array.length;i++){
			if(array[i] == valor){
				return true;
			}
		}
	}

	function visualizarPlugs(){
		if(Object.keys(plugsCriados).length > 0){
			$('#meusPlugs').show();
			
			$('select[name=plugsCriados]').html('<option value="" selected>Veja seus plugs...</option>');
			$.each(plugsCriados, function(a, b){
				$('select[name=plugsCriados]').append('<option value="">'+a+' => '+b+'</option>');
			});
		}
	}

	$('#addplug').on('click', function(){
		var prop = $(this).prop('checked');
		if(!prop){
			$('a.letra').removeClass('click');
			if(Object.keys(plugsCriados).length > 0){
				$.ajax({
					type: 'POST',
					url: 'sys/addPlugs.php',
					data: {plugsCriados: plugsCriados}
				});
			}
		}
	});

	$('#removePlugs').on('click', function(){
		if(Object.keys(plugsCriados).length > 0){
			plugsCriados = {};
			pares = [];
			jaClicados = [];
			i = 0;

			$('select[name=plugsCriados]').html('');
			$('#meusPlugs').hide();
			$('a.letra').removeClass('click');

		}
	});
	$('a.letra').on('click', function(e) {
		var letraClicada = $(this).attr('id');
		var plugs = $('#addplug').prop('checked');

		if(plugs == true){
			if(!in_array(letraClicada, jaClicados)){
				$(this).addClass('click');
				i++;
				jaClicados.push(letraClicada);
				
				pares.push(letraClicada);

				if(i%2 == 0){
					plugsCriados[pares[0]] = pares[1];
					visualizarPlugs();
					//console.log(plugsCriados);
					pares = [];
				}
			}

			
		}else{
			$(this).addClass('click');

			e.preventDefault();

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

				sleep(200)

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
			},function(retorno) {

				$('a.letra').removeClass('click');

				if (in_array(current-1, Object.keys(spaces))) {
					chars[current-1] = ' ';
				};

				chars[current] = retorno;

				$('#text').val(chars.join(''));
				
				current++;

				if (chars[current]) {
					$('#' + chars[current]).click();	
				} else if (chars[++current]) {
					$('#' + chars[current]).click();
				};

			});
			return false;
		}
	});

	var nrotor = 2;
	$('.more').on('click', function(){

		var rotor = '<label><span>Rotor '+nrotor+'</span><input type="text" name="r'+nrotor+'" id="r'+nrotor+'" value="1" maxlength="2" class="rotorAdd"/></label>';
		$('#maisRotores').append(rotor);
		nrotor++;
	});
	var addArray = [];
	$('#add').on('click', function(){
		
		$('.rotorAdd').each(function(i, rotor){
			var valor = Number( $.trim($(rotor).val()) );
			if(valor >= 26){
				valor = 25;
				$(rotor).val(valor);
			}
			addArray.push(valor);
		});

		$.ajax({
			method: 'POST',
			url: 'sys/seta-rotores.php',
			data: {rotoresAdd: addArray},
			success: function(retorno){
				if(retorno == 'ok'){
					location.href="maquina.php";
				}
			}
		});
	});

	$('body').on('keydown', '.rotorAdd', function(e){
		if(e.which == 9){
			var index = $('.rotorAdd').index(this);
			$('.more').click();
			setTimeout(function(){
				$('.rotorAdd:eq('+(index+1)+')').focus();
			}, 500);
		}
	});
	
});
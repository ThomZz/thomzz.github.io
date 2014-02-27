$("head").append('<script type="text/javascript" src="javascripts/complexify.js"></script>');


$(document).ready(function () {	
	// Fonction qui sert a valider les champs "occurences minimales".
	function validate_total() {
		var capsMin    = isNaN(parseInt($("#txtCapsMin").val())) 	? 0 : parseInt($("#txtCapsMin").val());
		var symbolsMin = isNaN(parseInt($("#txtSymbolsMin").val())) ? 0 : parseInt($("#txtSymbolsMin").val());
		var numbersMin = isNaN(parseInt($("#txtNumbersMin").val())) ? 0 : parseInt($("#txtNumbersMin").val());
		var lowersMin  = isNaN(parseInt($("#txtLowersMin").val()))  ? 0 : parseInt($("#txtLowersMin").val());
		
		if ((capsMin + lowersMin + symbolsMin + numbersMin) > $("#txtPassLength").val())
		{	
			$("#errorNums").show();
			$("#errorNums").text('Le total des occurences minimales ne peut excéder la longueur du mot de passe');
			return false;
		}
		else
		{
			$("#errorNums").hide();
			$("#errorNums").text('');
			return true;
		}	
	}
	//Gestion de l'états des champs d'options/erreurs lors du chargement de la page (après submit).
	function controls_state (p_type) {
	  if (p_type == "caps")
	  {
		if ($("#chkNoCaps").prop('checked') == true)
		{
			$("#errorNums").hide();
			$("#txtCapsMin").prop('disabled', true);
			$("#txtCapsMin").val(0);
		}
		else
			$("#txtCapsMin").prop('disabled', false);
	  }
	  else if (p_type == "symbols")
	  {
		if ($("#chkNoSymbols").prop('checked') == true) 
		{
			$("#errorNums").hide();
			$("#txtSymbolsMin").prop('disabled', true);
			$("#txtSymbolsMin").val(0);
		}
		else
			$("#txtSymbolsMin").prop('disabled', false);
	  }
	}
	 //Click sur l'onglet "options".
	$("#onglet_trigger").click(function() {
		if ($('#options_section').is(":hidden")) {
			$('#options_section').slideDown(500);
			$('#hide_options').val('0');
		}
		else {
			$('#options_section').slideUp(500);
			$('#hide_options').val('1');
		}
	});
	
	//Transition du style de l'onglet options en hover/mouseout.
	$("#onglet_trigger").mouseover(function() {
		$(this).addClass('onglet_hover');
	});
	
    $(".onglet").mouseout(function() { 
		$(this).removeClass('onglet_hover');
	});
	
	//A la perte de focus, appel de la fonction pour valider les champs d'occurences minimales.
	$(".mins").blur(function() {
		var Length = isNaN(parseInt($(this).val())) 	? 0 : parseInt($(this).val());
		if (Length <= 0)
			$(this).val(0); //Mettre le champs a 0 si on entre des caractère ou une valeur inférieure a 0.
		if (validate_total()) 
			return;
	});
	
	$("#txtPassLength").blur(function() {
		var passLength    = isNaN(parseInt($(this).val())) 	? 0 : parseInt($(this).val());
		if (passLength < 8)
			$(this).val(8);
		else if (passLength > 128)
			$(this).val(128);
		if (validate_total()) 
			return;
	});

	//Valider les occurences minimales au submit aussi.
	$("#generator").submit(function(event) {
		if (validate_total())
			return;
		else
			event.preventDefault();
	});
	
	//Gestion du "halo" verts autour des checkboxes lors du click/perte de focus.
	$('input[type=text]').focus(function() {
		$(this).addClass('textbox_focus');
	});
	
	$('input[type=text]').blur(function() {
		$(this).removeClass('textbox_focus');
	});
	
	//Validation lors de click sur le checkbox "Ne pas utiliser de majuscules".
	$("#chkNoCaps").click(function(){controls_state("caps");});
    
	//Validation lors de click sur le checkbox "Ne pas utiliser de symboles".
	$("#chkNoSymbols").click(function(){controls_state("symbols");});
	
	//Gestion de la barre de progrès pour la complexité du mot de passe.
	$(function () {
        $("#pass").complexify({}, function (valid, complexity) {
            if (Math.round(complexity) < 30)
                $('#progress').css({'width':complexity + '%'}).removeClass('progressbarValid progressbarValidMed').addClass('progressbarInvalid');
            else if (Math.round(complexity) >= 30 && Math.round(complexity) < 60)
                $('#progress').css({'width':complexity + '%'}).removeClass('progressbarInvalid progressbarValid').addClass('progressbarValidMed');
            else 
				$('#progress').css({'width':complexity + '%'}).removeClass('progressbarInvalid progressbarValidMed').addClass('progressbarValid');
            $('#complexity').html(Math.round(complexity) + '%');
        });
    });
	
	//Code exécuté a chaque chargement de la page.
	controls_state("caps");
	controls_state("symbols");
	$("#errorNums").hide();
	if ($('#hide_options').val() == '1') //Sert a gérer l'état de la section d'option.
		$("#options_section").hide();
		
});
$(document).ready(function() {
	$('.menu_linker').click(function() {
		$('#contentloader').load($(this).attr('data-link'));
	});

	$(document).on('click', '.katalog-detail', function(event) {
		var link = $(this).attr('data-link');
		var id = $(this).attr('data-id');
		
		if (!$('#details').hasClass('in'))
			$('.modal-dialog').load(link, {id: id});
	});
	
	
	
	$(document).on('click', '#btn_suche',function (event) {
		var link = '/EWA/G04/EwA_Projekt/Katalog.php';
		
		var Buchtitel = $('#Buchtitel').val();
		var Autor = $('#Autor').val();
		
		var loading = link + "?Buchtitel=" + Buchtitel + "&Autor=" + Autor ;
		
		$.get(link,
		{
			Buchtitel: Buchtitel,
			Autor: Autor
		}, function(response){
			$('#contentloader').html(response);
		});
	});
	
	
});

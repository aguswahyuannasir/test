$(".div-show-hover").hover(function() {
	$(this).children('.toShowBtn').fadeIn('fast', function() {
		
	});
}, function() {
	$(this).children('.toShowBtn').fadeOut('fast', function() {
		
	});
});

function request_detail(_type, _additional = 0, _additional2 = 0){
	$("#resultToShowResult").fadeOut('fast', function() {
		$("#loadingToShowResult").fadeIn('fast', function() {
			$.ajax({
				url: site_url + 'dashboard/getDetailRecevables',
				type: 'GET',
				dataType: 'HTML',
				data: {type: _type, additional:_additional, additional2:_additional2},
				async: true,
				contentType: false,
				processData: true
			})
			.done(function(e) {
				$("#resultToShowResult").html(e);
				$("#loadingToShowResult").fadeOut('fast', function() {
					$("#resultToShowResult").fadeIn('fast', function() {
					});
				});
			})
			.fail(function() {
				console.log('error');
				$("#resultToShowResult").html("<h3 style='text-align:center; color:red;'><b>Seomthing went wrong, Please try again after a moment</b></h3>");
				$("#loadingToShowResult").fadeOut('fast', function() {
					$("#resultToShowResult").fadeIn('fast', function() {
					});
				});
			})
			.always(function() {
				console.log("complete");
			});
			
		});
	});
}
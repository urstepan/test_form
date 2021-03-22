$(".contractorForm").submit(function () {
	$.ajax({
		url: '/',
		method: 'post',
		dataType: 'json',
		data: $(this).serialize(),
		success: function(data){
			if(data.errors){
				$('#errors'+data.errors.orderID).html(data.errors.error)
			}else{
				$('#errors').html("")
				$('#contrName'+data.response.orderID).html(data.response.contractor)
				$('#contractor_'+data.response.orderID).modal('hide')
				$('.textarea'+data.response.orderID).prop('readonly', false)
				$('#class'+data.response.orderID).toggleClass('bg-transparent')
			}
		}
    })
	 event.preventDefault()
})

$("#addOrder").submit(function () {
	$.ajax({
		url: '/site/add',
		method: 'post',
		dataType: 'json',
		data: $(this).serialize(),
		success: function(data){
			if(data.errors){
				$('#errors').html(data.errors.error)
			}else{
				$('#errors').html("")
	            $("#success").html("Заказ успешно добавлен!")
			}
		}
    })
	 event.preventDefault()
})


$("#formFilter").submit(function () {
	$.ajax({
		url: '/',
		method: 'post',
		dataType: 'json',
		data: $(this).serialize(),
		success: function(data){
            if(data.filtPrice) {
                $(".filtTr").each(function( index ) {
                    if($(this).find(".fPrice").text() == data.filtPrice){ 
               	        $(".filtTr").css("display","none")
               	        $(this).css("display","")
                    }
                });
            }
            if(data.filtDate) {
                $(".filtTr").each(function( index ) {
                    if($(this).find(".fDate").text() == data.filtDate){ 
               	        $(".filtTr").css("display","none")
               	        $(this).css("display","")
                    }
                });
            }
		}
    })
	 event.preventDefault()
})

function cleanFilter() {
	$(".filtTr").css("display","")
}

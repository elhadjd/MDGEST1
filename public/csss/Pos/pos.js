$.ajax({
    type : "GET",
    url : "/menuPos",
    data : {

    },
    success : function(data){
        $(".App").html(data);
    }
})

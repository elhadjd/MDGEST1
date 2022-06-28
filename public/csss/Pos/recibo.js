// function printDiv(recibo){
//     var printContents = document.getElementById("#recibo").innerHTML;
//     var originalContents = document.body.innerHTML;





//     document.body.innerHTML = printContents;


//       $("#NovaEncomenda").click(function(event){
//         event.preventDefault();


// $(window).bind("popstate", function(e) {
// $(‘#my-navigation-container’).load(e.state.url);
// });
// Switch to the item
// $("#NovaEncomenda").click(function(event){
//     event.preventDefault()
// window.history.pushState({ id: 35 }, 'Viewing item #35', $(this).attr("href")+"35");
// window.onpopstate = function (e) {
// var id = e.state.id;
// window.open(id)
// };
//  })
// window.location.href = "/Pos"
        $(".App").load("/menuPos");
        setInterval(function(){
            $(".fatura").hide();
        },500)
//     document.body.innerHTML = originalContents;
// }





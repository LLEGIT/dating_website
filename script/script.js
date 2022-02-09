$(document).ready(function() {
    $("#loupe").click(function() {
        $(".containerSearch").toggleClass("hidden")
    })
    $(".arrowDown").click(function() {
        $(".containerProfile").toggleClass("hidden")
        $(".containerRegistration").toggleClass("hidden")
        $(".containerConnection").toggleClass('hidden')
    })
})
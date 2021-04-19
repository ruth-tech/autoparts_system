$(document).ready(function(){

    console.log('Jquery esta funcionando');

    function logout(){
        var req = new XMLHttpRequest();
        req.open("POST", "/autoparts_system/php/logout.php", true);
        req.withCredentials = true;
        req.send();

        hide_error();
    }
});

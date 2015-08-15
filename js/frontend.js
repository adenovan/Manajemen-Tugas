$(document).ready(function(){
 $.get( "/tugas/backend/list.proses.php", { tugas: 0} ).done(function( data ) {
        $("#content-page").html(data);
        $("#sis-notice").fadeOut(2200);
        $("#sis-content-login").hide();
        $(".nav-acc").hide();
        $("#home").addClass("hover");
        $.get( "/tugas/backend/pagination.proses.php", {tugas: 0} )
        .done(function( data ) {
        $('#pagination-all').bootpag({total: data,maxVisible: 5,page: 1,leaps:false}).on("page", function(event, num){
           $("#content-page").load("/tugas/backend/list.proses.php?tugas="+(num-1)*5);
        });

        $.get( "/tugas/backend/pagination.proses.php", {tugas:0,status:0} ).done(function( data ) {
        $('#pagination-open').bootpag({total: data,maxVisible: 5,page: 1,leaps:false}).on("page", function(event, num){
        $("#content-page").load("/tugas/backend/list.proses.php?tugas="+(num-1)*5+"&status="+0);
        });
        
        $.get( "/tugas/backend/pagination.proses.php", {tugas:0,status:1} ).done(function( data ) {    
        $('#pagination-going').bootpag({total: data,maxVisible: 5,page: 1,leaps:false}).on("page", function(event, num){
        $("#content-page").load("/tugas/backend/list.proses.php?tugas="+(num-1)*5+"&status="+1);
        }); 

        $.get( "/tugas/backend/pagination.proses.php", {tugas:0,status:2} ).done(function( data ) {
        $('#pagination-complete').bootpag({total: data,maxVisible: 5,page: 1,leaps:false}).on("page", function(event, num){
        $("#content-page").load("/tugas/backend/list.proses.php?tugas="+(num-1)*5+"&status="+2);
        });

        $.get( "/tugas/backend/pagination-acc.proses.php").done(function( data ) {
        $('#pagination-acc').bootpag({total: data,maxVisible: 5,page: 1,leaps:false}).on("page", function(event, num){
        $("#content-page").load("/tugas/backend/tugas-acc.proses.php?tugas="+(num-1)*5);
        });

        $('#pagination-complete').hide();
        $('#pagination-open').hide();
        $('#pagination-going').hide();
        $('#pagination-search').hide();
        $('#pagination-acc').hide();

        $("#login").click(function(e) {
          e.preventDefault();
          $("#home").removeClass("hover");
          $("#login").addClass("hover");
          $("#sis-content-login").toggle("slow");
        });

        $("#anda").click(function(e){
             e.preventDefault();
            $(".nav-home").hide();
            $(".nav-acc").show();
            $("#plus").removeClass('act');
            $("#on-going").removeClass('act');
            $("#complete").removeClass('act');
            $("#all").removeClass('act');
            $("#open").removeClass("act");
            $("#home").removeClass("hover");
            $("#login").removeClass("hover");
            $("#all-acc").addClass('act');
            $("#anda").addClass("hover");
            $("#col-search").show();
            $("#col-label").show();
            $("#content-page").removeClass('col-md-7');
            $("#content-page").addClass('col-md-10');
            $.get( "/tugas/backend/tugas-acc.proses.php", { tugas: 0 } )
                    .done(function( data ) {
                    $("#content-page").html(data);
                    $('#pagination-all').hide();
                    $('#pagination-complete').hide();
                    $('#pagination-going').hide();
                    $('.pagination-search').remove();
                    $('#pagination-open').hide();
                    $('#pagination-acc').show();
                }); 
            });  
        });
        
        $("#open-acc").click(function(e){
        e.preventDefault();
        $("#on-going-acc").removeClass('act');
        $("#complete-acc").removeClass('act');
        $("#all-acc").removeClass('act');
        $("#open-acc").addClass("act");
        $.get( "/tugas/backend/tugas-acc.proses.php", { tugas: 0 ,status:0} )
            .done(function( data ) {
            $("#content-page").html(data);
            $('.pagination-search').remove();
            $('#pagination-acc').hide();
            });  
        });

        $("#searchbox").keyup(function(event) {
            $('.pagination-search').remove();
            $("#formsearch").submit(function(event) {
            event.preventDefault();
            });
            $('#pagination-complete').hide();
            $('#pagination-open').hide();
            $('#pagination-going').hide();
            $('#pagination-all').hide();
            $('#pagination-acc').hide();
            var query = $("#formsearch").serialize();
            $.get("/tugas/backend/search.proses.php?"+query+"&offset=0").done(function( data ) {
            $('.pagination-search').remove();
            $("#content-page").html(data);
                $.get( "/tugas/backend/search-pagination.proses.php",query).done(function( data ) {
                    $("<div id=\"pagination-search\" class=\"pagination pagination-search\">").bootpag({total: data,maxVisible: 5,page: 1,leaps:false}).on("page", function(event, num){
                    $("#content-page").load("/tugas/backend/search.proses.php?"+query+"&offset="+(num-1)*5);
                    }).appendTo('#pagewrap');
                });
            });
        });

        $("#plus").click(function(e){
             e.preventDefault();
            $("#open").removeClass('act');
            $("#on-going").removeClass('act');
            $("#complete").removeClass('act');
            $("#all").removeClass('act');
            $("#plus").addClass("act");
            $("#col-search").hide();
            $("#col-label").hide();

            $("#content-page").removeClass('col-md-10');
            $("#content-page").addClass('col-md-7');
            $("#content-page").load($("#plus").attr("href"));
            $('#pagination-all').hide();
            $('#pagination-complete').hide();
            $('#pagination-open').hide();
            $('#pagination-going').hide();
            $('#pagination-acc').hide();
            $('.pagination-search').remove();
            $('#content-page').css("margin-bottom","30px");
        });

        $("#open").click(function(e){
             e.preventDefault();
            $('#content-page').css("margin-bottom","0px");
            $("#plus").removeClass('act');
            $("#on-going").removeClass('act');
            $("#complete").removeClass('act');
            $("#all").removeClass('act');
            $("#open").addClass("act");
            $("#col-search").show();
            $("#col-label").show();
            $("#content-page").removeClass('col-md-7');
            $("#content-page").addClass('col-md-10');
            $.get( "/tugas/backend/list.proses.php", { tugas: 0 ,status:0} )
                    .done(function( data ) {
                    $("#content-page").html(data);
                    $('#pagination-all').hide();
                    $('#pagination-complete').hide();
                    $('#pagination-going').hide();
                    $('.pagination-search').remove();
                    $('#pagination-acc').hide();
                    $('#pagination-open').show();
                }); 
            });  
        });

        $("#on-going").click(function(e){
            e.preventDefault();
            $('#content-page').css("margin-bottom","0px");
            $("#plus").removeClass('act');
            $("#on-going").addClass('act');
            $("#complete").removeClass('act');
            $("#all").removeClass('act');
            $("#open").removeClass("act");
            $("#col-search").show();
            $("#col-label").show();
            $("#content-page").removeClass('col-md-7');
            $("#content-page").addClass('col-md-10');
            $.get( "/tugas/backend/list.proses.php", { tugas: 0 ,status:1} )
                    .done(function( data ) {
                    $("#content-page").html(data);
                    $('#pagination-all').hide();
                    $('#pagination-complete').hide();
                    $('#pagination-open').hide();
                    $('.pagination-search').remove();
                    $('#pagination-acc').hide();
                    $('#pagination-going').show();
                }); 
            });     
        });

        $("#complete").click(function(e){
            e.preventDefault();
            $('#content-page').css("margin-bottom","0px");
            $("#plus").removeClass('act');
            $("#on-going").removeClass('act');
            $("#complete").addClass('act');
            $("#all").removeClass('act');
            $("#open").removeClass("act");
            $("#col-search").show();
            $("#col-label").show();
            $("#content-page").removeClass('col-md-7');
            $("#content-page").addClass('col-md-10');
            $.get( "/tugas/backend/list.proses.php", { tugas: 0 ,status:2} )
                    .done(function( data ) {
                    $("#content-page").html(data);
                    $('#pagination-all').hide();
                    $('#pagination-open').hide();
                    $('#pagination-going').hide();
                    $('.pagination-search').remove();
                    $('#pagination-acc').hide();
                    $('#pagination-complete').show();
                }); 
            });
        });


        $("#all").click(function(e){
            e.preventDefault();
            $('#content-page').css("margin-bottom","0px");
            $("#plus").removeClass('act');
            $("#on-going").removeClass('act');
            $("#complete").removeClass('act');
            $("#all").addClass('act');
            $("#open").removeClass("act");
            $("#col-search").show();
            $("#col-label").show();
            $("#content-page").removeClass('col-md-7');
            $("#content-page").addClass('col-md-10');
            $.get( "/tugas/backend/list.proses.php", { tugas: "0"} )
                    .done(function( data ) {
                    $("#content-page").html(data);
                    $.get( "/tugas/backend/pagination.proses.php", {tugas:0} ).done(function( data ) {
                    $('#pagination-complete').hide();
                    $('#pagination-open').hide();
                    $('#pagination-going').hide();
                    $('#pagination-acc').hide();
                    $('.pagination-search').remove();
                    $('#pagination-all').show();
                }); 
            });
            //return false;
        });
    });
 });
});		

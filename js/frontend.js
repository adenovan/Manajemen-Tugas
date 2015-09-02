$(document).ready(function(){
 /*
 if(typeof window.history.pushState == 'function') {
        window.history.pushState({}, "Hide", "http://manajemen-tugas.dev/index");
 };*/
 $.get( "/backend/list.proses.php", { tugas: 0} ).done(function( data ) {
        $("#content-page").html(data);
        $("#sis-notice").fadeOut(2200);
        $("#sis-content-login").hide();
        $(".nav-acc").hide();
        $("#home").addClass("hover");

        $('#pagination-complete').hide();
        $('#pagination-open').hide();
        $('#pagination-going').hide();
        $('#pagination-search').hide();
        $('#pagination-acc').hide();
        $('#pagination-open-acc').hide();
        $('#pagination-ongoing-acc').hide();
        $('#pagination-complete-acc').hide();

        $.get( "/backend/pagination.proses.php", {tugas: 0} )
        .done(function( data ) {
        $('#pagination-all').bootpag({total: data,maxVisible: 5,page: 1,leaps:false}).on("page", function(event, num){
        $("#content-page").load("/backend/list.proses.php?tugas="+(num-1)*5);
        });

        $.get( "/backend/pagination.proses.php", {tugas:0,status:0} )
        .done(function( data ) {
        $('#pagination-open').bootpag({total: data,maxVisible: 5,page: 1,leaps:false}).on("page", function(event, num){
        $("#content-page").load("/backend/list.proses.php?tugas="+(num-1)*5+"&status="+0);
        });
        
        $.get( "/backend/pagination.proses.php", {tugas:0,status:1} ).done(function( data ) {    
        $('#pagination-going').bootpag({total: data,maxVisible: 5,page: 1,leaps:false}).on("page", function(event, num){
        $("#content-page").load("/backend/list.proses.php?tugas="+(num-1)*5+"&status="+1);
        }); 

        $.get( "/backend/pagination.proses.php", {tugas:0,status:2} ).done(function( data ) {
        $('#pagination-complete').bootpag({total: data,maxVisible: 5,page: 1,leaps:false}).on("page", function(event, num){
        $("#content-page").load("/backend/list.proses.php?tugas="+(num-1)*5+"&status="+2);
        });

        $.get( "/backend/pagination-acc.proses.php").done(function( data ) {
        $('#pagination-acc').bootpag({total: data,maxVisible: 5,page: 1,leaps:false}).on("page", function(event, num){
        $("#content-page").load("/backend/tugas-acc.proses.php?tugas="+(num-1)*5);
        });

        $.get( "/backend/pagination-acc.proses.php",{ tugas: 0 ,status: 0} ).done(function( data ) {
        $('#pagination-open-acc').bootpag({total: data,maxVisible: 5,page: 1,leaps:false}).on("page", function(event, num){
        $("#content-page").load("/backend/tugas-acc.proses.php?tugas="+(num-1)*5+"&status="+0);
        });


        $.get( "/backend/pagination-acc.proses.php",{ tugas: 0 ,status: 1} ).done(function( data ) {
        $('#pagination-ongoing-acc').bootpag({total: data,maxVisible: 5,page: 1,leaps:false}).on("page", function(event, num){
        $("#content-page").load("/backend/tugas-acc.proses.php?tugas="+(num-1)*5+"&status="+1);
        });


        $.get( "/backend/pagination-acc.proses.php",{ tugas: 0 ,status: 2} ).done(function( data ) {
        $('#pagination-complete-acc').bootpag({total: data,maxVisible: 5,page: 1,leaps:false}).on("page", function(event, num){
        $("#content-page").load("/backend/tugas-acc.proses.php?tugas="+(num-1)*5+"&status="+2);
        });

        $("#notif").click(function(){
            var e=$(this);
            $.get("/backend/notif.proses.php").done(function(data){
                e.popover({
                content: ' ',
                title: 'Notifikasi Anda',
                html: true,
                placement:'bottom',
                trigger:'manual'
                });
                e.attr('data-content',data);
                e.popover('show');
                $(".notif-modal").click(function(ev) {
                    ev.preventDefault();
                    var target = $(this).attr("href");
                    var x = $(this).find('.notif').data('idnotif');
                    $("#myModal .modal-dialog").load(target, function() { 
                            $("#myModal").modal("show");
                            e.popover('hide');
                            $.get("/backend/notif-dibaca.proses.php",{notif:x}); 
                    });
                });
            });
        });


        $("#aksi").click(function(){
            var a=$(this);
            $.get("/backend/aksi-proses.php").done(function(data){
                a.popover({
                content: ' ',
                title: 'Aktivitas Anda',
                html: true,
                placement:'bottom',
                trigger:'manual'
                });
                a.attr('data-content',data);
                a.popover('show');
                $(".notif-modal").click(function(ev) {
                    ev.preventDefault();
                    var target = $(this).attr("href");
                    var x = $(this).find('.notif').data('idnotif');
                    $("#myModal .modal-dialog").load(target, function() { 
                            $("#myModal").modal("show");
                            a.popover('hide');
                            $.get("/backend/aksi-dibaca.proses.php",{aksi:x}); 
                    });
                });
            });
        });

        $('body').on('click', function (e) {
        $('#notif').each(function () {
        if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
            $(this).popover('hide');
        }
        });
        $('#aksi').each(function () {
        if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
            $(this).popover('hide');
        }
        });
        });

        $("#login").click(function(e) {
          e.preventDefault();
          $("#home").removeClass("hover");
          $("#login").addClass("hover");
          $("#sis-content-login").toggle("slow");
        });


        $("#account").click(function(e){
            e.preventDefault();
            $("#content-page").removeClass('col-md-10');
            $("#content-page").addClass('col-md-8');
            $("#content-page").load($("#account").attr("href"));
            $(".nav-home").hide();
            $(".nav-acc").hide();
            $('#pagination-all').hide();
            $('#pagination-complete').hide();
            $('#pagination-open').hide();
            $('#pagination-going').hide();
            $('#pagination-acc').hide();
            $('#pagination-open-acc').hide();
            $('#pagination-ongoing-acc').hide();
            $('#pagination-complete-acc').hide();  
            $('.pagination-search').remove();
            $('#content-page').css("margin-bottom","20px");
            $('#content-page').css("margin-top","20px");
        });

        $("#anda").click(function(e){
             e.preventDefault();
            $(".nav-home").hide();
            $(".nav-acc").show();
            $('#content-page').css("margin-top","0px");
            $('#content-page').css("margin-bottom","0px");
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
            $("#content-page").removeClass('col-md-8');
            $("#content-page").addClass('col-md-10');
            $.get( "/backend/tugas-acc.proses.php", { tugas: 0 } )
                    .done(function( data ) {
                    $("#content-page").html(data);
                    $('#pagination-all').hide();
                    $('#pagination-complete').hide();
                    $('#pagination-going').hide();
                    $('.pagination-search').remove();
                    $('#pagination-open').hide();
                    $('#pagination-open-acc').hide();
                    $('#pagination-ongoing-acc').hide();
                    $('#pagination-complete-acc').hide();
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
        $.get( "/backend/tugas-acc.proses.php", { tugas: 0 ,status:0} )
            .done(function(data) {
            $("#content-page").html(data);
            $('.pagination-search').remove();
            $('#pagination-acc').hide();
            $('#pagination-open-acc').show();
            $('#pagination-ongoing-acc').hide();
            $('#pagination-complete-acc').hide();
            });  
        });

        $("#on-going-acc").click(function(e){
        e.preventDefault();
        $("#on-going-acc").addClass('act');
        $("#complete-acc").removeClass('act');
        $("#all-acc").removeClass('act');
        $("#open-acc").removeClass("act");
        $.get( "/backend/tugas-acc.proses.php", { tugas: 0 ,status:1} )
            .done(function(data) {
            $("#content-page").html(data);
            $('.pagination-search').remove();
            $('#pagination-acc').hide();
            $('#pagination-open-acc').hide();
            $('#pagination-ongoing-acc').show();
            $('#pagination-complete-acc').hide();
            });  
        });

        $("#complete-acc").click(function(e){
        e.preventDefault();
        $("#on-going-acc").removeClass('act');
        $("#complete-acc").addClass('act');
        $("#all-acc").removeClass('act');
        $("#open-acc").removeClass("act");
        $.get( "/backend/tugas-acc.proses.php", { tugas: 0 ,status:2} )
            .done(function(data) {
            $("#content-page").html(data);
            $('.pagination-search').remove();
            $('#pagination-acc').hide();
            $('#pagination-open-acc').hide();
            $('#pagination-ongoing-acc').hide();
            $('#pagination-complete-acc').show();
            });  
        });

        $("#all-acc").click(function(e){
        e.preventDefault();
        $("#on-going-acc").removeClass('act');
        $("#complete-acc").removeClass('act');
        $("#all-acc").addClass('act');
        $("#open-acc").removeClass("act");
        $.get( "/backend/tugas-acc.proses.php", { tugas: 0 } )
            .done(function(data) {
            $("#content-page").html(data);
            $('.pagination-search').remove();
            $('#pagination-acc').show();
            $('#pagination-open-acc').hide();
            $('#pagination-ongoing-acc').hide();
            $('#pagination-complete-acc').hide();
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
            $('#pagination-open-acc').hide();
            $('#pagination-ongoing-acc').hide();
            $('#pagination-complete-acc').hide();        
            var query = $("#formsearch").serialize();
            $.get("/backend/search.proses.php?"+query+"&offset=0").done(function( data ) {
            $('.pagination-search').remove();
            $("#content-page").html(data);
                $.get( "/backend/search-pagination.proses.php",query).done(function( data ) {
                    $("<div id=\"pagination-search\" class=\"pagination pagination-search\">").bootpag({total: data,maxVisible: 5,page: 1,leaps:false}).on("page", function(event, num){
                    $("#content-page").load("/backend/search.proses.php?"+query+"&offset="+(num-1)*5);
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
            $("#content-page").addClass('col-md-8');
            $("#content-page").load($("#plus").attr("href"));
            $('#pagination-all').hide();
            $('#pagination-complete').hide();
            $('#pagination-open').hide();
            $('#pagination-going').hide();
            $('#pagination-acc').hide();
            $('#pagination-open-acc').hide();
            $('#pagination-ongoing-acc').hide();
            $('#pagination-complete-acc').hide();  
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
            $("#content-page").removeClass('col-md-8');
            $("#content-page").addClass('col-md-10');
            $.get( "/backend/list.proses.php", { tugas: 0 ,status:0} )
                    .done(function( data ) {
                    $("#content-page").html(data);
                    $('#pagination-all').hide();
                    $('#pagination-complete').hide();
                    $('#pagination-going').hide();
                    $('.pagination-search').remove();
                    $('#pagination-acc').hide();
                    $('#pagination-open-acc').hide();
                    $('#pagination-ongoing-acc').hide();
                    $('#pagination-complete-acc').hide();  
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
            $("#content-page").removeClass('col-md-8');
            $("#content-page").addClass('col-md-10');
            $.get( "/backend/list.proses.php", { tugas: 0 ,status:1} )
                    .done(function( data ) {
                    $("#content-page").html(data);
                    $('#pagination-all').hide();
                    $('#pagination-complete').hide();
                    $('#pagination-open').hide();
                    $('.pagination-search').remove();
                    $('#pagination-acc').hide();
                    $('#pagination-open-acc').hide();
                    $('#pagination-ongoing-acc').hide();
                    $('#pagination-complete-acc').hide();  
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
            $("#content-page").removeClass('col-md-8');
            $("#content-page").addClass('col-md-10');
            $.get( "/backend/list.proses.php", { tugas: 0 ,status:2} )
                    .done(function( data ) {
                    $("#content-page").html(data);
                    $('#pagination-all').hide();
                    $('#pagination-open').hide();
                    $('#pagination-going').hide();
                    $('.pagination-search').remove();
                    $('#pagination-acc').hide();
                    $('#pagination-open-acc').hide();
                    $('#pagination-ongoing-acc').hide();
                    $('#pagination-complete-acc').hide();  
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
            $("#content-page").removeClass('col-md-8');
            $("#content-page").addClass('col-md-10');
            $.get( "/backend/list.proses.php", { tugas: "0"} )
                    .done(function( data ) {
                    $("#content-page").html(data);
                    $.get( "/backend/pagination.proses.php", {tugas:0} ).done(function( data ) {
                    $('#pagination-complete').hide();
                    $('#pagination-open').hide();
                    $('#pagination-going').hide();
                    $('#pagination-acc').hide();
                    $('#pagination-open-acc').hide();
                    $('#pagination-ongoing-acc').hide();
                    $('#pagination-complete-acc').hide();  
                    $('.pagination-search').remove();
                    $('#pagination-all').show();
                    }); 
            });
        });
        });
        });
        });
        });
    });
});		

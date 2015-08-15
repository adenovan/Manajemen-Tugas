				<script type="text/javascript">
				var res;
				 $.ajax({
  					url:"/tugas/backend/pagination.proses.php"
					}).done(function(data) {
						res = data.substring(0, 1);
						$('#pagination').bootpag({total: res,
						page: 1,
   				 		maxVisible: 5,
    			 		leaps: true,
    			 		firstLastUse: true,
    			 		first: '←',
    			 		last: '→',
    			 		wrapClass: 'pagination',
   				 		activeClass: 'active',
   				 		disabledClass: 'disabled',
    					nextClass: 'next',
         				prevClass: 'prev',
    					lastClass: 'last',
    			 		firstClass: 'first'
						});
					});
        		 $('#pagination').bootpag().on("page", function(event,num){
       		    	id_tugas=;
					$.ajax({//ajax call 1
    					url:"/tugas/backend/list.proses.php?tugas="+id_tugas,
    					success: function(data1){
        					$("#content-page").html(data1);
    					}
					});
        		});
    			</script>
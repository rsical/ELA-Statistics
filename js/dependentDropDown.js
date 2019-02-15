
	$(document).ready(function(){

		//DEPENDENT DROPDOWN FOR STUDENT STATISTICS
	$("#ExamID").on('change', function(){
		var ExamID = $(this).val();
			if(ExamID){
				$.ajax({
					type:'POST',
					url:'ajaxData.php',
					data:'ExamID=' + ExamID,
					success:function(html){
						$("#Grade").html(html);
					}
				});
			}
	});

	$("#Grade").on('change', function(){
		var Grade = $(this).val();
			if(Grade){
				$.ajax({
					type:'POST',
					url:'ajaxData.php',
					data:'Grade=' + Grade,
					success:function(html){
						$("#scope").html(html);
					}
				});
			}
	});


	$("#scope").on('change', function(){
		var scope = $(this).val();
			if(scope){
				$.ajax({
					type:'POST',
					url:'ajaxData.php',
					data:'scope=' + scope,
					success:function(html){
						$("#student").html(html);
					}
				});
			}
	});





	//DEPENDENT DROPDOWN FOR EXAM STATISTICS
	$("#test").on('change', function(){
		var test = $(this).val();
			if(test){
				$.ajax({
					type:'POST',
					url:'ajaxData.php',
					data:'test=' + test,
					success:function(html){
						$("#examScope").html(html);
					}
				});
			}
	});

});

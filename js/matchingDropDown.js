
	$(document).ready(function(){

	$("#matchExamID").on('change', function(){
		var matchExamID = $(this).val();
			if(matchExamID){
				$.ajax({
					type:'POST',
					url:'matchingAjax.php',
					data:'matchExamID=' + matchExamID,
					success:function(html){
						$("#matchScope").html(html);
					}
				});
			}
	});



	$("#matchScope").on('change', function(){
		var matchScope = $(this).val();
			if(matchScope){
				$.ajax({
					type:'POST',
					url:'matchingAjax.php',
					data:'matchScope=' + matchScope,
					success:function(html){
						$("#matchGrade").html(html);
					}
				});
			}
	});



	$("#matchGrade").on('change', function(){
		var matchGrade = $(this).val();
			if(matchGrade){
				$.ajax({
					type:'POST',
					url:'matchingAjax.php',
					data:'matchGrade=' + matchGrade,
					success:function(html){
						$("#matchStudent").html(html);
					}
				});
			}
	});

	$("#matchStudent").on('change', function(){
		var matchStudent = $(this).val();
			if(matchStudent){
				$.ajax({
					type:'POST',
					url:'matchingAjax.php',
					data:'matchStudent=' + matchStudent,
					success:function(html){
						$("#matchNumber").html(html);
					}
				});
			}
	});
//<button onclick="myFunction()">Try it</button>
	$("#matchNumber").on('change', function(){
		var matchNumber = $(this).val();
			if(matchNumber){
				radio();
					}
	});
	});
	//<button onclick="myFunction()">Try it</button>

function radio(){
	$("input[type=radio]").attr('disabled', false);
}

	function checkbox() {
	 $("input[type=checkbox]").attr('disabled', false);
	}

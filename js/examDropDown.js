
	$(document).ready(function(){

$("#selectExamYear").on('change', function(){
  var selectExamYear = $(this).val();
    if(selectExamYear){
      $.ajax({
        type:'POST',
        url:'examAjax.php',
        data:'selectExamYear=' + selectExamYear,
        success:function(html){
          $("#examScope").html(html);
        }
      });
    }
});

$("#examScope").on('change', function(){
  var examScope = $(this).val();
    if(examScope){
      $.ajax({
        type:'POST',
        url:'examAjax.php',
        data:'examScope=' + examScope,
        success:function(html){
          $("#examStudent").html(html);
        }
      });
    }
});

});

<input type = "button" id = "send" value = "Send to Server" />
<input type = "button" id = "add" value = "Add Row" />
<table class="table table-striped">
        <tr>
            <td><h2>In</h2></td>
            <td><h2>Out</h2></td>
            <td><h2>Total</h2></td>
        </tr>
        <tr>
            <td>InData</td>
            <td>OutData</td>
            <td>TotalData</td>
        </tr>
</table>
<script language="javascript" type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
<script language="javascript" type="text/javascript">

$(document).on('click', '#add', function(){

    var dt = new Date();
    var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds(); //set variable to current time
    $('table > tbody:last').append('<tr><td>'+time+'</td><td></td><td></td></tr>'); //add row to table with current time

});

$(document).on('click', '#send', function(){
    var dataArr = [];
    $("table").each(function(){
        dataArr.push($(this).html());
    });
    $('#send').click(function(){
        $.ajax({
          type : "POST",
          url : 'timesheet.php',
          data : "content="+dataArr,
          success: function(data) {
              alert(data);// alert the data from the server
          },
          error : function() {
          }
         });
    });
});
</script>
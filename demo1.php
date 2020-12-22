<table id="table" border=1>
    <thead> <tr>
    <th>First</th>
    <th>Last</th>
    <th>Date of birth</th>
    <th>City</th>
    </tr></thead>
    <tbody>
    <tr>
    <td>TEXT1</td>
    <td>TEXT2</td>
    <td>TEXT3</td>
    <td>TEXT4</td>
    </tr>
    <tr>
    <td>TEXT5</td>
    <td>TEXT6</td>
    <td>TEXT7</td>
    <td>TEXT8</td>
     </tr>
    <tr>
    <td>TEXT9</td>
    <td>TEXT10</td>
    <td>TEXT11</td>
    <td>TEXT12</td>
   </tr>
   </tbody>
   </table>

<input id="sendServer" name="sendServer" type="button" value="Send to Server" />

<script language="javascript" type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
<script language="javascript" type="text/javascript">

$(document).on('click', '#add', function(){

    var dt = new Date();
    var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds(); //set variable to current time
    $('table > tbody:last').append('<tr><td>'+time+'</td><td></td><td></td></tr>'); //add row to table with current time

});

$(function(){
    var dataArr = [];
    $("td").each(function(){
        dataArr.push($(this).html());
    });
    $('#sendServer').click(function(){
        $.ajax({
              type : "POST",
              url : 'demo.php',
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
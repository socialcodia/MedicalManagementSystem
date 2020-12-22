<!DOCTYPE html>
<html>
<head>
<title>Table Row Demo</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
tr.normal td {
    color: black;
    background-color: white;
}
tr.highlighted td {
    color: white;
    background-color: red;
}
</style>
</head>
<body>
<div id="results" class="scrollingdatagrid">
  Current Row: <select id="rownum">
    <option value="0" selected>None</option>
    </select>
  <table id="mstrTable" cellspacing="0" border="1">
     <thead>
      <tr> 
        <th>File Number</th>
        <th>Date1</th>
        <th>Date2</th>
        <th>Status</th>
        <th>Num.</th>
      </tr>
    </thead>
    <tbody>
      <tr> 
        <td>KABC</td>
        <td>09/12/2002</td>
        <td>09/12/2002</td>
        <td>Submitted</td>
        <td>1</td>
      </tr>
      <tr> 
        <td>KCBS</td>
        <td>09/11/2002</td>
        <td>09/11/2002</td>
        <td>Lockdown</td>
        <td>2</td>
      </tr>
      <tr> 
        <td>WFLA</td>
        <td>09/11/2002</td>
        <td>09/11/2002</td>
        <td>Submitted</td>
        <td>3</td>
      </tr>
      <tr> 
        <td>WTSP</td>
        <td>09/15/2002</td>
        <td>09/15/2002</td>
        <td>In-Progress</td>
        <td>4</td>
      </tr>
    </tbody>
  </table>
</div>
<script type="text/javascript">
(function() {
    var trows = document.getElementById('mstrTable').rows, t = trows.length, trow, nextrow,
    rownum = document.getElementById('rownum'),
    addEvent = (function(){return window.addEventListener? function(el, ev, f){
            el.addEventListener(ev, f, false); //modern browsers
        }:window.attachEvent? function(el, ev, f){
            el.attachEvent('on' + ev, function(e){f.apply(el, [e]);}); //IE 8 and less
        }:function(){return;}; //a very old browser (IE 4 or less, or Mozilla, others, before Netscape 6), so let's skip those
    })();

    // function option(num){
    //     var o = document.createElement('option');
    //     o.value = num;
    //     rownum.insertBefore(o, rownum.options[1]); //IE 8 and less, must insert to page before setting text property
    //     o.text = trows[num].cells[0].innerHTML + ' (' + num + ')';
    // }

    // function rownumchange(){
    //     if(this.value > 0){ //activates the highlight function for the selected row (highlights it)
    //         highlightRow.apply(trows[this.value]);
    //     } else { //activates the highlight function for the row that is currently highlighted (turns it off)
    //         highlightRow.apply(trows[highlightRow(true)]);
    //     }
    //     this.blur(); //prevent Mozilla from firing on internal events that change rownum's value
    // }

    // addEvent(rownum, 'change', rownumchange);

    // rownum.value = 1; //reset for browsers that remember select values on reload

    // while (--t > 0) {
    //     trow = trows[t];
    //     trow.className = 'normal';
    //     addEvent(trow, 'click', highlightRow);
    //     option(t);
    // }//end while

    function highlightRow(gethighlight) { //now dual use - either set or get the highlighted row
        gethighlight = gethighlight === true;
        var t = trows.length;
        while (--t > 0) {
            trow = trows[t];
            if(gethighlight && trow.className === 'highlighted'){return t;}
            else if (!gethighlight){
                if(trow !== this) { trow.className = 'normal'; }
                else if(this.className === 'normal') { rownum.value = t; }
                else { rownum.value = 0; }
            }
        }//end while

        return gethighlight? null : this.className = this.className === 'highlighted'? 'normal' : 'highlighted';
    }//end function

    function movehighlight(way, e){
        e.preventDefault && e.preventDefault();
        e.returnValue = false;
        var idx = highlightRow(true); //gets current index or null if none highlighted
        if(typeof idx === 'number'){//there was a highlighted row
            idx += way; //increment\decrement the index value
            if(idx && (nextrow = trows[idx])){ return highlightRow.apply(nextrow); } //index is > 0 and a row exists at that index
            else if(idx){ return highlightRow.apply(trows[1]); } //index is out of range high, go to first row
            return highlightRow.apply(trows[trows.length - 1]); //index is out of range low, go to last row
        }
        return highlightRow.apply(trows[way > 0? 1 : trows.length - 1]); //none was highlighted - go to 1st if down arrow, last if up arrow
    }//end function

    function processkey(e){
        switch(e.keyCode){
            case 38: {//up arrow
                return movehighlight(-1, e);
            }
            case 40: {//down arrow
                return movehighlight(1, e);
            }
            case 13: {//down arrow
                return console.log(1);
            }
            default: {
                return true;
            }
        }
    }//end function

    addEvent(document, 'keydown', processkey);
    addEvent(window, 'unload', function(){}); //optional, resets the page for browsers that remember the script state on back and forward buttons

}/* end function */)();//execute function and end script
</script>
</body>
</html>
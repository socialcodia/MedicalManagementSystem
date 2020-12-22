
var BASE_URL = "http://socialcodia.net/SocialApiFriendsSystemVideoThumb/public/";


function getFeeds()
{
  console.log(getMethodApi('feeds'));
}

function getMethodApi(endPoint)
{
  var data;
  var settings = {
    "url" : BASE_URL+endPoint,
    "method" : "GET",
    "timeout" : 0,
    "headers" : {
      "token" : getCookie()
    },
  };

  $.ajax(settings).done(function(response)
    {
      console.log(response);
      return response;
    });
}

function getCookie() {
    var nameEQ = 'token=';
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0)
         return c.substring(nameEQ.length,c.length);
    }
    return null;
}



  let BASE_URL = 'http://socialcodia.net/SocialApiFriendsSystemVideoThumbUsername/public/';
  console.log('%cWarning message to FAMBLAH users!', 'color: red; font-size: 30px; font-weight: bold;');
  console.log('%cThis is a browser feature intended for developers. If someone told you to copy and paste something here to enable a FAMBLAH feature or "hack" someones account, it is a scam and will give them access to your FAMBLAH account.', 'color: white; font-size: 15px; font-weight: bold;');
  console.log('%cBe Aware!', 'color: red; font-size: 30px; font-weight: bold;');
      let notificationBadge = document.getElementById('notificationBadge');
      let notificationBadgeMobile = document.getElementById('notificationBadgeMobile');

      const Toast = Swal.mixin({
        toast: true,
        position: 'bottom-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      })

      // users page configuration and listener

      // let btnAddFriend = document.getElementById('btnAddFriend');
      // btnAddFriend.addEventListener('click',console.log('clicked btnAddFriend'));

      window.onload = function() {
        checkNotificationsCount();
      };
      if (localStorage.getItem("notificationsCount")!=0) {
        notificationBadge.innerHTML = localStorage.getItem("notificationsCount");
        notificationBadgeMobile.innerHTML = localStorage.getItem("notificationsCount");
      }
      else
      {
        notificationBadge.style.display = 'none';
        notificationBadgeMobile.style.display = 'none';
      }
    function notificationSeened()
    {
      if (localStorage.getItem("notificationsCount")>0){
                  $.ajax({
          headers:{  
             "token":"<?php if (isset($_COOKIE['token'])) echo $_COOKIE['token']; ?>"
          },
          type:"get",
          url:BASE_URL+"/notifications/Seened",
          success:function(response)
          {
            console.log(response);
            if (!response.error)
            {
              localStorage.setItem("notificationsCount",0);
              notificationBadge.style.display = 'none';
              notificationBadgeMobile.style.display = 'none';
            }
            else
            {
              createToast(mUserName,response.message,'error',mUserImage,'2000');
            }
          }
        });
      }
      else
        console.log("no need to call the api when the notifications count is zero");
    }

    function setNotificationCount(nc)
    {
      notificationBadge.style.display = 'revert';
      notificationBadgeMobile.style.display = 'revert';
      notificationBadge.innerHTML = nc;
      notificationBadgeMobile.innerHTML = nc;
    }

    function checkNotificationsCount()
    {
        $.ajax({
          headers:{  
             "token":"<?php if (isset($_COOKIE['token'])) echo $_COOKIE['token']; ?>"
          },
          type:"get",
          url:BASE_URL+"/notifications/Count",
          success:function(response)
          {
            console.log(response);
            if (!response.error)
            {
              localStorage.setItem("notificationsCount",response.notificationsCount);
              if (response.notificationsCount>0)
                setNotificationCount(localStorage.getItem("notificationsCount"));
            }
            else
            {
              createToast(mUserName,response.message,'error',mUserImage,'2000');
            }
          }
        });
    }
    



    
    // let mToken = getCookie();


function createToast(title,text,type,icon,timeout) {
    // see if DOM is already available
    if (document.readyState === "complete" || document.readyState === "interactive") {
        // call on next available tick
            function create() {
                VanillaToasts.create({
                  title: title,
                  text: text,
                  type: type,
                  icon: icon,
                  timeout: timeout
                });
            }
    } else {
        document.addEventListener("DOMContentLoaded", fn);
        create();
    }
    create();
} 

function reportFeed(value)
{
  let reportFeed = "<?php echo REPORT_FEED; ?>";
  let reportFeedDesc = "<?php echo REPORT_FEED_DESC; ?>";
  Swal.fire({
  title: reportFeed,
  text: reportFeedDesc,
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Report'
}).then((result) => {
  if (result.isConfirmed) {
    doReport(value);
  }
})
}

function deleteFeed(value)
{
  console.log(value);
  let reportFeed = "Are you sure?";
  let reportFeedDesc = 'Are you sure want to delete this feed, Remember you will able to recover it again';
  Swal.fire({
  title: reportFeed,
  text: reportFeedDesc,
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Delete'
}).then((result) => {
  if (result.isConfirmed) {
    doDeleteFeed(value);
  }
})
}

 
function readURL(input) {
  if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
          $('#feedImage')
              .attr('src', e.target.result);
      };

      reader.readAsDataURL(input.files[0]);
  }
}

function previewProfileImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#userProfileImage')
                .attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}
  



    function doLike(value){
    value = value.replace('like','');
    let btnId = document.getElementById("like"+value);
    let btnUnlike = document.getElementById("unlike"+value);
    let lC = "likescount"+value;
    let likesCount = document.getElementById(lC);
    $.ajax({
              headers:{  
                 "token":"<?php if (isset($_COOKIE['token'])) echo $_COOKIE['token']; ?>"
              },
              type:"post",
              url:BASE_URL+"feed/like",
              data: 
              {  
                 'feedId' : value
              },
              success:function(response)
              {
                if (!response.error)
                {
                  likesCount.innerHTML = "<b>"+response.feed.feedLikes+"</b>"+" Likes";
                  btnId.style.display = 'none';
                  btnUnlike.style.display = 'block';
                }
                else
                {
                  createToast(mUserName,response.message,'error',mUserImage,'2000');
                }
              }
            });
            return false;
     }

    function doUnlike(value){
    value = value.replace('unlike','');
    let btnId = document.getElementById("like"+value);
    let btnUnlike = document.getElementById("unlike"+value);
    let lC = "likescount"+value;
    let likesCount = document.getElementById(lC);
    $.ajax({
              headers:{  
                 "token":"<?php if (isset($_COOKIE['token'])) echo $_COOKIE['token']; ?>"
              },
              type:"post",
              url:BASE_URL+"feed/unlike",
              data: 
              {  
                 'feedId' : value
              },
              success:function(response)
              {
                if (!response.error)
                {
                  likesCount.innerHTML = "<b>"+response.feed.feedLikes+"</b>"+" Likes";
                  btnId.style.display = 'block';
                  btnUnlike.style.display = 'none';
                }
                else
                {
                  createToast(mUserName,response.message,'error',mUserImage,'2000');
                }
              }
            });
            return false;
     }

    function likeComment(value){
      value = value.replace('likecomment','');
      let btnLike = document.getElementById("likecomment"+value);
      let btnUnlike = document.getElementById("unlikecomment"+value);
      let likesCount = document.getElementById("likecommetcounts"+value);
      $.ajax({
                headers:{  
                   "token":"<?php if (isset($_COOKIE['token'])) echo $_COOKIE['token']; ?>"
                },
                type:"post",
                url:BASE_URL+"comment/like",
                data: 
                {  
                   'commentId' : value
                },
                success:function(response)
                {
                  console.log(response);
                  if (!response.error)
                  {
                    btnLike.style.display = 'none';
                    btnUnlike.style.display = 'block';
                    likesCount.innerHTML = response.comments.commentLikesCount;
                  }
                  else
                  {
                    createToast(mUserName,response.message,'error',mUserImage,'2000');
                  }
                }
              });
              return false;
     }

    function unlikeComment(value){
      value = value.replace('unlikecomment','');
      let btnLike = document.getElementById("likecomment"+value);
      let btnUnlike = document.getElementById("unlikecomment"+value);
      let likesCount = document.getElementById("likecommetcounts"+value);
      $.ajax({
                headers:{  
                   "token":"<?php if (isset($_COOKIE['token'])) echo $_COOKIE['token']; ?>"
                },
                type:"post",
                url:BASE_URL+"comment/unlike",
                data: 
                {  
                   'commentId' : value
                },
                success:function(response)
                {
                  console.log(response);
                  if (!response.error)
                  {
                    btnLike.style.display = 'block';
                    btnUnlike.style.display = 'none';
                    likesCount.innerHTML = response.comments.commentLikesCount;
                  }
                  else
                  {
                    createToast(mUserName,response.message,'error',mUserImage,'2000');
                  }
                }
              });
              return false;
     }

    function doReport(value){
    value = value.replace('report','');
    $.ajax({
              headers:{  
                 "token":"<?php if (isset($_COOKIE['token'])) echo $_COOKIE['token']; ?>"
              },
              type:"post",
              url:BASE_URL+"feed/report",
              data: 
              {  
                 'feedId' : value
              },
              success:function(response)
              {
                if (!response.error)
                {
                  Swal.fire(
                    'Thankyou',
                    'Feed Has Been Reported!',
                    'success'
                  )
                }
                else
                {
                  Swal.fire(
                    'Error',
                    response.message,
                    'error'
                  )
                }
              }
            });
            return false;
     }

    function doDeleteFeed(value){
    value = value.replace('delete','');
    let feedCard = document.getElementById('feedCard'+value);
    $.ajax({
              headers:{  
                 "token":"<?php if (isset($_COOKIE['token'])) echo $_COOKIE['token']; ?>"
              },
              type:"post",
              url:BASE_URL+"feed/delete",
              data: 
              {  
                 'id' : value
              },
              success:function(response)
              {
                console.log(response);
                if (!response.error)
                {
                  Swal.fire(
                    'Thankyou',
                    'Feed Has Been Delete!',
                    'success'
                  )
                  feedCard.style.display='none';
                }
                else
                {
                  Swal.fire(
                    'Error',
                    response.message,
                    'error'
                  )
                }
              }
            });
            return false;
     }

      function getCookie() {
        let name = "token";
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
      }
     function commentListener()
     {
      let comment = document.getElementById('inputComment');
      let btn = document.getElementById('btnComment');
      btn.style.display='block';
     }

     function postComment()
     {
      let comment = document.getElementById('inputComment');
      let btn = document.getElementById('btnComment');

      let feedId = btn.value.replace('comment','');
        $.ajax({
              headers:
              {  
                 "token":"<?php if (isset($_COOKIE['token'])) echo $_COOKIE['token']; ?>"
              },
              type:"post",
              url:BASE_URL+"comment/post",
              data: 
              {  
                 'comment' : comment.value,
                 'feedId' : feedId
              },
              success:function(response)
              {
                console.log(response);
                if (!response.error)
                {
                  let messageArea = document.getElementById('message-area');
                  let rowDiv = document.createElement('div');
                  let messageDiv = `
                              <div class="row" style="padding: 0px 5px 0px 5px;" >
                                <div class="col l1 m1 s2 center">
                                    <a href='${response.comments.userUsername}'><img src="${response.comments.userImage}"class="responsive-img circle" style="border: 2px solid blue; margin-top: 5px; height:40px; width:40px; object-fit:cover; " alt=""></a>
                                </div>
                                <div class="col s9 l10 m10" style="padding: 0px">
                                    <div class="grey lighten-3" style="border-radius: 10px; padding: 10px;">
                                        <a href='${response.comments.userUsername}'><b style="color:black">${response.comments.userName}</b></a><br><p style="margin-top: -5px">${response.comments.commentTimestamp}</p>
                                        <div>
                                            <p style="margin-top: -15px; margin-bottom: -5px; ">${response.comments.commentComment}</p>
                                        </div>
                                    </div>
                                    <div style="margin-left: 10px;">
                                        <Button class="left blue-text" id="likecomment${response.comments.commentId}" onClick="likeComment(this.value)" value="likecomment${response.comments.commentId}" style="padding: 5px; background-color: Transparent; background-repeat:no-repeat; border: none; cursor:pointer; overflow: hidden; display:block; outline:none;"><i class="material-icons prefix tiny">thumb_up</i> Like</Button>
                                        <Button class="left red-text" id="unlikecomment${response.comments.commentId}" onClick="unlikeComment(this.value)" value="unlikecomment${response.comments.commentId}" style="padding: 5px; background-color: Transparent; display:none; background-repeat:no-repeat; border: none; cursor:pointer; overflow: hidden; outline:none;"><i class="material-icons prefix tiny">thumb_up</i> Unlike</Button> <b style="padding:5px;" id="likecommetcounts${response.comments.commentId}" value="${response.comments.commentId}" ">${response.comments.commentLikesCount}</b>
                                    </div>
                                </div>
                            </div>
                  `;
                  rowDiv.innerHTML = messageDiv;
                  messageArea.appendChild(rowDiv);
                  comment.value = '';
                  btn.style.display = 'none';
                }
                else
                {

                }
              }
            });
    }

    


    let hisId = '<?php if(isset($hisId)) echo $hisId; ?>';
    let friendshipStatus = '<?php if(isset($friendshipStatus)) echo $friendshipStatus; ?>';
    let status = '<?php if(isset($status)) echo $status; ?>';
    friendshipStatus = parseInt(friendshipStatus);
    let btnAddFriend = document.getElementById('btnAddFriend'+hisId);
    let btnCancelFriendRequest = document.getElementById('btnCancelFriendRequest'+hisId);
    let btnUnfriend = document.getElementById('btnUnfriend'+hisId);
    let btnAcceptFriendRequest = document.getElementById('btnAcceptFriendRequest'+hisId);
    let btnRejectFriendRequest = document.getElementById('btnRejectFriendRequest'+hisId);
    let btnBlockFriend = document.getElementById('btnBlockFriend'+hisId);
    let btnUnBlockFriend = document.getElementById('btnUnBlockFriend'+hisId);
    console.log(status);


    switch(friendshipStatus)
    {
        case 0:
            btnAddFriend.style.display = 'block';
            btnCancelFriendRequest.style.display = 'none';
            btnUnfriend.style.display = 'none';
            btnAcceptFriendRequest.style.display = 'none';
            btnRejectFriendRequest.style.display = 'none';
            btnBlockFriend.style.display='block';
        break;
        case 1:
            btnAddFriend.style.display = 'none';
            btnCancelFriendRequest.style.display = 'none';
            btnUnfriend.style.display = 'block';
            btnAcceptFriendRequest.style.display = 'none';
            btnRejectFriendRequest.style.display = 'none';
            btnBlockFriend.style.display='block';

        break;
        case 2:
            btnAddFriend.style.display = 'none';
            btnCancelFriendRequest.style.display = 'block';
            btnUnfriend.style.display = 'none';
            btnAcceptFriendRequest.style.display = 'none';
            btnRejectFriendRequest.style.display = 'none';
            btnBlockFriend.style.display='block'; 
        break;
        case 3:
            btnAddFriend.style.display = 'none';
            btnCancelFriendRequest.style.display = 'none';
            btnUnfriend.style.display = 'none';
            btnBlockFriend.style.display = 'none';
            btnAcceptFriendRequest.style.display = 'block';
            btnRejectFriendRequest.style.display = 'block';
        break;


    }

    if (status!=2)
    {
        btnUnBlockFriend.style.display = 'none';
        if (friendshipStatus!=3)
            btnBlockFriend.style.display = 'block';
    }
    else
    {
        console.log('running');
        btnBlockFriend.style.display = 'none';
        btnUnBlockFriend.style.display = 'block';
    }

    function alertDeleteNotification(value)
    {
      console.log(value);
          Swal.fire({
          title: 'Are you sure?',
          text: 'Are you sure want to delete this notification. Remember you will not able to recover it again',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Delete Notification'
        }).then((result) => {
          if (result.isConfirmed) {
            deleteNotification(value);
          }
        })
    }

    function deleteNotification(value)
    {
        let btnDeleteNotification = document.getElementById('btnDeleteNotification'+value);
        let divNotification = document.getElementById('divNotification'+value);
        btnDeleteNotification.classList.add('disabled');
        $.ajax({
          headers:{  
             "token":"<?php if (isset($_COOKIE['token'])) echo $_COOKIE['token']; ?>"
          },
          type:"post",
          url:BASE_URL+"notification/delete",
          data: 
          {  
             'notificationId' : value
          },
          success:function(response)
          {
            console.log(response);
            if (!response.error)
            {
                divNotification.style.display = 'none';
                btnDeleteNotification.classList.remove('disabled');
            }
            else
            {
                btnDeleteNotification.classList.remove('disabled');
              createToast(mUserName,response.message,'error',mUserImage,'2000');
            }
          }
        });
    }

    function sendFriendRequest(value)
    {
      let btnAddFriend = document.getElementById('btnAddFriend'+value);
      let btnCancelFriendRequest = document.getElementById('btnCancelFriendRequest'+value);
      let btnUnfriend = document.getElementById('btnUnfriend'+value);
      let btnAcceptFriendRequest = document.getElementById('btnAcceptFriendRequest'+value);
      let btnRejectFriendRequest = document.getElementById('btnRejectFriendRequest'+value);
        btnAddFriend.classList.add('disabled');
        $.ajax({
          headers:{  
             "token":"<?php if (isset($_COOKIE['token'])) echo $_COOKIE['token']; ?>"
          },
          type:"post",
          url:BASE_URL+"sendFriendRequest",
          data: 
          {  
             'userId' : value
          },
          success:function(response)
          {
            console.log(response);
            if (!response.error)
            {
                btnAddFriend.style.display = 'none';
                btnCancelFriendRequest.style.display = 'block';
                btnUnfriend.style.display = 'none';
                btnAcceptFriendRequest.style.display = 'none';
                btnRejectFriendRequest.style.display = 'none';
                btnAddFriend.classList.remove('disabled');
                Toast.fire({
                  icon: 'success',
                  title: response.message
                })
            }
            else
            {
                btnAddFriend.classList.remove('disabled');
              createToast(mUserName,response.message,'error',mUserImage,'2000');
            }
          }
        });
    }

    function alertCancelFriendRequest(value)
    {
      console.log(value);
          Swal.fire({
          title: 'Are you sure?',
          text: 'Are you sure want to cancle your Friend Request',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Cancel Friend Request'
        }).then((result) => {
          if (result.isConfirmed) {
            cancelFriendRequest(value);
          }
        })
    }

    function alertRejectFriendRequest(value)
    {
          Swal.fire({
          title: 'Are you sure?',
          text: 'Are you sure want to reject this Friend Request',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Reject Friend Request'
        }).then((result) => {
          if (result.isConfirmed) {
            cancelFriendRequest(value);
          }
        })
    }

    function alertDeleteFriend(value)
    {
          Swal.fire({
          title: 'Are you sure?',
          text: 'Are you sure want to delete this FriendShip',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Delete FriendShip'
        }).then((result) => {
          if (result.isConfirmed) {
            unfriend(value);
          }
        })
    }

    function alertBlockFriend(value)
    {
        let name = '<?php if(isset($hisName)) echo $hisName; ?>';
          Swal.fire({
          title: 'Are you sure want to block',
          text: name+" will no longer be able to:\n\n\t○ See things you post on your timeline\n \t○ Add you as a friend\n\nIf you're friends, blocking "+name+" will also unfriend him,",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Block'
        }).then((result) => {
          if (result.isConfirmed) {
            blockUser(value);
          }
        })
    }

    function alertUnBlockFriend(value)
    {
        let name = '<?php if(isset($hisName)) echo $hisName; ?>';
          Swal.fire({
          title: 'Are you sure want to UnBlock',
          text: name+" will be able to:\n\n\t○ See things you post on your timeline\n\t○ Add you as a friend",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'UnBlock'
        }).then((result) => {
          if (result.isConfirmed) {
            unblockUser(value);
          }
        })
    }

    function blockUser(value)
    {
        let btnAddFriend = document.getElementById('btnAddFriend'+value);
        let btnCancelFriendRequest = document.getElementById('btnCancelFriendRequest'+value);
        let btnUnfriend = document.getElementById('btnUnfriend'+value);
        let btnAcceptFriendRequest = document.getElementById('btnAcceptFriendRequest'+value);
        let btnRejectFriendRequest = document.getElementById('btnRejectFriendRequest'+value);
        let btnBlockFriend = document.getElementById('btnBlockFriend'+value);
        let btnUnBlockFriend = document.getElementById('btnUnBlockFriend'+value);
        btnBlockFriend.classList.add('disabled');
        $.ajax({
          headers:{  
             "token":"<?php if (isset($_COOKIE['token'])) echo $_COOKIE['token']; ?>"
          },
          type:"post",
          url:BASE_URL+"user/block",
          data: 
          {  
             'userId' : btnBlockFriend.value
          },
          success:function(response)
          {
            console.log(response);
            if (!response.error)
            {
                btnAddFriend.style.display = 'block';
                btnCancelFriendRequest.style.display = 'none';
                btnUnfriend.style.display = 'none';
                btnAcceptFriendRequest.style.display = 'none';
                btnRejectFriendRequest.style.display = 'none';
                btnBlockFriend.style.display = 'none';
                btnUnBlockFriend.style.display = 'block';
                btnBlockFriend.classList.remove('disabled');
            }
            else
            {
                btnBlockFriend.classList.remove('disabled');
              createToast(mUserName,response.message,'error',mUserImage,'2000');
            }
          }
        });
    }

    function unblockUser(value)
    {
        let btnAddFriend = document.getElementById('btnAddFriend'+value);
        let btnCancelFriendRequest = document.getElementById('btnCancelFriendRequest'+value);
        let btnUnfriend = document.getElementById('btnUnfriend'+value);
        let btnAcceptFriendRequest = document.getElementById('btnAcceptFriendRequest'+value);
        let btnRejectFriendRequest = document.getElementById('btnRejectFriendRequest'+value);
        let btnBlockFriend = document.getElementById('btnBlockFriend'+value);
        let btnUnBlockFriend = document.getElementById('btnUnBlockFriend'+value);
        btnUnBlockFriend.classList.add('disabled');
        $.ajax({
          headers:{  
             "token":"<?php if (isset($_COOKIE['token'])) echo $_COOKIE['token']; ?>"
          },
          type:"post",
          url:BASE_URL+"user/unblock",
          data: 
          {  
             'userId' : btnUnBlockFriend.value
          },
          success:function(response)
          {
            console.log(response);
            if (!response.error)
            {
                btnAddFriend.style.display = 'block';
                btnCancelFriendRequest.style.display = 'none';
                btnUnfriend.style.display = 'none';
                btnAcceptFriendRequest.style.display = 'none';
                btnRejectFriendRequest.style.display = 'none';
                btnBlockFriend.style.display = 'block';
                btnUnBlockFriend.classList.remove('disabled');
                btnUnBlockFriend.style.display = 'none';
            }
            else
            {
                btnCancelFriendRequest.classList.remove('disabled');
              createToast(mUserName,response.message,'error',mUserImage,'2000');
            }
          }
        });
    }

    function cancelFriendRequest(value)
    {
        let btnAddFriend = document.getElementById('btnAddFriend'+value);
        let btnCancelFriendRequest = document.getElementById('btnCancelFriendRequest'+value);
        console.log(btnCancelFriendRequest+"btn cancel");
        console.log(value+"value is");
        let btnUnfriend = document.getElementById('btnUnfriend'+value);
        let btnAcceptFriendRequest = document.getElementById('btnAcceptFriendRequest'+value);
        let btnRejectFriendRequest = document.getElementById('btnRejectFriendRequest'+value);
        let btnBlockFriend = document.getElementById('btnBlockFriend'+value);
        console.log(btnBlockFriend);
        let btnUnBlockFriend = document.getElementById('btnUnBlockFriend'+value);
        btnCancelFriendRequest.classList.add('disabled');
        $.ajax({
          headers:{  
             "token":"<?php if (isset($_COOKIE['token'])) echo $_COOKIE['token']; ?>"
          },
          type:"post",
          url:BASE_URL+"cancelFriendRequest",
          data: 
          {  
             'userId' : value
          },
          success:function(response)
          {
            console.log(response);
            if (!response.error)
            {
                btnAddFriend.style.display = 'block';
                btnCancelFriendRequest.style.display = 'none';
                btnUnfriend.style.display = 'none';
                btnAcceptFriendRequest.style.display = 'none';
                btnRejectFriendRequest.style.display = 'none';
                btnBlockFriend.style.display = 'block';
                btnCancelFriendRequest.classList.remove('disabled');
            }
            else
            {
                btnCancelFriendRequest.classList.remove('disabled');
              createToast(mUserName,response.message,'error',mUserImage,'2000');
            }
          }
        });
    }

    function acceptFriendRequest(value)
    {
        let btnAddFriend = document.getElementById('btnAddFriend'+value);
        let btnCancelFriendRequest = document.getElementById('btnCancelFriendRequest'+value);
        let btnUnfriend = document.getElementById('btnUnfriend'+value);
        let btnAcceptFriendRequest = document.getElementById('btnAcceptFriendRequest'+value);
        let btnRejectFriendRequest = document.getElementById('btnRejectFriendRequest'+value);
        let btnBlockFriend = document.getElementById('btnBlockFriend'+value);
        let btnUnBlockFriend = document.getElementById('btnUnBlockFriend'+value);
        btnAcceptFriendRequest.classList.add('disabled');
        $.ajax({
          headers:{  
             "token":"<?php if (isset($_COOKIE['token'])) echo $_COOKIE['token']; ?>"
          },
          type:"post",
          url:BASE_URL+"acceptFriendRequest",
          data: 
          {  
             'userId' : btnAcceptFriendRequest.value
          },
          success:function(response)
          {
            console.log(response);
            if (!response.error)
            {
                btnAddFriend.style.display = 'none';
                btnCancelFriendRequest.style.display = 'none';
                btnUnfriend.style.display = 'block';
                btnAcceptFriendRequest.style.display = 'none';
                btnRejectFriendRequest.style.display = 'none';
                btnBlockFriend.style.display = 'block';
                btnAcceptFriendRequest.classList.remove('disabled');
            }
            else
            {
                btnAcceptFriendRequest.classList.remove('disabled');
              createToast(mUserName,response.message,'error',mUserImage,'2000');
            }
          }
        });
    }

    function rejectFriendRequest()
    {
        let btnAddFriend = document.getElementById('btnAddFriend'+value);
        let btnCancelFriendRequest = document.getElementById('btnCancelFriendRequest'+value);
        let btnUnfriend = document.getElementById('btnUnfriend'+value);
        let btnAcceptFriendRequest = document.getElementById('btnAcceptFriendRequest'+value);
        let btnRejectFriendRequest = document.getElementById('btnRejectFriendRequest'+value);
        let btnBlockFriend = document.getElementById('btnBlockFriend'+value);
        let btnUnBlockFriend = document.getElementById('btnUnBlockFriend'+value);
        btnRejectFriendRequest.classList.add('disabled');
        $.ajax({
          headers:{  
             "token":"<?php if (isset($_COOKIE['token'])) echo $_COOKIE['token']; ?>"
          },
          type:"post",
          url:BASE_URL+"cancelFriendRequest",
          data: 
          {  
             'userId' : btnRejectFriendRequest.value
          },
          success:function(response)
          {
            console.log(response);
            if (!response.error)
            {
                btnAddFriend.style.display = 'block';
                btnCancelFriendRequest.style.display = 'none';
                btnUnfriend.style.display = 'none';
                btnAcceptFriendRequest.style.display = 'none';
                btnRejectFriendRequest.style.display = 'none';
                btnBlockFriend.style.display='block';
                btnRejectFriendRequest.classList.remove('disabled');
            }
            else
            {
                btnRejectFriendRequest.classList.remove('disabled');
              createToast(mUserName,response.message,'error',mUserImage,'2000');
            }
          }
        });
    }

    function unfriend(value)
    {
        let btnAddFriend = document.getElementById('btnAddFriend'+value);
        let btnCancelFriendRequest = document.getElementById('btnCancelFriendRequest'+value);
        let btnUnfriend = document.getElementById('btnUnfriend'+value);
        let btnAcceptFriendRequest = document.getElementById('btnAcceptFriendRequest'+value);
        let btnRejectFriendRequest = document.getElementById('btnRejectFriendRequest'+value);
        let btnBlockFriend = document.getElementById('btnBlockFriend'+value);
        let btnUnBlockFriend = document.getElementById('btnUnBlockFriend'+value);
        btnUnfriend.classList.add('disabled');
        $.ajax({
          headers:{  
             "token":"<?php if (isset($_COOKIE['token'])) echo $_COOKIE['token']; ?>"
          },
          type:"post",
          url:BASE_URL+"deleteFriend",
          data: 
          {  
             'userId' : btnUnfriend.value
          },
          success:function(response)
          {
            console.log(response);
            if (!response.error)
            {
                btnAddFriend.style.display = 'block';
                btnCancelFriendRequest.style.display = 'none';
                btnUnfriend.style.display = 'none';
                btnAcceptFriendRequest.style.display = 'none';
                btnRejectFriendRequest.style.display = 'none';
                btnUnfriend.classList.remove('disabled');
            }
            else
            {
                btnUnfriend.classList.remove('disabled');
              createToast(mUserName,response.message,'error',mUserImage,'2000');
            }
          }
        });
    }

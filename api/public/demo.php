<?php



    function addFeedComment($feedId, $feedComment, $userId)
    {
        $feedPrivacy = $this->getFeedPrivacyByFeedId($feedId);
        $feedAuthorId = $this->getFeedAuthorIdByFeedId($feedId);
        $tokenId = $this->getUserId();
        if ($feedPrivacy!=1) 
        {
            if ($this->isAlreadyFriend($tokenId,$feedAuthorId)) 
            {
                return FEED_COMMENT_ADD_FAILED;
            }
            else
            {
                if (!$this->isUserBlocked($feedAuthorId)) 
                {
                    $query = "INSERT INTO comments (feedId,feedComment,userId) VALUES (?,?,?)";
                    $stmt = $this->con->prepare($query);
                    $stmt->bind_param("sss",$feedId,$feedComment,$userId);
                    if ($stmt->execute())
                        return FEED_COMMENT_ADDED;
                    else
                        return FEED_COMMENT_ADD_FAILED;
                }
                else
                    return FEED_COMMENT_ADD_FAILED;
            }
        }
        else
        {
            if (!$this->isUserBlocked($feedAuthorId)) 
            {
                $query = "INSERT INTO comments (feedId,feedComment,userId) VALUES (?,?,?)";
                $stmt = $this->con->prepare($query);
                $stmt->bind_param("sss",$feedId,$feedComment,$userId);
                if ($stmt->execute())
                    return FEED_COMMENT_ADDED;
                else
                    return FEED_COMMENT_ADD_FAILED;
            }
            else
                return FEED_COMMENT_ADD_FAILED;
        }
    }

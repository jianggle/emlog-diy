<?php
/**
 * 发表评论
 *
 * @copyright (c) Emlog All Rights Reserved
 */

class Comment_Controller {
  function addComment($params) {
    $name = isset($_POST['comname']) ? addslashes(trim($_POST['comname'])) : '';
    $content = isset($_POST['comment']) ? addslashes(trim($_POST['comment'])) : '';
    $mail = isset($_POST['commail']) ? addslashes(trim($_POST['commail'])) : '';
    $url = isset($_POST['comurl']) ? addslashes(trim($_POST['comurl'])) : '';
    $imgcode = isset($_POST['imgcode']) ? addslashes(trim(strtoupper($_POST['imgcode']))) : '';
    $blogId = isset($_POST['gid']) ? intval($_POST['gid']) : -1;
    $pid = isset($_POST['pid']) ? intval($_POST['pid']) : 0;

    if (ISLOGIN === true) {
      $CACHE = Cache::getInstance();
      $user_cache = $CACHE->readCache('user');
      $name = addslashes($user_cache[UID]['name_orig']);
      $mail = addslashes($user_cache[UID]['mail']);
      $url = addslashes(BLOG_URL);
    }

    if ($url && strncasecmp($url,'http',4)) {
      $url = 'http://'.$url;
    }

    doAction('comment_post');

    $Comment_Model = new Comment_Model();
    $Comment_Model->setCommentCookie($name,$mail,$url);
    if($Comment_Model->isLogCanComment($blogId) === false) {
      myJson(json_encode(array("status"=>"1")));
    } elseif ($Comment_Model->isCommentExist($blogId, $name, $content) === true) {
      myJson(json_encode(array("status"=>"2")));
    } elseif (ROLE == ROLE_VISITOR && $Comment_Model->isCommentTooFast() === true) {
      myJson(json_encode(array("status"=>"3")));
    } elseif (empty($name)) {
      myJson(json_encode(array("status"=>"4")));
    } elseif (strlen($name) > 20) {
      myJson(json_encode(array("status"=>"5")));
    } elseif ($mail != '' && !checkMail($mail)) {
      myJson(json_encode(array("status"=>"6")));
    } elseif (ISLOGIN == false && $Comment_Model->isNameAndMailValid($name, $mail) === false) {
      myJson(json_encode(array("status"=>"7")));
    } elseif (!empty($url) && preg_match("/^(http|https)\:\/\/[^<>'\"]*$/", $url) == false) {
      myJson(json_encode(array("status"=>"8")));
    } elseif (empty($content)) {
      myJson(json_encode(array("status"=>"9")));
    } elseif (strlen($content) > 8000) {
      myJson(json_encode(array("status"=>"10")));
    } elseif (ROLE == ROLE_VISITOR && Option::get('comment_needchinese') == 'y' && !preg_match('/[\x{4e00}-\x{9fa5}]/iu', $content)) {
      myJson(json_encode(array("status"=>"11")));
    } elseif (ISLOGIN == false && Option::get('comment_code') == 'y' && session_start() && $imgcode != $_SESSION['code']) {
      myJson(json_encode(array("status"=>"12")));
    } else {
            $_SESSION['code'] = null;
      $Comment_Model->addComment($name, $content, $mail, $url, $imgcode, $blogId, $pid);
    }
  }
}

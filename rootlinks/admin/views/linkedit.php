<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class=containertitle><b>编辑链接</b></div>
<div class=line></div>
<form action="link.php?action=update_link" method="post">
<div class="item_edit">
  <li>
  <select name="linksortid" id="linksortid" class="input">
    <option value="-1">未分类</option>
    <?php foreach($sortlink as $key=>$value):?>
    <option value="<?php echo $key; ?>"<?php if($linksortid == $key):?> selected="selected"<?php endif; ?>><?php echo $value['linksort_name']; ?></option>
    <?php endforeach; ?>
  </select>选择分类
  </li>
  <li><input size="40" value="<?php echo $sitename; ?>" class="input" name="sitename" /> 名称<span class="required">*</sapn></li>
  <li><input size="40" value="<?php echo $siteurl; ?>" class="input" name="siteurl" /> 地址<span class="required">*</sapn></li>
  <li>链接描述<br /><textarea name="description" rows="3" class="textarea" cols="42"><?php echo $description; ?></textarea></li>
  <li>
    <input type="hidden" value="<?php echo $linkId; ?>" name="linkid" />
    <input type="submit" value="保 存" class="button" />
    <input type="button" value="取 消" class="button" onclick="javascript: window.history.back();" />
  </li>
</div>
</form>
<script>
$("#menu_link").addClass('sidebarsubmenu1');
</script>

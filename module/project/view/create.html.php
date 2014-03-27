<?php
/**
 * The create view of project module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2013 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     project
 * @version     $Id: create.html.php 4728 2013-05-03 06:14:34Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php if(isset($tips)):?>
<?php $defaultURL = $this-> createLink('project', 'task', 'projectID=' . $projectID);?>
<?php include '../../common/view/header.lite.html.php';?>
<body>
<script>
$(document).ready(function() {$('#tipsModal').modal('show');});
</script>
<div class='modal fade' id='tipsModal'>
  <div class='modal-dialog mw-500px'>
    <div class='modal-header'>
      <a href='<?php echo $defaultURL;?>' class='close'>&times;</a>
      <h4 class='modal-title' id='myModalLabel'><i class='icon-info-sign'></i></h4>
    </div>
    <div class='modal-body'>
      <?php echo $tips;?>
    </div>
    <div class='modal-footer'>
      <div class='text-center'><a href='<?php echo $defaultURL;?>' class='btn btn-primary'><?php echo $lang->project->task;?> <i class='icon-arrow-right'></i></div></a>
    </div>
  </div>
</div>
</body>
</html>
<?php exit;?>
<?php endif;?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<?php js::import($jsRoot . 'misc/date.js');?>
<?php js::set('holders', $lang->project->placeholder);?>
<div class='container mw-900px'>
  <div id='titlebar'>
    <div class='heading'>
      <span class='prefix'><?php echo html::icon($lang->icons['project']);?></span>
      <strong><small class='text-muted'><i class='icon icon-plus'></i></small> <?php echo $lang->project->create;?></strong>
    </div>
    <div class='actions'>
      <?php if($copyProjectID != 0):?>
      <div class='text text-success'>
        <i class='icon-ok-sign'></i> <?php printf($lang->project->copyFromProject, html::icon($lang->icons['project']) . ' ' . $projects[$copyProjectID]);?>
      </div>
      <div class='btn-group'>
        <a class='btn text-danger' href='javascript:setCopyProject("");'><?php echo html::icon($lang->icons['cancel']) . ' ' . $lang->project->cancelCopy;?> ?</a>
        <button class='btn btn-primary' id='cpmBtn'><?php echo html::icon($lang->icons['copy']) . ' ' . $lang->project->reCopyProject;?> ?</button>
      </div>
      <?php else:?>
      <button class='btn btn-primary' id='cpmBtn'><?php echo html::icon($lang->icons['copy']) . ' ' . $lang->project->copy;?> ?</button>
      <?php endif; ?>
    </div>
  </div>
  <form class='form-condensed' method='post' target='hiddenwin' id='dataform'>
    <table class='table table-form'> 
      <tr>
        <th class='w-90px'><?php echo $lang->project->name;?></th>
        <td class='w-p50'><?php echo html::input('name', $name, "class='form-control'");?></td><td></td>
      </tr>
      <tr>
        <th><?php echo $lang->project->code;?></th>
        <td><?php echo html::input('code', $code, "class='form-control'");?></td>
      </tr>  
      <tr>
        <th><?php echo $lang->project->dateRange;?></th>
        <td>
          <div class='input-group'>
            <?php echo html::input('begin',date('Y-m-d'), "class='form-control form-date' onchange='computeWorkDays()' placeholder='" . $lang->project->begin . "'");?>
            <span class='input-group-addon'><?php echo $lang->project->to;?></span>
            <?php echo html::input('end', '', "class='form-control form-date' onchange='computeWorkDays()' placeholder='" . $lang->project->end . "'");?>
            <div class='input-group-btn'>
              <button type='button' class='btn dropdown-toggle' data-toggle='dropdown'><?php echo $lang->project->byPeriod;?> <span class='caret'></span></button>
              <ul class='dropdown-menu'>
              <?php foreach ($lang->project->endList as $key => $name):?>
                <li><a href='javascript:computeEndDate("<?php echo $key;?>")'><?php echo $name;?></a></li>
              <?php endforeach;?>
              </ul>
            </div>
          </div>
        </td>
      </tr>
      <tr>
        <th><?php echo $lang->project->days;?></th>
        <td>
          <div class='input-group'>
          <?php echo html::input('days', '', "class='form-control'");?>
            <span class='input-group-addon'><?php echo $lang->project->day;?></span>
          </div>
        </td>
      </tr>  
      <tr>
        <th><?php echo $lang->project->teamname;?></th>
        <td><?php echo html::input('team', $team, "class='form-control'");?></td>
      </tr>  
      <tr>
        <th><?php echo $lang->project->type;?></th>
        <td>
          <?php echo html::select('type', $lang->project->typeList, '', "class='form-control'");?>
          <div class='help-block'><i class='icon-question-sign'></i> <?php echo $lang->project->typeDesc;?></div>
        </td>
      </tr>
      <tr>
        <th><?php echo $lang->project->manageProducts;?></th>
        <td class='text-left' id='productsBox' colspan="2"><?php echo html::select("products[]", $allProducts, $products, "class='form-control chosen' data-placeholder='{$lang->project->linkProduct}' multiple");?></td>
      </tr>
      <tr>
        <th><?php echo $lang->project->desc;?></th>
        <td colspan='2'><?php echo html::textarea('desc', '', "rows='6' class='area-1'");?></td>
      </tr>  
      <tr>
        <th><?php echo $lang->project->acl;?></th>
        <td colspan='2'><?php echo nl2br(html::radio('acl', $lang->project->aclList, $acl, "onclick='setWhite(this.value);'", 'block'));?></td>
      </tr>  
      <tr id='whitelistBox' <?php if($acl != 'custom') echo "class='hidden'";?>>
        <th><?php echo $lang->project->whitelist;?></th>
        <td colspan='2'><?php echo html::checkbox('whitelist', $groups, $whitelist);?></td>
      </tr>  
      <tr>
        <td colspan='2' class='text-center'><?php echo html::submitButton() . html::backButton();?></td>
      </tr>
    </table>
  </form>
</div>
<div class='modal fade' id='copyProjectModal'>
  <div class='modal-dialog mw-800px'>
    <div class='modal-header'>
      <button type='button' class='close' data-dismiss='modal'>&times;</button>
      <h4 class='modal-title' id='myModalLabel'><i class='icon-copy'></i> <?php echo $lang->project->copy;?> <small><?php echo $lang->project->copyTitle;?></small></h4>
    </div>
    <div class='modal-body'>
      <?php if(count($projects) == 1):?>
      <div class='alert alert-warning'>
        <i class='icon-info-sign'></i>
        <div class='content'>
          <p><?php echo $lang->project->copyNoProject;?></p>
        </div>
      </div>
      <?php else:?>
      <div id='copyProjects' class='row'>
      <?php foreach ($projects as $id => $name):?>
        <div class='col-md-4 col-sm-6'>
        <?php if(empty($id)):?>
          <a href='javascript:;' data-id='' class='cancel'><?php echo html::icon($lang->icons['cancel']) . ' ' . $lang->project->cancelCopy;?></a>
        <?php else: ?>
          <a href='javascript:;' data-id='<?php echo $id;?>' class='nobr <?php echo ($copyProjectID == $id) ? ' active' : '';?>'><?php echo html::icon($lang->icons['project'], 'text-muted') . ' ' . $name;?></a>
        <?php endif; ?>
        </div>
      <?php endforeach;?>
      </div>
      <?php endif;?>
    </div>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>

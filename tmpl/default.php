<?php
/**
 * @package        mod_qltodo
 * @copyright    Copyright (C) 2022 ql.de All rights reserved.
 * @author        Mareike Riegel mareike.riegel@ql.de
 * @license        GNU General Public License version 2 or later; see LICENSE.txt
 */

use Hoochicken\Datagrid\Datagrid;
use Joomla\CMS\Factory;
use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\Language\Text;

// no direct access
defined('_JEXEC') or die;
/** @var \Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = Factory::getApplication()->getDocument()->getWebAssetManager();
$wa->registerAndUseStyle('qltodo', 'mod_qltodo/styles.css');

/* @var stdClass $module */
/* @var \Joomla\Registry\Registry $params */
/* @var array $data */
/* @var array $errores */
/* @var bool $displayEntry */
/* @var bool $displayList */
?>

<div class="qltodo <?= $params->get('shape', 'round') === 'round' ? 'round' : 'rectangular' ?>"
     id="module<?php echo $module->id ?>">
    <a href="#" title="Todo">
        <span href="#" title="Todo" type="button" class="btn btn-primary">
            <i class="fa fa-chess-knight"></i>
        </span>
    </a>
    <span title="Todo" class="qltodo-label">
         <?php
         if (0 < count($errores->getErrors())) {
             $errores = array_column($errores->getErrors(), QltodoError::ATTR_MESSAGE);
             echo sprintf('<div class="alert alert-info">%s</div>', implode('<br />', $errores));
         }
         require ModuleHelper::getLayoutPath('mod_qltodo', 'default_form');
         if ($displayEntry) require ModuleHelper::getLayoutPath('mod_qltodo', 'default_entry');
         if ($displayList) {
             require ModuleHelper::getLayoutPath('mod_qltodo', 'default_list');
         }
         ?>
    </span>

</div>
<?php return; ?>




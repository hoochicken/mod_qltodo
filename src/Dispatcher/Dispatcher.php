<?php
/**
 * @package     Hoochicken\Module\Qltodo
 *
 * @copyright   Copyright (C) 2026 Mareike Riegel. All rights reserved.
 * @license     GNU General Public License version 2 or later;
 */

namespace Hoochicken\Module\Qltodo\Site\Dispatcher;

defined('_JEXEC') or die;

use Exception;
use Hoochicken\Module\Qltodo\Site\Helper\DisplayData;
use Hoochicken\Module\Qltodo\Site\Helper\DisplayDataInterface;
use Hoochicken\Module\Qltodo\Site\Helper\ParametersCustom;
use Hoochicken\Module\Qltodo\Site\Helper\QltodoForm;
use Hoochicken\Module\Qltodo\Site\Helper\QltodoRepository;
use Hoochicken\Module\Qltodo\Site\Helper\TodoItem;
use Hoochicken\Module\Qltodo\Site\Helper\UrlWizard;
use Joomla\CMS\Dispatcher\AbstractModuleDispatcher;
use Joomla\CMS\Factory;
use Joomla\CMS\Helper\HelperFactoryAwareInterface;
use Joomla\CMS\Helper\HelperFactoryAwareTrait;
use Hoochicken\Module\Qltodo\Site\Helper\QltodoHelper;
use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\WebAsset\WebAssetManager;
use Joomla\Registry\Registry;

class Dispatcher extends AbstractModuleDispatcher implements HelperFactoryAwareInterface
{
    use HelperFactoryAwareTrait;

    private const HELPER_NAME = 'QltodoHelper';
    private ?Registry $params = null;
    private QltodoRepository $qltodoTable;

    public function dispatch()
    {
        try {
            $this->loadLanguage();

            static::loadWebAssets();

            $input = Factory::getApplication()->getInput();
            $qltodoId = $input->getInt(QltodoForm::PARAM_TODO_ID, 0);
            $qltodoTask = $input->getString(QLtodoForm::PARAM_TODO_TASK);

            // init helper
            /** @var QltodoHelper $helper */
            $config = Factory::getContainer()->get('config');
            $qltodoRepository = $this->getDbQltodoRepository($config);
            $helper = $this->getHelperFactory()->getHelper(static::HELPER_NAME, [
                QltodoRepository::class => $qltodoRepository,
            ]);

            $displayList =
                !QltodoForm::isTaskCreate($qltodoTask)
                && (
                    0 >= $qltodoId
                    || QltodoForm::isTaskSaveAndClose($qltodoTask)
                    || QltodoForm::isTaskClose($qltodoTask)
                );

            if (QltodoForm::isTaskSave($qltodoTask)) {
                $entry = $helper->getTodoItemFromInput($input);
                $helper->saveEntry($entry);
            } elseif (QltodoForm::isTaskDelete($qltodoTask)) {
                $helper->deleteEntry($qltodoId);
            }

            $displayData = $this->getLayoutDataAdvanced($helper, $qltodoId, $displayList);
            $path = ModuleHelper::getLayoutPath('mod_qltodo', $displayData->getParams()->getLayout());
            require $path;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    protected function isProperDisplayCustom(array $displayData): bool
    {
        return empty($displayData) || !isset($displayData['data']) || ParametersCustom::class !== get_class($displayData['data']);
    }

    protected function getLayoutData(): array
    {
        try {
            $layoutData = parent::getLayoutData();
            $this->params = new Registry($layoutData['params']);

            // init database table
            $config = Factory::getContainer()->get('config');
            $qltodoRepository = $this->getDbQltodoRepository($config);

            /** @var QltodoHelper $helper */
            $helper = $this->getHelperFactory()->getHelper(static::HELPER_NAME, [
                QltodoRepository::class => $qltodoRepository,
            ]);

            $displayModel = $this->getLayoutDataAdvanced($helper);
            return $displayModel->toArray();
        } catch (Exception $e) {
            return ['msg' => $e->getMessage()];
        }
    }

    protected function getLayoutDataAdvanced(QltodoHelper $helper, int $qltodoId = 0, bool $displayList = true): DisplayDataInterface
    {
        $data = parent::getLayoutData();
        $this->params = new Registry($data['params']);
        $params = new ParametersCustom($this->params ?? null, $this->module);

        // create display data object
        $displayData = new DisplayData($params);
        if ($displayList) {
            // list of entries
            $list = $helper->getQlTodoEntries();
            $displayData->setQltodoEntries($list);
            return $displayData;
        }

        // single entry given by get params
        $entry = 0 < $qltodoId
            ? $helper->getQlTodoEntryById($qltodoId) :
            (new TodoItem())
                ->setPageUrl(UrlWizard::getPageUrl())
                ->setMenuItemTitle(UrlWizard::getMenuTitle())
                ->setMenuItemId(UrlWizard::getMenuItemId())
        ;
        $displayData->setDisplayForm();
        $displayData->setQltodoEntry($entry);
        return $displayData;
    }

    private function getDbQltodoRepository(Registry $config): QltodoRepository
    {
        require_once JPATH_BASE . '/modules/mod_qltodo/vendor/autoload.php';
        $tableName = str_replace('#__', $config->get('dbprefix', ''), QltodoRepository::TABLE_NAME);
        $table = new QltodoRepository($config->get('host', ''), $config->get('db', ''), $config->get('user', ''), $config->get('password', ''), $config->get('port', 3306));
        $table->setTable($tableName);
        // $table->create('test' . rand(1,1000), 'description');
        if ($table->tableExistsQltodo()) {
            return $table;
        }
        return $table->createTableQltodo();
    }

    private static function loadWebAssets(): void
    {
        /** @var WebAssetManager $wa */
        $wa = Factory::getApplication()->getDocument()->getWebAssetManager();
        $wa->registerScript('mod_qltodo', 'mod_qltodo/script.js');
        $wa->registerStyle('mod_qltodo', 'mod_qltodo/styles.css');

        if (!$wa->assetExists('script', 'mod_qltodo')) {
            var_dump('Script "mod_qltodo" NOT exists!');
        }
        if (!$wa->assetExists('style', 'mod_qltodo')) {
            var_dump('Style "mod_qltodo" NOT exists!');
        }
    }
}

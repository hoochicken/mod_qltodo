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
use Joomla\CMS\Dispatcher\AbstractModuleDispatcher;
use Joomla\CMS\Factory;
use Joomla\CMS\Helper\HelperFactoryAwareInterface;
use Joomla\CMS\Helper\HelperFactoryAwareTrait;
use Hoochicken\Module\Qltodo\Site\Helper\QltodoHelper;
use Joomla\CMS\Helper\ModuleHelper;
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
            $input = Factory::getApplication()->getInput();
            $qltodoId = $input->getInt(QltodoForm::PARAM_TODO_ID, 0);
            // $request = array_merge($_REQUEST, $_SERVER);

            $displayData = $this->getLayoutDataRaw($qltodoId);
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
            $data = parent::getLayoutData();
            $this->params = new Registry($data['params']);

            $displayModel = $this->getLayoutDataRaw();
            return $displayModel->toArray();
        } catch (Exception $e) {
            return ['msg' => $e->getMessage()];
        }
    }

    protected function getLayoutDataRaw(int $qltodoId = 0): DisplayDataInterface
    {
        $data = parent::getLayoutData();
        $this->params = new Registry($data['params']);

        // init database table
        $config = Factory::getContainer()->get('config');
        $qltodoRepository = $this->getDbQltodoRepository($config);

        // list of entries
        /** @var QltodoHelper $helper */
        $helper = $this->getHelperFactory()->getHelper(static::HELPER_NAME, [
            QltodoRepository::class => $qltodoRepository,
        ]);
        $list = $helper->getQlTodoEntries();
        $params = new ParametersCustom($this->params ?? null, $this->module);

        // single entry given by get params
        $entry = 0 < $qltodoId ? $helper->getQlTodoEntryById($qltodoId) : null;

        // create display data object
        $displayData = new DisplayData($params);
        $displayData->setMessage($helper->getMessage($this->params, $this->getApplication()));
        if (0 < $qltodoId) {
            $displayData->setDisplayForm();
            $displayData->setQltodoEntry($entry);
        } else {
            $displayData->setQltodoEntries($list);
        }

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
}

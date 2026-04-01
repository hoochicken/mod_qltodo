<?php
/**
 * @package     Hoochicken\Module\Qltodo
 *
 * @copyright   Copyright (C) 2025 Mareike Riegel. All rights reserved.
 * @license     GNU General Public License version 2 or later;
 */

namespace Hoochicken\Module\Qltodo\Site\Dispatcher;

defined('_JEXEC') or die;

use Exception;
use Hoochicken\Module\Qltodo\Site\Helper\DisplayData;
use Hoochicken\Module\Qltodo\Site\Helper\DisplayDataInterface;
use Hoochicken\Module\Qltodo\Site\Helper\ParametersCustom;
use Joomla\CMS\Dispatcher\AbstractModuleDispatcher;
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

    public function dispatch()
    {
        try {
            $this->loadLanguage();

            $displayData = $this->getLayoutDataRaw();
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

    protected function getLayoutDataRaw(): DisplayDataInterface
    {
        $data = parent::getLayoutData();
        $this->params = new Registry($data['params']);

        /** @var QltodoHelper $helper */
        $helper = $this->getHelperFactory()->getHelper(static::HELPER_NAME);

        $params = new ParametersCustom($this->params ?? null, $this->module);
        $displayData = new DisplayData($params);
        $displayData->setMessage($helper->getMessage($this->params, $this->getApplication()));

        return $displayData;
    }
}
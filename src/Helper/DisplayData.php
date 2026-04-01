<?php
/**
 * mod_qltodo
 *
 * @copyright  Copyright (C) 2026. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Hoochicken\Module\Qltodo\Site\Helper;

use Joomla\Registry\Registry;
use stdClass;

class DisplayData implements DisplayDataInterface
{
    private ParametersCustomInterface $params;

    public function __construct(ParametersCustomInterface $params)
    {
        $this->params = $params;
    }

    /**
     * @return array{message: string|null, params: Registry, module: stdClass}
     */
    public function toArray(): array
    {
        return [
            'data' => $this->params,
            'message' => $this->params->getMessage(),
            'params' => $this->getParams(),
            'module' => $this->getParams()->getModule(),
        ];
    }

    public function getParams(): ParametersCustom
    {
        return $this->params;
    }

    public function setMessage(?string $message): void
    {
        $this->params->setMessage($message);
    }
}

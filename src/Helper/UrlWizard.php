<?php

namespace Hoochicken\Module\Qltodo\Site\Helper;

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;

class UrlWizard
{

    public function __construct(public string $baseUrl, public string $separator)
    {

    }

    public function getDeleteUrl(int $id): string
    {
        return sprintf(
            '%s%s%s=%s&%s=%d',
            $this->baseUrl,
            $this->separator,
            QltodoForm::PARAM_TODO_TASK,
            QltodoForm::TASK_DELETE,
            QltodoForm::PARAM_TODO_ID,
            $id
        );
    }

    public function getEditUrl(int $id): string
    {
        return sprintf(
            '%s%s%s=%s&%s=%d',
            $this->baseUrl,
            $this->separator,
            QltodoForm::PARAM_TODO_TASK,
            QltodoForm::TASK_EDIT,
            QltodoForm::PARAM_TODO_ID,
            $id
        );
    }

    public static function getPageUrl(): string
    {
        return (Uri::getInstance())->toString();
    }

    public static function getPageUrlCleanedUp(): string
    {
        $pagelUrl = static::getPageUrl();
        $pagelUrl = preg_replace('~qltodoid=([0-9]*)~', '', $pagelUrl);
        $pagelUrl = preg_replace('~qltodotask=([0-9.a-zA-Z]*)~', '', $pagelUrl);
        return $pagelUrl;
    }

    public static function getMenuTitle(): string
    {
        return Factory::getApplication()->getMenu()->getActive()->title ?? '';
    }

    public static function getMenuItemId(): string
    {
        return Factory::getApplication()->getMenu()->getActive()->id ?? 0;
    }
}
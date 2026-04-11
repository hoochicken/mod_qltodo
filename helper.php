<?php

namespace Hoochicken\Module\Qltodo\Site;

use Hoochicken\Module\Qltodo\Site\Helper\QltodoHelper;

class ModQltodoHelper
{
    public function getHelper(string $name, array $config = [])
    {
        return new QltodoHelper;
    }
}

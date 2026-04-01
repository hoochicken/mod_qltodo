<?php

namespace Hoochicken\Module\Qltodo\Site\Helper;

class TodoItem
{
    public int $id = 0;
    public string $title = '';
    public string $description = '';
    public string $page_url = '';
    public int $menu_item_id = 0;
    public string $menu_item_title = '';
    public int $state = 1;
    public int $workflow = 1;
    public int $severity = 1;
    public string $created_at = '';
    public int $created_by = 0;
    public string $modified_at = '';
    public int $modified_by = 0;
    public string $deleted_at = '';
    public int $deleted_by = 0;
}

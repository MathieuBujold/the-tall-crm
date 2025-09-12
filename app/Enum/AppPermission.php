<?php

namespace App\Enum;

enum AppPermission: string
{
    case VIEW_DASHBOARD = 'view_dashboard';
    case EDIT_USER = 'edit_user';
}

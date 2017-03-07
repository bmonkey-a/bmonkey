<?php
class M_UserFunctions{

    function getMenu($mode = 0)
    {
        $mode_bar = ['user' => 'Обычный пользователь', 'superuser' => 'Суперпользователь'];
        if ($mode == 1) {
            $mode_bar['user'] = "<a href='index.php'>" . $mode_bar['user'] . "</a>";
            $mode_bar['superuser'] = "<b>" . $mode_bar['superuser'] . "</b>";
        }else{
            $mode_bar['user'] = "<b>" . $mode_bar['user'] . "</b>";
            $mode_bar['superuser'] = "<a href='index.php?c=moderate'>" . $mode_bar['superuser'] . "</a>";
        }
        return $mode_bar;
    }
}

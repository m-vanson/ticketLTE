<?php

if (($tabs = $nav->getTabs()) && is_array($tabs)) {
    foreach ($tabs as $name => $tab) {
        if ($tab['href'][0] != '/') {
            $tab['href'] = ROOT_PATH . 'scp/' . $tab['href'];
            if (count($nav->getSubMenu($name)) > 0) {
                echo sprintf('<li class="treeview %s"><a href="#"><span>%s</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>',$tab['active'] ? 'active' : '', $tab['desc']);
            } else {
                echo sprintf('<li class="treeview"><a href="%s"><span>%s</span></a>', $tab['href'], $tab['desc']);
            }
        }
        if (!empty($nav->getSubMenu($name))) {
            $subnav = $nav->getSubMenu($name);
            echo '<ul class="treeview-menu">';
            foreach ($subnav as $k => $item) {
                if (!($id = $item['id'])) {
                    $id = "nav$k";
                    if ($item['href'][0] != '/') {
                        $item['href'] = ROOT_PATH . 'scp/' . $item['href'];
                        echo sprintf('<li><a href="%s"><i class="fa fa-circle-o"></i>%s</a></li>', $item['href'], $item['desc']);
                    }
                }
            }
            echo "</ul>";
        }
        echo "</li>";
    }
}

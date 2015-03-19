<?php

class IndexController extends PlatformController
{

    public function indexAction()
    {
        $this->display('index.html');
    }

    public function topAction()
    {
        $this->display('top.html');
    }

    public function menuAction()
    {
        $this->display('menu.html');
    }

    public function mainAction()
    {
        $this->display('main.html');
    }

}

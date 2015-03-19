<?php
class CaptchaController
{
    public function indexAction()
    {
        header('Context-Type:image/jpeg');
        CaptchaTool::generate();
    }
}

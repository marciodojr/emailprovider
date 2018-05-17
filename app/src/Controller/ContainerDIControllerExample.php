<?php

namespace IntecPhp\Controller;


use IntecPhp\Model\ContainerDIModelExample;

class ContainerDIControllerExample
{

    private $di;

    public function __construct(ContainerDIModelExample $di)
    {
        $this->di = $di;
    }


    public function testDI($request)
    {
        echo '<pre>';
        var_dump([$this->di, $request]);
    }

}

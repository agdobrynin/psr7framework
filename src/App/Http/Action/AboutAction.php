<?php
namespace App\Http\Action;

use Zend\Diactoros\Response\HtmlResponse;

class AboutAction
{
    /**
     * Undocumented function
     *
     * @return Zend\Diactoros\Response\HtmlResponse
     */
    public function __invoke()
    {
        return new HtmlResponse("About. Simple site.");
    }
}

<?php
namespace App\Http\Action;

use Zend\Diactoros\Response\HtmlResponse;

/**
 * Undocumented class
 *
 */

class AboutAction
{
    /**
     * Undocumented function
     *
     * @return Zend\Diactoros\Response\HtmlResponse
     */
    public function __invorke()
    {
        return new HtmlResponse("About. Simple site.");
    }
}

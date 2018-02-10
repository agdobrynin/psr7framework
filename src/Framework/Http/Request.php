<?php
namespace Framework\Http;
use Framework\Http\Request;

/**
 * Обработка запросов http
 */
class Request
{
    protected $queryParams;
    protected $parsedBody;

    /**
     * создание объекта Request
     * @method __construct
     * @param  array       $queryParams параметры как правило GET
     * @param  [type]      $parsedBody  параметры тела как правило POST
     */
    public function __construct(array $queryParams = [], $parsedBody = null)
    {
        $this->queryParams = $queryParams;
        $this->parsedBody = $parsedBody;
    }

    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    public function withQueryParams(array $query): self
    {
        $new = clone $this;
        $new->queryParams = $query;
        return $new;
    }

    public function getParsedBody()
    {
        return $this->parsedBody ?:null;
    }

    public function withParsedBody($data): self
    {
        $new = clone $this;
        $new->parsedBody = $data;
        return $new;
    }
}

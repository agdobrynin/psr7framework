<?php
namespace Framework\Http;

/**
 * Обработка запросов http
 */
class Request implements ServerRequestInterface
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

    /**
     * вернет значения из Query String
     * @method getQueryParams
     * @return array          [description]
     */
    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    /**
     * Добавит патмеры
     * @method withQueryParams
     * @param  array           $query [description]
     * @return self                   [description]
     */
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

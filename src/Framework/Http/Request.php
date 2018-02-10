<?php
namespace Framework\Http;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

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

    public function getProtocolVersion() {}
    public function withProtocolVersion($version) {}
    public function getHeaderLine($name) {}
    public function withAddedHeader($name, $value) {}
    public function withoutHeader($name) {}
    public function withBody(StreamInterface $body) {}
    public function getRequestTarget() {}
    public function withRequestTarget($requestTarget) {}
    public function getMethod() {}
    public function withMethod($method) {}
    public function getUri() {}
    public function withUri(UriInterface $uri, $preserveHost = false) {}
    public function getServerParams() {}
    public function getCookieParams() {}
    public function withCookieParams(array $cookies) {}
    public function getUploadedFiles() {}
    public function withUploadedFiles(array $uploadedFiles) {}
    public function getAttributes() {}
    public function getAttribute($name, $default = null) {}
    public function withAttribute($name, $value) {}
    public function withoutAttribute($name) {}
    public function getHeaders() {}
    public function hasHeader($name) {}
    public function getHeader($name) {}
    public function withHeader($name, $value) {}
    public function getBody() {}
}

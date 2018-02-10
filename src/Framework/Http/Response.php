<?php
namespace Framework\Http;

class Response
{
    protected $headers = [];
    protected $body;
    protected $statusCode;
    protected $reasonPhrase = '';

    protected static $phrases = [
        200 => 'OK',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not Found',
        500 => 'Internal Server Error',
    ];

    /**
     * [__construct description]
     * @method __construct
     * @param  [type]      $body   [description]
     * @param  integer     $status [description]
     */
    public function __construct($body, $status = 200)
    {
        $this->body = $body;
        $this->statusCode = $status;
    }

    /**
     * [getBody description]
     * @method getBody
     * @return [type]  [description]
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * [withBody description]
     * @method withBody
     * @param  [type]   $body [description]
     * @return self           [description]
     */
    public function withBody($body): self
    {
        $new = clone $this;
        $new->body = $body;
        return $new;
    }

    /**
     * [getStatusCode description]
     * @method getStatusCode
     * @return int           [description]
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * [getReasonPhrase description]
     * @method getReasonPhrase
     * @return string          [description]
     */
    public function getReasonPhrase(): string
    {
        if(!$this->reasonPhrase && isset(self::$phrases[$this->statusCode])){
            $this->reasonPhrase = self::$phrases[$this->statusCode];
        }
        return $this->reasonPhrase;
    }

    /**
     * [withStatus description]
     * @method withStatus
     * @param  [type]     $code         [description]
     * @param  string     $resaonPhrase [description]
     * @return self                     [description]
     */
    public function withStatus($code, $resaonPhrase = ''): self
    {
        $new = clone $this;
        $new->statusCode = $code;
        $new->reasonPhrase = $resaonPhrase;
        return $new;
    }

    /**
     * [getHeaders description]
     * @method getHeaders
     * @return array      [description]
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * [hasHeader description]
     * @method hasHeader
     * @param  [type]    $header [description]
     * @return bool           [description]
     */
    public function hasHeader($header): bool
    {
        return isset($this->headers[$header]);
    }

    /**
     * [getHeader description]
     * @method getHeader
     * @param  [type]    $header [description]
     * @return [type]            [description]
     */
    public function getHeader($header)
    {
        if(!$this->hasHeader($header)){
            return null;
        }
        return $this->headers[$header];
    }

    /**
     * [withHeader description]
     * @method withHeader
     * @param  [type]     $header [description]
     * @param  [type]     $value  [description]
     * @return self               [description]
     */
    public function withHeader($header, $value): self
    {
        $new = clone $this;
        if($new->hasHeader($header)){
            unset($new->headers[$header]);
        }
        $new->headers[$header] = $value;
        return $new;
    }
}
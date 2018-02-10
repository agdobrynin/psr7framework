<?php
namespace Framework\Http;

interface ResponseInterface
{
    /**
     * [getBody description]
     * @method getBody
     * @return [type]  [description]
     */
    public function getBody();

    /**
     * [withBody description]
     * @method withBody
     * @param  [type]   $body [description]
     * @return self           [description]
     */
    public function withBody($body);

    /**
     * [getStatusCode description]
     * @method getStatusCode
     * @return int           [description]
     */
    public function getStatusCode(): int;

    /**
     * [getReasonPhrase description]
     * @method getReasonPhrase
     * @return string          [description]
     */
    public function getReasonPhrase(): string;

    /**
     * [withStatus description]
     * @method withStatus
     * @param  [type]     $code         [description]
     * @param  string     $resaonPhrase [description]
     * @return self                     [description]
     */
    public function withStatus($code, $resaonPhrase = '');

    /**
     * [getHeaders description]
     * @method getHeaders
     * @return array      [description]
     */
    public function getHeaders(): array;

    /**
     * [hasHeader description]
     * @method hasHeader
     * @param  [type]    $header [description]
     * @return bool           [description]
     */
    public function hasHeader($header): bool;

    /**
     * [getHeader description]
     * @method getHeader
     * @param  [type]    $header [description]
     * @return [type]            [description]
     */
    public function getHeader($header);

    /**
     * [withHeader description]
     * @method withHeader
     * @param  [type]     $header [description]
     * @param  [type]     $value  [description]
     * @return self               [description]
     */
    public function withHeader($header, $value);
}

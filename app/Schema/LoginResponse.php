<?php

namespace App\Schema;

/**
 * @OA\Schema(
 *     title="LoginResponse",
 *     description="LoginResponse",
 *     @OA\Xml(
 *         name="LoginResponse"
 *     )
 * )
 * @SuppressWarnings(PHPMD)
 */
class LoginResponse
{
    /**
     * @OA\Property(
     *      title="access_token",
     *      description="access_token of user",
     *      example="123.456.789"
     * )
     *
     * @var string
     */
    public $access_token;

    /**
     * @OA\Property(
     *      title="type",
     *      description="Access token type when call api",
     *      example="Bearer"
     * )
     *
     * @var string
     */
    public $type;

    /**
     * @OA\Property(
     *      title="expires_in",
     *      description="expires of token",
     *      example="3600"
     * )
     *
     * @var integer
     */
    public $expires_in;
}

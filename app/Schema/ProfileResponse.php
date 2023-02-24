<?php

namespace App\Schema;

/**
 * @OA\Schema(
 *     title="ProfileResponse",
 *     description="ProfileResponse",
 *     @OA\Xml(
 *         name="ProfileResponse"
 *     )
 * )
 * @SuppressWarnings(PHPMD)
 */
class ProfileResponse
{
    /**
     * @OA\Property(
     *      title="sub",
     *      example="123"
     * )
     *
     * @var integer
     */
    public $sub;

    /**
     * @OA\Property(
     *      title="email",
     *      example="email@gmail.com"
     * )
     *
     * @var string
     */
    public $email;

    /**
     * @OA\Property(
     *      title="fullname",
     *      example="fullname"
     * )
     *
     * @var string
     */
    public $fullname;

    /**
     * @OA\Property(
     *      title="departmentId",
     *      description="expires of token",
     *      example="1"
     * )
     *
     * @var integer
     */
    public $departmentId;

    /**
     * @OA\Property(
     *      title="roleId",
     *      example="1"
     * )
     *
     * @var integer
     */
    public $roleId;
}

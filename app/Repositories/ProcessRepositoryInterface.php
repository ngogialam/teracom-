<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface ProcessRepositoryInterface.
 *
 * @package namespace App\Repositories;
 */
interface ProcessRepositoryInterface extends RepositoryInterface
{
    public function getProcessWithStatusApproveAndFirstStep(): array;
}

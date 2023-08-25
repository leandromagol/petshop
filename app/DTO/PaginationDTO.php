<?php

namespace App\DTO;

/**
 *
 */
class PaginationDTO
{
    /**
     * @param int $limit
     * @param string $sortBy
     * @param bool $desc
     */
    public function __construct(public int $limit, public string $sortBy, public bool $desc)
    {
    }
}

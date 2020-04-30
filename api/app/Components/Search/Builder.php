<?php

namespace App\Components\Search;

class Builder extends \Laravel\Scout\Builder
{
    public function getHighlighted()
    {
        return $this->engine()->highlight($this->get(), $this->raw());
    }

    public function paginateHighlighted($perPage = null, $pageName = 'page', $page = null)
    {
        $paginator = $this->paginate($perPage, $pageName, $page);

    }
}

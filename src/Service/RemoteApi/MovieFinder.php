<?php

namespace App\Service\RemoteApi;

use PoLaKoSz\Mafab\EndPoints\SearchEndpointInterface;
use PoLaKoSz\Mafab\MafabInterface;

class MovieFinder
{
    /**
     * @var MafabInterface
     */
    private MafabInterface $mafabApi;

    /**
     * MovieFinder constructor.
     * @param MafabInterface $mafabApi
     */
    public function __construct(MafabInterface $mafabApi)
    {
        $this->mafabApi = $mafabApi;
    }

    public function find(string $name)
    {
        return $this->getSearcher()->quicklyFor($name);
    }

    public function getSearcher(): SearchEndpointInterface
    {
        return $this->mafabApi->search();
    }
}
<?php

namespace App\Services;

use App\Commit;
use App\Abstracts\Notifiable;
use App\Exceptions\PhabricatorObjectFetchFailedException;
use App\Exceptions\PhabricatorObjectNotFoundException;
use App\Exceptions\PhabricatorObjectNotSupportedException;
use App\Story;
use App\Task;
use Illuminate\Support\Arr;
use Phabricator\Phabricator;

class Fetcher
{
    protected $notifiables = [
        'CMIT' => Commit::class,
        'TASK' => Task::class,
    ];

    /**
     * @var Phabricator
     */
    private $phabricator;

    public function __construct(Phabricator $phabricator)
    {
        $this->phabricator = $phabricator;
    }

    /**
     * @param string $phid
     * @return Notifiable
     * @throws PhabricatorObjectFetchFailedException
     * @throws PhabricatorObjectNotSupportedException
     * @throws PhabricatorObjectNotFoundException
     */
    public function phid(string $phid)
    {
        $response = $this->phabricator->Phid('query', ['phids' => [$phid]]);

        if ($response->isFailed()) throw new PhabricatorObjectFetchFailedException("{$response->getErrorCode()}: {$response->getErrorInfo()}");

        $result = collect(Arr::first($response->getResult()));

        if ($result->isEmpty()) throw new PhabricatorObjectNotFoundException("Object {$phid} has not been found");

        if (! Arr::exists($this->notifiables, $result->get('type'))) throw new PhabricatorObjectNotSupportedException("Object of type {$result->get('type')} is not supported yet.");

        return $this->notifiables[$result->get('type')]::make($result->toArray());
    }

    /**
     * @param string $phid
     * @return mixed
     * @throws PhabricatorObjectFetchFailedException
     * @throws PhabricatorObjectNotFoundException
     */
    public function story(string $phid)
    {
        $response = $this->phabricator->Feed('query', [
            'filterPHIDs' => [$phid],
            'limit' => 1,
            'view' => 'text'
        ]);

        if ($response->isFailed()) throw new PhabricatorObjectFetchFailedException("{$response->getErrorCode()}: {$response->getErrorInfo()}");

        $result = collect(Arr::first($response->getResult()));

        if ($result->isEmpty()) throw new PhabricatorObjectNotFoundException("Object {$phid} has not been found");

        return Story::make($result->toArray());
    }
}
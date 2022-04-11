<?php

namespace App\Repositories\Candidates;

use App\Models\Candidate\CandidateStatus;
use App\Traits\CacheableRepository;
use App\Models\Candidate\Candidate;
use Symfony\Component\HttpFoundation\ParameterBag;

class CandidateCacheRepo implements CandidateRepoInterface
{
    use CacheableRepository;

    protected $candidateRepo;

    public function __construct(CandidateRepo $candidateRepo)
    {
        $this->candidateRepo = $candidateRepo;
    }

    public function get(int $id): Candidate
    {
        return $this->remember(
            'candidate',
            [$id],
            600,
            function () use ($id) {
                return $this->candidateRepo->get($id);
            }
        );
    }


    public function dataTable(ParameterBag $params)
    {

        $params->remove('_');
        $params->remove('draw');
        return $this->remember(
            'candidates',
            [$params->all(), 'datatable'],
            600,
            function () use ($params) {
                return $this->candidateRepo->dataTable($params);
            }
        );
    }

    public function create(ParameterBag $data): Candidate
    {
        $this->clearCache();
        $status = new ParameterBag([
            'status' => 'Initial',
            'is_current'=>true
        ]);
        $candidate = $this->candidateRepo->create($data);
        $this->createStatus($candidate, $status);
        return $candidate;
    }

    public function update(int $id, ParameterBag $data): Candidate
    {
        $this->clearCache();
        return $this->candidateRepo->update($id, $data);
    }

    public function createStatus(Candidate $candidate, ParameterBag $data): CandidateStatus
    {
        return $this->candidateRepo->createStatus($candidate, $data);
    }

    public function clearCache()
    {
        $this->clearCacheByTags([
            'candidates',
            'candidate',
        ]);
    }
}

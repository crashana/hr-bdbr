<?php

namespace App\Services\Candidates;

use App\Models\Candidate\Candidate;
use App\Repositories\Candidates\CandidateRepoInterface;
use App\Services\MainService;
use App\Services\Media\MediaService;
use Symfony\Component\HttpFoundation\ParameterBag;

class CandidateService extends MainService
{
    protected $candidateRepo;
    protected $mediaService;


    public function __construct(
        CandidateRepoInterface $candidateRepo,
        MediaService           $mediaService
    ) {
        $this->candidateRepo = $candidateRepo;
        $this->mediaService = $mediaService;
    }


    public function getAll()
    {
        return $this->candidateRepo->getAll();
    }

    public function get(int $id)
    {
        return $this->candidateRepo->get($id);
    }

    public function dataTable(ParameterBag $params)
    {
        return $this->candidateRepo->dataTable($params);
    }

    public function create(ParameterBag $data): Candidate
    {

        $candidate = $this->candidateRepo->create($data);

        if ($data->get('documents')) {
            foreach ($data->get('documents') as $documents) {
                $this->mediaService->uploadFile(
                    $candidate,
                    $documents,
                    'document',
                    'documents'
                );
            }
        }
        if ($data->get('skills')) {
            foreach ($data->get('skills') as $skill) {
                $this->candidateRepo->createSkill($candidate, $skill);
            }
        }

        return $candidate;
    }

    public function update(int $id, ParameterBag $data): Candidate
    {

        $candidate = $this->candidateRepo->update($id, $data);
        if ($data->get('documents')) {
            foreach ($data->get('documents') as $documents) {
                $this->mediaService->uploadFile(
                    $candidate,
                    $documents,
                    'document',
                    'documents'
                );
            }
        }

        if ($data->get('skills')) {
            foreach ($data->get('skills') as $skill) {
                $this->candidateRepo->createSkill($candidate, $skill);
            }
        }
        return $candidate;
    }


    public function deleteSkill(int $candidateId, string $skill)
    {
        $candidate = $this->get($candidateId);
        return $this->candidateRepo->deleteSkill($candidate, $skill);
    }


    public function getStatuses()
    {
        return $this->candidateRepo->getStatuses();
    }


    public function createStatus($candidate, string $status, string $comment)
    {
        $data = new ParameterBag([
            'is_current' => true,
            'status' => $status,
            'comment' => $comment,
        ]);
        return $this->candidateRepo->createStatus($candidate, $data);
    }

    public function clearCache()
    {
        $this->candidateRepo->clearCache();
    }
}

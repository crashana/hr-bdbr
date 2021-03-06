<?php

namespace App\Repositories\Candidates;

use App\Models\Candidate\Candidate;
use App\Models\Candidate\CandidateSkill;
use App\Models\Candidate\CandidateStatus;
use Symfony\Component\HttpFoundation\ParameterBag;

interface CandidateRepoInterface
{

    public function getAll();

    public function get(int $id);

    public function dataTable(ParameterBag $params);

    public function create(ParameterBag $data): Candidate;

    public function update(int $id, ParameterBag $data): Candidate;

    public function createStatus(Candidate $candidate, ParameterBag $data): CandidateStatus;

    public function createSkill(Candidate $candidate, string $skill): CandidateSkill;

    public function deleteSkill(Candidate $candidate, string $skill);

    public function getStatuses();

    public function clearCache();
}

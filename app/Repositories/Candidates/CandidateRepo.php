<?php

namespace App\Repositories\Candidates;

use App\Models\Candidate\CandidateStatus;
use Symfony\Component\HttpFoundation\ParameterBag;
use App\Classes\DataTable;
use App\Models\Candidate\Candidate;

class CandidateRepo implements CandidateRepoInterface
{

    public function get(int $id): Candidate
    {
        return Candidate::findOrFail($id);
    }

    public function dataTable(ParameterBag $params)
    {

        $search_arr = $params->get('search');
        $searchValue = $search_arr['value'];
        $data = Candidate::query();
        if ($searchValue) {
            $data->where(function ($query) use ($searchValue) {
                $query->where('id', $searchValue);

                $search = explode(' ', $searchValue);
                if (count($search) > 1) {
                    $query->orWhere(function ($data) use ($search) {
                        $data->where('first_name', 'like', '%' . $search[0] . '%')
                            ->where('last_name', 'like', '%' . $search[1] . '%');
                    });
                    $query->orWhere(function ($data) use ($search) {
                        $data->where('first_name', 'like', '%' . $search[1] . '%')
                            ->where('last_name', 'like', '%' . $search[0] . '%');
                    });
                } else {
                    $query->orWhere('first_name', 'like', '%' . $search[0] . '%')
                        ->orWhere('last_name', 'like', '%' . $search[0] . '%');
                }

                $query->orWhere('position', 'like', '%' . $searchValue . '%')
                    ->orWhereHas('skills', function ($q) use ($searchValue) {
                        $q->where('skill', 'like', '%' . $searchValue . '%');
                    })->orWhereHas('statuses', function ($q) use ($searchValue) {
                        $q->where('status', 'like', '%' . $searchValue . '%');
                    });
            });
        }

        $customData = null;
        return DataTable::render(
            $data,
            Candidate::class,
            $params,
            $customData,
            'id',
            'DESC'
        );
    }

    public function create(ParameterBag $data): Candidate
    {
        $candidate = Candidate::create([
            'first_name' => $data->get('first_name'),
            'last_name' => $data->get('last_name'),
            'position' => $data->get('position'),
            'min_salary' => $data->get('min_salary'),
            'max_salary' => $data->get('max_salary'),
            'linkedin_url' => $data->get('linkedin_url'),
        ]);
        return $candidate;
    }

    public function update(int $id, ParameterBag $data): Candidate
    {
        $candidate = $this->get($id);
        $candidate->update([
            'first_name' => $data->get('first_name', $candidate->first_name),
            'last_name' => $data->get('last_name', $candidate->last_name),
            'position' => $data->get('position', $candidate->position),
            'min_salary' => $data->get('min_salary', $candidate->min_salary),
            'max_salary' => $data->get('max_salary', $candidate->max_salary),
            'linkedin_url' => $data->get('linkedin_url', $candidate->linkedin_url),
        ]);
        return $this->get($id);
    }

    public function createStatus(Candidate $candidate, ParameterBag $data): CandidateStatus
    {
        foreach ($candidate->statuses as $status) {
            if ($status->is_current) {
                $status->update(['is_current' => false]);
            }
        }

        return $candidate->statuses()->create([
            'candidate_id' => $candidate->id,
            'is_current' => $data->get('is_current'),
            'status' => $data->get('status'),
            'comment' => $data->get('comment'),
        ]);
    }


    public function clearCache()
    {
        return null;
    }
}

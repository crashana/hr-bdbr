<?php

namespace App\Http\Controllers\Api;

use App\Services\Candidates\CandidateService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\ParameterBag;

class CandidateController extends Controller
{

    protected $candidateService;

    public function __construct(CandidateService $candidateService)
    {
        $this->candidateService = $candidateService;
    }

    public function all()
    {
        $candidates = $this->candidateService->getAll();
        return $this->response($candidates);
    }


    public function get($id)
    {
        $candidate = $this->candidateService->get($id);
        if ($candidate) {
            return $this->response($candidate);
        } else {
            return $this->response(null, false, 'ჩანაწერი არ მოიძებნა', 404);
        }
    }

    public function create(Request $request)
    {
        $valid['first_name'] = 'required|string';
        $valid['last_name'] = 'required|string';
        $valid['position'] = 'required|string';
        $valid['min_salary'] = 'nullable|numeric';
        $valid['max_salary'] = 'nullable|numeric';
        $valid['linkedin_url'] = 'nullable|url';
        $this->validate($request, $valid);
        $data = new ParameterBag($request->all());

        $result = $this->candidateService->create($data);
        if ($result) {
            return $this->response($result, true, 'კანდიდატი წარმატებით შეიქმნა');
        }
        return $this->response(null, false, 'დაფიქსირდა შეცდომა!');
    }

    public function update(Request $request, $id)
    {
        $candidate = $this->candidateService->get($id);
        if (!$candidate) {
            return $this->response(null, false, 'ჩანაწერი არ მოიძებნა', 404);
        }
        $valid['first_name'] = 'required|string';
        $valid['last_name'] = 'required|string';
        $valid['position'] = 'required|string';
        $valid['min_salary'] = 'nullable|numeric';
        $valid['max_salary'] = 'nullable|numeric';
        $valid['linkedin_url'] = 'nullable|url';
        $this->validate($request, $valid);
        $data = new ParameterBag($request->all());

        $result = $this->candidateService->update($id, $data);
        if ($result) {
            return $this->response($result, true, 'კანდიდატი წარმატებით განახლდა');
        }
        return $this->response(null, false, 'დაფიქსირდა შეცდომა!');
    }

    public function deleteSkill(Request $request, $id)
    {

        $candidate = $this->candidateService->get($id);
        if (!$candidate) {
            return $this->response(null, false, 'ჩანაწერი არ მოიძებნა', 404);
        }

        $this->validate($request, [
            'skill*' => 'required|exists:candidate_skills,skill',
        ]);

        foreach ($request->skill as $skill) {
            $result = $this->candidateService->deleteSkill($id, $skill);
        }

        if ($result) {
            return $this->response(null, true, 'skill წარმატებით წაიშალა!');
        }
        return $this->response(null, false, 'დაფიქსირდა შეცდომა!');
    }

    public function changeStatus(Request $request, $id)
    {
        $candidate = $this->candidateService->get($id);
        if (!$candidate) {
            return $this->response(null, false, 'ჩანაწერი არ მოიძებნა', 404);
        }
        $this->validate($request, [
            'status' => 'required|string|in:Initial,First Contact,Interview,Tech Assignment,Rejected, Hired',
            'comment' => 'required|string',
        ]);

        if ($candidate->current_status == $request->status) {
            return $this->response(null, false, 'სტატუსის ცვლილება შეუძლებელია!');
        }

        $result = $this->candidateService->createStatus($candidate, $request->status, $request->comment);
        if ($result) {
            return $this->response($result, true, 'სტატუსი წარმატებით შეიცვალა!');
        }
        return $this->response(null, false, 'დაფიქსირდა შეცდომა!');
    }

    public function getStatuses()
    {
        return $this->response($this->candidateService->getStatuses());
    }
}

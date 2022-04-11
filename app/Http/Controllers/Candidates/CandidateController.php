<?php

namespace App\Http\Controllers\Candidates;

use App\Http\Controllers\Controller;
use App\Services\Candidates\CandidateService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\ParameterBag;

class CandidateController extends Controller
{

    protected $candidateService;

    public function __construct(CandidateService $candidateService)
    {
        $this->candidateService = $candidateService;
    }

    public function index()
    {
        $statuses = $this->candidateService->getStatuses();
        return view('Pages.candidates', compact('statuses'));
    }

    public function datatable(Request $request)
    {
        $params = new ParameterBag($request->all());
        return $this->candidateService->dataTable($params);
    }

    public function get(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:candidates,id'
        ]);

        $candidate = $this->candidateService->get($request->id);
        return $this->response($candidate);
    }

    public function store(Request $request)
    {
        if ($request->action == 'edit') {
            $valid['id'] = 'required|exists:candidates,id';
        }
        $valid['first_name'] = 'required|string';
        $valid['last_name'] = 'required|string';
        $valid['position'] = 'required|string';
        $valid['min_salary'] = 'nullable|numeric';
        $valid['max_salary'] = 'nullable|numeric';
        $valid['linkedin_url'] = 'nullable|url';
        $this->validate($request, $valid);

        $data = new ParameterBag($request->all());
        if ($request->action == 'new') {
            $result = $this->candidateService->create($data);
            $msg = 'კანდიდატი წარმატებით შეიქმნა!';
        } else {
            $result = $this->candidateService->update($request->id, $data);
            $msg = 'კანდიდატი წარმატებით დარედაქტირდა!';
        }
        if ($result) {
            return $this->response($result, true, $msg);
        }
        return $this->response(null, false, 'დაფიქსირდა შეცდომა!');
    }

    public function deleteSkill(Request $request)
    {

        $this->validate($request, [
            'skill' => 'required|exists:candidate_skills,skill',
            'candidate_id' => 'required|exists:candidates,id',
        ]);

        $result = $this->candidateService->deleteSkill($request->candidate_id, $request->skill);
        if ($result) {
            return $this->response(null, true, 'skill წარმატებით წაიშალა!');
        }
        return $this->response(null, false, 'დაფიქსირდა შეცდომა!');
    }

    public function changeStatus(Request $request)
    {
        $this->validate($request, [
            'candidate_id' => 'required|exists:candidates,id',
            'status' => 'required|string',
            'comment' => 'required|string',
        ]);

        $candidate = $this->candidateService->get($request->candidate_id);

        if ($candidate->current_status == $request->status) {
            return $this->response(null, false, 'სტატუსის ცვლილება შეუძლებელია!');
        }

        $result = $this->candidateService->createStatus($candidate, $request->status, $request->comment);
        if ($result) {
            return $this->response($result, true, 'სტატუსი წარმატებით შეიცვალა!');
        }
        return $this->response(null, false, 'დაფიქსირდა შეცდომა!');
    }
}

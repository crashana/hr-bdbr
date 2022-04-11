<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Validation\ValidationException;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function response(
        $result = null,
        bool $success = true,
        $msg = '',
        $statusCode = 200
    ) {

        if ($success) {
            $response = [
                'success' => $success,
                'msg' => $msg,
                'result' => $result,
            ];
        } else {
            throw new HttpResponseException(response()->json(
                [
                    'error' => true,
                    'msg' => $msg,
                    'result' => $result,
                ],
                $statusCode
            ));
        }
        return response()->json($response);
    }


    public function validate(
        Request $request,
        array   $rules,
        array   $messages = [],
        array   $customAttributes = []
    ) {
        $validator = $this->getValidationFactory()
            ->make(
                $request->all(),
                $rules,
                $messages,
                $customAttributes
            );
        if ($validator->fails()) {
            $errors = (new ValidationException($validator))->errors();
            throw new HttpResponseException(response()->json(
                [
                    'error' => true,
                    'msg' => 'validation error!',
                    'rules' => $errors,
                ],
                JsonResponse::HTTP_UNPROCESSABLE_ENTITY
            ));
        }
    }
}

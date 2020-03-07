<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class AddLicenseRequest
 * @package App\Http\Requests
 * @since 1.0
 */
class AddLicenseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        // TODO - Check if it is a server license or an extension license
        // TODO - If it's a server license, ensure the field replace_active is set

        return [
            //
        ];
    }
}

<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $method = $this->method();

        if($method === "PUT"){
            return [
                "name" => ["required","unique:stores,name"],
                "type" => ["required"],
                "description" => ["required"],
                "location" => ["required"],
            ];
        }else{
            return [
                "name" => ["sometimes","required","unique:stores,name"],
                "type" => ["sometimes","required"],
                "description" => ["sometimes","required"],
                "location" => ["sometimes","required"],
            ];
        }
    }

    public function prepareForValidation(){
        if($this->imageSource){
            $this->merge([
                "image_source" => $this->imageSource,
            ]);
        }
    }
}

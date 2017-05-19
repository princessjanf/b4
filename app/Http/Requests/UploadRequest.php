<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use SSO\SSO;

class UploadRequest extends FormRequest
{
  public function authorize()
  {
    SSO::authenticate();
    return true;
  }

  public function rules()
  {
    foreach(range(1, 5) as $index) {
      $rules['berkases.' . $index] = 'mimes:pdf|max:2048';
    }
    $rules['DokumenKerjasama'] = 'mimes:pdf|max:2048';
    return $rules;
  }
}

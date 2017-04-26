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
    $jumlah = count($this->input('berkases'));
    foreach(range(0, 5) as $index) {
      $rules['berkases.' . $index] = 'mimes:pdf|max:10240';
    }
    return $rules;
  }
}

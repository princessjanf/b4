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
    $rules = [
      'name' => 'required'
    ];
    $photos = count($this->input('photos'));
    foreach(range(0, $photos) as $index) {
      $rules['photos.' . $index] = 'image|mimes:jpeg,bmp,png|max:2000';
    }

    return $rules;
  }
}

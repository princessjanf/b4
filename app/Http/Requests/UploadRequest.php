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
      if($this->input('berkases')!=null){
      $jumlah = count($this->input('berkases'));
        foreach(range(0, $jumlah) as $index) {
          $rules['berkases.' . $index] = 'mimes:pdf|max:2048';
      }
        return $rules;
      }else{
        return [
            'DokumenKerjasama' => 'mimes:pdf|max:2048'
        ];
      }
  }
}

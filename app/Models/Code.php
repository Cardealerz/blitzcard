<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    use HasFactory;

    /*
        Atributes:
            id
            code_template_id: Id of the associated code template
            code: Product key
            used: True if the code has already been used 
            item_id: Id of the associated item when purchased
            created_at 
            updated_at
    */

    protected $fillable = ['code_template_id', 'code'];

    public static function validate($request)
    {
        $request->validate([
            'code_template_id' => 'required',
            'code' => ['required', 'unique:codes', 'regex:/[A-Z0-9]{4,8}(-[A-Z0-9]{4,8}){2,8}/'],
        ]);
    }
    public static function validateChange($request, $code)
    {
        $request->validate([
            'code' => ['required', 'unique:codes,code,' . $code->getId(), 'regex:/[A-Z0-9]{4,8}(-[A-Z0-9]{4,8}){2,8}/'],
        ]);
    }

    public function getId()
    {
        return $this->attributes['id'];
    }

    public function setId($id)
    {
        $this->attributes['id'] = $id;
    }

    public function getCode()
    {
        return $this->attributes['code'];
    }

    public function setCode($code)
    {
        $this->attributes['code'] = $code;
    }

    public function getUsed()
    {
        return $this->attributes['used'];
    }

    public function setUsed($used)
    {
        $this->attributes['used'] = $used;
    }

    public function getCodeTemplateId()
    {
        return $this->attributes['code_template_id'];
    }

    public function setCodeTemplateId($code_template_id)
    {
        $this->attributes['code_template_id'] = $code_template_id;
    }

    public function setItemId($item_id)
    {
        $this->attributes['item_id'] = $item_id;
    }

    public function codeTemplate()
    {
        return $this->belongsTo(CodeTemplate::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    use HasFactory;

    //Attributes: id, code_temaplte_id, code, used, item_id
    protected $fillable = ['code_template_id', 'code'];

    public static function validate($request)
    {
        $request->validate([
            'code_template_id' => 'required',
            'code' => ['required', 'regex:/[A-Z0-9]{4,8}(-[A-Z0-9]{4,8}){2,8}/'],
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

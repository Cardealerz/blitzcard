<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodeTemplate extends Model
{
    use HasFactory;

    //Attributes: id, platform, value, type, created_at, updated_at
    protected $fillable = ['platform', 'value', 'type'];

    public static function validate($request)
    {
        $request->validate([
            'platform' => 'required',
            'value' => 'required|gt:0',
            'type' => 'required',
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

    public function getPlatform()
    {
        return $this->attributes['platform'];
    }

    public function setPlatform($platform)
    {
        $this->attributes['platform'] = $platform;
    }

    public function getValue()
    {
        return $this->attributes['value'];
    }

    public function setValue($value)
    {
        $this->attributes['value'] = $value;
    }

    public function getType()
    {
        return $this->attributes['type'];
    }

    public function setType($type)
    {
        $this->attributes['type'] = $type;
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function codes()
    {
        return $this->hasMany(Code::class);
    }

    public function getName()
    {
        return '$' . $this->attributes['value'] . ' ' . $this->attributes['platform'] . ' ' . $this->attributes['type'];
    }
}

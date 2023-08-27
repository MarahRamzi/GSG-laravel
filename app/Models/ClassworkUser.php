<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ClassworkUser extends Pivot
{
    use HasFactory;

  protected $table = "classroom_work_user";

    public function setUpdatedAt($value)
    {
        // $this->{$this->getUpdatedAtColumn()} = $value; //كدا وقفت وضع قيمة لل value
        return $this;
    }
}

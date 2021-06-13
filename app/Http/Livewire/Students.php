<?php

namespace App\Http\Livewire;

use App\Models\Student; //追加
use Livewire\Component;

class Students extends Component
{
    public function render()
    {
        $students = Student::orderBy('id', 'DESC')->get(); //追加
        return view('livewire.students.index', compact('students')); //追加
    }
}

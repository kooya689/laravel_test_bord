<?php

namespace App\Http\Livewire;

use App\Models\Student; //追加
use Livewire\Component;

   
class Students extends Component
{ 
    public $ids;
    public $firstname;
    public $lastname;
    public $email;
    public $phone;
    public $modalStatus;

    public function render()
    {
        $students = Student::orderBy('id', 'DESC')->get(); //追加
        return view('livewire.students.index', compact('students')); //追加
    }

    
        public function openModal() //modalStatusをtrueにしmodalを表示する
        {
            $this->resetInputFields();
            $this->modalStatus = true;
        }

        public function closeModal() //modalStatusをfalseにしmodalを閉じる
        {
            $this->modalStatus = false;
        }

        public function resetInputFields()  //Inputタグの中身を空にする
        {
            $this->firstname = '';
            $this->lastname = '';
            $this->email = '';
            $this->phone = '';
            
        }

        public function store() //バリデーションをした後に、生徒のデータを保存
        {
            $validateData = $this->validate([
                'firstname' => 'required',
                'lastname' => 'required',
                'email' => 'required|email',
                'phone' => 'required',

            ]);

            Student::create($validateData);
            session()->flash('message', '新規投稿に成功しました。');
            $this->resetInputFields();
            $this->closeModal();
        }

}

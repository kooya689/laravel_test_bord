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
    public $modalUpdateStatus;

    public function render()
    {
        $students = Student::orderBy('id', 'DESC')->get(); //追加
        return view('livewire.students.index', compact('students')); //追加
    }


    //新規投稿機能
    
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

        //編集機能
        

        public function openUpdateModal($id)
        {
            $student = Student::where('id', $id)->first();
            $this->ids = $student->id;
            $this->firstname = $student->firstname;
            $this->lastname = $student->lastname;
            $this->email = $student->email;
            $this->phone = $student->phone;
            $this->modalUpdateStatus = true;
            
        }

        public function closeUpdateModal()
        {
            $this->modalUpdateStatus = false;
        }

        public function update()
        {
            $validateData = $this->validate([
                'firstname' => 'required',
                'lastname' => 'required',
                'email' => 'required|email',
                'phone' => 'required',                
            ]);
            if ($this->ids) {
                $student = Student::find($this->ids);
                $student->update([
                    'firstname' => $this->firstname,
                    'lastname' => $this->lastname,
                    'email' => $this->email,
                    'phone' => $this->phone,
            ]);
            session()->flash('message', '投稿の編集に成功しました。');
            $this->resetInputFields();
            $this->closeUpdateModal();
            }
        }

        //削除機能

        public function delete($id)
        {
            if($id)
            {
                Student::where('id', $id)->delete();
                session()->flash('message', '投稿の削除に成功しました。');
            }
        }

}

<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Employee as Emp;

class Employee extends Component
{
	public $employee_data, $first_name, $last_name, $email, $gender, $data_id;

    public function render()
    {
    	$this->employee_data = Emp::latest()->get();
    	
        return view('livewire.employee');
    }

    public function resetInputFields()
    {
    	$this->first_name = '';
    	$this->last_name = '';
    	$this->email = '';
    	$this->gender = '';
    }

    public function store()
    {
    	$validation = $this->validate([
    		'first_name'		=>	'required',
    		'last_name'			=>	'required',
    		'email'             =>  'required|email',
    		'gender'			=>	'required'
    	]);

    	Emp::create($validation);

    	session()->flash('message', 'Data Created Successfully.');

    	$this->resetInputFields();

    	$this->emit('userStore');
    }

    public function edit($id)
    {
        $data = Emp::findOrFail($id);
        $this->data_id = $id;
        $this->first_name = $data->first_name;
        $this->last_name = $data->last_name;
        $this->email = $data->email;
        $this->gender = $data->gender;
    }

    public function update()
    {
        $validate = $this->validate([
            'first_name'    =>  'required',
            'last_name'     =>  'required',
            'email'         =>  'required|email',
            'gender'        =>  'required'
        ]);

        $data = Emp::find($this->data_id);

        $data->update([
            'first_name'        =>  $this->first_name,
            'last_name'         =>  $this->last_name,
            'email'             =>  $this->email, 
            'gender'            =>  $this->gender
        ]);

        session()->flash('message', 'Data Updated Successfully.');

        $this->resetInputFields();

        $this->emit('userStore');
    }

    public function delete($id)
    {
        Emp::find($id)->delete();
        session()->flash('message', 'Data Deleted Successfully.');
    }
}
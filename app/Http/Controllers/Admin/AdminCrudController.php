<?php
	namespace App\Http\Controllers\Admin;
	use Backpack\CRUD\app\Http\Controllers\CrudController;

	//VALIDATION : change the request to match your own file names if you need from validation
	use App\Http\Requests\CategoryRequest as StoreRequest;
	use App\Http\Requests\CategoryRequest as UpdateRequest;

/**
* 
*/
class AdminCrudController extends CrudController
{
	
	public function setup()
	{
		$this->crud->setModel("App\Models\Admin");
		$this->crud->setRoute("admin/manageadmin");
		$this->crud->setEntityNameStrings('admin','admin');


		// ------ CRUD COLUMNS
		$this->crud->addColumn([
				'name' => 'name',
				'label' => 'Name'
			]);
		$this->crud->addColumn([
				'name' => 'email',
				'label' => 'Email',
				'type' => 'email',
			]);
		$this->crud->addColumn([
				'name' => 'jenis',
				'label' => 'Jenis'
			]);
		
		// ------ CRUD FIELDS
		$this->crud->addField([
				'name' => 'name',
				'label' => 'Name'
			]);

		$this->crud->addField([
				'name' => 'email',
				'label' => 'Email',
				'type' => 'email',
			]);

		$this->crud->addField([
				'name' => 'password',
				'label' => 'Password',
				'type' => 'password',

			]);

		$this->crud->addField([
				'name' => 'confirm_password',
				'label' => 'Confirm Password',
				'type' => 'password',
			]);

		$this->crud->addField([
				'name' => 'jenis',
				'label' => 'Jenis',
			    'type' => 'select_from_array',
			    'options' => ['ADMIN' => 'ADMIN', 'SUPERADMIN' => 'SUPERADMIN'],
			    'allows_null' => false,
			    // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
			]);
	}

	public function store(StoreRequest $request)
	{
		$this->crud->hasAccessOrFail('create');

        // insert item in the db
        if ($request->input('password')) {
            $item = $this->crud->create(\Request::except(['redirect_after_save']));

            // now bcrypt the password
            $item->password = bcrypt($request->input('password'));
            $item->save();
        } else {
            $item = $this->crud->create(\Request::except(['redirect_after_save', 'password']));
        }

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        // save the redirect choice for next time
        $this->setSaveAction();

        return $this->performSaveAction($item->getKey());
	}

	public function update(UpdateRequest $request)
	{
		//encrypt password and set it to request
        $this->crud->hasAccessOrFail('update');

        $dataToUpdate = \Request::except(['redirect_after_save', 'password']);

        //encrypt password
        if ($request->input('password')) {
            $dataToUpdate['password'] = bcrypt($request->input('password'));
        }

        // update the row in the db
        $this->crud->update(\Request::get($this->crud->model->getKeyName()), $dataToUpdate);

        // show a success message
        \Alert::success(trans('backpack::crud.update_success'))->flash();

        // save the redirect choice for next time
        $this->setSaveAction();

        return $this->performSaveAction();
	}
}
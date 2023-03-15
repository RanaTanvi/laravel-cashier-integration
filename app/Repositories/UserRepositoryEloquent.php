<?php

namespace App\Repositories;

use App\User;
use Illuminate\Support\Facades\DB;
use App\Models\SelectProjectTimeSlot;


class UserRepositoryEloquent implements UserRepository
{

	private $model;
	private $adminAddressRepository;

	public function __construct(User $model)
	{
		$this->model = $model;
	}

	public function saveuser(array $user, int $roleid, $password = true)
	{

		$usr = null;

		$email = $user['email'];
		if (isset($user['id'])) {
			$usr = $this->model->where('id', $user['id'])->first();
		}
		if (is_null($usr)) {
			$usr =  new $this->model;

			if ($password) {
				$usr->password = bcrypt($user['password']);
			} else {
				$password = uniqid();
				$usr->password = bcrypt($password);
			}
			$usr->role_id = $roleid;
		}
		if (!is_null($organisation_id)) {
			$usr->organisation_id = $organisation_id;
		}

		$usr->name = $user['name'];
		$usr->email = $user['email'];
		$usr->save();

		return [$usr, $password];
	}


	public function update(array $user, int $role_id, $password = true)
	{
		$email_updated = "true";
		$usr = $this->model->where('id', $user['id'])->first();
		$old_email = $usr->email;
		$new_email = $user['email'];
		$usr->slack_email=$user['slack_email']??null;
		if ($old_email != $new_email) {
			$usr->email = $new_email;
			// $password = uniqid();
			// $usr->password = bcrypt($password);
			$usr->name = $user['name'];
			$usr->save();
			return [$usr, $password, $email_updated];
		}
		// $password = $usr->password;
		$usr->name = $user['name'];
		$usr->role_id = $role_id;
		$usr->save();
		return [$usr, $password];
	}

	public function getUser(int $user_id) {
		return $this->model->where('id',$user_id)->first();

	}
	
}

<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Supplier
 * 
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password_hash
 * @property string $role
 * @property string|null $contact_person
 * @property string $phone
 * @property string $address
 * @property int $warehouseId
 * 
 * @property Warehouse $warehouse
 * @property Collection|Invoice[] $invoices
 * @property Collection|Medicine[] $medicines
 * @property Collection|Purchaseorder[] $purchaseorders
 *
 * @package App\Models
 */
class Supplier extends Model
{
	protected $table = 'supplier';
	public $timestamps = false;

	protected $casts = [
		'warehouseId' => 'int'
	];

	protected $fillable = [
		'name',
		'email',
		'password_hash',
		'role',
		'contact_person',
		'phone',
		'address',
		'warehouseId'
	];

	public function warehouse()
	{
		return $this->belongsTo(Warehouse::class, 'warehouseId');
	}

	public function invoices()
	{
		return $this->hasMany(Invoice::class);
	}

	public function medicines()
	{
		return $this->hasMany(Medicine::class);
	}

	public function purchaseorders()
	{
		return $this->hasMany(Purchaseorder::class);
	}
}

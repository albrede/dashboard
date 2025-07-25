<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Inventory
 * 
 * @property int $id
 * @property int $medicine_id
 * @property string $location_type
 * @property int $quantity
 * @property float $cost_price
 * @property float $selling_price
 * @property Carbon $expiry_date
 * @property Carbon $last_updated
 * @property int|null $pharmacy_id
 * @property int|null $warehouse_id
 * 
 * @property Medicine $medicine
 * @property Pharmacy|null $pharmacy
 * @property Warehouse|null $warehouse
 *
 * @package App\Models
 */
class Inventory extends Model
{
	protected $table = 'inventory';
	public $timestamps = false;

	protected $casts = [
		'medicine_id' => 'int',
		'quantity' => 'int',
		'cost_price' => 'float',
		'selling_price' => 'float',
		'expiry_date' => 'datetime',
		'last_updated' => 'datetime',
		'pharmacy_id' => 'int',
		'warehouse_id' => 'int'
	];

	protected $fillable = [
		'medicine_id',
		'location_type',
		'quantity',
		'cost_price',
		'selling_price',
		'expiry_date',
		'last_updated',
		'pharmacy_id',
		'warehouse_id'
	];

	public function medicine()
	{
		return $this->belongsTo(Medicine::class);
	}

	public function pharmacy()
	{
		return $this->belongsTo(Pharmacy::class);
	}

	public function warehouse()
	{
		return $this->belongsTo(Warehouse::class);
	}
}

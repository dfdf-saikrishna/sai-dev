<?php
namespace WeDevs\ERP\Corptne\Models;

//use WeDevs\ERP\Framework\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Dependents
 *
 * @package WeDevs\ERP\HRM\Models
 */
class TravelAgent extends Model {

   // use SoftDeletes;

    protected $table = 'superadmin';
    public $timestamps = false;
   // protected $fillable = [ 'user_id', 'COM_Id', 'TDBA_Id', 'COM_Name', 'COM_Prefix', 'COM_Email', 'COM_Mobile', 'COM_Landline', 'COM_Address', 'COM_Location', 'COM_City', 'COM_State', 'COM_Cp1username', 'COM_Logo', 'SUP_Id' ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    //protected $dates = ['deleted_at', 'date_of_birth'];
}


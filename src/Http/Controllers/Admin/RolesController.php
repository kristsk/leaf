<?php

namespace CubeSystems\Leaf\Http\Controllers\Admin;

use CubeSystems\Leaf\Admin\Form;
use CubeSystems\Leaf\Admin\Form\Fields\Text;
use CubeSystems\Leaf\Admin\Grid;
use CubeSystems\Leaf\Admin\Traits\Crudify;
use CubeSystems\Leaf\Auth\Roles\Role;
use CubeSystems\Leaf\Services\Module;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;

/**
 * Class RoleController
 * @package App\Http\Controllers
 */
class RolesController extends Controller
{
    use Crudify;

    /**
     * @var string
     */
    protected $resource = Role::class;

    /**
     * @param Model $model
     * @return Form
     */
    protected function form( Model $model )
    {
        return $this->module()->form( $model, function ( Form $form )
        {
            /**
             * @var $collection Collection
             */
            $options = \Admin::modules()->mapWithKeys( function ( Module $value )
            {
                return [ $value->getControllerClass() => (string) $value ];
            } );

            $form->addField( new Text( 'name' ) );
            $form->addField( ( new Form\Fields\MultipleSelect( 'permissions' ) )->options( $options ) );
        } );
    }

    /**
     * @return Grid
     */
    public function grid()
    {
        return $this->module()->grid( $this->resource(), function ( Grid $grid )
        {
            $grid->column( 'name' )->sortable();
            $grid->column( 'created_at' )->sortable();
            $grid->column( 'updated_at' );
        } );
    }
}

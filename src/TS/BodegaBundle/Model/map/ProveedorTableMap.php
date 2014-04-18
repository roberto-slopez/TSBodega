<?php

namespace TS\BodegaBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'proveedor' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.src.TS.BodegaBundle.Model.map
 */
class ProveedorTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.TS.BodegaBundle.Model.map.ProveedorTableMap';

    /**
     * Initialize the table attributes, columns and validators
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('proveedor');
        $this->setPhpName('Proveedor');
        $this->setClassname('TS\\BodegaBundle\\Model\\Proveedor');
        $this->setPackage('src.TS.BodegaBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('nombre', 'Nombre', 'VARCHAR', false, 100, null);
        $this->getColumn('nombre', false)->setPrimaryString(true);
        $this->addColumn('encargado', 'Encargado', 'VARCHAR', false, 100, null);
        $this->addColumn('nit', 'Nit', 'VARCHAR', false, 80, null);
        $this->addColumn('dpi', 'Dpi', 'VARCHAR', false, 80, null);
        $this->addColumn('direccion', 'Direccion', 'VARCHAR', false, 150, null);
        $this->addColumn('telefono', 'Telefono', 'VARCHAR', false, 80, null);
        $this->addColumn('movil', 'Movil', 'VARCHAR', false, 80, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Compras', 'TS\\BodegaBundle\\Model\\Compras', RelationMap::ONE_TO_MANY, array('id' => 'proveedor_id', ), null, null, 'Comprass');
        $this->addRelation('Inventario', 'TS\\BodegaBundle\\Model\\Inventario', RelationMap::ONE_TO_MANY, array('id' => 'proveedor_id', ), null, null, 'Inventarios');
    } // buildRelations()

} // ProveedorTableMap

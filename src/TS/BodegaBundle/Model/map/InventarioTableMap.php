<?php

namespace TS\BodegaBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'inventario' table.
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
class InventarioTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.TS.BodegaBundle.Model.map.InventarioTableMap';

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
        $this->setName('inventario');
        $this->setPhpName('Inventario');
        $this->setClassname('TS\\BodegaBundle\\Model\\Inventario');
        $this->setPackage('src.TS.BodegaBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('producto_id', 'ProductoId', 'INTEGER', 'producto', 'id', false, null, null);
        $this->addForeignKey('proveedor_id', 'ProveedorId', 'INTEGER', 'proveedor', 'id', false, null, null);
        $this->addColumn('fecha', 'Fecha', 'DATE', false, null, null);
        $this->addColumn('stock', 'Stock', 'INTEGER', false, null, null);
        $this->addColumn('precio_unitario', 'PrecioUnitario', 'DECIMAL', false, null, null);
        $this->addColumn('neto', 'Neto', 'DECIMAL', false, null, null);
        $this->addColumn('total', 'Total', 'DECIMAL', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Producto', 'TS\\BodegaBundle\\Model\\Producto', RelationMap::MANY_TO_ONE, array('producto_id' => 'id', ), null, null);
        $this->addRelation('Proveedor', 'TS\\BodegaBundle\\Model\\Proveedor', RelationMap::MANY_TO_ONE, array('proveedor_id' => 'id', ), null, null);
        $this->addRelation('Compras', 'TS\\BodegaBundle\\Model\\Compras', RelationMap::ONE_TO_MANY, array('id' => 'inventario_id', ), null, null, 'Comprass');
        $this->addRelation('Ventas', 'TS\\BodegaBundle\\Model\\Ventas', RelationMap::ONE_TO_MANY, array('id' => 'inventario_id', ), null, null, 'Ventass');
    } // buildRelations()

} // InventarioTableMap

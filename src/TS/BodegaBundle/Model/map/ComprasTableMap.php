<?php

namespace TS\BodegaBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'compras' table.
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
class ComprasTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.TS.BodegaBundle.Model.map.ComprasTableMap';

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
        $this->setName('compras');
        $this->setPhpName('Compras');
        $this->setClassname('TS\\BodegaBundle\\Model\\Compras');
        $this->setPackage('src.TS.BodegaBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('proveedor_id', 'ProveedorId', 'INTEGER', 'proveedor', 'id', false, null, null);
        $this->addForeignKey('inventario_id', 'InventarioId', 'INTEGER', 'inventario', 'id', false, null, null);
        $this->addForeignKey('factura_id', 'FacturaId', 'INTEGER', 'factura', 'id', false, null, null);
        $this->addForeignKey('producto_id', 'ProductoId', 'INTEGER', 'producto', 'id', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Proveedor', 'TS\\BodegaBundle\\Model\\Proveedor', RelationMap::MANY_TO_ONE, array('proveedor_id' => 'id', ), null, null);
        $this->addRelation('Factura', 'TS\\BodegaBundle\\Model\\Factura', RelationMap::MANY_TO_ONE, array('factura_id' => 'id', ), null, null);
        $this->addRelation('Inventario', 'TS\\BodegaBundle\\Model\\Inventario', RelationMap::MANY_TO_ONE, array('inventario_id' => 'id', ), null, null);
        $this->addRelation('Producto', 'TS\\BodegaBundle\\Model\\Producto', RelationMap::MANY_TO_ONE, array('producto_id' => 'id', ), null, null);
    } // buildRelations()

} // ComprasTableMap

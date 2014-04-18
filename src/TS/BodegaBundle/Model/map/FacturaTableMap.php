<?php

namespace TS\BodegaBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'factura' table.
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
class FacturaTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.TS.BodegaBundle.Model.map.FacturaTableMap';

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
        $this->setName('factura');
        $this->setPhpName('Factura');
        $this->setClassname('TS\\BodegaBundle\\Model\\Factura');
        $this->setPackage('src.TS.BodegaBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('numero_factura', 'NumeroFactura', 'VARCHAR', false, 250, null);
        $this->addColumn('fecha', 'Fecha', 'DATE', false, null, null);
        $this->addColumn('tipo', 'Tipo', 'VARCHAR', false, 80, null);
        $this->addForeignKey('clientes_id', 'ClientesId', 'INTEGER', 'clientes', 'id', false, null, null);
        $this->addColumn('subtotal', 'Subtotal', 'DECIMAL', false, null, null);
        $this->addColumn('impuesto', 'Impuesto', 'DECIMAL', false, null, null);
        $this->addColumn('descuento', 'Descuento', 'DECIMAL', false, null, null);
        $this->addColumn('total', 'Total', 'DECIMAL', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Clientes', 'TS\\BodegaBundle\\Model\\Clientes', RelationMap::MANY_TO_ONE, array('clientes_id' => 'id', ), null, null);
        $this->addRelation('Compras', 'TS\\BodegaBundle\\Model\\Compras', RelationMap::ONE_TO_MANY, array('id' => 'factura_id', ), null, null, 'Comprass');
        $this->addRelation('Ventas', 'TS\\BodegaBundle\\Model\\Ventas', RelationMap::ONE_TO_MANY, array('id' => 'factura_id', ), null, null, 'Ventass');
        $this->addRelation('FacturaDetalle', 'TS\\BodegaBundle\\Model\\FacturaDetalle', RelationMap::ONE_TO_MANY, array('id' => 'factura_id', ), null, null, 'FacturaDetalles');
    } // buildRelations()

} // FacturaTableMap

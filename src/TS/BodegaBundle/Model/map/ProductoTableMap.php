<?php

namespace TS\BodegaBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'producto' table.
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
class ProductoTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.TS.BodegaBundle.Model.map.ProductoTableMap';

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
        $this->setName('producto');
        $this->setPhpName('Producto');
        $this->setClassname('TS\\BodegaBundle\\Model\\Producto');
        $this->setPackage('src.TS.BodegaBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('nombre', 'Nombre', 'VARCHAR', false, 100, null);
        $this->getColumn('nombre', false)->setPrimaryString(true);
        $this->addColumn('precio_unitario', 'PrecioUnitario', 'DECIMAL', false, null, null);
        $this->addColumn('descripcion', 'Descripcion', 'VARCHAR', false, 180, null);
        $this->addForeignKey('categoria_id', 'CategoriaId', 'INTEGER', 'categoria', 'id', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Categoria', 'TS\\BodegaBundle\\Model\\Categoria', RelationMap::MANY_TO_ONE, array('categoria_id' => 'id', ), null, null);
        $this->addRelation('Compras', 'TS\\BodegaBundle\\Model\\Compras', RelationMap::ONE_TO_MANY, array('id' => 'producto_id', ), null, null, 'Comprass');
        $this->addRelation('FacturaDetalle', 'TS\\BodegaBundle\\Model\\FacturaDetalle', RelationMap::ONE_TO_MANY, array('id' => 'producto_id', ), null, null, 'FacturaDetalles');
        $this->addRelation('Inventario', 'TS\\BodegaBundle\\Model\\Inventario', RelationMap::ONE_TO_MANY, array('id' => 'producto_id', ), null, null, 'Inventarios');
    } // buildRelations()

} // ProductoTableMap

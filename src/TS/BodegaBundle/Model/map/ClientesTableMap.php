<?php

namespace TS\BodegaBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'clientes' table.
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
class ClientesTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.TS.BodegaBundle.Model.map.ClientesTableMap';

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
        $this->setName('clientes');
        $this->setPhpName('Clientes');
        $this->setClassname('TS\\BodegaBundle\\Model\\Clientes');
        $this->setPackage('src.TS.BodegaBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('nombres', 'Nombres', 'VARCHAR', false, 100, null);
        $this->addColumn('apellidos', 'Apellidos', 'VARCHAR', false, 100, null);
        $this->addColumn('nombre_completo', 'NombreCompleto', 'VARCHAR', false, 100, null);
        $this->addColumn('dpi', 'Dpi', 'VARCHAR', false, 100, null);
        $this->addColumn('nit', 'Nit', 'VARCHAR', false, 100, null);
        $this->addColumn('telefono', 'Telefono', 'VARCHAR', false, 100, null);
        $this->addColumn('direccion', 'Direccion', 'VARCHAR', false, 100, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Ventas', 'TS\\BodegaBundle\\Model\\Ventas', RelationMap::ONE_TO_MANY, array('id' => 'clientes_id', ), null, null, 'Ventass');
        $this->addRelation('Factura', 'TS\\BodegaBundle\\Model\\Factura', RelationMap::ONE_TO_MANY, array('id' => 'clientes_id', ), null, null, 'Facturas');
    } // buildRelations()

} // ClientesTableMap

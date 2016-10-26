<?php
namespace GOG\Models\Base;

class CustomBase
{
    /**
     * Generates a Criteria instance from the paired Query class
     * @param  string $modelAlias The alias of a model in the query
     * @param  Criteria $criteria Optional Criteria to build the query from
     * @return \Propel\Runtime\ActiveQuery\Criteria
     */
    public static function createQuery($modelAlias = null, Criteria $criteria = null)
    {
        return call_user_func_array(get_called_class().'Query::create', [$modelAlias, $criteria]);
    }

    /**
     * Using an instance from the paired Query class, uses arguments as PrimaryKey value to query, returns terminated.
     * @param  mixed $pk  Primary Key value, can be complex
     * @return self
     */
    public static function findPK($pk)
    {
        return self::createQuery()->findPk($pk);
    }
}
